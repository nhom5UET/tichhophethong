<?php
/**
 * Created by PhpStorm.
 * User: Hiroshin
 * Date: 12/27/2015
 * Time: 6:43 AM
 */
function check_login(){
//if(isset($_SESSION["logout"])){
//    $a = 1;
//}else{
//    $a = 0;
//}
        $check = array(
            "check_logout"=>$_SESSION["logout"]
        );
//echo json_encode($check);
        return $check;
}