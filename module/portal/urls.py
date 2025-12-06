from django.urls import path
from . import views

app_name = 'portal'

urlpatterns = [
    path('', views.index, name='index'),
    path('register/', views.register_view, name='register'),
    path('login/', views.login_view, name='login'),
    path('logout/', views.logout_view, name='logout'),
    path('applications/create/', views.create_application, name='create_application'),
    path('applications/', views.applications_view, name='applications'),
    path('applications/<int:pk>/feedback/', views.add_feedback, name='add_feedback'),
]