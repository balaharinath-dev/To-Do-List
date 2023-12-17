<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require '../vendor/autoload.php';
$mongoClient=new MongoDB\Client("mongodb://localhost:27017");
$database=$mongoClient->selectDatabase('toDoList');
$collection=$database->selectCollection('Lists');
$result=$collection->find([]);
foreach($result as $document){
    foreach($document->remainder as $remainderarray){
        $username=$document->username;
        $firstname=$document->firstname;
        $lastname=$document->lastname;
        $name=$firstname.' '.$lastname;
        foreach($remainderarray[0] as $remainderid){
            $id=$remainderid;
        }
        foreach($remainderarray[1] as $labelname){
            $label=$labelname;
        }
        foreach($remainderarray[2] as $remaindertime){
            date_default_timezone_set('Asia/Kolkata');
            $remainderconvertedtime=strtotime($remaindertime);
            $currentTime=time();
            if($currentTime>=$remainderconvertedtime){
                $mail=new PHPMailer(true);
                try{
                    $mail->isSMTP();
                    $mail->Host='smtp.gmail.com';
                    $mail->SMTPAuth=true;
                    $mail->Username='a14116323@gmail.com';
                    $mail->Password='najctyxrkbasqivo';
                    $mail->SMTPSecure='tls';
                    $mail->Port=587;

                    $mail->setFrom('a14116323@gmail.com','Code Clause');
                    $mail->addAddress($username);
                    $mail->isHTML(true);

                    $mail->Subject ="Code Clause Remainder";
                    $mail->Body = 'Hello '.$name.', The time has come for your '.$label;
                    $mail->send();
                    echo "success";
                }
                catch(Exception $e){
                    echo "Email could not be sent. Error: {$mail->ErrorInfo}";
                }
                $findQuery = [
                    'username' => $username,
                    'remainder.0._id' => $id
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
                $deleteResult = $collection->updateOne($findQuery, $update);              
            }
        }
    }
}
?>