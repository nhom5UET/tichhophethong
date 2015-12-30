<?php
/**
 * Created by PhpStorm.
 * User: Hiroshin
 * Date: 12/3/2015
 * Time: 5:50 PM
 */
if(isset($_SESSION["session_user"])){
    echo $_SESSION["session_user"];
}
else{
    echo "No";
}
?>