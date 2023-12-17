<?php
session_start();
if(isset($_COOKIE["loginusername"])&&!isset($_SESSION["loginusername"])){
    $_SESSION["loginusername"]=$_COOKIE["loginusername"];
}
if(!isset($_COOKIE["loginusername"])&&!isset($_SESSION["loginusername"])){
    session_destroy();
    header("Location:index.php");
    exit;
}
$username=$_SESSION["loginusername"];
require 'vendor/autoload.php';
$mongoDBUrl="mongodb://localhost:27017";
$databaseName="toDoList";
$collectionName="Lists";
$client=new MongoDB\Client($mongoDBUrl);
$database=$client->selectDatabase($databaseName);
$collection=$database->selectCollection($collectionName);
$usernameToFetch=[
    'username'=>$username
];
$checkUsername=$collection->findOne($usernameToFetch);
$firstname=$checkUsername->firstname;
$lastname=$checkUsername->lastname;
$name=$firstname." ".$lastname;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do-List</title>
    <link rel="icon" href="utilities/post-it.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>@import url('https://fonts.googleapis.com/css2?family=Mooli&display=swap');</style>
    <link rel="stylesheet" href="notes.css">
</head>
<body>
    <div class="container-fluid mynavbar px-sm-2 px-0">
        <div class="row m-0 py-sm-3 px-sm-2 py-2 px-0">
            <div class="col-10 d-flex flex-row align-items-center">
                <div class="me-sm-2 me-1"><img height="35px" width="35px" src="utilities/post-it.svg"></div>
                <div class="title">Code Clause To-Do-List<i class="bi bi-dot"></i>Check list</div>
            </div>
            <div class="col-2 d-flex justify-content-end align-items-center">
                <button class="menubtn btn m-0 p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <i class="bi bi-menu-button-wide"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="container-fluid p-0">
        <div class="row m-0 p-3">
            <?php include "checklistretrieve.php" ?>
        </div>
    </div>
    <!-- offcanvas -->
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
            <h4 class="offcanvas-title" id="offcanvasWithBothOptionsLabel"><b><?php echo $name ?></b></h4>
        </div>
        <div class="offcanvas-body">
            <ul class="list-group">
                <a class="list-group-item" href="notes.php"><i class="bi bi-file-earmark-fill me-3"></i>Notes</a>
                <a class="list-group-item active" href="checklist.php"><i class="bi bi-list-check me-3"></i>Check list</a>
                <a class="list-group-item" href="remainder.php"><i class="bi bi-alarm-fill me-3"></i>Remainder</a>
            </ul>
            <hr class="mx-1">
            <ul class="list-group">
                <a class="list-group-item" href="logout.php"><i class="bi bi-box-arrow-right me-3"></i>Log out</a>
            </ul>
        </div>
    </div>
    <!-- offcanvas -->
    <!-- modal -->
    <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><b>New Check list</b></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="checklistform">
                        <div class="row m-0">
                            <div class="col-12 px-2 mb-4">
                                <div class="form-group">
                                    <label for="checkliststitle" class="form-label">Title</label>
                                    <input type="text" class="form-control" name="checkliststitle">
                                </div>
                                <div id="checklisttitlediv" class="invalid-feedback d-block"></div>
                            </div>
                            <div class="col-12 px-2 mb-5">
                                <label for="checklist" class="form-label">Check lists <div class="invalid-feedback d-block" id="checklistdiv"></div></label>
                                <div class="form-group" id="checklistgroup">
                                    <input type="text" name="checklist1" class="form-control checklist mb-2">
                                </div>
                            </div>
                            <div class="col-12 px-2 mb-3">
                                <div class="row m-0">
                                    <div class="col-4 ps-0 pe-1"><button type="reset" class="btn myclearbtn w-100">Clear</button></div>
                                    <div class="col-4 px-0"><button type="button"style="background-color: #f8be39;" class="btn mysubmitbtn w-100" id="addchecklistbtn"><i style="font-weight: bolder;" class="bi bi-journal-plus"></i></button></div>
                                    <div class="col-4 ps-1 pe-0"><button type="button" style="background-color: #f8be39;" class="btn mysubmitbtn w-100" id="checklistformserializebtn">Create</button></div>
                                </div>
                            </div>
                        </div>              
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
    <!-- deletemodal -->
    <div class="modal fade" id="exampleModalchecklist" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalchecklist" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><b>Delete Check list</b></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row m-0">
                        <div class="col-12 px-2 mb-4">
                            Are you sure you want to delete this check list?
                        </div>
                        <div class="col-12 px-2 mb-3">
                            <div class="row m-0">
                                <div class="col-6 ps-0 pe-1"><button type="button" style="background-color: #f8be39;" class="btn mysubmitbtn w-100" id="yeschecklist">Yes</button></div>
                                <div class="col-6 ps-1 pe-0"><button type="button" class="btn myclearbtn w-100" id="nochecklist">No</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- deletemodal -->
    <button class="btn plusbtn d-flex justify-content-center p-0 shadow" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">+</button>
    <div class="checklisttoast d-none p-3 m-0 rounded shadow" id="checklisttoast">
        <div class="d-flex justify-content-between align-items-center">
          <div class="toast-body me-xl-3 d-flex justify-content-center align-items-center">
            <b>Check list created successfully</b>
          </div>
          <button type="button" class="btn-close btn-close-checklisttoast d-flex justify-content-end align-items-center"></button>
        </div>
    </div>
    <div class="deletechecklisttoast d-none p-3 m-0 rounded shadow" id="deletechecklisttoast">
        <div class="d-flex justify-content-between align-items-center">
          <div class="toast-body me-xl-3 d-flex justify-content-center align-items-center">
            <b style="font-size:13px">Check list deleted successfully</b>
          </div>
          <button type="button" class="btn-close btn-close-deletechecklisttoast d-flex justify-content-end align-items-center"></button>
        </div>
    </div>
    <div class="tasktoast d-none p-3 m-0 rounded shadow" id="tasktoast">
        <div class="d-flex justify-content-between align-items-center">
          <div class="toast-body me-xl-3 d-flex justify-content-center align-items-center">
            <b>Task status updated</b>
          </div>
          <button type="button" class="btn-close btn-close-tasktoast d-flex justify-content-end align-items-center"></button>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="notes.js" ></script>
    <script>
        //toast
        document.addEventListener("DOMContentLoaded",function(){
            var urlParams=new URLSearchParams(window.location.search);
            if(urlParams.get("checklisttoast")==="true"){
                var myDiv=document.getElementById("checklisttoast");
                if(myDiv){
                    setTimeout(() =>{
                        myDiv.classList.add("d-block");
                        myDiv.classList.remove("d-none");
                    },1000);
                }
            }
        });
        $(document).ready(function(){
            $(".btn-close-checklisttoast").click(function(){
                $(".checklisttoast").addClass("d-none").removeClass("d-block");
                var newURL=window.location.href.split('?')[0];
                history.pushState({},document.title,newURL);
            });
        });
        document.addEventListener("DOMContentLoaded",function(){
            var urlParams=new URLSearchParams(window.location.search);
            if(urlParams.get("deletechecklisttoast")==="true"){
                var myDiv=document.getElementById("deletechecklisttoast");
                if(myDiv){
                    setTimeout(() =>{
                        myDiv.classList.add("d-block");
                        myDiv.classList.remove("d-none");
                    },1000);
                }
            }
        });
        $(document).ready(function(){
            $(".btn-close-deletechecklisttoast").click(function(){
                $(".deletechecklisttoast").addClass("d-none").removeClass("d-block");
                var newURL=window.location.href.split('?')[0];
                history.pushState({},document.title,newURL);
            });
        });
        document.addEventListener("DOMContentLoaded",function(){
            var urlParams=new URLSearchParams(window.location.search);
            if(urlParams.get("tasktoast")==="true"){
                var myDiv=document.getElementById("tasktoast");
                if(myDiv){
                    setTimeout(() =>{
                        myDiv.classList.add("d-block");
                        myDiv.classList.remove("d-none");
                    },1);
                }
            }
        });
        $(document).ready(function(){
            $(".btn-close-tasktoast").click(function(){
                $(".tasktoast").addClass("d-none").removeClass("d-block");
                var newURL=window.location.href.split('?')[0];
                history.pushState({},document.title,newURL);
            });
        });
        $(document).ready(function(){
            $(".btn-close-nochecklisttoast,.plusbtn").click(function(){
                $(".nochecklisttoast").addClass("d-none").removeClass("d-block");
            });
        });
        const button=document.querySelector('.plusbtn');
        button.addEventListener('mousedown',() =>{
            button.style.backgroundColor='#ffc94a';
            button.style.border='none';
        });
        button.addEventListener('mouseup',()=>{
            button.style.backgroundColor='#ffc94a';
            button.style.border='none';
        });
    </script>
</body>
</html>