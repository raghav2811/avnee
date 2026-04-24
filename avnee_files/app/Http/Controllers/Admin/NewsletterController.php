<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewsletterCampaign;
use App\Models\NewsletterSubscriber;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    /**
     * Show the newsletter management page.
     */
    public function index()
    {
        $subscribers = NewsletterSubscriber::where('is_active', true)->latest()->paginate(20);
        $totalSubscribers = NewsletterSubscriber::where('is_active', true)->count();
        $totalUnsubscribed = NewsletterSubscriber::where('is_active', false)->count();

        return view('admin.newsletter.index', compact('subscribers', 'totalSubscribers', 'totalUnsubscribed'));
    }

    /**
     * Apply SMTP settings from the database at runtime.
     */
    protected function applyMailConfig(): void
    {
        $settings = Setting::whereIn('key', [
            'mail_host', 'mail_port', 'mail_username', 'mail_password',
            'mail_from_address', 'mail_from_name', 'mail_encryption',
        ])->pluck('value', 'key')->toArray();

        if (empty($settings['mail_host'])) {
            return; // Fall back to .env if not configured in admin
        }

        Config::set('mail.mailers.smtp.host', $settings['mail_host'] ?? '');
        Config::set('mail.mailers.smtp.port', (int) ($settings['mail_port'] ?? 587));
        Config::set('mail.mailers.smtp.username', $settings['mail_username'] ?? '');
        Config::set('mail.mailers.smtp.password', $settings['mail_password'] ?? '');
        Config::set('mail.mailers.smtp.encryption', $settings['mail_encryption'] ?? 'tls');
        Config::set('mail.from.address', $settings['mail_from_address'] ?? $settings['mail_username'] ?? '');
        Config::set('mail.from.name', $settings['mail_from_name'] ?? 'AVNEE Collections');
        Config::set('mail.default', 'smtp');
    }

    /**
     * Send a campaign email to all active subscribers.
     */
    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        // Apply DB mail config
        $this->applyMailConfig();

        $subscribers = NewsletterSubscriber::where('is_active', true)->get();

        if ($subscribers->isEmpty()) {
            return redirect()->back()->with('error', 'No active subscribers to send to.');
        }

        $sent = 0;
        $failed = 0;
        foreach ($subscribers as $subscriber) {
            try {
                Mail::to($subscriber->email)->send(new NewsletterCampaign(
                    $request->subject,
                    $request->body
                ));
                $sent++;
            } catch (\Exception $e) {
                $failed++;
                \Log::warning("Failed to send newsletter to {$subscriber->email}: " . $e->getMessage());
            }
        }

        $msg = "Newsletter sent to {$sent} subscriber(s) successfully!";
        if ($failed > 0) {
            $msg .= " ({$failed} failed — check logs.)";
        }

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Delete a subscriber.
     */
    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();
        return redirect()->back()->with('success', 'Subscriber removed.');
    }
}
