<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Subscribe an email to the newsletter.
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        NewsletterSubscriber::firstOrCreate(
            ['email' => $request->email],
            ['is_active' => true]
        );

        // Re-activate if previously unsubscribed
        NewsletterSubscriber::where('email', $request->email)->update(['is_active' => true]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Thank you for subscribing!']);
        }

        return redirect()->back()->with('success', 'Thank you for subscribing to our newsletter!');
    }

    /**
     * Unsubscribe an email from newsletter.
     */
    public function unsubscribe(Request $request)
    {
        if ($request->email) {
            NewsletterSubscriber::where('email', $request->email)->update(['is_active' => false]);
        }

        return redirect('/')->with('success', 'You have been unsubscribed successfully.');
    }
}
