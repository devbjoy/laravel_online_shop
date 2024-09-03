<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function order()
    {
        $orders = Order::with('user')->orderBy('id','desc')->paginate(10);
        // $orders = Order::with('user')->orderBy('id','desc')->get();
        // return $orders;
        $data['orders'] = $orders;
        return view('admin.orders.order',$data);
    }

    public function orderDetails($orderId)
    {
        $order = Order::with('country')->find($orderId);
        if(empty($order)){
            return redirect()->route('admin.order');
        }
        // return $order;

        $orderItem = OrderItem::where('order_id',$orderId)->get();

        $data['order'] = $order;
        $data['orderItem'] = $orderItem;
        return view('admin.orders.order-details',$data);
    }

    public function changeOrderStatus(Request $request, $id)
    {
        $order = Order::find($id);

        $order->status = $request->status;
        $order->shipped_date = $request->shipped_date;
        $order->save();

        $message = 'Order status updated successfully';
        session()->flash('success',$message);
        return response()->json([
            'status' => true,
            'message' => $message
        ]); 
    }

    // send invoice email

    public function sendInvoiceEmail(Request $request, $id)
    {
        orderEmail($id,$request->user_type);

        $message = 'Order email send successfully';
        session()->flash('success',$message);
        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
}
