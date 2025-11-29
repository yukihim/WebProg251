# The Executive Garage

A modern car dealership platform for browsing, searching, and managing luxury and performance automobiles.

---

## Project Overview

The Executive Garage is a web application for car enthusiasts and buyers to explore, filter, and view details of premium cars from top brands.  
It features user authentication, brand and style filtering, search, and social login options.

---

## Setup Instructions

### Prerequisites
- **XAMPP** (or compatible PHP/MySQL stack)
- **EmailJS** (for emailing)
- **HybridAuth** (for social login)

### Installation Steps

1. **Clone the Repository**
   ```sh
   git clone <repository-url>
   cd quanswebsite
   ```

2. **Database Setup**
   - Import `database/script.sql` into phpMyAdmin or your MySQL server.

3. **Download and unzip the HybridAuth to access to its vendor**
   - Open your browser and go to:  
     `https://github.com/hybridauth/hybridauth/releases`
   - Download hybridauth version 3.12.2 (Latest in 29/11/2025)
   - Unzip and put the vendor folder in the root directory

4. **Access the Application**
   - Open your browser and go to:  
     `http://localhost/quanswebsite/`

---

## Default Login Credentials

After importing the database, you can log in with:

- **john.doe@example.com** / **johndoe**
- **jane.smith@example.com** / **janesmith**

---

## 📁 Project Structure

```
quanswebsite/
├── app/
│   ├── Controllers/
│   │   ├── AuthController.php     # Manages user authentication and sessions
│   │   ├── BrandController.php    # Handles brand-related logic and queries
│   │   ├── CarController.php      # Handles car-related business logic and queries
│   │   └── LocationController.php # Manages user authentication and sessions
│   ├── Models/
│   │   ├── Brand.php              # Brand database model
│   │   ├── Car.php                # Car database model
│   │   ├── Location.php           # Location database model
│   │   └── User.php               # User database model
│   └── Views/
│       ├── car/
│       │   └── show.php           # Displays details for a single car
│       ├── images/                # Images for each cars
│       │   └── ...
│       └── partials/
│           ├── header.php         # Shared site header/navigation
│           └── footer.php         # Shared site footer
├── config/
│   ├── database.php               # Database connection settings and credentials
│   └── hybridauth_config.php      # Hybridauth connection settings and credentials (Facebook and Google)
├── database/
│   └── script.sql                 # SQL schema and initial seed data for the app
├── public/
│   ├── css/
│   │   └── style.css              # Main stylesheet for the frontend
│   ├── helper/
│   │   └── ajax_search.php        # PHP endpoint for AJAX car search
│   ├── js/
│   │   ├── ajaxSearch.js          # Handles AJAX search for cars
│   │   ├── otherEffects.js        # Miscellaneous JS effects
│   │   └── resetPassword.js       # Reset Password for users
│   ├── uploads/                   # General images for brands and sample cars
│   │   └── ...
│   ├── contact.php                # Contact information and form
│   ├── forgot_password.php        # Password reset and recovery page
│   ├── index.php                  # Homepage: car listing, search, and filters
│   ├── login.php                  # User login form and handler
│   ├── logout.php                 # Logs out the current user
│   ├── robots.txt                 # Applying SEO in sitemap
│   ├── signup.php                 # User registration form and handler
│   ├── sitemap.xml                # Actual sitemap.xml for SEO
│   ├── social_callback.php        # Handles OAuth callback (Aftermath) for social logins (Google/Facebook)
│   └── social_login.php           # Initiates social login (Google/Facebook) process
├── .htaccess                      # Apache rewrite rules for clean URLs
└── README.md                      # Project documentation and setup instructions
```

---

## Features

- **Authentication**: Allow login with my website account, login with google/facebook account, logout, registering, reset password through email (Forgot Password).
- **Car Listings**: Browse, search, and filter cars by brand, style, or keyword.
- **Car Details**: View detailed information and images for each car.
- **Brand Showcase**: Explore cars by top brands with logo backgrounds.
- **Responsive Design**: Mobile-friendly layout.

---

## For hybridauth config

Contact me through `jacklorien@gmail.com` to get the config. This is to ensure all the keys are not public and be used by others.
