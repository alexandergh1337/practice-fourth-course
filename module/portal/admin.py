from django.contrib import admin
from django.contrib.auth.admin import UserAdmin as BaseUserAdmin
from portal.models import User, Application, Course

# Register your models here.
@admin.register(User)
class UserAdmin(BaseUserAdmin):
    list_display = ('id', 'username', 'full_name', 'email', 'phone')
    search_fields = ('username', 'full_name', 'email', 'phone')

@admin.register(Course)
class CourseAdmin(admin.ModelAdmin):
    list_display = ('id', 'name', 'created_at')
    search_fields = ('name',)
    
@admin.register(Application)
class ApplicationAdmin(admin.ModelAdmin):
    list_display = ('id', 'user', 'course', 'start_date', 'payment_method', 'status', 'created_at')
    list_editable = ('status',)
    list_filter = ('course', 'payment_method', 'status', 'start_date', 'created_at',)
    search_fields = ('user__username', 'user__full_name', 'user__email', 'user__phone', 'course__name')
    ordering = ('-created_at',)