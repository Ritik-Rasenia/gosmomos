<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Gallery;
use App\Models\EventLead;
use App\Models\Blog;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminCateringLeadMail;
use App\Mail\AdminContactLeadMail;

class PageController extends Controller
{
    public function ourStory()
    {
        return view('pages.our-story');
    }

    public function locations()
    {
        $locations = Location::active()->get();
        return view('pages.locations', compact('locations'));
    }

    public function catering()
    {
        return view('pages.catering');
    }

    public function storeCateringLead(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|digits:10',
            'event_type' => 'required|string',
            'event_date' => 'required|date|after_or_equal:today',
            'guest_count' => 'required|integer|min:1',
            'budget' => 'nullable|numeric|min:0',
            'city' => 'required|string|max:100',
            'message' => 'nullable|string',
        ]);

        $lead = EventLead::create($request->all());

        // Notify Admins
        \App\Models\Notification::notifyAdmins(
            'catering',
            "New {$lead->event_type} Inquiry — {$lead->guest_count} Guests",
            "A new catering inquiry from {$lead->name} ({$lead->phone}) for {$lead->event_type} on " . date('d M Y', strtotime($lead->event_date)) . " with {$lead->guest_count} guests in {$lead->city}.",
            ['event_type' => $lead->event_type, 'guests' => $lead->guest_count, 'city' => $lead->city]
        );

        // Send Emails
        try {
            Mail::to(setting('contact_email', 'info@gosmomo.com'))->send(new AdminCateringLeadMail($lead, true));
            Mail::to($lead->email)->send(new AdminCateringLeadMail($lead, false));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send catering inquiry emails: " . $e->getMessage());
        }

        return back()->with('success', 'Thank you! Your inquiry has been submitted. Our team will contact you shortly.');
    }

    public function gallery()
    {
        $photos = Gallery::active()->orderBy('sort_order')->get();
        return view('pages.gallery', compact('photos'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function storeContactLead(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|digits:10',
            'message' => 'required|string',
        ]);

        $leadData = $request->only(['name', 'email', 'phone', 'message']);

        // Send Contact Message Emails
        try {
            Mail::to(setting('contact_email', 'info@gosmomo.com'))->send(new AdminContactLeadMail($leadData, true));
            Mail::to($leadData['email'])->send(new AdminContactLeadMail($leadData, false));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send contact message emails: " . $e->getMessage());
        }

        return back()->with('success', 'Your message has been sent successfully. We will get back to you soon!');
    }

    public function showPage($slug)
    {
        $page = \App\Models\Page::active()->where('slug', $slug)->firstOrFail();
        return view('pages.show', compact('page'));
    }
}
