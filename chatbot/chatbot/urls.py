from django.contrib import admin
from django.urls import path
from  chatbotapp import views

urlpatterns = [
    path('admin/', admin.site.urls),
    path('',views.home,name='home'),
    path('bot_response/', views.bot_response, name='bot_response'), # 応答
]
