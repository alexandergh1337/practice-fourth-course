from django.contrib.auth import views as auth_views
from django.urls import path

from . import views

urlpatterns = [
    path("", views.home, name="home"),
    path("register/", views.register, name="register"),
    path(
        "login/",
        auth_views.LoginView.as_view(template_name="booking/login.html"),
        name="login",
    ),
    path("logout/", views.logout_user, name="logout"),
    path("book/", views.create_booking, name="create_booking"),
    path("my-bookings/", views.my_bookings, name="my_bookings"),
    path("review/<int:booking_id>/", views.add_review, name="add_review"),
]
