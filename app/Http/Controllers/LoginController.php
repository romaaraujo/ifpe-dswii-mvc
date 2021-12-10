<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function login()
    {
        $usuario = Usuario::where(['email' => request()->input('email')])->first();
        if ($usuario !== null) {
            if (password_verify(request()->input('senha'), $usuario->senha)) {
                $token = md5(time() . $usuario->email);
                $usuario->token = $token;
                $usuario->save();

                return redirect()->to(url(env('FRONTEND_URL') . '/auth/login.php?token=' . $token));
            }
        }
    }

    //
}
