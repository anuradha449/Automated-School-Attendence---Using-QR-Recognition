Attendance Full Project (ready for XAMPP)
----------------------------------------
1. Extract this folder into C:\xampp\htdocs\attendance_full_project
2. Start Apache and MySQL from XAMPP Control Panel
3. Import 'attendance_system.sql' via phpMyAdmin
4. Open: http://localhost/attendance_full_project/login.php
   - username: admin
   - password: admin123
Notes:
- The project will try to use phpqrcode library placed in phpqrcode/qrlib.php for offline QR generation.
- If phpqrcode is not present, generator will fall back to Google Chart API (internet required).
- To make phpqrcode fully offline, download the phpqrcode library and place it into the phpqrcode/ folder.
