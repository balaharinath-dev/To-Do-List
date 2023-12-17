<?php
$filter=['username'=>$username];
$projection=['remainder'=>1,];
$options=['projection'=>$projection,'sort'=>['notes.3.timestamp'=>1]];
$FetchResult=$collection->findOne($filter,$options);
if(count($FetchResult['remainder'])===0){
    echo '
        <div class="noremaindertoast d-block p-3 m-0 rounded shadow">
            <div class="toast-body d-flex flex-column justify-content-center align-items-center">
                <div class="col-12 px-0 d-flex justify-content-between mb-2 pb-2 border-bottom border-dark">
                    <b>No remainders are set</b>
                    <button type="button" class="btn-close btn-close-noremaindertoast d-flex justify-content-end align-items-center"></button>
                </div>
                <div class="col-12 px-0">
                    Click the plus button at the bottom right to set a new remainder and access them at anytime <span class="me-3"></span><i class="bi bi-arrow-down-right-square-fill"></i>
                </div>
            </div>
        </div>
    ';
}
else{
    $remainderarray=$FetchResult['remainder'];
    foreach($remainderarray as $cursor){
        echo '
            <div class="col-xl-4 col-md-6 col-12 p-2">
                <div class="card">
                    <div class="card-header border-0 mycardlabel">
                        '.$cursor[1]['label'].'
                    </div>
                    <div class="card-body pb-2 d-flex justify-content-center align-items-center">
                        <div class="mycardtime d-flex align-items-center justify-content-center rounded-pill py-3">
                            '.$cursor[2]['time'].'<i class="bi bi-alarm-fill ms-2"></i>
                        </div>
                    </div>
                    <div class="card-footer border-0 d-flex pt-0">
                        <div class="col-6 px-0 d-flex align-items-center time">
                            '.$cursor[3]['timestamp'].'
                        </div>
                        <div class="col-6 px-0 d-flex justify-content-end">
                            <div><button type="button" class="btn delete" id="remainder'.$cursor[0]['_id'].'"><i class="bi bi-trash-fill"></i></button></div>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }
}
?>