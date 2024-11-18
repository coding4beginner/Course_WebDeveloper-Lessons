from django.urls import path

from .views import CreatePostView, IndexPageView, delete_post

urlpatterns = [
    path("", IndexPageView.as_view(), name="index"),
    path("post/", CreatePostView.as_view(), name="add_post"),
    path('delete/<int:post_id>/', delete_post, name='delete_post'),
]