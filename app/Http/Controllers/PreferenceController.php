<?php

namespace App\Http\Controllers;

use App\Models\Preference;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{
    //
    public static function set($name, $value)
    {
        $preference = Preference::where([
            'user_id' => Auth::user()->id,
            'name' => $name
        ]);

        if($preference->first()) {
            Preference::where([
                'user_id' => Auth::user()->id,
                'name' => $name
            ])->update([
                'value' => $value
            ]);
        } else {
            Preference::create([
                'user_id' => Auth::user()->id,
                'name' => $name,
                'value' => $value
            ]);
        }

        if(request('redirectTo')) return redirect(request('redirectTo'));
        return back()->withInput();
    }

    public static function get($name)
    {
        $preference = Preference::where([
            'user_id' => Auth::user()->id,
            'name' => $name
        ])->first();

        return $preference ? $preference->value : null;
    }
}
