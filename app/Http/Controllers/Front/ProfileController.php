<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileSavingRequest;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use PragmaRX\Countries\Package\Countries;

class ProfileController extends Controller
{
	/**
	 * @return View
	 */
	public function index(): View
	{
		/** @var User $user */
		$user = Auth::user();
		$cities = collect([]);
		$orders = collect([]);

		if ($user->profile && $user->profile->country) {
			$cities = (new Countries())
				->where('name.common', $user->profile->country)
				->first()->hydrate('cities')->cities->pluck('name');
		}

		if ($user->orders()->count()) {
			$orders->put('processing', $user->processingOrders);
			$orders->put('completed', $user->completedOrders);
			$orders->put('declined', $user->declinedOrders);
		}

		return \view('app.profile.index', [
			'favorites' => $user->favorites
				->groupBy('favoritable_type')->reverse(),
			'orders' => $orders,
			'countries' => (new Countries())->all()->pluck('name.common')->sort(),
			'cities' => $cities,
			'user' => $user,
		]);
	}

	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function getCities(Request $request): JsonResponse
	{
		return \response()->json([
			'cities' => (new Countries())
				->where('name.common', $request->input('country'))
				->first()->hydrate('cities')->cities->pluck('name'),
		]);
	}

	/**
	 * @param UserProfileSavingRequest $request
	 * @return RedirectResponse
	 */
	public function update(UserProfileSavingRequest $request): RedirectResponse
	{
		/** @var User $user */
		$user = Auth::user();
		$user->update($request->only('name'));

		$user->profile()->updateOrCreate([
			'user_id' => $user->id,
		], [
			'phone_1' => $request->input('phone_1'),
			'phone_2' => $request->input('phone_2'),
			'country' => $request->input('country'),
			'city' => $request->input('city'),
			'address' => $request->input('address'),
		]);

		return \back();
	}
}
