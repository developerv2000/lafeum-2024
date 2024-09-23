<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.pages.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        // Initialize the Agent instance
        $agent = new Agent();

        // Use an external service to get country based on IP using ipinfo.io
        $ip = $request->ip();
        $country = User::getCountryFromIP($ip);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'registered_ip_address' => $ip,
            'registered_browser' => $agent->browser(),
            'registered_device' => $agent->device(),
            'registered_country' => $country,
        ]);

        $user->roles()->attach(Role::findByName(Role::USER_NAME)->id);

        Auth::login($user);

        event(new Registered($user));

        return redirect()->intended(route('home'));
    }
}
