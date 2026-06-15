<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FranchiseLead;

class FranchiseLeadController extends Controller
{
    public function index()
    {
        $leads = FranchiseLead::latest()->paginate(20);
        return view('admin.franchise-leads.index', compact('leads'));
    }

    public function show($id)
    {
        $lead = FranchiseLead::findOrFail($id);
        return view('admin.franchise-leads.show', compact('lead'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,contacted,site_visit,approved,rejected',
        ]);

        $lead = FranchiseLead::findOrFail($id);
        $lead->update([
            'status'      => $request->status,
            'admin_notes' => $request->admin_notes,
            'follow_up_date' => $request->follow_up_date,
        ]);

        return back()->with('success', 'Franchise lead status updated successfully!');
    }

    public function destroy($id)
    {
        FranchiseLead::findOrFail($id)->delete();
        return back()->with('success', 'Lead deleted.');
    }
}
