<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::where("user_id", Auth::id())
            ->latest()
            ->get();
        return view("dashboard", compact("applications"));
    }

    public function create()
    {
        $services = Service::all();
        return view("applications.create", compact("services"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "service_id" => "required|exists:services,id",
            "phone" => "required",
            "date" => "required|date",
            "time" => "required",
            "guests" => "required|integer|between:1,10",
        ]);

        Application::create([
            "user_id" => Auth::id(),
            "service_id" => $request->service_id,
            "details" => $request->details,
            "date" => $request->date,
            "time" => $request->time,
            "guests" => $request->guests,
            "phone" => $request->phone,
            "payment_method" => $request->payment_method,
            "status" => "Новая",
        ]);

        return redirect("/dashboard")->with(
            "success",
            "Заявка успешно создана!",
        );
    }

    public function adminIndex()
    {
        $applications = Application::with(["user", "service"])
            ->latest()
            ->get();
        return view("admin.index", compact("applications"));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $request->validate([
            "status" => "required",
            "cancel_reason" => "required_if:status,Отменена",
        ]);

        $application->update([
            "status" => $request->status,
            "cancel_reason" => $request->cancel_reason,
        ]);

        return back()->with("success", "Статус обновлен!");
    }

    public function updateReview(Request $request, Application $application)
    {
        if (
            $application->user_id !== Auth::id() ||
            $application->status !== "Посещение состоялось"
        ) {
            return back()->with("error", "Вы не можете оставить отзыв.");
        }

        $request->validate(["review" => "required|string|min:5"]);

        $application->update(["review" => $request->review]);

        return back()->with("success", "Отзыв сохранен!");
    }
}
