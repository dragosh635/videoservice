<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAccountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{

    /**
     * AccountController constructor.
     * All the methods from here are available only for logged in users
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Edit account details
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit()
    {
        $user = auth()->user();

        return view('account.edit', compact('user'));
    }

    /**
     * Update Account details
     *
     * @param  UpdateAccountRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAccountRequest $request)
    {
        $password = $request->filled('password') ? Hash::make($request->password) : auth()->user()->getAuthPassword();

        auth()->user()->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $password,
        ]);

        return redirect()->back();
    }
}
