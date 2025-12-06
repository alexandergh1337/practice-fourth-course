from django import forms
from django.contrib.auth.forms import UserCreationForm
from portal.models import User, Course, Application
import re
from datetime import date

class RegistrationForm(UserCreationForm):

    
    class Meta:
        model = User
        fields = ['username', 'email', 'full_name', 'phone', 'password1', 'password2']

    def clean_username(self):
        username = self.cleaned_data['username']
        if not re.match(r'^[A-Za-z0-9]{6,}$', username):
            raise forms.ValidationError('Логин: латиница и цифры, не менее 6 символов')
        return username
    
    def clean_full_name(self):
        full_name = self.cleaned_data['full_name']
        if not re.match(r'^[А-Яа-яЁё\s]+$', full_name):
            raise forms.ValidationError('ФИО: символы кириллицы и пробелы')
        return full_name
    
    def clean_phone(self):
        phone = self.cleaned_data['phone']
        if not re.match(r'^8\(\d{3}\)\d{3}-\d{2}-\d{2}$', phone):
            raise forms.ValidationError('Телефон: формат 8(XXX)XXX-XX-XX')
        return phone
    
class ApplicationForm(forms.ModelForm):
    course = forms.ModelChoiceField(queryset=Course.objects.all(), label='Курс')
    start_date = forms.DateField(label='Дата начала', widget=forms.DateInput(attrs={'type': 'date'}))
    class Meta:
        model = Application
        fields = ['course', 'start_date', 'payment_method']

    def clean_start_date(self):
        start_date = self.cleaned_data['start_date']
        if start_date < date.today():
            raise forms.ValidationError('Дата не может быть в прошлом')
        return start_date

class FeedbackForm(forms.ModelForm):
    class Meta:
        model = Application
        fields = ['feedback']
        widgets = {'feedback': forms.Textarea(attrs={'rows': 3})}