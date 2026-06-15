<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventLead;

class EventLeadController extends Controller
{
    public function index()
    {
        $leads = EventLead::latest()->paginate(20);
        return view('admin.event-leads.index', compact('leads'));
    }

    public function show($id)
    {
        $lead = EventLead::findOrFail($id);
        return view('admin.event-leads.show', compact('lead'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:new,contacted,booked,cancelled']);
        $lead = EventLead::findOrFail($id);
        $lead->update([
            'status'      => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);
        return back()->with('success', 'Status updated successfully!');
    }

    public function destroy($id)
    {
        $lead = EventLead::findOrFail($id);
        $lead->delete();
        return back()->with('success', 'Event lead deleted successfully!');
    }
}
