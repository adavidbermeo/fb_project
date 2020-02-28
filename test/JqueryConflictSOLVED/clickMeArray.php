<?php 
if(isset($_POST['mssg'])){
    $mssg = $_POST['mssg'];

    $fields = [
        'name' => [
            'Angel','Luis','Alfredo'
        ],
        'last_name' => [
            'Bermeo', 'Castro','Molina'
        ],
        'age' => [
            '19','15','21'
        ],
        'mssg' => $mssg
    ];
    echo json_encode($fields);
}else{
    echo "No llega";
}
