from django import forms

from .models import Booking, User


class RegisterForm(forms.ModelForm):
    password = forms.CharField(widget=forms.PasswordInput, min_length=6, label="Пароль")

    class Meta:
        model = User
        fields = ["username", "first_name", "last_name", "phone", "email", "password"]
        widgets = {
            "phone": forms.TextInput(
                attrs={"placeholder": "+7(XXX)-XXX-XX-XX", "class": "form-control"}
            ),
        }

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
