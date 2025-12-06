from django.shortcuts import render, redirect
from django.contrib.auth import login, logout
from django.contrib.auth.forms import AuthenticationForm
from django.contrib.auth.decorators import login_required
from portal.forms import RegistrationForm, ApplicationForm, FeedbackForm
from portal.models import Application

# Create your views here.
def index(request):
    return render(request, 'portal/index.html')

def register_view(request):
    if request.method == 'POST':
        form = RegistrationForm(request.POST)
        if form.is_valid():
            user = form.save()
            login(request, user)
            return redirect('portal:applications')
    else:
        form = RegistrationForm()
    return render(request, 'portal/register.html', {'form': form})

def login_view(request):
    form = AuthenticationForm(request, data=request.POST or None)
    if request.method == 'POST' and form.is_valid():
        login(request, form.get_user())
        return redirect('portal:applications')
    return render(request, 'portal/login.html', {'form': form})

def logout_view(request):
    logout(request)
    return redirect('portal:login')

@login_required
def create_application(request):
    if request.method == 'POST':
        form = ApplicationForm(request.POST)
        if form.is_valid():
            app = form.save(commit=False)
            app.user = request.user
            app.save()
            return redirect('portal:applications')
    else:
        form = ApplicationForm()
    return render(request, 'portal/create_application.html', {'form': form})

@login_required
def applications_view(request):
    apps = Application.objects.filter(user=request.user).order_by('-created_at')
    return render(request, 'portal/applications.html', {'applications': apps})

@login_required
def add_feedback(request, pk):
    app = Application.objects.get(pk=pk, user=request.user)
    if app.status != 'completed':
        return redirect('portal:applications')
    if request.method == 'POST':
        form = FeedbackForm(request.POST, instance=app)
        if form.is_valid():
            form.save()
            return redirect('portal:applications')
    else:
        form = FeedbackForm(instance=app)
    return render(request, 'portal/add_feedback.html', {'form': form, 'app': app})