from django.core.management.base import BaseCommand
from portal.models import Course

class Command(BaseCommand):
    help = 'Создаёт курсы для заявок'

    def handle(self, *args, **options):
        data = [
            'Основы алгоритмизации и программирования',
            'Основы веб-дизайна',
            'Основы проектирования баз данных',
        ]
        for name in data:
            Course.objects.get_or_create(name=name)
        self.stdout.write(self.style.SUCCESS('Курсы созданы'))