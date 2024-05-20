from django.db import models

# Create your models here.
from django.db import models

class Segmentation(models.Model):
    deg_id = models.IntegerField()
    seg_img = models.ImageField(upload_to='segmentation_images/')  # Assuming seg_img is an image field

    def __str__(self):
        return f"ID: {self.seg_id}, Image: {self.seg_img}"
