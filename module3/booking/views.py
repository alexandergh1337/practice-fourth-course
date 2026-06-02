from django.contrib import messages
from django.contrib.auth import login
from django.contrib.auth.decorators import login_required
from django.shortcuts import redirect, render

from .forms import BookingForm, RegisterForm
from .models import Booking


def home(request):
    return render(request, "booking/home.html")


def register(request):
    if request.method == "POST":
        form = RegisterForm(request.POST)
        if form.is_valid():
            user = form.save()
            login(request, user)
            return redirect("home")
        messages.error(request, "Ошибка регистрации. Проверьте данные.")
    else:
        form = RegisterForm()
    return render(request, "booking/register.html", {"form": form})


@login_required
def create_booking(request):
    if request.method == "POST":
        form = BookingForm(request.POST)
        if form.is_valid():
            booking = form.save(commit=False)
            booking.user = request.user
            booking.save()
            messages.success(request, "Заявка отправлена!")
            return redirect("my_bookings")
    else:
        form = BookingForm()
    return render(request, "booking/create_booking.html", {"form": form})


@login_required
def my_bookings(request):
    bookings = Booking.objects.filter(user=request.user).order_by("-created_at")
    return render(request, "booking/my_bookings.html", {"bookings": bookings})


@login_required
def add_review(request, booking_id):
    booking = Booking.objects.get(id=booking_id, user=request.user)
    if booking.status == "visited" and request.method == "POST":
        booking.review = request.POST.get("review")
        booking.save()
        messages.success(request, "Отзыв добавлен!")
    return redirect("my_bookings")
