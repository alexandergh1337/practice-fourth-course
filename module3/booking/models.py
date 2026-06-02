from django.contrib.auth.models import AbstractUser
from django.core.validators import MaxValueValidator, MinValueValidator, RegexValidator
from django.db import models

phone_validator = RegexValidator(
    regex=r"^\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}$", message="Формат: +7(XXX)-XXX-XX-XX"
)


class User(AbstractUser):
    username = models.CharField(max_length=150, unique=True, verbose_name="Логин")
    phone = models.CharField(
        max_length=20, validators=[phone_validator], verbose_name="Телефон"
    )


class Booking(models.Model):
    STATUS_CHOICES = [
        ("new", "Новое"),
        ("visited", "Посещение состоялось"),
        ("cancelled", "Отменено"),
    ]
    user = models.ForeignKey(User, on_delete=models.CASCADE, related_name="bookings")
    date = models.DateField(verbose_name="Дата")
    time = models.TimeField(verbose_name="Время")
    guests = models.IntegerField(
        validators=[MinValueValidator(1), MaxValueValidator(10)], verbose_name="Гостей"
    )
    contact_phone = models.CharField(
        max_length=20, validators=[phone_validator], verbose_name="Телефон"
    )
    status = models.CharField(
        max_length=20, choices=STATUS_CHOICES, default="new", verbose_name="Статус"
    )
    review = models.TextField(blank=True, null=True, verbose_name="Отзыв")
    created_at = models.DateTimeField(auto_now_add=True)
