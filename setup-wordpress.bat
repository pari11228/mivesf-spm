@echo off
echo Setting up local WordPress environment...

REM Create WordPress directory structure
if not exist "wordpress" mkdir wordpress
if not exist "wordpress\wp-content" mkdir wordpress\wp-content
if not exist "wordpress\wp-content\themes" mkdir wordpress\wp-content\themes
if not exist "wordpress\wp-content\plugins" mkdir wordpress\wp-content\plugins
if not exist "wordpress\wp-content\uploads" mkdir wordpress\wp-content\uploads

REM Download WordPress (if not exists)
if not exist "wordpress\wp-config-sample.php" (
    echo Downloading WordPress...
    powershell -Command "Invoke-WebRequest -Uri 'https://wordpress.org/latest.tar.gz' -OutFile 'latest.tar.gz'"
    powershell -Command "Expand-Archive -Path 'latest.tar.gz' -DestinationPath '.' -Force"
    xcopy /E /I /Y "wordpress\*" "wordpress\"
    rmdir /S /Q "wordpress"
)

echo WordPress setup complete!
echo Next steps:
echo 1. Install XAMPP and start Apache + MySQL
echo 2. Create database 'wordpress' in phpMyAdmin
echo 3. Copy this folder to C:\xampp\htdocs\mivehjaan\
echo 4. Visit http://localhost/mivehjaan/ to complete installation

pause
