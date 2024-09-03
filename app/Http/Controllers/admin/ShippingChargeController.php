<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;

class ShippingChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippingChaeges = ShippingCharge::with('shipping_charge')->paginate(10);
        // return $shippingChaeges;
        $data['shippingChaeges'] = $shippingChaeges;
        return view('admin.shipping.allshipping',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::orderBy('name','asc')->get();
        $data['countries'] = $countries;
        return view('admin.shipping.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'country' => 'required',
            'amount' => 'required|numeric'
        ]);
        // check the country all ready exists
        $count = ShippingCharge::where('country_id',$request->country)->count();
        if($count > 0){
            return redirect()->route('shipping.index')->with('error','Shipping Country Allready Exists');
        }

        if($validate){
            ShippingCharge::create([
                'country_id' => $request->country,
                'amount' => $request->amount,
            ]);
        }

        return redirect()->route('shipping.index')->with('success','This Country Shipping Charge Added Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $shippingChaeges = ShippingCharge::with('shipping_charge')->find($id);

        if(empty($shippingChaeges)){
            return redirect()->route('shipping.index')->with('error','Data Not Found');
        }

        $countries = Country::get();

        $data['countries'] = $countries;
        $data['shippingChaeges'] = $shippingChaeges;

        // return $shippingChaeges;
        return view('admin.shipping.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $shippingItem = ShippingCharge::find($id);

        if(empty($shippingItem)){
            return redirect()->route('shipping.index')->with('error','Updated Row Not Found');
        }
        $validate = $request->validate([
            'country' => 'required',
            'amount' => 'required|numeric'
        ]);

        $shippingItem->country_id = $request->country;
        $shippingItem->amount = $request->amount;

        $shippingItem->save();

        return redirect()->route('shipping.index')->with('success','shipping item price updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shippingItem = ShippingCharge::find($id);
        if(empty($shippingItem)){
            return redirect()->route('shipping.index')->with('error','Deleted Shipping Porduct Not Found!');
        }

        $shippingItem->delete();
        return redirect()->route('shipping.index')->with('success','Shipping Item Deleted Successfully');
    }
}
