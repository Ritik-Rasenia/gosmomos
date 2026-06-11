<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class CustomerAddressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|in:home,work,other',
            'address_line_1' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
        ]);

        UserAddress::create([
            'user_id' => Auth::id(),
            'label' => $request->label,
            'address_line_1' => $request->address_line_1,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
        ]);

        return back()->with('success', 'Address added successfully!');
    }

    public function destroy($id)
    {
        $address = UserAddress::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $address->delete();

        return back()->with('success', 'Address deleted successfully!');
    }
}
