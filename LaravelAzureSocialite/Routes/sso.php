<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Http\Request;


Route::middleware(['web'])->group(function () {

    Route::post('logout', function (Request $request) {
        Auth::guard()->logout();
        $request->session()->flush();
        $azureLogoutUrl = Socialite::driver('azure')->getLogoutUrl(route('login'));
        return redirect($azureLogoutUrl);
    })->name('logout');

    Route::get('/auth/redirect', function () {
        return Socialite::driver('azure')->scopes(['User.Read'])->redirect();
    })->name('login');

    Route::get('/auth/callback', function () {
        $azureUser  = Socialite::driver('azure')->user();

        $user = User::updateOrCreate([
            'email' => $azureUser->email,
        ], [
            'name' => $azureUser->name,
            'email' => $azureUser->email,
            'azure_access_token' => $azureUser->token,
            'azure_refresh_token' => $azureUser->refreshToken,
            'azure_expires_timestamp' => date('Y-m-d H:i:s', bcadd(strtotime(date('Y-m-d H:i:s')), $azureUser->expiresIn)),
        ]);

        Auth::login($user);

        return redirect('/');
    });

    Route::get('/auth/refresh', function () {
        return redirect(route('login'));
    });


    Route::get('/', function () {
        return view('shawinigan_sso::welcome', ['user' => Auth::user()]);
    })->middleware('auth')->name('home');

    Route::get('/applications', function () {
        return view('shawinigan_sso::dashboard', ['user' => Auth::user()]);
    })->middleware('auth')->name('dashboard');


});



