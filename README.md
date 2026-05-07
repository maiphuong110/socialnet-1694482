⚠️  Important Deployment & Configuration Notes
This project was developed in a specific Linux environment (Ubuntu + Nginx + PHP 8.3-fpm). Please note the following specific configurations required for the application to function correctly:

1. Project Root & Routing
Directory Structure: The application is designed to reside in a subdirectory named /socialnet under the web server's root.

Absolute Paths: All frontend assets (CSS, Images) use root-relative paths starting with /socialnet/. If you change the directory name, please update the paths in the PHP files accordingly.

Nginx Location Block: Ensure your server block includes a directive to handle the subdirectory:

Nginx
location /socialnet {
    try_files $uri $uri/ /socialnet/index.php?$query_string;
}




2. File System Permissions (Critical)
The Nginx user (www-data) requires explicit write permissions for the following:

Uploads Folder: /socialnet/uploads/ must be writable for the profile picture feature to work.

Bash
sudo chown -R www-data:www-data uploads/
sudo chmod -R 775 uploads/
PHP Sessions: If you encounter login issues, ensure the PHP session directory (default: /var/lib/php/sessions) is owned by www-data.




3. PHP-FPM Version
The configuration provided uses the PHP 8.3-fpm socket. If you are using a different version, please update the fastcgi_pass directive in the Nginx config:
fastcgi_pass unix:/var/run/php/php[VERSION]-fpm.sock;




4. PHP Upload Limits
Max resolution for profile picture is 2 MB.

5. Password
Default password for accounts are initiated with "123456" or "234567".
