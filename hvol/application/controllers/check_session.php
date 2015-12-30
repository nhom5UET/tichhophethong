<?php
/**
 * Created by PhpStorm.
 * User: Hiroshin
 * Date: 12/25/2015
 * Time: 7:35 PM
 */
session_start();
function check_hvol(){
    $check = array(
        "check_hvol"=>$_SESSION["check_1"],
        "check_login"=>$_SESSION["check_loginhvol"]
    );
    return $check;
}