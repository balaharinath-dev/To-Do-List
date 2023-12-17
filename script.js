//login
var loginform=document.getElementById("loginform");
if(loginform){
    loginform.addEventListener("submit",(event)=>{
        event.preventDefault();
        if(loginValidate()){
            var loginusername=document.getElementById("loginusername");
            var loginpassword=document.getElementById("loginpassword");
            var loginusernamenew=loginusername.value.trim();
            var loginpasswordnew=loginpassword.value.trim();
            var loginusernamediv=document.getElementById("loginusernamediv");
            var loginpassworddiv=document.getElementById("loginpassworddiv");
            //xmlrequest
            const xhr=new XMLHttpRequest();
            xhr.open("POST","loggingin.php",true);
            xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            xhr.send('loginusernamenew='+encodeURIComponent(loginusernamenew)+'&loginpasswordnew='+encodeURIComponent(loginpasswordnew));
            xhr.onreadystatechange=function(){
                if(xhr.readyState===4&&xhr.status===200){
                    var response=xhr.responseText;
                    if(response==="success"){
                        window.location.href="notes.php?mytoast=true";
                    }
                    else if(response==="usernamenotexist"){
                        loginusername.classList.add("is-invalid");
                        loginusernamediv.innerHTML="Username doesn't exist";
                    }
                    else if(response==="invalidpassword"){
                        $(".input-group-text").css("border-color","#dc3545");
                        loginpassword.classList.add("is-invalid");
                        loginpassworddiv.innerHTML="Invalid password";
                    }
                    else{
                        alert('Error occurred: '+response.message);
                    }
                }
                else if(xhr.readyState==2||xhr.readyState==3){}
                else{
                    alert(xhr.readyState);
                }
            };
        }
    });
    function loginValidate(){
        let isValid=true;
        isValid=loginInitialValidate("loginusername","loginusernamediv")&&isValid;
        isValid=loginInitialValidate("loginpassword","loginpassworddiv")&&isValid;
        return isValid;
    }
    function loginInitialValidate(loginInput,loginDiv){
        var input=document.getElementById(loginInput);
        var div=document.getElementById(loginDiv);
        var value=input.value.trim();
        if(loginInput==="loginusername"){
            isValid=false;
            if(!validateEmail(value)){
                input.classList.add("is-invalid");
                div.innerHTML="Enter a valid E-mail ID";
            }
            else{
                input.classList.remove("is-invalid");
                div.innerHTML="";
                isValid=true;
            }
            return isValid;
        }
        if(loginInput==="loginpassword"){
            isValid=false;
            if(!validatePassword(value)){
                $(".input-group-text").css("border-color","#dc3545");
                input.classList.add("is-invalid");
                div.innerHTML="Enter a valid password";
            }
            else{
                $(".input-group-text").css("border-color","#ced4da");
                input.classList.remove("is-invalid");
                div.innerHTML="";
                isValid=true;
            }
            return isValid;
        }
    }
}
//signin
var signinform=document.getElementById("signinform");
if(signinform){
    signinform.addEventListener("submit",(event)=>{
        event.preventDefault();
        if(signinValidate()){
            var signinusername=document.getElementById("signinusername");
            var signinpassword=document.getElementById("signinpassword");
            var signinfirstname=document.getElementById("signinfirstname");
            var signinlastname=document.getElementById("signinlastname");
            var signinusernamenew=signinusername.value.trim();
            var signinpasswordnew=signinpassword.value.trim();
            var signinfirstnamenew=signinfirstname.value.trim();
            var signinlastnamenew=signinlastname.value.trim();
            var signinusernamediv=document.getElementById("signinusernamediv");
            //xmlrequest
            const xhr=new XMLHttpRequest();
            xhr.open("POST","signingin.php",true);
            xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            xhr.send('signinusernamenew='+encodeURIComponent(signinusernamenew)+'&signinfirstnamenew='+encodeURIComponent(signinfirstnamenew)+'&signinlastnamenew='+encodeURIComponent(signinlastnamenew)+'&signinpasswordnew='+encodeURIComponent(signinpasswordnew));
            xhr.onreadystatechange=function(){
                if(xhr.readyState===4&&xhr.status===200){
                    var response=xhr.responseText;
                    if(response==="success"){
                        window.location.href="login.php?mytoast=true";
                    }
                    else if(response==="usernameexist"){
                        signinusername.classList.add("is-invalid");
                        signinusernamediv.innerHTML="Username already exists";
                    }
                    else{
                        alert('Error occurred: '+response.message);
                    }
                }
                else if(xhr.readyState==2||xhr.readyState==3){}
                else{
                    alert(xhr.readyState);
                }
            };
        }
    });
    var passwordFlag=false;
    var repasswordFlag=false;
    var passwordRegex=/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%&_])[A-Za-z\d!@#$%&_]{12,}$/;
    document.getElementById("signinpassword").addEventListener("input",function(){
        if(passwordRegex.test(document.getElementById("signinpassword").value.trim())){
            document.getElementById("signinpassword").classList.remove("is-invalid");
            $(".password-border").css("border-color","#ced4da");
            document.getElementById("signinpassworddiv").innerHTML="";
            passwordFlag=true;
        }
        else{
            document.getElementById("signinpassword").classList.add("is-invalid");
            $(".password-border").css("border-color","#dc3545");
            document.getElementById("signinpassworddiv").innerHTML="Enter a stronger password";
        }  
    });
    document.getElementById("resigninpassword").addEventListener("input",function(){
        if(document.getElementById("signinpassword").value.trim()==document.getElementById("resigninpassword").value.trim()){
            document.getElementById("resigninpassword").classList.remove("is-invalid");
            $(".repassword-border").css("border-color","#ced4da");
            document.getElementById("resigninpassworddiv").innerHTML="";
            repasswordFlag=true;
        }
        else{
            document.getElementById("resigninpassword").classList.add("is-invalid");
            $(".repassword-border").css("border-color","#dc3545");
            document.getElementById("resigninpassworddiv").innerHTML="Password doesn't match";
        }  
    });
    function signinValidate(){
        if(passwordRegex.test(document.getElementById("signinpassword").value.trim())){
            document.getElementById("signinpassword").classList.remove("is-invalid");
            $(".password-border").css("border-color","#ced4da");
            document.getElementById("signinpassworddiv").innerHTML="";
            passwordFlag=true;
        }
        else{
            document.getElementById("signinpassword").classList.add("is-invalid");
            $(".password-border").css("border-color","#dc3545");
            document.getElementById("signinpassworddiv").innerHTML="Enter a valid password";
        }
        if(document.getElementById("signinpassword").value.trim()==document.getElementById("resigninpassword").value.trim()&&document.getElementById("resigninpassword").value.trim()!=""){
            document.getElementById("resigninpassword").classList.remove("is-invalid");
            $(".repassword-border").css("border-color","#ced4da");
            document.getElementById("resigninpassworddiv").innerHTML="";
            repasswordFlag=true;
        }
        else{
            document.getElementById("resigninpassword").classList.add("is-invalid");
            $(".repassword-border").css("border-color","#dc3545");
            document.getElementById("resigninpassworddiv").innerHTML="Re-enter the password";
        }
        let isValid=true;
        isValid=signinInitialValidate("signinusername","signinusernamediv")&&isValid;
        isValid=signinInitialValidate("signinfirstname","signinfirstnamediv")&&isValid;
        isValid=signinInitialValidate("signinlastname","signinlastnamediv")&&isValid;
        isValid=passwordFlag&&repasswordFlag&&isValid;
        return isValid;
    }
    function signinInitialValidate(signinInput,signinDiv){
        var input=document.getElementById(signinInput);
        var div=document.getElementById(signinDiv);
        var value=input.value.trim();
        if(signinInput==="signinusername"){
            isValid=false;
            if(!validateEmail(value)){
                input.classList.add("is-invalid");
                div.innerHTML="Enter a valid E-mail ID";
            }
            else{
                input.classList.remove("is-invalid");
                div.innerHTML="";
                isValid=true;
            }
            return isValid;
        }
        if(signinInput==="signinfirstname"||signinInput==="signinlastname"){
            isValid=false;
            if(!validateName(value)){
                input.classList.add("is-invalid");
                if(signinInput==="signinfirstname"){
                    div.innerHTML="Enter a valid first name";
                }
                else{
                    div.innerHTML="Enter a valid last name";
                }
            }
            else{
                input.classList.remove("is-invalid");
                div.innerHTML="";
                isValid=true;
            }
            return isValid;
        }
    }
}
function validateEmail(email){
    const emailRegex=/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
    return emailRegex.test(email);
}
function validatePassword(password){
    const passwordRegex=/^(?=.*\S).+$/;
    return passwordRegex.test(password);
}
function validateEmail(email){
    const emailRegex=/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
    return emailRegex.test(email);
}
function validateName(name){
    const nameRegex=/^[a-zA-Z ]+$/;
    return nameRegex.test(name);
}