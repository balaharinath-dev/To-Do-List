<?php
session_start();
if(isset($_COOKIE["loginusername"])||isset($_SESSION["loginusername"])){
    header("Location:index.php");
    exit;
}
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
    <style>@import url('https://fonts.googleapis.com/css2?family=Mooli&display=swap');</style>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container m-sm-5 mx-1 my-5">
        <div class="row m-0 d-flex justify-content-center align-items-center">
            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 col-10 p-0 d-flex justify-content-center align-items-center">
                <form id="loginform" class=" px-sm-5 px-4 py-3">
                    <div class="row m-0">   
                        <div class="col-12 p-0 d-flex justify-content-center align-items-center mb-4">
                            <div class="d-flex justify-content-center align-items-center" id="logintitle"><img style="height: 40px; width: 40px;" class="me-2" src="utilities/post-it.svg">Login</div>
                        </div>
                        <div class="col-12 p-0 mb-4">
                            <div class="form-floating">
                                <input type="mail" class="form-control" id="loginusername" placeholder="Username">
                                <label for="loginusername" class="form-floating-label">Username</label>
                            </div>
                            <div id="loginusernamediv" class="invalid-feedback d-block"></div>
                        </div>
                        <div class="col-12 p-0 mb-5">
                            <div class="input-group input-group-relative">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="loginpassword" placeholder="Password" autocomplete="off">
                                    <label for="loginpassword" class="form-floating-label">Password</label>
                                </div>
                                <label for="loginpassword" class="input-group-text login"><i style="color: #f8be39; font-size: 22px;" class="bi bi-eye-slash-fill eye"></i></label>
                            </div>
                            <div id="loginpassworddiv" class="invalid-feedback d-block"></div>
                        </div>
                        <div class="col-12 p-0 mb-4">
                            <div class="form-floating">
                                <button style="background-color: #f8be39;" type="submit" class="btn btn-lg w-100" id="loginbtn">Login</button>
                            </div>
                        </div>
                        <div class="col-12 p-0 d-flex justify-content-center align-items-center mb-3">
                            <div class="form-floating d-flex flex-row align-items-center">
                                <hr style="width: 100px;"><div class="mx-2" style="font-size: 15px;">or</div><hr style="width: 100px;">                                                            
                            </div>
                        </div>
                        <div class="col-12 p-0 d-flex justify-content-center align-items-center mb-4">
                            <div class="form-floating">
                                <div>Don't have an account? <a href="signin.php" style="color: #f8be39;">Sign in</a></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="mytoast d-none p-3 m-3 mt-0" id="mytoast">
        <div class="d-flex align-items-center">
          <div class="toast-body me-3">
            <b>Account created successfully</b>
          </div>
          <button type="button" class="btn-close d-flex justify-content-end"></button>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="script.js" ></script>
    <script>
        //showpword
        $(document).ready(function(){
            $(document).on("click",".bi-eye-slash-fill",function(event){
                event.preventDefault();
                $("#loginpassword").attr("type","text");
                $(".eye").removeClass("bi-eye-slash-fill").addClass("bi-eye-fill");
            });
            $(document).on("click",".bi-eye-fill",function(event){
                event.preventDefault();
                $("#loginpassword").attr("type","password");
                $(".eye").removeClass("bi-eye-fill").addClass("bi-eye-slash-fill");
            });
        });
        //toast
        document.addEventListener("DOMContentLoaded",function(){
            var urlParams=new URLSearchParams(window.location.search);
            if(urlParams.get("mytoast")==="true"){
                var myDiv=document.getElementById("mytoast");
                if(myDiv){
                    myDiv.classList.add("d-block");
                    myDiv.classList.remove("d-none");
                }
            }
        });
        $(document).ready(function(){
            $(".btn-close").click(function(){
                $(".mytoast").addClass("d-none").removeClass("d-block");
                var newURL=window.location.href.split('?')[0];
                history.pushState({},document.title,newURL);
            });
        });
    </script>
</body>
</html>