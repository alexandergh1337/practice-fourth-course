import re

from django import forms
from django.core.exceptions import ValidationError

from .models import Booking, User


class RegisterForm(forms.ModelForm):
    password = forms.CharField(widget=forms.PasswordInput, min_length=6, label="Пароль")

    class Meta:
        model = User
        fields = ["username", "first_name", "last_name", "email", "phone", "password"]
        widgets = {
            f: forms.TextInput(attrs={"class": "form-control"})
            for f in ["username", "first_name", "last_name", "email", "phone"]
        }
        widgets["password"] = forms.PasswordInput(attrs={"class": "form-control"})

    def clean_username(self):
        username = self.cleaned_data.get("username")
        if not re.match(r"^[а-яА-ЯёЁ]{6,}$", username):
            raise ValidationError(
                "Логин должен быть на кириллице и не менее 6 символов."
            )
        return username

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
                attrs={"class": "form-control", "min": 1, "max": 10}
            ),
            "contact_phone": forms.TextInput(
                attrs={"class": "form-control", "placeholder": "+7(XXX)-XXX-XX-XX"}
            ),
        }
