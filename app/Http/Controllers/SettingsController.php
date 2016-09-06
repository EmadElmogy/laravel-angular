<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

use App\Http\Requests;

class SettingsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('settings.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function save()
    {
        $data = request()->all();

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect('settings')->with('success', true);
    }

    public function mail(){
        $user=['hi','lol'];
        \Mail::send('emails.email', ['user' => $user], function ($m) use ($user) {
            $m->from('mobile@bluecrunch.com', 'Your Application');

            $m->to('emadelmogy619@gmail.com', 'emad')->subject('Your Reminder!');
        });
    }
}
