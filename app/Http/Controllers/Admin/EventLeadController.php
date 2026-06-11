<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventLead;

class EventLeadController extends Controller
{
    public function index()
    {
        $leads = EventLead::latest()->get();
        return view('admin.event-leads.index', compact('leads'));
    }

    public function destroy($id)
    {
        $lead = EventLead::findOrFail($id);
        $lead->delete();

        return back()->with('success', 'Event lead deleted successfully!');
    }
}
