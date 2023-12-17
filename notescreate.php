<?php
session_start();
require 'vendor/autoload.php';
$mongoClient=new MongoDB\Client("mongodb://localhost:27017");
$database=$mongoClient->selectDatabase('toDoList');
$collection=$database->selectCollection('Lists');
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username=$_SESSION["loginusername"];
    $title=$_POST["title"];
    $description=$_POST["description"];
    $query=['username'=>$username];
    $uniqueId=uniqid();
    $uniqueId.=time().mt_rand(1000,9999);
    date_default_timezone_set('Asia/Kolkata');
    $updateData=['$push'=>['notes'=>[['_id'=>$uniqueId],['title'=>$title],['description'=>$description],['timestamp'=>date('d-m-Y h:i:s A')]]]];
    $result=$collection->updateOne($query,$updateData);
    if($result->getModifiedCount()>0){
        echo "success";
    }
    else{
        echo "notsuccess";
    }
}
?>