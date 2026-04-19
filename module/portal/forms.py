import re

from django import forms
from django.contrib.auth.forms import UserCreationForm

from .models import Application, Course, User


class RegistrationForm(UserCreationForm):
    full_name = forms.CharField(label="ФИО")
    phone = forms.CharField(label="Телефон")

    class Meta:
        model = User
        fields = ["username", "email", "full_name", "phone"]

    def clean_username(self):
        v = self.cleaned_data["username"]
        if not re.match(r"^[A-Za-z0-9]{6,}$", v):
            raise forms.ValidationError("Минимум 6 символов, латиница и цифры")
        return v

    def clean_full_name(self):
        v = self.cleaned_data["full_name"]
        if not re.match(r"^[А-Яа-яЁё\s]+$", v):
            raise forms.ValidationError("Только кириллица и пробелы")
        return v

    def clean_phone(self):
        v = self.cleaned_data["phone"]
        if not re.match(r"^8\(\d{3}\)\d{3}-\d{2}-\d{2}$", v):
            raise forms.ValidationError("Формат: 8(XXX)XXX-XX-XX")
        return v


class ApplicationForm(forms.ModelForm):
    start_date = forms.DateField(
        label="Дата начала",
        input_formats=["%d.%m.%Y"],
        widget=forms.DateInput(attrs={"placeholder": "ДД.ММ.ГГГГ"}),
    )

    class Meta:
        model = Application
        fields = ["course", "start_date", "payment_method"]


class FeedbackForm(forms.ModelForm):
    class Meta:
        model = Application
        fields = ["feedback"]
        widgets = {"feedback": forms.Textarea(attrs={"rows": 3})}
