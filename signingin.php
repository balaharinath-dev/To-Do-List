<?php
require 'vendor/autoload.php';
$mongoDBUrl="mongodb://localhost:27017";
$databaseName="toDoList";
$collectionName="Lists";
$client=new MongoDB\Client($mongoDBUrl);
$database=$client->selectDatabase($databaseName);
$collection=$database->selectCollection($collectionName);
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username=$_POST["signinusernamenew"];
    $firstname=$_POST["signinfirstnamenew"];
    $lastname=$_POST["signinlastnamenew"];
    $password=$_POST["signinpasswordnew"];
    $dataToCheck=[
        'username'=>$username
    ];
    $checkResult=$collection->findOne($dataToCheck);
    if($checkResult!=null){
        echo "usernameexist";
    }
    else{
        $dataToInsert=[
            'username'=>$username,
            'firstname'=>$firstname,
            'lastname'=>$lastname,
            'password'=>password_hash($password,PASSWORD_DEFAULT),
            'notes'=>[],
            'checklist'=>[],
            'remainder'=>[],
            'trash'=>[]
        ];
        $insertResult=$collection->insertOne($dataToInsert);
        if($insertResult->getInsertedCount()>0){
            echo "success";
        } 
        else{
            echo "failed";
        }
    }
}
?>