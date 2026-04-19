from django.contrib import admin
from django.contrib.auth.admin import UserAdmin as BaseUserAdmin

from portal.models import Application, Course, User


# Register your models here.
@admin.register(User)
class UserAdmin(BaseUserAdmin):
    list_display = ("id", "username", "full_name", "email", "phone")
    search_fields = ("username", "full_name", "email", "phone")


@admin.register(Course)
class CourseAdmin(admin.ModelAdmin):
    list_display = ("id", "name")
    search_fields = ("name",)


@admin.register(Application)
class ApplicationAdmin(admin.ModelAdmin):
    list_display = ("id", "user", "course", "start_date", "status")
    list_editable = ("status",)
    list_filter = ("status", "course")
    search_fields = ("user__username", "course__name")
