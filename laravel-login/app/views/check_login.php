<?php
/**
 * Created by PhpStorm.
 * User: Hiroshin
 * Date: 12/25/2015
 * Time: 12:09 AM
 */
session_start();
function check_login(){
//    $username = Input::get("user_input");;
//    $password = Input::get("password");

        $check = array(
            "check_user"=>"admin",
            "check_pass"=>"huyhoangk57",
//            "check_user"=>$_COOKIE['cookie_user'],
//            "check_pass"=>$_COOKIE['cookie_pass'],
//            "check_user"=>$_SESSION["session_user"],
//            "check_pass"=>$_SESSION["session_password"],
            "check_session"=>$_SESSION["session_user"]
        );
        return $check;
}
