<?php
    session_start();
    require_once('../connect/logic.php');

    try {
        $data = [
            'place' => $_POST['place'],
            'dateMicr' => $_POST['dateMicr'],
            'firstAid' => $_POST['firstAid'],
            'dateApp' => $_POST['dateApp'],
            'medicial' => $_POST['medicial'],
            'trauma' => $_POST['trauma'],
            'release' => $_POST['release'],
            'circ' => $_POST['circ'],
            'id_reason' => $_POST['idReason'],
            'reason' => $_POST['reason'],
            'id_type_main' => $_POST['idTypeMain'],
            'id_type' => $_POST['idType'],
            'type' => $_POST['type'],
            'suggestions' => $_POST['suggestions'],
            'idMicrotr' => $_POST['idMicrotr'],
            'action' => $_POST['action']
        ];
    
        if($data['id_reason'] == 0) {
            $reason = 'custom_reason';
            $reason_value = $data['reason'];
            $reason_another = 'id_reason';
            $reason_another_value = '0';
        } else {
            $reason = 'id_reason';
            $reason_value = $data['id_reason'];
            $reason_another = 'custom_reason';
            $reason_another_value = '';
        }
    
        if($data['id_type_main'] == 0 && $data['id_type'] == 0) {
            $type = 'custom_type';
            $typeMain = 'id_type_main';
            $type_value = $data['type'];
            $type_main_value = 0;
            $type_another = 'id_type_secondary';
            $type_another_value = 0;
        } else if($data['id_type_main'] != 0 && $data['id_type'] == 0) {
            $type = 'id_type_secondary';
            $typeMain = 'id_type_main';
            $type_value = 0;
            $type_main_value = $data['id_type_main'];
            $type_another = 'custom_type';
            $type_another_value = '';
        } else {
            $type = 'id_type_secondary';
            $typeMain = 'id_type_main';
            $type_value = $data['id_type'];
            $type_main_value = $data['id_type_main'];
            $type_another = 'custom_type';
            $type_another_value = '';
        }
        
        $dateMicr = date('Y-m-d H:i', strtotime($data['dateMicr']));
        $dateApp = date('Y-m-d H:i', strtotime($data['dateApp']));
        
        // $sql = "UPDATE `microtraumas` SET `place_microtr` = ?, `date_microtr` = ?, `first_aid` = ?, `date_of_application` = ?, `title_medicial` = ?, `trauma` = ?, `duration_release` = ?, `circumstances` = ?, `reasons` = ?, `suggestions` = ? WHERE `id_microtr` = ?";
        // $res = $pdo -> prepare($sql);
        // $res -> execute(array($data['place'], $dateMicr, $data['firstAid'], $dateApp, $data['medicial'], $data['trauma'], $data['release'], $data['circ'], $data['reasons'], $data['suggestions'], $data['idMicrotr']));
        // $save_lines = $res -> fetchAll();
    
        if($data['action'] == 'save') {
            $sql = "UPDATE `microtraumas` SET `place_microtr` = ?, `date_microtr` = ?, `first_aid` = ?, `date_of_application` = ?, `title_medicial` = ?, `trauma` = ?, `duration_release` = ?, `circumstances` = ?, `$reason` = ?, `$reason_another` = ?, `$type` = ?, `$typeMain` = ?, `$type_another` = ?, `suggestions` = ? WHERE `id_microtr` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($data['place'], $dateMicr, $data['firstAid'], $dateApp, $data['medicial'], $data['trauma'], $data['release'], $data['circ'], "$reason_value", "$reason_another_value", "$type_value", "$type_main_value", "$type_another_value", $data['suggestions'], $data['idMicrotr']));
            $save_lines = $res -> fetchAll();

            echo 'Микротравма успешно сохранена';
        } else if($data['action'] == 'end') {
            $sql = "UPDATE `microtraumas` SET `place_microtr` = ?, `date_microtr` = ?, `first_aid` = ?, `date_of_application` = ?, `title_medicial` = ?, `trauma` = ?, `duration_release` = ?, `circumstances` = ?, `$reason` = ?, `$reason_another` = ?, `$type` = ?, `$typeMain` = ?, `$type_another` = ?, `suggestions` = ?, `status` = 'Завершено' WHERE `id_microtr` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($data['place'], $dateMicr, $data['firstAid'], $dateApp, $data['medicial'], $data['trauma'], $data['release'], $data['circ'], "$reason_value", "$reason_another_value", "$type_value", "$type_main_value", "$type_another_value", $data['suggestions'], $data['idMicrotr']));
            $save_lines = $res -> fetchAll();

            echo 'Микротравма успешно отправлена в архив';
        } else if($data['action'] == 'return') {
            $sql = "UPDATE `microtraumas` SET `place_microtr` = ?, `date_microtr` = ?, `first_aid` = ?, `date_of_application` = ?, `title_medicial` = ?, `trauma` = ?, `duration_release` = ?, `circumstances` = ?, `$reason` = ?, `$reason_another` = ?, `$type` = ?, `$typeMain` = ?, `$type_another` = ?, `suggestions` = ?, `status` = 'В рассмотрении' WHERE `id_microtr` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($data['place'], $dateMicr, $data['firstAid'], $dateApp, $data['medicial'], $data['trauma'], $data['release'], $data['circ'], "$reason_value", "$reason_another_value", "$type_value", "$type_main_value", "$type_another_value", $data['suggestions'], $data['idMicrotr']));
            $save_lines = $res -> fetchAll();

            echo 'Микротравма успешно возвращена из архива';
        }
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;
    }
?>