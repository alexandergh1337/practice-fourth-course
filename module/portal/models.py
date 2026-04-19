from django.contrib.auth.models import AbstractUser
from django.db import models


class User(AbstractUser):
    full_name = models.CharField("ФИО", max_length=255)
    phone = models.CharField("Телефон", max_length=18)
    email = models.EmailField("Электронная почта", unique=True)


class Course(models.Model):
    name = models.CharField("Название", max_length=255, unique=True)

    def __str__(self):
        return self.name


class Application(models.Model):
    PAYMENTS = [("cash", "Наличными"), ("phone", "Перевод по номеру телефона")]
    STATUSES = [
        ("new", "Новая"),
        ("in_progress", "Идёт обучение"),
        ("completed", "Обучение завершено"),
    ]

    user = models.ForeignKey(
        User, on_delete=models.CASCADE, related_name="applications"
    )
    course = models.ForeignKey(Course, on_delete=models.PROTECT)
    start_date = models.DateField()
    payment_method = models.CharField("Способ оплаты", max_length=10, choices=PAYMENTS)
    status = models.CharField(max_length=16, choices=STATUSES, default="new")
    feedback = models.TextField("Отзыв", blank=True, null=True)
    created_at = models.DateTimeField(auto_now_add=True)
