<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsersController extends Controller
{
	/**
	 * Display a listing of the resource.
	 * @return View
	 */
	public function index(): View
	{
		return \view('admin.users.index', [
			'users' => User::where('id', '!=', 1)->latest('id')->paginate(20),
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\User\User $user
	 * @return View
	 */
	public function show(User $user): View
	{
		return \view('admin.users.show', compact('user'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\User\User $user
	 * @return \Illuminate\Http\Response
	 */
	public function edit(User $user)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Models\User\User $user
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\User\User $user
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user)
	{
		//
	}
}
