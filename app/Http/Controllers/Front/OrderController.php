<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Order;
use App\Models\Catalog\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
	/**
	 * Handle the incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Product $product
	 * @return RedirectResponse
	 */
	public function __invoke(Request $request, Product $product): RedirectResponse
	{
		if (Auth::check()) {
			$exists = Auth::user()->orders()->where('product_id', $product->id)->count();
		} else {
			$exists = Order::where('contact', $request->get('contact'))
						   ->where('product_id', $product->id)
						   ->count();
		}

		if (!$exists) {
			$attributes = $request->only('contact', 'message');
			$attributes['price'] = $product->price;

			if (Auth::check()) {
				$attributes['user_id'] = Auth::user()->id;
			}

			$product->orders()->create($attributes);
		}

		session()->put('product', $product);
		session()->put('message', 'pages.thanks.product.' . ($exists ? 'exists' : 'added'));

		return redirect()->route('app.thanks');
	}
}
