<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FranchiseLead;

class FranchiseLeadController extends Controller
{
    public function index()
    {
        $leads = FranchiseLead::latest()->get();
        return view('admin.franchise-leads.index', compact('leads'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,contacted,site_visit,approved,rejected',
        ]);

        $lead = FranchiseLead::findOrFail($id);
        $lead->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Franchise lead status updated successfully!');
    }
}
