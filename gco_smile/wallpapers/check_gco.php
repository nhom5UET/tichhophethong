<?php
/**
 * Created by PhpStorm.
 * User: Hiroshin
 * Date: 12/25/2015
 * Time: 4:48 AM
 */
session_start();
function check_gco(){
    $check = array(
        "check_gco"=>$_SESSION[nome_user],
        "check_in"=>$_SESSION["check_in"]
    );
    return $check;
}