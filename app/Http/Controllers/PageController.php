<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Gallery;
use App\Models\EventLead;
use App\Models\Blog;

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
            'event_date' => 'required|date|after:today',
            'guest_count' => 'required|integer|min:10',
            'budget' => 'nullable|numeric|min:0',
            'city' => 'required|string|max:100',
            'message' => 'nullable|string',
        ]);

        EventLead::create($request->all());

        return back()->with('success', 'Thank you! Your catering inquiry has been submitted. Our team will contact you shortly.');
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

        // We can log or store in contacts table, or send email. 
        // For now, return success.
        return back()->with('success', 'Your message has been sent successfully. We will get back to you soon!');
    }
}
