S.K. Auto CNG Cylinder Testing - PHP + MySQL Website (Ready)

Structure:
- public/             => Public website files (upload this to your public_html or www folder)
- admin/              => Admin panel (place in public_html/admin or protect as you wish)
- includes/config.php => Database credentials (edit before use)
- uploads/images/     => All site images (already included)
- database.sql        => SQL file to create DB and default admin user

Quick setup (cPanel / shared hosting):
1. Create a MySQL database and user (e.g., sk_auto_db, sk_user) and grant privileges.
2. Import database.sql using phpMyAdmin (this creates tables and a default admin user).
3. Edit includes/config.php with your DB credentials.
4. Upload the entire project to your hosting public folder (public/ -> public_html/). Adjust paths if needed.
5. Visit /admin/login.php and login with: admin@skauto.com / Admin@1234
6. Go to Admin -> Manage Gallery / Services to add content. Contact form submissions are saved to 'contacts' table.

Security notes:
- Change the default admin password after first login.
- Set proper file permissions for includes/config.php (not world-readable).
- For email notifications, integrate SMTP later (optional).

If you want, I can also deploy this to your hosting or guide you step-by-step.
