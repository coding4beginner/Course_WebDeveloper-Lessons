"""A management command to list all templates in the project.

This command will list all templates in the project, depending on the template
engines and loaders that are configured in the Django settings, and display them
in the way you should add them to a `{% url "" %}` template tag or for rendering in
a view.

By default, it will scan all directories in the TEMPLATES setting for
template files.

To customize which template extensions that are scanned, set the
SHOWTEMPLATE_EXTENSIONS setting in your Django settings file. The default
is ['.html', '.htm', '.django', '.jinja', '.md']

Make sure to add this command to the management commands of an app in your
project. For example, you can create a new app called 'example_app' and add this
command to it.

Example Directory Structure:

└── ./
    └── example_project
        └── example_app
            └── management
                ├── commands
                │   ├── __init__.py
                │   └── showtemplates.py
                └── __init__.py

Call it with:

    python manage.py showtemplates
"""

import os

from django.conf import settings
from django.core.management.base import BaseCommand
from django.template import engines
from django.template.loaders.app_directories import Loader as AppDirLoader
from django.template.loaders.filesystem import Loader as FilesystemLoader


class Command(BaseCommand):
    """A management command to list all templates in the project."""

    help = "List all templates with their Django-relative paths"

    def log(self, msg, level=1):
        """Log message if verbosity is high enough."""
        if self.verbosity >= level:
            self.stdout.write(msg)

    def get_template_files(self, directory):
        """Get all template files in a directory.

        Args:
            directory (str): Directory to scan

        Returns:
            list: List of template file paths relative to the directory
        """
        templates = []

        if not os.path.exists(directory):
            self.log(f"Directory does not exist: {directory}", 2)
            return templates

        self.log(f"Scanning directory: {directory}", 2)

        for root, _, files in os.walk(directory):
            for file in files:
                template_extensions = getattr(
                    settings, "SHOWTEMPLATE_EXTENSIONS", [".html", ".htm", ".django", ".jinja", ".md"]
                )
                if file.endswith(tuple(template_extensions)):
                    full_path = os.path.join(root, file)
                    rel_path = os.path.relpath(full_path, directory)
                    templates.append(rel_path)
                    self.log(f"Found template: {rel_path}", 3)

        return templates

    def get_loader_templates(self, loader):
        """Get templates from a specific loader.

        Args:
            loader: Template loader instance

        Returns:
            set: Set of template paths
        """
        templates = set()
        loader_name = loader.__class__.__name__
        self.log(f"Processing loader: {loader_name}", 2)

        # Handle cached loader
        if hasattr(loader, "loaders"):
            self.log("Found cached loader, processing inner loaders", 2)
            for inner_loader in loader.loaders:
                templates.update(self.get_loader_templates(inner_loader))
            return templates

        # Get directories from filesystem loader
        if isinstance(loader, FilesystemLoader):
            self.log("Processing filesystem loader", 2)
            dirs = loader.get_dirs()
            self.log(f"Filesystem loader dirs: {dirs}", 2)
            for template_dir in dirs:
                templates.update(self.get_template_files(template_dir))

        # Get directories from app directories loader
        if isinstance(loader, AppDirLoader):
            self.log("Processing app directories loader", 2)
            app_template_dirs = loader.get_dirs()
            self.log(f"App template dirs: {app_template_dirs}", 2)
            for template_dir in app_template_dirs:
                templates.update(self.get_template_files(template_dir))

        return templates

    def handle(self, *args, **options):
        self.verbosity = options.get("verbosity", 1)
        is_verbose = options.get("verbose", False)
        if is_verbose:
            self.verbosity = 3

        all_templates = set()

        # Process each template configuration
        for template_config in settings.TEMPLATES:
            self.stdout.write(f"\nProcessing template backend: {template_config['BACKEND']}")

            # Find the engine that matches the BACKEND
            backend = None
            for engine in engines.all():
                if engine.__class__.__name__ == template_config["BACKEND"].split(".")[-1]:
                    backend = engine
                    break

            if backend is None:
                self.log(f"Engine not found for backend {template_config['BACKEND']}", 2)
                continue

            engine = backend.engine  # The actual Engine instance

            # Process loaders
            loaders = []
            options_dict = template_config.get("OPTIONS", {})
            loader_list = options_dict.get("loaders", [])

            if loader_list:
                self.log("Found loaders in OPTIONS:", 2)
                loaders = engine.get_template_loaders(loader_list)
            else:
                self.log("No loaders found in OPTIONS, using engine's loaders", 2)
                loaders = engine.template_loaders

            # Process loaders
            for loader in loaders:
                templates = self.get_loader_templates(loader)
                all_templates.update(templates)

        # Sort results
        template_list = sorted(all_templates)

        if not template_list:
            self.stdout.write("\nNo templates found.")
            return

        self.stdout.write("\nFound templates:")
        self.stdout.write("\n".join(template_list))
        self.stdout.write(f"\nTotal templates found: {len(template_list)}")
        