import os
from django.core.management.base import BaseCommand
from posts.models import Post
from django.conf import settings
from django.core.files import File

class Command(BaseCommand):
    help = "Seed the database with initial posts and images from the seed_images folder"

    def handle(self, *args, **kwargs):
        media_folder = os.path.join(settings.MEDIA_ROOT, 'images')
        image_folder = os.path.join(settings.BASE_DIR, 'seed_images')
        
        # Clear all files in the media folder
        if os.path.exists(media_folder):
            for file_name in os.listdir(media_folder):
                file_path = os.path.join(media_folder, file_name)
                if os.path.isfile(file_path):
                    os.remove(file_path)
                    self.stdout.write(self.style.SUCCESS(f"Deleted file: {file_path}"))
        else:
            self.stdout.write(self.style.WARNING(f"Media folder '{media_folder}' does not exist. Skipping deletion."))


        if not os.path.exists(image_folder):
            self.stdout.write(self.style.ERROR("Image folder does not exist!"))
            return

        # Allowed image file extensions
        allowed_extensions = {".jpg", ".jpeg", ".png", ".gif"}

        # Get a list of all valid image files in the folder
        image_files = [
            f for f in os.listdir(image_folder)
            if os.path.isfile(os.path.join(image_folder, f)) and os.path.splitext(f)[1].lower() in allowed_extensions
        ]

        if not image_files:
            self.stdout.write(self.style.ERROR("No valid image files found in the seed_images folder!"))
            return

        Post.objects.all().delete()

        for image_file in image_files:
            image_path = os.path.join(image_folder, image_file)

            with open(image_path, "rb") as img_file:
                # Use the file name (without extension) as the title
                title = os.path.splitext(image_file)[0]

                # Create a new Post instance
                post = Post(
                    title=title.capitalize()  # Capitalize the title for aesthetics
                )
                post.cover.save(image_file, File(img_file))
                post.save()

                self.stdout.write(self.style.SUCCESS(f"Post '{title}' created with image '{image_file}'."))


