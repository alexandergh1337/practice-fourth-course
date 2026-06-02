from django.contrib import admin

from .models import Booking, User

admin.site.register(User)
admin.site.register(Booking)
