# Local WordPress Setup Guide

## Option 1: Docker (Preferred)
1. Wait for Docker Desktop to fully start (green icon in system tray)
2. Run: `docker-compose up -d`
3. Access: http://localhost:8080
4. phpMyAdmin: http://localhost:8081

## Option 2: XAMPP Alternative
If Docker continues to have issues:

1. Download and install XAMPP from https://www.apachefriends.org/
2. Start Apache and MySQL services
3. Download WordPress from https://wordpress.org/
4. Extract to `C:\xampp\htdocs\mivehjaan\`
5. Create database via phpMyAdmin (http://localhost/phpmyadmin)
6. Visit http://localhost/mivehjaan/ to install WordPress

## Option 3: Local WordPress with SQLite
For testing without MySQL:
1. Install WordPress SQLite plugin
2. No database server required

## Current Status
- Docker Desktop: Starting...
- docker-compose.yml: Fixed (removed obsolete version)
- Project structure: Ready
