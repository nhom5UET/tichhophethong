<?php
/**
 * Created by PhpStorm.
 * User: Hiroshin
 * Date: 11/30/2015
 * Time: 11:28 PM
 */


$json = file_get_contents('http://maps.googleapis.com/maps/api/directions/json?origin=');
$obj = json_decode($json);
echo $obj->access_token;
//echo json_decode($json);

$truth = array('panda' => 'Awesome!');
echo json_encode($truth);

$truth = json_decode('{"panda":"Awesome!"}');
echo $truth->panda;

$truth = json_decode('{"panda":"Awesome!"}', true);
echo $truth['panda'];