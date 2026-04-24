<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Setting;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ShiprocketWebhookController extends Controller
{
    /**
     * Handle Shiprocket Webhook
     *
     * Shiprocket will send a POST request with JSON payload:
     * {
     *   "order_id": "... (Shiprocket Order ID)",
     *   "shipment_id": "...",
     *   "awb": "...",
     *   "status": "...",
     *   "current_status": "...",
     *   "etd": "...",
     *   "scans": [...]
     * }
     */
    public function handle(Request $request)
    {
        if (!$this->isValidSignature($request)) {
            return response()->json(['message' => 'Invalid webhook signature'], 401);
        }

        if (!$this->isWithinTimestampWindow($request)) {
            return response()->json(['message' => 'Webhook timestamp is outside the accepted window'], 401);
        }

        $payload = $request->all();
        $awb = $payload['awb'] ?? null;
        $status = strtolower($payload['current_status'] ?? '');
        $shiprocketOrderId = $payload['order_id'] ?? null;

        Log::info('Shiprocket webhook accepted', [
            'shiprocket_order_id' => $shiprocketOrderId,
            'status' => $status,
            'awb' => $awb,
        ]);

        if (!$shiprocketOrderId) {
            return response()->json(['message' => 'Order ID missing'], 400);
        }

        // Find the order by Shiprocket Order ID
        $order = Order::where('shiprocket_order_id', $shiprocketOrderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $nonce = trim((string) (
            $request->header('x-shiprocket-event-id')
                ?? $request->header('x-webhook-id')
                ?? ''
        ));
        if ($nonce !== '') {
            $nonceKey = 'webhook:shiprocket:nonce:' . sha1($nonce);
            $isFreshNonce = Cache::add($nonceKey, now()->toIso8601String(), now()->addHours(24));
            if (!$isFreshNonce) {
                Log::info('Shiprocket webhook duplicate nonce suppressed', [
                    'shiprocket_order_id' => $shiprocketOrderId,
                    'nonce' => $nonce,
                ]);

                return response()->json(['success' => true, 'duplicate' => true]);
            }
        }

        $replayKey = $this->resolveReplayKey($request, $payload, $shiprocketOrderId);
        if ($replayKey !== null) {
            $cacheKey = 'webhook:shiprocket:replay:' . $replayKey;
            $isFresh = Cache::add($cacheKey, now()->toIso8601String(), now()->addHours(24));
            if (!$isFresh) {
                Log::info('Shiprocket webhook duplicate suppressed', [
                    'shiprocket_order_id' => $shiprocketOrderId,
                    'replay_key' => $replayKey,
                ]);

                return response()->json(['success' => true, 'duplicate' => true]);
            }
        }

        // Map Shiprocket status to local order status
        $newStatus = $this->mapStatus($status);

        if ($newStatus) {
            $order->status = $newStatus;
        }

        // Update tracking number if available
        if ($awb && !$order->tracking_number) {
            $order->tracking_number = $awb;
        }

        // Update ETD if available
        if (isset($payload['etd']) && !empty($payload['etd'])) {
            $order->expected_delivery_date = $payload['etd'];
        }

        $order->save();

        return response()->json(['success' => true]);
    }

    private function isValidSignature(Request $request): bool
    {
        $secret = (string) Setting::where('key', 'shiprocket_webhook_secret')->value('value');
        if ($secret === '') {
            Log::warning('Shiprocket webhook secret is not configured.');
            return false;
        }

        $signature = (string) ($request->header('x-shiprocket-signature')
            ?? $request->header('x-webhook-signature')
            ?? '');

        if ($signature === '') {
            return false;
        }

        $payload = (string) $request->getContent();
        $expected = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expected, trim($signature));
    }

    private function isWithinTimestampWindow(Request $request): bool
    {
        $rawTimestamp = trim((string) (
            $request->header('x-shiprocket-timestamp')
                ?? $request->header('x-webhook-timestamp')
                ?? ''
        ));

        // Backward compatible: if provider does not send timestamp yet, keep accepting signed payloads.
        if ($rawTimestamp === '') {
            return true;
        }

        try {
            if (preg_match('/^\d+$/', $rawTimestamp) === 1) {
                $timestamp = CarbonImmutable::createFromTimestampUTC((int) $rawTimestamp);
            } else {
                $timestamp = CarbonImmutable::parse($rawTimestamp);
            }
        } catch (\Throwable $e) {
            Log::warning('Shiprocket webhook has invalid timestamp format', [
                'timestamp' => $rawTimestamp,
            ]);

            return false;
        }

        $skew = abs(now()->diffInSeconds($timestamp));

        return $skew <= 300;
    }

    /**
     * Map Shiprocket status codes to local order status
     */
    protected function mapStatus($shiprocketStatus)
    {
        $map = [
            'picked up' => 'shipped',
            'in transit' => 'shipped',
            'out for delivery' => 'shipped',
            'delivered' => 'delivered',
            'cancelled' => 'cancelled',
            'returned' => 'returned',
            'rto initiated' => 'returned',
            'rto delivered' => 'returned',
        ];

        return $map[$shiprocketStatus] ?? null;
    }

    private function resolveReplayKey(Request $request, array $payload, string $shiprocketOrderId): ?string
    {
        $eventId = trim((string) (
            $payload['event_id']
                ?? $request->header('x-shiprocket-event-id')
                ?? $request->header('x-webhook-id')
                ?? ''
        ));

        if ($eventId !== '') {
            return 'event:' . sha1($eventId);
        }

        $status = strtolower((string) ($payload['current_status'] ?? ''));
        $awb = strtolower((string) ($payload['awb'] ?? ''));
        $contentHash = hash('sha256', (string) $request->getContent());

        if ($shiprocketOrderId === '' && $contentHash === '') {
            return null;
        }

        return 'hash:' . sha1($shiprocketOrderId . '|' . $status . '|' . $awb . '|' . $contentHash);
    }
}
