<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class DiscountCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discount = DiscountCoupon::orderBy('id','desc')->paginate(10);
        $data['discounts'] = $discount;
        return view('admin.discount.all',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.discount.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = FacadesValidator::make($request->all(),[
            'code' => 'required',
            'discount_amount' => 'required|numeric',
            'type' => 'required',
            'status' => 'required'
        ]);

        if($validator->passes()){

            // start date must be grater then current date
            if(!empty($request->starts_at)){
                $now = Carbon::now();
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);
                if($startAt->lte($now)){
                    return response()->json([
                        'status' => false,
                        'errors' => ['starts_at'=>'Start date can not be less than current date and time'],
                    ]);
                }
            }

            // expaire date must be gratter than start date
            if(!empty($request->starts_at) && !empty($request->expires_at)){
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);
                $expaireAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->expires_at);
                if($expaireAt->gt($startAt) == false){
                    return response()->json([
                        'status' => false,
                        'errors' => ['expires_at'=>'Expires date must be gratter then start date'],
                    ]);
                }
            }

            $discount = new DiscountCoupon();
            $discount->code = $request->code;
            $discount->name = $request->name;
            $discount->description = $request->description;
            $discount->max_uses = $request->max_uses;
            $discount->max_uses_user = $request->max_uses_user;
            $discount->type = $request->type;
            $discount->min_amount = $request->min_amount;
            $discount->discount_amount = $request->discount_amount;
            $discount->status = $request->status;
            $discount->starts_at = $request->starts_at;
            $discount->expires_at = $request->expires_at;
            $discount->save();

            session()->flash('success','Discount Code Added Successfully');
            return response()->json([
                'status' => true,
                'message' => 'message'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
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
        $discount = DiscountCoupon::find($id);

        if(empty($discount)){
            return redirect()->route('discount.index')->with('success','Discount Coupon Item Not Found');
        }
        // return $discount;
        return view('admin.discount.edit',['discount'=> $discount]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $discount = DiscountCoupon::find($id);

        if($discount == null){   
            session()->flash('success','Discount Cuopone Item Not Found !');
            return response()->json([
                'status' => true,
                'message' => 'Discount Cuopone Item Not Found !'
            ]);
        }

        $validator = FacadesValidator::make($request->all(),[
            'code' => 'required',
            'discount_amount' => 'required|numeric',
            'type' => 'required',
            'status' => 'required'
        ]);

        if($validator->passes()){

            // start date must be grater then current date
            // if(!empty($request->starts_at)){
            //     $now = Carbon::now();
            //     $startAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);
            //     if($startAt->lte($now)){
            //         return response()->json([
            //             'status' => false,
            //             'errors' => ['starts_at'=>'Start date can not be less than current date and time'],
            //         ]);
            //     }
            // }

            // expaire date must be gratter than start date
            if(!empty($request->starts_at) && !empty($request->expires_at)){
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);
                $expaireAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->expires_at);
                if($expaireAt->gt($startAt) == false){
                    return response()->json([
                        'status' => false,
                        'errors' => ['expires_at'=>'Expires date must be gratter then start date'],
                    ]);
                }
            }

            
            $discount->code = $request->code;
            $discount->name = $request->name;
            $discount->description = $request->description;
            $discount->max_uses = $request->max_uses;
            $discount->max_uses_user = $request->max_uses_user;
            $discount->type = $request->type;
            $discount->min_amount = $request->min_amount;
            $discount->discount_amount = $request->discount_amount;
            $discount->status = $request->status;
            $discount->starts_at = $request->starts_at;
            $discount->expires_at = $request->expires_at;
            $discount->save();

            session()->flash('success','Discount Cuopone Code Updated Successfully');
            return response()->json([
                'status' => true,
                'message' => 'Discount Cuopone Code Updated Successfully'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $discount = DiscountCoupon::find($id);

        if($discount == null){
            return redirect()->route('discount.index')->with('error','Record Not Found !');
        }

        $discount->delete();
        
        return redirect()->route('discount.index')->with('success','Discount Item Deleted Successfully');
    }
}
