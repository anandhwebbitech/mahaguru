<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingCharge;
class ShippingChargeController extends Controller
{
    //
    public function index() {
        $shippings = ShippingCharge::all();
        return view('admin.shipping.index', compact('shippings'));
    }
     public function create()
    {
        return view('admin.shipping.create');
    }

    public function store(Request $request) {
        $request->validate([
            'state' => 'required|unique:shipping_charges,state',
            'charge_amount' => 'required|numeric|min:0'
        ]);

        ShippingCharge::create([
            'country' => 'India',
            'state' => $request->state,
            'charge_amount' => $request->charge_amount
        ]);

        return redirect()->back()->with('success', 'Shipping charge added successfully!');
    }

      public function edit($id)
    {
        $shipping = ShippingCharge::findOrFail($id);

        return view('admin.shipping.edit', compact('shipping'));
    }

    public function update(Request $request, $id) {
        $shipping = ShippingCharge::findOrFail($id);
        $shipping->update([
            'charge_amount' => $request->charge_amount
        ]);
        return redirect()->back()->with('success', 'Shipping charge updated!');
    }
    public function destroy($id)
    {
        $color = ShippingCharge::findOrFail($id);

        $color->delete();

        return redirect()
            ->back()
            ->with('success', 'Color Deleted Successfully');
    }
}
