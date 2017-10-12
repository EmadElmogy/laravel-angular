<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (auth()->check()) {
            return redirect('admins');
        }

        return redirect('login');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view('login');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {
        validate($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], true)) {
            return redirect()->intended('/')->with('loginSuccess', true);
        }

        return redirect('login')->with('loginFailed', true);
    }

    /**
     * @param $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function logout(Request $request)
    {
        auth()->logout();

        return redirect('login')->with('loggedOutSuccessfully', true);
    }
}
