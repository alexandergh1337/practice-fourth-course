import re

from django import forms
from django.core.exceptions import ValidationError

from .models import Booking, User


class RegisterForm(forms.ModelForm):
    password = forms.CharField(widget=forms.PasswordInput, min_length=6, label="Пароль")

    class Meta:
        model = User
        fields = ["username", "first_name", "last_name", "phone", "email", "password"]

    def clean_username(self):
        username = self.cleaned_data.get("username")
        if not re.match(r"^[а-яА-ЯёЁ]{6,}$", username):
            raise ValidationError(
                "Логин должен состоять только из кириллицы и быть не менее 6 символов."
            )
        if User.objects.filter(username=username).exists():
            raise ValidationError("Этот логин уже занят.")
        return username

    def clean_phone(self):
        phone = self.cleaned_data.get("phone")
        if not re.match(r"^\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}$", phone):
            raise ValidationError("Формат телефона должен быть +7(XXX)-XXX-XX-XX")
        return phone

    def save(self, commit=True):
        user = super().save(commit=False)
        user.set_password(self.cleaned_data["password"])
        if commit:
            user.save()
        return user


class BookingForm(forms.ModelForm):
    class Meta:
        model = Booking
        fields = ["date", "time", "guests", "contact_phone"]
        widgets = {
            "date": forms.DateInput(attrs={"type": "date", "class": "form-control"}),
            "time": forms.TimeInput(attrs={"type": "time", "class": "form-control"}),
            "guests": forms.NumberInput(
                attrs={"min": 1, "max": 10, "class": "form-control"}
            ),
            "contact_phone": forms.TextInput(
                attrs={"placeholder": "+7(XXX)-XXX-XX-XX", "class": "form-control"}
            ),
        }
