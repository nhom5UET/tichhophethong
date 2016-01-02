README:

Bước 1: 
	Copy 4 project : laravel-login, chikitsa, gco_smile và hvol vào thư mục htdocs trong xampp.
Bước 2: 
	Vào thư mục gco_smile\wallpapers\index_ajax.php. 
	Thay E:\Study\workspace thành đường dẫn đến thư mục htdocs (../htdocs).
Bước 3:
	Mật khẩu của mysql là: user = "root", password = "". 
	Nếu mật khẩu khác thì sẽ chỉnh sửa lại trong phần kết nối database của từng module theo các đường dẫn:
Laravel-login: 	E:\Study\workspace\laravel-login\app\config\database.php
HVOL:		E:\Study\workspace\hvol\application\config\database.php
Chikitsa:		E:\Study\workspace\Chikitsa\application\config\database.php
Gco_smile:	E:\Study\workspace\gco_smile\lib\config.inc.php
Bước 4: 
	Import 4 database vào MYSQL (vào đường dẫn http://localhost/phpmyadmin để import).
Bước 5: 
	Chạy chương trình bằng đường dẫn http://localhost/laravel-login/public/login để đăng nhập (username: admin, password: huyhoangk57). 