<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CustomerRegisterController extends Controller
{
    public function register(){
        return view('website.customer.auth.register');
    }

    public function store(SignupRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'password'     => bcrypt($data['password']),
            'system_admin' => 'customer',
        ]);

        Auth::login($user);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Account created successfully!');

    }
}
