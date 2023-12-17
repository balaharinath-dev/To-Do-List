<?php
session_start();
require 'vendor/autoload.php';
$mongoClient=new MongoDB\Client("mongodb://localhost:27017");
$database=$mongoClient->selectDatabase('toDoList');
$collection=$database->selectCollection('Lists');
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username=$_SESSION["loginusername"];
    $checkerid=$_POST["checkerid"];
    $checklistnumber=$_POST["checklistnumber"];
    $checker=$_POST["checker"];
    $query=['username'=>$username,'checklist'=>['$elemMatch'=>['0._id'=>$checkerid]]];
    $updateData=['$set'=>["checklist.$.1.checklistdetails.{$checklistnumber}.1"=>$checker]];
    $result=$collection->updateOne($query,$updateData);
    if($result->getModifiedCount()>0){
        echo "success";
    }
    else{
        echo "notsuccess";
    }
}
?>