<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function toggleTheme(Request $request)
    {
        $user = $request->user();
        $reversedTheme = $user->settings['preferred_theme'] == 'light' ? 'dark' : 'light';
        $user->updateSetting('preferred_theme', $reversedTheme);

        return redirect()->back();
    }
}
