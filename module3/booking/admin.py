from django.contrib import admin

from .models import Booking, User

admin.site.site_header = "Я буду кушац"
admin.site.site_title = "Администрирование"
admin.site.index_title = "Добро пожаловать в панель управления"


@admin.register(User)
class UserAdmin(admin.ModelAdmin):
    list_display = ["username", "first_name", "last_name", "phone", "email"]
    search_fields = ["username", "phone"]


@admin.register(Booking)
class BookingAdmin(admin.ModelAdmin):
    list_display = ["id", "user", "date", "time", "status", "guests"]
    list_filter = ["status", "date"]
    search_fields = ["user__username", "contact_phone"]
    list_editable = ["status"]
