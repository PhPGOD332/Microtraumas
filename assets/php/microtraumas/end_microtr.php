<?php
    session_start();
    require_once('../connect/logic.php');

    $data = [
        'place' => $_POST['place'],
        'dateMicr' => $_POST['dateMicr'],
        'firstAid' => $_POST['firstAid'],
        'dateApp' => $_POST['dateApp'],
        'medicial' => $_POST['medicial'],
        'trauma' => $_POST['trauma'],
        'release' => $_POST['release'],
        'circ' => $_POST['circ'],
        'reasons' => $_POST['reasons'],
        'suggestions' => $_POST['suggestions'],
        'idMicrotr' => $_POST['idMicrotr']
    ];
    
    $dateMicr = date('Y-m-d H:i', strtotime($data['dateMicr']));
    $dateApp = date('Y-m-d H:i', strtotime($data['dateApp']));
    echo $data['suggestions'];
    
    $sql = "UPDATE `microtraumas` SET `place_microtr` = ?, `date_microtr` = ?, `first_aid` = ?, `date_of_application` = ?, `title_medicial` = ?, `trauma` = ?, `duration_release` = ?, `circumstances` = ?, `reasons` = ?, `suggestions` = ? WHERE `id_microtr` = ?";
    $res = $pdo -> prepare($sql);
    $res -> execute(array($data['place'], $dateMicr, $data['firstAid'], $dateApp, $data['medicial'], $data['trauma'], $data['release'], $data['circ'], $data['reasons'], $data['suggestions'], $data['idMicrotr']));
    $save_lines = $res -> fetchAll();

    if($save_lines > 0) {
        echo "Изменения успешно сохранены";
    } 
?>