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
    list_display = ["id", "user", "date", "time", "status", "guests", "contact_phone"]
    list_filter = ["status", "date", "created_at"]
    search_fields = ["user__username", "contact_phone", "user__first_name"]
    list_editable = ["status"]
    list_per_page = 10
    date_hierarchy = "date"
