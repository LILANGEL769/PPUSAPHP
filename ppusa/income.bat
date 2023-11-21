@ECHO OFF
SET "PHP_EXECUTABLE=C:\Users\joyga\Downloads\php-8.2.9-nts-Win32-vs16-x64\php.exe"  REM Replace with your actual PHP executable path

:loop
"%PHP_EXECUTABLE%" "D:\xampeepee\htdocs\ppusa\update_income.php"
timeout /t 300 /nobreak >NUL
GOTO loop
