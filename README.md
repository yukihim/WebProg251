# Website Project Folder Structure

This document outlines the standard folder structure for this project.

## Folder Structure

```
project-root/
├── public/           # Publicly accessible files (served by the web server)
│   ├── index.php     # Main entry point
│   ├── css/          # Stylesheets
│   ├── js/           # JavaScript files
│   ├── images/       # Images used in the website
│   └── assets/       # Other public assets (fonts, icons, etc.)
│
├── app/              # Application Logic (controllers, models, functions)
│
├── config/           # Configuration files (database, app settings)
│
├── resources/        # Templates, views, raw assets before compilation
│
├── storage/          # Logs, cached files, uploaded files
│
├── vendor/           # External libraries (if using Composer)
│
└── README.md         # Documentation for the project
```

## Request Flow

1.  A visitor opens `http://localhost/`.
2.  Apache points the request to `public/index.php`.
3.  `index.php` loads application logic from the `app/` directory.
4.  The `config/` directory provides database information and other settings.
5.  CSS, JavaScript, and images are loaded from their respective subfolders in the `public/` directory.