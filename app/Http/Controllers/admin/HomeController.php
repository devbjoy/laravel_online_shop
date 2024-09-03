<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
   public function index(){
        $totalOrders = Order::where('status','!=','cancelled')->count();
        $totalProducts = Product::count();
        $totalCustomer = User::where('role',1)->count();
        $totalSale = Order::where('status', '!=', 'cancelled')->sum('grand_total');

        // this mounth revenue
        $thisMounthStartDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $currentDate = Carbon::now()->format('Y-m-d');
        $currentMonth = Carbon::now()->format('M');

        $revenueThisMonth = Order::where('status','!=','cancelled')
                            ->whereDate('created_at','>=',$thisMounthStartDate)
                            ->whereDate('created_at','<=',$currentDate)
                            ->sum('grand_total');

        // last month revenue
        $lastMonthStartDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $lastMonthEndDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        $lastMonthName = Carbon::now()->subMonth()->startOfMonth()->format('M');
        
        $revenueLastMonth =  Order::where('status','!=','cancelled')
                            ->whereDate('created_at','>=',$lastMonthStartDate)
                            ->whereDate('created_at','<=',$lastMonthEndDate)
                            ->sum('grand_total');
        
        // sale last thirty days
        $lastThirtyDayStartDate = Carbon::now()->subDays(30)->format('Y-m-d');

        $revenueLastThirtyDay = Order::where('status','!=','cancelled')
                                ->whereDate('created_at','>=',$lastThirtyDayStartDate)
                                ->whereDate('created_at','<=',$currentDate)
                                ->sum('grand_total');

        $data['totalOrders'] = $totalOrders;
        $data['totalProducts'] = $totalProducts;
        $data['totalCustomer'] = $totalCustomer;
        $data['totalSale'] = $totalSale;
        $data['revenueThisMonth'] = $revenueThisMonth;
        $data['revenueLastMonth'] = $revenueLastMonth;
        $data['revenueLastThirtyDay'] = $revenueLastThirtyDay;
        $data['lastMonthName'] = $lastMonthName;
        $data['currentMonth'] = $currentMonth;

        return view('admin.dashboard',$data);

    }

    public function logout(){

        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
