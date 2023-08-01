<?php
    session_start();
    require_once('../connect/logic.php');

    try {
        $data = [
            'FIO' => $_POST['fio'],
            'address' => $_POST['address'],
            'phone' => $_POST['phone'],
            'idGroup' => $_POST['idGroup'],
            'dateStudy' => $_POST['dateStudy'],
            'dateBirth' => $_POST['dateBirth'],
            'addInfo' => $_POST['addInfo']
        ];
        
        if(!$data['FIO']) {
            $data['FIO'] = '';
        }
    
        if(!$data['address']) {
            $data['address'] = '';
        }
    
        if(!$data['phone']) {
            $data['phone'] = '';
        }
    
        if(!$data['idGroup']) {
            $data['idGroup'] = 0;
        }
    
        if(!$data['addInfo']) {
            $data['addInfo'] = '';
        }

        if(!$data['dateStudy']) {
            $data['dateStudy'] = '1970-01-01';
        }

        if(!$data['dateBirth']) {
            $data['dateBirth'] = '1970-01-01';
        }

        $sql = "INSERT INTO `students` SET `FIO` = ?, `img` = '', `address` = ?, `phone` = ?, `id_group` = ?, `admission_to_study` = ?, `date_birth` = ?, `add_information` = ?, `archive` = 0, `date_archive` = '1970-01-01'";
        $res = $pdo -> prepare($sql);
        $res -> execute(array($data['FIO'], $data['address'], $data['phone'], $data['idGroup'], $data['dateStudy'], $data['dateBirth'], $data['addInfo']));

        echo 'Студент успешно создан';
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;
    }
?>