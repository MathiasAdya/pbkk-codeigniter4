@echo off
rem Jalankan dev server dengan ekstensi intl (php.ini XAMPP default tidak mengaktifkannya)
cd /d %~dp0
C:\xampp\php\php.exe -d extension=intl -S localhost:%1 -t public vendor\codeigniter4\framework\system\rewrite.php
