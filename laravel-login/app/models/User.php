<?php
/**
 * Created by PhpStorm.
 * User: Hiroshin
 * Date: 11/24/2015
 * Time: 11:43 PM
 */

class User extends Eloquent{
    public $table="users";
    public static function check_login($user_input,$password){
        $array1 = array('user_input'=>$user_input);
        $rules = array("user_input"=>"email");
        if(Validator::make($array1,$rules)->fails())
            $check=User::where("username","=",$user_input)->where("password","=",$password)->count();
        else
            $check=User::where("email","=",$user_input)->where("password","=",$password)->count();
        if($check>0){
            return true;
        }

        else
            return false;
    }
    public static function check_register($user_input,$email){
        $check_register = User::where("username","=",$user_input)->where("email","=",$email)->count();
        if($check_register>0)
            return true;
        else
            return false;

    }
}
