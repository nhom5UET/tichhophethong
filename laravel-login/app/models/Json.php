<?php
/**
 * Created by PhpStorm.
 * User: Hiroshin
 * Date: 12/1/2015
 * Time: 1:39 AM
 */
use User;
$user = User::find()->all();
return Response::json($user);