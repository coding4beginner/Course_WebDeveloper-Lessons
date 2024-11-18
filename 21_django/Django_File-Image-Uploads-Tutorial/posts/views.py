from django.urls import reverse_lazy
from django.views.generic import ListView, CreateView


from django.shortcuts import redirect, get_object_or_404
from django.contrib import messages

from .forms import PostForm 
from .models import Post


class IndexPageView(ListView):
    model = Post
    template_name = "posts/index.html"


class CreatePostView(CreateView):  # new
    model = Post
    form_class = PostForm
    template_name = "posts/post.html"
    success_url = reverse_lazy("index")


def delete_post(request, post_id):
    if request.method == "POST":
        post = get_object_or_404(Post, id=post_id)
        post.cover.delete()  # Deletes the associated image file
        post.delete()        # Deletes the Post instance
        messages.success(request, "Post deleted successfully.")

    return redirect('index')  # Redirect to the list view
