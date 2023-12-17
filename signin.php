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
    <div class="container m-sm-5 m-1">
        <div class="row m-0 d-flex justify-content-center align-items-center">
            <div class="col-xl-6 col-lg-7 col-md-9 col-sm-11 col-11 p-0 d-flex justify-content-center align-items-center">
                <form id="signinform" class=" px-sm-5 px-4 py-3">
                    <div class="row m-0">
                        <div class="col-12 p-0 d-flex justify-content-center align-items-center mb-4">
                            <div class="d-flex justify-content-center align-items-center" id="signintitle"><img style="height: 40px; width: 40px;" class="me-2" src="utilities/post-it.svg">Sign up</div>
                        </div>
                        <div class="col-12 p-0 mb-4">
                            <div class="form-floating">
                                <input type="mail" class="form-control" id="signinusername" placeholder="Username">
                                <label for="signinusername" class="form-floating-label">Username</label>
                            </div>
                            <div id="signinusernamediv" class="invalid-feedback d-block"></div>
                        </div>
                        <div class="col-md-6 pe-md-2 p-0 mb-4">
                            <div class="form-floating">
                                <input type="mail" class="form-control" id="signinfirstname" placeholder="First name">
                                <label for="signinfirstname" class="form-floating-label">First name</label>
                            </div>
                            <div id="signinfirstnamediv" class="invalid-feedback d-block"></div>
                        </div>
                        <div class="col-md-6 ps-md-2 p-0 mb-4">
                            <div class="form-floating">
                                <input type="mail" class="form-control" id="signinlastname" placeholder="Last name">
                                <label for="signinlastname" class="form-floating-label">Last name</label>
                            </div>
                            <div id="signinlastnamediv" class="invalid-feedback d-block"></div>
                        </div>
                        <div class="col-12 p-0 mb-4">
                            <div class="input-group input-group-relative">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="signinpassword" placeholder="Password" autocomplete="off">
                                    <label for="signinpassword" class="form-floating-label">Password</label>
                                </div>
                                <label for="signinpassword" class="input-group-text password-border"><i style="color: #f8be39; font-size: 22px;" class="bi bi-eye-slash-fill password-slash-fill" id="eye"></i></label>
                            </div>
                            <div id="signinpassworddiv" class="invalid-feedback d-block"></div>
                        </div>
                        <div class="col-12 p-0 mb-5">
                            <div class="input-group input-group-relative">
                                <div class="form-floating">
                                    <input style="border-right: 0;" type="password" class="form-control" id="resigninpassword" placeholder="Re-enter password" autocomplete="off">
                                    <label for="resigninpassword" class="form-floating-label">Re-enter password</label>
                                </div>
                                <label for="resigninpassword" class="input-group-text repassword-border"><i style="color: #f8be39; font-size: 22px;" class="bi bi-eye-slash-fill repassword-slash-fill" id="reeye"></i></label>
                            </div>
                            <div id="resigninpassworddiv" class="invalid-feedback d-block"></div>
                        </div>
                        <div class="col-12 p-0 mb-4">
                            <div class="form-floating">
                                <button style="background-color: #f8be39;" type="submit" class="btn btn-lg w-100" id="signinbtn">Sign up</button>
                            </div>
                        </div>
                        <div class="col-12 p-0 d-flex justify-content-center align-items-center mb-3">
                            <div class="form-floating d-flex flex-row align-items-center">
                                <hr style="width: 100px;"><div class="mx-2" style="font-size: 15px;">or</div><hr style="width: 100px;">                                                            
                            </div>
                        </div>
                        <div class="col-12 p-0 d-flex justify-content-center align-items-center mb-4">
                            <div class="form-floating">
                                <div>Already have an account? <a href="login.php" style="color: #f8be39;">Login</a></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="script.js" ></script>
    <script>
        //showpword
        $(document).ready(function(){
            $(document).on("click",".password-slash-fill",function(event){
                event.preventDefault();
                $("#signinpassword").attr("type","text");
                $("#eye").removeClass("bi-eye-slash-fill password-slash-fill").addClass("bi-eye-fill password-fill");
            });
            $(document).on("click",".password-fill",function(event){
                event.preventDefault();
                $("#signinpassword").attr("type","password");
                $("#eye").removeClass("bi-eye-fill password-fill").addClass("bi-eye-slash-fill password-slash-fill");
            });
            $(document).on("click",".repassword-slash-fill",function(event){
                event.preventDefault();
                $("#resigninpassword").attr("type","text");
                $("#reeye").removeClass("bi-eye-slash-fill repassword-slash-fill").addClass("bi-eye-fill repassword-fill");
            });
            $(document).on("click",".repassword-fill",function(event){
                event.preventDefault();
                $("#resigninpassword").attr("type","password");
                $("#reeye").removeClass("bi-eye-fill repassword-fill").addClass("bi-eye-slash-fill repassword-slash-fill");
            });
        });
    </script>
</body>
</html>