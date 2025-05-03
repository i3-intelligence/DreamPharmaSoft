project/
│
├── config/
│   └── database.php        # Secure DB connection
│
├── public/
│   ├── index.php           # Public entry (route controller)
│   ├── css/ js/ assets/
│
├── includes/
│   ├── auth.php            # Authentication logic
│   ├── session.php         # Session handling
│   └── helpers.php         # Common utility functions
│
├── views/
│   ├── header.php footer.php
│   ├── login.php register.php dashboard.php
│
├── actions/
│   ├── login.php           # Processes login form
│   ├── register.php        # Processes registration
│   └── logout.php
│
└── .htaccess               # Prevent directory access
