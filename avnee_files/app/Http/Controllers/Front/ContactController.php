<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $theme = session('brand_id', 1) == 2 ? 'jewellery' : 'studio';
        return view('front.contact', compact('theme'));
    }

    public function careers()
    {
        $theme = session('brand_id', 1) == 2 ? 'jewellery' : 'studio';
        return view('front.careers', compact('theme'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $message = ContactMessage::create($request->all());

        try {
            $subject = 'New Contact Form Message - AVNEE Collections';
            $body = "New enquiry received from AVNEE contact form.\n\n"
                . "Name: {$message->name}\n"
                . "Email: {$message->email}\n"
                . "Phone: " . ($message->phone ?: 'N/A') . "\n"
                . "Subject: " . ($message->subject ?: 'General enquiry') . "\n\n"
                . "Message:\n{$message->message}\n";

            Mail::raw($body, function ($mail) use ($subject) {
                $mail->to('avnee.collections@gmail.com')
                    ->cc('studio@avneecollections.com')
                    ->subject($subject);
            });
        } catch (\Throwable $e) {
            // Do not fail UX on mail transport errors.
            Log::warning('Contact form email delivery failed', ['error' => $e->getMessage()]);
        }

        return back()->with('success', 'Thank you! Your message has been received. Our concierge will contact you shortly.');
    }
}
