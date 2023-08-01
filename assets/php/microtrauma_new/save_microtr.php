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
            'idUser' => $_POST['idUser'],
            'typeUser' => $_POST['typeUser']
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
    
        if($data['typeUser'] == 'student') {
            $sqlJournal = "SELECT * FROM `journals` WHERE `type_victim` = 'students' AND `archive` = 0";
            $resJournal = $pdo -> query($sqlJournal);
            $journal_line = $resJournal -> fetch();
            if($journal_line['id_journal'] == null) {
                $journal_line['id_journal'] = 0;
            } 

            $sql = "SELECT * FROM `students` WHERE `id_student` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($data['idUser']));
            $student_line = $res -> fetch();

            $sql = "INSERT INTO `microtraumas` SET `id_student` = ?, `id_staff` = 0, `id_group` = ?, `id_journal` = ?, `place_microtr` = ?, `first_aid` = ?, `date_of_application` = ?, `title_medicial` = ?, `duration_release` = ?, `circumstances` = ?, `$reason` = ?, `$reason_another` = ?, `$type` = ?, `$typeMain` = ?, `$type_another` = ?, `suggestions` = ?, `trauma` = ?, `date_microtr` = ?, `status` = 'В рассмотрении'";
            $res = $pdo -> prepare($sql);
            $res -> execute(array(
                $data['idUser'],
                $student_line['id_group'],
                $journal_line['id_journal'],
                $data['place'],
                $data['firstAid'],
                $dateApp,
                $data['medicial'],
                $data['release'],
                $data['circ'],
                "$reason_value",
                "$reason_another_value",
                "$type_value",
                "$type_main_value",
                "$type_another_value",
                $data['suggestions'],
                $data['trauma'],
                $dateMicr
            ));

            echo 'Микротравма успешно создана';
    
        } else if($data['typeUser'] == 'staff') {
            $sqlJournal = "SELECT * FROM `journals` WHERE `type_victim` = 'staff' AND `archive` = 0";
            $resJournal = $pdo -> query($sqlJournal);
            $journal_line = $resJournal -> fetch();

            if($journal_line['id_journal'] == null) {
                $journal_line['id_journal'] = 0;
            } 

            $sql = "INSERT INTO `microtraumas` SET `id_student` = 0, `id_staff` = ?, `id_group` = 0, `id_journal` = ?, `place_microtr` = ?, `first_aid` = ?, `date_of_application` = ?, `title_medicial` = ?, `duration_release` = ?, `circumstances` = ?, `$reason` = ?, `$reason_another` = ?, `$type` = ?, `$typeMain` = ?, `$type_another` = ?, `suggestions` = ?, `trauma` = ?, `date_microtr` = ?, `status` = 'В рассмотрении'";
            $res = $pdo -> prepare($sql);
            $res -> execute(array(
                $data['idUser'],
                $journal_line['id_journal'],
                $data['place'],
                $data['firstAid'],
                $dateApp,
                $data['medicial'],
                $data['release'],
                $data['circ'],
                "$reason_value",
                "$reason_another_value",
                "$type_value",
                "$type_main_value",
                "$type_another_value",
                $data['suggestions'],
                $data['trauma'],
                $dateMicr
            ));

            echo 'Микротравма успешно создана';
        }
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;
    }
?>