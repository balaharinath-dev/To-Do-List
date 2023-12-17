//notescreate
$(document).ready(function(){
    $("#notesform").submit(function(event){
        event.preventDefault();
        if(notesOk()){
            var title=$.trim($("#notestitle").val());
            var description=$.trim($("#notesdescription").val());
            //xmlrequest
            const notesxhr=new XMLHttpRequest();
            notesxhr.open("POST","notescreate.php",true);
            notesxhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            notesxhr.send('title='+encodeURIComponent(title)+'&description='+encodeURIComponent(description));
            notesxhr.onreadystatechange=function(){
                if(notesxhr.readyState===4&&notesxhr.status===200){
                    var response=notesxhr.responseText;
                    if(response==="success"){
                        window.location.href="notes.php?notestoast=true";
                    }
                    else{
                        alert('Error occurred: '+response.message);
                    }
                }
                else if(notesxhr.readyState==2||notesxhr.readyState==3){}
                else{
                    alert(notesxhr.readyState);
                }
            };
        }
    });
});
function notesOk(){
    var isNotes=true;
    isNotes=notescheck("notestitle","notestitlediv")&&isNotes;
    isNotes=notescheck("notesdescription","notesdescriptiondiv")&&isNotes;
    return isNotes;
}
function notescheck(input,div){
    inputVal=$.trim($("#"+input).val());
    if(inputVal==""){
        $("#"+input).addClass("is-invalid");
        if(input=="notestitle"){
            $("#"+div).html("Title can't be empty");
        }
        else{
            $("#"+div).html("Description can't be empty");
        }
        return false;
    }
    else{
        $("#"+input).removeClass("is-invalid");
        $("#"+div).html("");
        return true;
    }
}
//checklistcreate
$(document).ready(function(){
    var uid=1;
    $("#addchecklistbtn").click(function(){
        uid+=1;
        var newList='<div class="d-flex align-items-center mb-2"><input type="text" class="form-control checklist me-2" name="checklist'+uid+'" id="input'+uid+'"><button class="btn-close removechecklistbtn" type="button" id="btn'+uid+'"</div>';
        $("#checklistgroup").append(newList);
    })
});
$(document).on("click",".removechecklistbtn",function(){
    var numericpart=$(this).attr("id").replace(/\D/g,'');
    $("#input"+numericpart).parent().remove();
});
//serialize
$(document).on("click","#checklistformserializebtn",function(){
    var ischecklistValid=true;
    var checklistflagArray=[];
    var dataArray=[];
    var formData=$("#checklistform").serializeArray();
    $.each(formData,function(index,field){
        if(field.name=="checkliststitle"){
            if(field.value==""){
                $('[name='+field.name+']').addClass("is-invalid");
                $('#checklisttitlediv').html("Title can't be empty");
                ischecklistValid=ischecklistValid&&false;
            }
            else{
                $('[name='+field.name+']').removeClass("is-invalid");
                $('#checklisttitlediv').html("");
                ischecklistValid=ischecklistValid&&true;
                dataArray.push(field.value);
            }
        }
        else{
            if(field.value==""){
                $('[name='+field.name+']').addClass("is-invalid");
                checklistflagArray.push(0);
            }
            else{
                $('[name='+field.name+']').removeClass("is-invalid");
                checklistflagArray.push(1);
                dataArray.push([field.value,0]);
            }
        }
    });
    if(checklistflagArray.includes(0)){
        $("#checklistdiv").html("(All the checklists must be filled)");
        ischecklistValid=ischecklistValid&&false;
    }
    else{
        $("#checklistdiv").html("");
        ischecklistValid=ischecklistValid&&true;
    }
    if(ischecklistValid){
        const checklistxhr=new XMLHttpRequest();
        checklistxhr.open("POST","checklistcreate.php",true);
        checklistxhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        var dataToSend=JSON.stringify({dataArray:dataArray});
        checklistxhr.send('dataToSend='+encodeURIComponent(dataToSend));
        checklistxhr.onreadystatechange=function(){
            if(checklistxhr.readyState===4&&checklistxhr.status===200){
                var response=checklistxhr.responseText;
                if(response==="success"){
                    window.location.href="checklist.php?checklisttoast=true";
                }
                else{
                    alert('Error occurred: '+response.message);
                }
            }
            else if(checklistxhr.readyState==2||checklistxhr.readyState==3){}
            else{
                alert(checklistxhr.readyState);
            }
        };
    }
});
$(".form-check-input").change(function(){
    if($(this).is(":checked")){
        var elementId=$(this).attr('id');
        var pattern=/^([a-zA-Z]+)(.*)$/;
        var matches = pattern.exec(elementId);
        if(matches){
            var remainingPart=matches[2];
        }
        $("#divid"+remainingPart).css({"text-decoration":"line-through","color":"grey"});
        var checker1="1";
        var checklistnumber1=remainingPart[0];
        var checkerid1=$(this).parent().attr('id');
        const chk1=new XMLHttpRequest();
        chk1.open("POST","checklistchecker.php",true);
        chk1.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        chk1.send('checkerid='+encodeURIComponent(checkerid1)+'&checklistnumber='+encodeURIComponent(checklistnumber1)+'&checker='+encodeURIComponent(checker1));
        chk1.onreadystatechange=function(){
            if(chk1.readyState===4&&chk1.status===200){
                var response=chk1.responseText;
                if(response==="success"){
                    window.location.href="checklist.php?tasktoast=true";
                }
                else{
                    alert('Error occurred: '+response.message);
                }
            }
            else if(chk1.readyState==2||chk1.readyState==3){}
            else{
                alert(chk1.readyState);
            }
        };
    }
    else{
        var elementId=$(this).attr('id');
        var pattern=/^([a-zA-Z]+)(.*)$/;
        var matches = pattern.exec(elementId);
        if(matches){
            var remainingPart=matches[2];
        }
        $("#divid"+remainingPart).css({"text-decoration":"none","color":"black"});
        var checker2="0";
        var checklistnumber2=remainingPart[0];
        var checkerid2=$(this).parent().attr('id');
        const chk2=new XMLHttpRequest();
        chk2.open("POST","checklistchecker.php",true);
        chk2.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        chk2.send('checkerid='+encodeURIComponent(checkerid2)+'&checklistnumber='+encodeURIComponent(checklistnumber2)+'&checker='+encodeURIComponent(checker2));
        chk2.onreadystatechange=function(){
            if(chk2.readyState===4&&chk2.status===200){
                var response=chk2.responseText;
                if(response==="success"){
                    window.location.href="checklist.php?tasktoast=true";
                }
                else{
                    alert('Error occurred: '+response.message);
                }
            }
            else if(chk2.readyState==2||chk2.readyState==3){}
            else{
                alert(chk2.readyState);
            }
        };
    }
});
//remaindercreate
$(document).ready(function(){
    $("#remainderform").submit(function(event){
        event.preventDefault();
        if(remainderOk()){
            var label=$.trim($("#remainderlabel").val());
            var time=$.trim($("#remaindertime").val());
            //xmlrequest
            const notesxhr=new XMLHttpRequest();
            notesxhr.open("POST","remaindercreate.php",true);
            notesxhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            notesxhr.send('label='+encodeURIComponent(label)+'&time='+encodeURIComponent(time));
            notesxhr.onreadystatechange=function(){
                if(notesxhr.readyState===4&&notesxhr.status===200){
                    var response=notesxhr.responseText;
                    if(response==="success"){
                        window.location.href="remainder.php?remaindertoast=true";
                    }
                    else{
                        alert('Error occurred: '+response.message);
                    }
                }
                else if(notesxhr.readyState==2||notesxhr.readyState==3){}
                else{
                    alert(notesxhr.readyState);
                }
            };
        }
    });
});
function remainderOk(){
    var isRemainder=true;
    isRemainder=remaindercheck("remainderlabel","remainderlabeldiv")&&isRemainder;
    isRemainder=remaindercheck("remaindertime","remaindertimediv")&&isRemainder;
    return isRemainder;
}
function remaindercheck(input,div){
    inputVal=$.trim($("#"+input).val());
    if(input=="remainderlabel"){
        if(inputVal==""){
            $("#"+input).addClass("is-invalid");
            $("#"+div).html("Label can't be empty");
            return false;
        }
        else{
            $("#"+input).removeClass("is-invalid");
            $("#"+div).html("");
            return true;
        }
    }
    else{
        const datetimePattern=/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/;
        const enteredTime=new Date(inputVal);
        const now=new Date();
        if(datetimePattern.test(inputVal)&&enteredTime>=new Date(now.getTime() + 5 * 60000)){
            $("#"+input).removeClass("is-invalid");
            $("#"+div).html("");
            return true;
        }
        else{
            $("#"+input).addClass("is-invalid");
            $("#"+div).html("Set a valid timer (Greater than 5 mins from now)");
            return false;
        }
    }
}
//deletenotes
$(document).ready(function(){
    $(".delete").click(function(){
        var id=$(this).attr("id");
        var divider=id.match(/^([a-zA-Z]+)(.*)$/);
        if(divider[1]=="notes"){
            $("#exampleModalnote").modal("show");
            $("#nonotes").click(function(){
                $("#exampleModalnote").modal("hide");
            });
            $("#yesnotes").click(function(){
                const dnotes=new XMLHttpRequest();
                dnotes.open("POST","notesdelete.php",true);
                dnotes.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
                dnotes.send('notesid='+encodeURIComponent(divider[2]));
                dnotes.onreadystatechange=function(){
                    if(dnotes.readyState===4&&dnotes.status===200){
                        var response=dnotes.responseText;
                        if(response==="success"){
                            window.location.href="notes.php?deletenotetoast=true";
                        }
                        else{
                            alert('Error occurred: '+response.message);
                        }
                    }
                    else if(dnotes.readyState==2||dnotes.readyState==3){}
                    else{
                        alert(dnotes.readyState);
                    }
                };
            });
        }
    })
});
//deletechecklist
$(document).ready(function(){
    $(".delete").click(function(){
        var id=$(this).attr("id");
        var divider=id.match(/^([a-zA-Z]+)(.*)$/);
        if(divider[1]=="checklist"){
            $("#exampleModalchecklist").modal("show");
            $("#nochecklist").click(function(){
                $("#exampleModalchecklist").modal("hide");
            });
            $("#yeschecklist").click(function(){
                const dnotes=new XMLHttpRequest();
                dnotes.open("POST","checklistdelete.php",true);
                dnotes.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
                dnotes.send('checklistid='+encodeURIComponent(divider[2]));
                dnotes.onreadystatechange=function(){
                    if(dnotes.readyState===4&&dnotes.status===200){
                        var response=dnotes.responseText;
                        if(response==="success"){
                            window.location.href="checklist.php?deletechecklisttoast=true";
                        }
                        else{
                            alert('Error occurred: '+response.message);
                        }
                    }
                    else if(dnotes.readyState==2||dnotes.readyState==3){}
                    else{
                        alert(dnotes.readyState);
                    }
                };
            });
        }
    })
});
//deleteremainder
$(document).ready(function(){
    $(".delete").click(function(){
        var id=$(this).attr("id");
        var divider=id.match(/^([a-zA-Z]+)(.*)$/);
        if(divider[1]=="remainder"){
            $("#exampleModalremainder").modal("show");
            $("#noremainder").click(function(){
                $("#exampleModalremainder").modal("hide");
            });
            $("#yesremainder").click(function(){
                const dnotes=new XMLHttpRequest();
                dnotes.open("POST","remainderdelete.php",true);
                dnotes.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
                dnotes.send('remainderid='+encodeURIComponent(divider[2]));
                dnotes.onreadystatechange=function(){
                    if(dnotes.readyState===4&&dnotes.status===200){
                        var response=dnotes.responseText;
                        if(response==="success"){
                            window.location.href="remainder.php?deleteremaindertoast=true";
                        }
                        else{
                            alert('Error occurred: '+response.message);
                        }
                    }
                    else if(dnotes.readyState==2||dnotes.readyState==3){}
                    else{
                        alert(dnotes.readyState);
                    }
                };
            });
        }
    })
});
//editnotes
$(document).ready(function(){
    $(".edit").click(function(){
        var id=$(this).attr("id");
        var divider=id.match(/^([a-zA-Z]+)(.*)$/);
        if(divider[1]=="notes"){
            window.location.href="notesedit.php?notesid="+divider[2];
        }
    })
});
//editremainder
$(document).ready(function(){
    $(".edit").click(function(){
        var id=$(this).attr("id");
        var divider=id.match(/^([a-zA-Z]+)(.*)$/);
        if(divider[1]=="remainder"){
            window.location.href="remainderedit.php?remainderid="+divider[2];
        }
    })
});