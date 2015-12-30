<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
session_start();

Route::get('/', function()
{
	return View::make('hello');

});

Route::get('test', function()
{
	return 'Hello World';
});

Route::get("register",function(){
	return View::make("register");
});

Route::post("register",function(){
	$rules=array(
		"username"=>"required|min:3",
		"password"=>"required|min:4",
		"email"=>"required|email");
	if(!Validator::make(Input::all(),$rules)->fails()){
		if(!User::check_register(Input::get("user_input"),Input::get("email"))){
			echo "Tên người dùng đã tồn tại";
			return View::make("register");
		}
		else{
			$user=new User();
			$user->username=Input::get("username");
			$user->password=md5(sha1(Input::get("password")));
			$user->email=Input::get("email");
			$user->save();
			return View::make("login");
		}
	}
});

Route::get("login",function(){
    if(isset($_SESSION["session_user"])){
        return View::make("module");
    }else
        return View::make("login");
//	}
});

Route::get("welcome",function(){
	return View::make("module");
});

Route::post("welcome", function(){
	if(User::check_login(Input::get("user_input"),md5(sha1(Input::get("password"))))){
//		return View::make("session");

//        setcookie("cookie_user",Input::get("user_input"),time() + 3600);
//        setcookie("cookie_pass",Input::get("password"),time() + 3600);
//        $_SESSION["session_users"] = $_COOKIE["cookie_user"];
//        $_SESSION["session_passwords"] = $_COOKIE["cookie_pass"];

		$_SESSION["session_user"]=Input::get("user_input");
		$_SESSION["session_password"]=Input::get("password");
//		$_SESSION["session_passwordCK"]=base64_encode(Input::get("password"));
		return View::make("module");
	}
	else{
//		unset($_SESSION["session_user"]);
//		unset($_SESSION["session_password"]);
		return "Logn fail";
	}
});



Route::get('data', function () {
	$user = User::all();
	return json_encode($user->toArray());
});

Route::get('json',function(){
	$data = file_get_contents('http://localhost/laravel-login/public/data');
	$data = json_decode($data, true);
	print_r($data);
});

Route::get('data_gco', function () {
	$patient = Gco::all();
	return json_encode($patient->toArray());
});


Route::get('json_gco',function(){
	$data = file_get_contents('http://localhost/laravel-login/public/data_gco');
//	$data = json_decode($data, true);
	$data = json_decode($data,true);
	foreach($data as $key=>$value){
		echo $key."</br>";
		foreach($value as $k=>$val)
			if($k=="email"){
				echo $k."|".$val."</br>";
			}

	}
//	echo $data['email'];
	//print_r($data);
});

Route::get('data_chikitsa', function () {
	$patient = Chikitsa::all();
	return json_encode($patient->toArray());
});


Route::get('json_chikitsa',function(){
	$data = file_get_contents('http://localhost/laravel-login/public/chikitsa');
	$data = json_decode($data, true);
	print_r($data);
});

Route::get("patient",function(){
	return View::make("patient");
});

Route::post("logout",function(){
	session_destroy();
	session_start();
    $_SESSION["logout"]=1;
	return View::make("login");
});

Route::post("patient",function(){
//	$rules=array(
//		"id"=>"required",
//		"email"=>"required|email");
//	if(!Validator::make(Input::all(),$rules)->fails()){
//		$patient=new Patient();
//		$patient->firstname=Input::get("firstname");
//		$patient->middelname=Input::get("middelname");
//		$patient->lastname=Input::get("lastname");
//		$patient->phonenumber=Input::get("phonenumber");
//		$patient->displayname=Input::get("displayname");
//		$patient->email=Input::get("email");
//		$patient->address=Input::get("address");
//		$patient->city=Input::get("city");
//		$patient->state=Input::get("state");
//		$patient->postalcode=Input::get("postalcode");
//		$patient->country=Input::get("country");
//		$patient->save();
//		echo "xinchao";

	$patient=new Chikitsa();
	$patient->first_name=Input::get("first_name");
	$patient->middle_name=Input::get("middle_name");
	$patient->last_name=Input::get("last_name");
	$patient->phone_number=Input::get("phone_number");
	$patient->display_name=Input::get("display_name");
	$patient->email=Input::get("email");
	$patient->address_line_1=Input::get("address_line_1");
	$patient->city=Input::get("city");
	$patient->state=Input::get("state");
	$patient->postal_code=Input::get("postal_code");
	$patient->country=Input::get("country");
//	display_id(Input::get("contact_id"));
	$patient->save();
	echo "OK";

	$gco=new Gco();
	$gco->nome=Input::get("last_name");
	$gco->celular=Input::get("phone_number");
	$gco->email=Input::get("email");
	$gco->endereco=Input::get("address_line_1");
	$gco->cidade=Input::get("city");
	$gco->estado=Input::get("state");
//	$patient_gco->cep=Input::get("postal_code");
	$gco->pais=Input::get("country");
	$gco->profissao=Input::get("job");
	$gco->save();

	echo "OK";

	$gaia=new Gaia();
	$gaia->fname=Input::get("first_name");
	$gaia->mname=Input::get("middle_name");
	$gaia->lname=Input::get("last_name");
	$gaia->mobile_phone=Input::get("phone_number");
	$gaia->email=Input::get("email");
	$gaia->address=Input::get("address_line_1");
	$gaia->city=Input::get("city");
	$gaia->state=Input::get("state");
//	$patient_gco->cep=Input::get("postal_code");
	$gaia->country=Input::get("country");
	$gaia->save();

	echo "OK";

	$patient=new Patient_chikitsa();
	$patient->contact_id=Input::get("contact_id");
	$lname = Input::get("last_name");
	$str = $lname[0];
	$str = strtoupper($str);

	$p_id = Input::get("contact_id");
	$n = 5;
	$num = str_pad((int) $p_id, $n, "0", STR_PAD_LEFT);
	$display_id = $str . $num;
	$patient->display_id=$display_id;
	$patient->save();
	echo "OK";

//	}
});

Route::get('query/select-all',function(){
	$data = DB::table('users')->get();
	echo "<pre>";
	print_r($data);
	echo "<pre>";
});
Route::get('query/select-column',function(){
	$data = DB::table('users')->select('username')->where('id',4)->orwhere('id',2)->get();
	echo "<pre>";
	print_r($data);
	echo "<pre>";
});
