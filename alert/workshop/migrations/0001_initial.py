# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.db import models, migrations


class Migration(migrations.Migration):

    dependencies = [
    ]

    operations = [
        migrations.CreateModel(
            name='workshops',
            fields=[
                ('id', models.AutoField(serialize=False, primary_key=True, auto_created=True, verbose_name='ID')),
                ('workshopDate', models.DateField()),
                ('timeFrom', models.DateField()),
                ('timeTo', models.DateField()),
                ('noOfAttendees', models.CharField(max_length=10)),
                ('dateEnquiry', models.DateField()),
                ('contactPerson', models.CharField(max_length=255)),
                ('contactNo', models.CharField(max_length=10)),
                ('venue', models.CharField(max_length=255)),
                ('doctor', models.CharField(max_length=255)),
                ('noOfCertificates', models.CharField(max_length=10)),
                ('noOfKits', models.CharField(max_length=10)),
                ('noOfCds', models.CharField(max_length=10)),
                ('noOfManuals', models.CharField(max_length=10)),
                ('noOfStickers', models.CharField(max_length=10)),
            ],
            options={
            },
            bases=(models.Model,),
        ),
    ]
