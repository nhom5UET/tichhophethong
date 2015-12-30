<?php
/**
 * Created by PhpStorm.
 * User: Hiroshin
 * Date: 12/25/2015
 * Time: 4:30 AM
 */
session_start();
function check_chikitsa(){
    $check = array(
        "check_login"=>$_SESSION["check"],
        "check_chikitsa"=>$_SESSION["check_chikitsa"]
    );
    return $check;
}