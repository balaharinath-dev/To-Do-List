<?php
$filter=['username'=>$username];
$projection=['notes'=>1,];
$options=['projection'=>$projection,'sort'=>['notes.3.timestamp'=>1]];
$FetchResult=$collection->findOne($filter,$options);
if(count($FetchResult['notes'])===0){
    echo '
        <div class="nonotestoast d-block p-3 m-0 rounded shadow">
            <div class="toast-body d-flex flex-column justify-content-center align-items-center">
                <div class="col-12 px-0 d-flex justify-content-between mb-2 pb-2 border-bottom border-dark">
                    <b>No notes are available</b>
                    <button type="button" class="btn-close btn-close-nonotestoast d-flex justify-content-end align-items-center"></button>
                </div>
                <div class="col-12 px-0">
                    Click the plus button at the bottom right to create a new note and access them at anytime <span class="me-3"></span><i class="bi bi-arrow-down-right-square-fill"></i>
                </div>
            </div>
        </div>
    ';
}
else{
    $notesarray=$FetchResult['notes'];
    foreach($notesarray as $cursor){
        echo '
            <div class="col-xl-4 col-md-6 col-12 p-2 cardcol cardrow">
                <div class="card">
                    <div class="card-header border-0 mycardtitle">
                        '.$cursor[1]['title'].'
                    </div>
                    <div class="card-body">
                        '.$cursor[2]['description'].'
                    </div>
                    <div class="card-footer border-0 d-flex">
                        <div class="col-6 px-0 d-flex align-items-center time">
                            '.$cursor[3]['timestamp'].'
                        </div>
                        <div class="col-6 px-0 d-flex justify-content-end">
                            <div><button type="button" class="btn delete" id="notes'.$cursor[0]['_id'].'"><i class="bi bi-trash-fill"></i></button></div>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }
}
?>