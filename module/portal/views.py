from django.contrib.auth import login, logout
from django.contrib.auth.decorators import login_required
from django.contrib.auth.forms import AuthenticationForm
from django.shortcuts import redirect, render

from portal.forms import ApplicationForm, FeedbackForm, RegistrationForm
from portal.models import Application


# Create your views here.
def index(request):
    return render(request, "portal/index.html")


def register_view(request):
    form = RegistrationForm(request.POST)
    if request.method == "POST" and form.is_valid():
        login(request, form.save())
        return redirect("portal:applications")
    return render(request, "portal/register.html", {"form": form})


def login_view(request):
    form = AuthenticationForm(request, data=request.POST)
    if request.method == "POST" and form.is_valid():
        login(request, form.get_user())
        return redirect("portal:applications")
    return render(request, "portal/login.html", {"form": form})


def logout_view(request):
    logout(request)
    return redirect("portal:login")


@login_required
def create_application(request):
    form = ApplicationForm(request.POST)
    if request.method == "POST" and form.is_valid():
        app = form.save(commit=False)
        app.user = request.user
        app.save()
        return redirect("portal:applications")
    return render(request, "portal/create_application.html", {"form": form})


@login_required
def applications_view(request):
    apps = Application.objects.filter(user=request.user).order_by("-created_at")
    return render(request, "portal/applications.html", {"applications": apps})


@login_required
def add_feedback(request, pk):
    app = Application.objects.get(pk=pk, user=request.user)
    if app.status != "completed":
        return redirect("portal:applications")
    form = FeedbackForm(request.POST or None, instance=app)
    if request.method == "POST" and form.is_valid():
        form.save()
        return redirect("portal:applications")
    return render(request, "portal/add_feedback.html", {"form": form})
