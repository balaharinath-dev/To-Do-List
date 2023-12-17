<?php
session_start();
require 'vendor/autoload.php';
$mongoClient=new MongoDB\Client("mongodb://localhost:27017");
$database=$mongoClient->selectDatabase('toDoList');
$collection=$database->selectCollection('Lists');
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username=$_SESSION["loginusername"];
    $label=$_POST["label"];
    $inputDatetime=$_POST["time"];
    $dateTimeObj=DateTime::createFromFormat("Y-m-d\TH:i",$inputDatetime);
    $time=$dateTimeObj->format("d-m-Y h:i A");
    $query=['username'=>$username];
    $uniqueId=uniqid();
    $uniqueId.=time().mt_rand(1000,9999);
    date_default_timezone_set('Asia/Kolkata');
    $updateData=['$push'=>['remainder'=>[['_id'=>$uniqueId],['label'=>$label],['time'=>$time],['timestamp'=>date('d-m-Y h:i:s A')]]]];
    $result=$collection->updateOne($query,$updateData);
    if($result->getModifiedCount()>0){
        echo "success";
    }
    else{
        echo "notsuccess";
    }
}
?>