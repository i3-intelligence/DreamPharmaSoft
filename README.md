## **Pharmacy Management System**

> project/
│
├── config/
│   └── Database.php        # Secure DB connection
│
├── public/
│   ├── Index.php           # Public entry (route controller)
│   ├── css/                # Folder for CSS files
│   │   └── styles.css      # Example CSS file
│   ├── js/                 # Folder for JavaScript files
│   │   └── script.js       # Example JavaScript file
│   ├── assets/             # Folder for other assets like images
│
├── includes/
│   ├── Auth.php            # Authentication logic
│   ├── Session.php         # Session handling
│   ├── AccessLog.php       # Access Log
│
├── views/
│   ├── Header.php Footer.php
│   ├── Login.php Register.php Dashboard.php
│
├── actions/
│   ├── LoginExecute.php           # Processes login form
│   ├── Register.php        # Processes registration
│   └── Logout.php
│
└── .htaccess               # Prevent directory access


**Developer End**
 1. Insert Data Ajex Code (100 )
 2. Duplicate Data Check Ajex Code (102 )
 3. Update Data  Ajex Code (200 )
 4. Delete Data  Ajex Code (300 )
 5. Data Error Code (400) 
 6. Data Not Found Error Code (404)
 7. Data Not Found Error Code (405)
 8. Data Not Found Error Code (406)

**USER/Package Menu Permission **
> 	1.Added Menu  (0)
> 	2.Medicine View (1)
> 	3.Customer/Supplier View (2)
> 	4.Cash View (3)
> 	5.Purchase Menu (4)
> 	6.Purchase Product (5)
> 	7.Purchase Product  Return(6)
> 	8.Purchase Product  Return(7)


**GIT **
cd /home/nuralam
git clone https://github.com/i3-intelligence/DreamPharmaSoft.git dream.nuralam.online


cd /home/nuralam/dream.nuralam.online
git fetch origin
git reset --hard origin/main

Automate deployment with correct permissions
Make sure your /home/nuralam/deploy.sh has:

#!/bin/bash
cd /home/nuralam/dream.nuralam.online || exit
git reset --hard
git pull origin main
chown -R nuralam:nuralam /home/nuralam/dream.nuralam.online

Make it executable:
chmod +x /home/nuralam/deploy.sh




