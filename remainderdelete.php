<?php
session_start();
require 'vendor/autoload.php';
$mongoClient=new MongoDB\Client("mongodb://localhost:27017");
$database=$mongoClient->selectDatabase('toDoList');
$collection=$database->selectCollection('Lists');
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username=$_SESSION["loginusername"];
    $id=$_POST["remainderid"];
    $findQuery = [
        'username' => $username
    ];
    $update = [
        '$pull' => [
            'remainder' => [
                '$elemMatch' => [
                    '_id' => $id
                ]
            ]
        ]
    ];
    $result=$collection->updateOne($findQuery,$update);
    if($result->getModifiedCount()>0){
        echo "success";
    }
    else{
        echo "notsuccess";
    }
}
?>