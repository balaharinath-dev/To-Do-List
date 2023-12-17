<?php
require 'vendor/autoload.php';
$mongoDBUrl="mongodb://localhost:27017";
$databaseName="toDoList";
$collectionName="Lists";
$client=new MongoDB\Client($mongoDBUrl);
$database=$client->selectDatabase($databaseName);
$collection=$database->selectCollection($collectionName);
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username=$_POST["loginusernamenew"];
    $password=$_POST["loginpasswordnew"];
    $usernameToCheck=[
        'username'=>$username
    ];
    $checkUsername=$collection->findOne($usernameToCheck);
    if($checkUsername==null){
        echo "usernamenotexist";
    }
    else{
        $storedpassword=$checkUsername->password;
        if(password_verify($password,$storedpassword)){
            session_start();
            $_SESSION["loginusername"]=$username;
            setcookie("loginusername",$username,time()+360000,"/");
            echo "success";
        }
        else{
            echo "invalidpassword";
        }
    }
}
?>