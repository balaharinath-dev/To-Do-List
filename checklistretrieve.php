<?php
$filter=['username'=>$username];
$projection=['checklist'=>1,];
$options=['projection'=>$projection,'sort'=>['checklist.2.timestamp'=>1]];
$FetchResult=$collection->findOne($filter,$options);
if(count($FetchResult->checklist)===0){
    echo '
        <div class="nochecklisttoast d-block p-3 m-0 rounded shadow">
            <div class="toast-body d-flex flex-column justify-content-center align-items-center">
                <div class="col-12 px-0 d-flex justify-content-between mb-2 pb-2 border-bottom border-dark">
                    <b>No check lists are available</b>
                    <button type="button" class="btn-close btn-close-nochecklisttoast d-flex justify-content-end align-items-center"></button>
                </div>
                <div class="col-12 px-0">
                    Click the plus button at the bottom right to create a new check list and access them at anytime <span class="me-3"></span><i class="bi bi-arrow-down-right-square-fill"></i>
                </div>
            </div>
        </div>
    ';
}
else{
    foreach($FetchResult->checklist as $document){
        $div='';
        $count=0;
        foreach($document[1]->checklistdetails as $cursor){
            if($count==0){
                $div.='<div class="col-xl-4 col-md-6 col-12 p-2 cardcol cardrow">
                            <div class="card">
                                <div class="card-header border-0 mycardtitle">
                                    '.$cursor.'
                                </div>
                                <div class="card-body">';
                $count++;
            }
            else{
                if($cursor[1]=="0"){
                    $div.='<div class="d-flex align-items-center mb-1">
                                <div class="col-1 d-flex align-items-center pb-1 me-2" id="'.$document[0]->_id.'">
                                    <input id="inputid'.$count.$document[0]->_id.'" type="checkbox" class="form-check-input">
                                </div>
                                <div class="col-11 d-flex align-items-center" id="divid'.$count.$document[0]->_id.'" >
                                    '.$cursor[0].'
                                </div>
                            </div>';
                }
                else{
                    $div.='<div class="d-flex align-items-center mb-1">
                                <div class="col-1 d-flex align-items-center pb-1 me-2" id="'.$document[0]->_id.'">
                                    <input id="inputid'.$count.$document[0]->_id.'" type="checkbox" checked class="form-check-input">
                                </div>
                                <div class="col-11 d-flex align-items-center" style="text-decoration:line-through;color:grey" id="divid'.$count.$document[0]->_id.'" >
                                    '.$cursor[0].'
                                </div>
                            </div>';
                }
                $count++;
            }
        }
        $div.=' </div>
                    <div class="card-footer border-0 d-flex">
                        <div class="col-6 px-0 d-flex align-items-center time">
                            '.$document[2]->timestamp.'
                        </div>
                        <div class="col-6 px-0 d-flex justify-content-end">
                            <div><button type="button" class="btn delete" id="checklist'.$document[0]->_id.'"><i class="bi bi-trash-fill"></i></button></div>
                        </div>
                    </div>
                </div>
                </div>';
        echo $div;
    }
}
?>