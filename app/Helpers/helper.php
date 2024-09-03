<?php

use App\Mail\OrderEmail;
use App\Models\Categorie;
use App\Models\Order;
use App\Models\Page;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Mail;

function getCategory()
{
	return Categorie::orderBy('name','ASC')
									->with('sub_category')
									->where('show_home','Yes')
									->where('status',1)
									->get();
}

function getProductImages($id)
{
	return ProductImage::where('product_id',$id)->first();
}

function orderEmail($prductId,$userType="customer")
{
	$orderItem = Order::with(['items','country'])->where('id',$prductId)->first();

	if($userType == 'customer'){
		$subject = 'Thanks for your order';
		$email = $orderItem->email;
	}else{
		$subject = 'You have received an order';
		$email = env('ADMIN_EMAIL');
	}

	$mailData = [
		'subject'=> $subject,
		'order' => $orderItem,
		'userType' => $userType
	];

	mail::to($email)->send(new OrderEmail($mailData));

}

function staticPage(){
	$pages = Page::orderBy('id','asc')->get();

	return $pages;
}

?>