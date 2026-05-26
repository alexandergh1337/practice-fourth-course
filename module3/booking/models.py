from django.contrib.auth.models import AbstractUser
from django.core.validators import MaxValueValidator, MinValueValidator, RegexValidator
from django.db import models

cyrillic_username = RegexValidator(
    regex=r"^[а-яА-ЯёЁ]{6,}$",
    message="Логин должен состоять только из кириллицы и быть не менее 6 символов.",
)
phone_regex = RegexValidator(
    regex=r"^\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}$",
    message="Формат телефона должен быть +7(XXX)-XXX-XX-XX",
)


class User(AbstractUser):
    username = models.CharField(
        max_length=150,
        unique=True,
        validators=[cyrillic_username],
        verbose_name="Логин",
    )
    phone = models.CharField(
        max_length=20, validators=[phone_regex], verbose_name="Номер телефона"
    )

    def __str__(self):
        return self.username


class Booking(models.Model):
    STATUS_CHOICES = [
        ("new", "Новое"),
        ("completed", "Посещение состоялось"),
        ("cancelled", "Отменено"),
    ]

    user = models.ForeignKey(User, on_delete=models.CASCADE, related_name="bookings")
    date = models.DateField(verbose_name="Дата")
    time = models.TimeField(verbose_name="Время")
    guests = models.IntegerField(
        validators=[MinValueValidator(1), MaxValueValidator(10)],
        verbose_name="Количество гостей",
    )
    contact_phone = models.CharField(
        max_length=20, validators=[phone_regex], verbose_name="Контактный номер"
    )
    status = models.CharField(
        max_length=20, choices=STATUS_CHOICES, default="new", verbose_name="Статус"
    )
    review = models.TextField(blank=True, null=True, verbose_name="Отзыв")
    created_at = models.DateTimeField(auto_now_add=True)

    def __str__(self):
        return f"Бронь {self.id} - {self.user.username} ({self.date})"
