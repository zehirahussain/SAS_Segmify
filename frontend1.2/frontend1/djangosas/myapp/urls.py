# C:\xampp\htdocs\fyp0.3\djangosas\myapp\urls.py
from django.urls import path
from . import views

urlpatterns = [
    path('', views.home, name='home'),
]
