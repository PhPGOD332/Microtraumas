<?php
    session_start();
    require_once('../../../assets/php/connect/logic.php');

    try {
        $data = [
            'place' => $_POST['place'],
            'dateMicr' => $_POST['dateMicr'],
            'dateApp' => $_POST['dateApp'],
            'trauma' => $_POST['trauma'],
            'circ' => $_POST['circ'],
            'idUser' => $_POST['idUser'],
            'typeUser' => $_POST['typeUser']
        ];
    
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
    
            $sql = "INSERT INTO `microtraumas` SET `id_student` = ?, `id_staff` = 0, `id_group` = ?, `id_journal` = ?, `place_microtr` = ?, `first_aid` = '', `date_of_application` = ?, `title_medicial` = '', `duration_release` = '', `circumstances` = ?, `id_reason` = 0, `custom_reason` = '', `id_type_main` = 0, `id_type_secondary` = 0, `custom_type` = '', `suggestions` = '', `trauma` = ?, `date_microtr` = ?, `status` = 'В рассмотрении'";
            $res = $pdo -> prepare($sql);
            $res -> execute(array(
                $data['idUser'],
                $student_line['id_group'],
                $journal_line['id_journal'],
                $data['place'],
                $dateApp,
                $data['circ'],
                $data['trauma'],
                $dateMicr
            ));
            $new_line = $res -> fetchAll();
            $count = count($new_line);
    
            if($count > 0) {
                echo "Микротравма успешно создана";
            }
    
        } else if($data['typeUser'] == 'staff') {
            $sqlJournal = "SELECT * FROM `journals` WHERE `type_victim` = 'staff' AND `archive` = 0";
            $resJournal = $pdo -> query($sqlJournal);
            $journal_line = $resJournal -> fetch();
    
            if($journal_line['id_journal'] == null) {
                $journal_line['id_journal'] = 0;
            } 
    
            $sql = "INSERT INTO `microtraumas` SET `id_student` = 0, `id_staff` = ?, `id_group` = 0, `id_journal` = ?, `place_microtr` = ?, `first_aid` = '', `date_of_application` = ?, `title_medicial` = '', `duration_release` = '', `circumstances` = ?, `id_reason` = 0, `custom_reason` = '', `id_type_main` = 0, `id_type_secondary` = 0, `custom_type` = '', `suggestions` = '', `trauma` = ?, `date_microtr` = ?, `status` = 'В рассмотрении'";
            $res = $pdo -> prepare($sql);
            $res -> execute(array(
                $data['idUser'],
                $journal_line['id_journal'],
                $data['place'],
                $dateApp,
                $data['circ'],
                $data['trauma'],
                $dateMicr
            ));
            $new_line = $res -> fetchAll();
            $count = count($new_line);
    
            if($count > 0) {
                echo "Микротравма успешно создана";
            }
        }

        echo 'Микротравма успешно отправлена';
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;
    }
?>
