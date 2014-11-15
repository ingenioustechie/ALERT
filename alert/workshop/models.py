from django.db import models

# Create your models here.
class workshops(models.Model):
    workshopDate = models.DateField()
    timeFrom = models.DateField()
    timeTo = models.DateField()
    noOfAttendees = models.CharField(max_length=10)
    dateEnquiry = models.DateField()
    contactPerson = models.CharField(max_length = 255)
    contactNo = models.CharField(max_length = 10)
    venue = models.CharField(max_length = 255)
    doctor = models.CharField(max_length=255)
    noOfCertificates = models.CharField(max_length = 10)
    noOfKits = models.CharField(max_length=10)
    noOfCds = models.CharField(max_length = 10)
    noOfManuals = models.CharField(max_length = 10)
    noOfStickers = models.CharField(max_length = 10)
