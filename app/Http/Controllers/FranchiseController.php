<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FranchiseLead;
use App\Models\FranchiseDocument;

class FranchiseController extends Controller
{
    public function index()
    {
        return view('pages.franchise');
    }

    public function apply(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|digits:10',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'investment_budget' => 'required|string',
            'franchise_type' => 'required|string',
            'experience' => 'nullable|string',
            'message' => 'nullable|string',
            'id_proof' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $lead = FranchiseLead::create($request->except('id_proof'));

        // Handle file upload
        if ($request->hasFile('id_proof')) {
            $path = $request->file('id_proof')->store('franchise_documents', 'public');
            
            FranchiseDocument::create([
                'franchise_lead_id' => $lead->id,
                'document_type' => 'ID Proof',
                'file_path' => $path,
                'is_verified' => false,
            ]);
        }

        return back()->with('success', 'Your franchise application has been submitted successfully! Our expansion manager will contact you soon.');
    }
}
