<?php

namespace App\Http\Controllers;

use App\Advisor;

class ApiController extends Controller
{
    public function login()
    {
        validate(request()->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        $advisor = Advisor::where(request()->only('username', 'password'))->first();

        if (! $advisor) {
            return response('Unauthorized.', 401);
        }

        return response([
            'advisor' => transform($advisor)
        ]);
    }

}
