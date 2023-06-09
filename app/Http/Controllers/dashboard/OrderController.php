<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::whereHas('client', function ($q) use ($request) {
            return $q->where('name', 'like', "%" . $request->search . "%");
        })->latest()->paginate(10);
        return view('dashboard.orders.index', compact('orders'));
    }


    public function products(Order $order)
    {
        $products = $order->products;
        return view('dashboard.orders._products', compact('order','products'));
    }

    public function destroy(Order $order)
    {   
        // return quantity to product stock
        foreach($order->products as $product)
        {
            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);
        }

        // delete order
        $order->delete();

        // redirect
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.orders.index');
    }
}
