Chỉnh cấu hình kết nối dtb trong .env.example trước rồi chạy lệnh "setup.bat"

Lấy full buildings: curl.exe -X GET http://127.0.0.1:8000/api/buildings 


composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"