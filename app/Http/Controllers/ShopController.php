<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        if (auth()->user()->user_type == "seller") {
            $packages = Package::where('user_type' , "seller")->where('package_type' , 'Package')->get();
        } else {
            $packages = Package::where('user_type' , "agent")->where('package_type' , 'Package')->get();
        }
        
        $boosters = Package::where('user_type' , auth()->user()->user_type)->where('package_type' , 'Booster')->get();
        $cart = session()->get('cart');

        return view('shop.index', compact('packages', 'boosters' , 'cart'));
    }

    function viewCart()
    {
        $cart = session()->get('cart');
        return view('shop.cart', compact('cart'));
    }

    public function addToCart($id)
    {
        $cart = session()->get('cart', []);
        $package = Package::findOrFail($id);

        $cart[$id] = [
            "item_id"   =>  $id,
            "name"      =>  $package->name,
            "quantity"  =>  1,
            "price"     =>  $package->price,
        ];

        session()->put('cart', $cart);
        return redirect()->back()->with('status', 'Added to Cart successfully!');
    }

    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function removeCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }
}
