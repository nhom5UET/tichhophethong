<?php
/**
 * Created by PhpStorm.
 * User: Hiroshin
 * Date: 12/25/2015
 * Time: 12:09 AM
 */
session_start();
//$_SESSION["session_user"] = "admin";
//$_SESSION["session_password"] = "huyhoangk57";
//Hàm ?? kh?i t?o ??ng nh?p.
function check_login(){
//if(isset($_SESSION["logout"])){
//    $a = 1;
//}else{
//    $a = 0;
//}
        $check = array(
            "check_user"=>$_SESSION["session_user"],
            "check_pass"=>$_SESSION["session_password"],
            "check_session"=> $_SESSION["session_user"],
//            "check_logout"=>$_POST["form-logout"]
        );
//    echo json_encode($check);
        return $check;
}
