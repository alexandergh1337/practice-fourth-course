<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where("user_id", Auth::id())->latest()->get();
        return view("dashboard", compact("bookings"));
    }

    public function create()
    {
        $services = Service::all();
        return view("bookings.create", compact("services"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "service_id" => "required",
            "address" => "required|string",
            "scheduled_at" => "required",
            "payment_method" => "required",
        ]);

        Booking::create([
            "user_id" => Auth::id(),
            "service_id" => $request->service_id,
            "address" => $request->address,
            "scheduled_at" => $request->scheduled_at,
            "payment_method" => $request->payment_method,
        ]);

        return redirect()
            ->route("dashboard")
            ->with("success", "Заявка успешно создана!");
    }

    public function adminIndex()
    {
        $bookings = Booking::with(["user", "service"])
            ->latest()
            ->get();
        return view("admin.index", compact("bookings"));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $booking->update([
            "status" => $request->status,
            "cancel_reason" => $request->cancel_reason,
        ]);
        return back()->with("success", "Статус обновлен");
    }
}
