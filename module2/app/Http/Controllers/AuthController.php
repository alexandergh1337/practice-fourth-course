<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view("auth.register");
    }

    public function showLogin()
    {
        return view("auth.login");
    }

    public function register(Request $request)
    {
        $request->validate(
            [
                "name" => ["required", "string", 'regex:/^[А-Яа-яЁё\s\-]+$/u'],
                "login" => [
                    "required",
                    "unique:users",
                    "min:6",
                    'regex:/^[A-Za-z0-9]+$/',
                ],
                "email" => ["required", "email", "unique:users"],
                "phone" => [
                    "required",
                    'regex:/^\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}$/',
                ],
                "password" => ["required", "min:6", "confirmed"],
            ],
            [
                "name.regex" => "ФИО должно быть на кириллице.",
                "login.regex" =>
                    "Логин должен содержать только латиницу и цифры.",
                "phone.regex" =>
                    "Телефон должен быть в формате +7(XXX)-XXX-XX-XX",
            ],
        );

        $user = User::create([
            "name" => $request->name,
            "login" => $request->login,
            "email" => $request->email,
            "phone" => $request->phone,
            "password" => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect("/")->with("success", "Регистрация успешна!");
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "login" => ["required"],
            "password" => ["required"],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended("/")->with("success", "Вы вошли!");
        }

        return back()
            ->withErrors(["login" => "Неверный логин или пароль."])
            ->onlyInput("login");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/");
    }
}
