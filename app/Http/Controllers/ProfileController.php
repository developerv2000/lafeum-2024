<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Country;
use App\Models\Gender;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\File;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $countries = Country::getAll();
        $genders = Gender::getAll();

        return view('front.pages.profile', compact('user', 'countries', 'genders'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->updateProfileFromRequest($request);

        return redirect()->back()->with('status', 'profile-updated');
    }

    public function updateAva(Request $request)
    {
        $request->validate([
            'photo' => ['file', File::types(['png', 'jpg', 'jpeg']), 'required'],
        ]);

        $request->user()->updatePhoto($request);

        return redirect()->back();
    }

    public function deleteAva(Request $request)
    {
        $user = $request->user();
        $user->photo = null;
        $user->save();

        return redirect()->back();
    }

    // /**
    //  * Delete the user's account.
    //  */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validateWithBag('userDeletion', [
    //         'password' => ['required', 'current_password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }
}
