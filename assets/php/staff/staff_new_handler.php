<?php
    session_start();
    require_once('../connect/logic.php');

    try {
        $data = [
            'FIO' => $_POST['fio'],
            'img' => $_FILES['img'],
            'post' => $_POST['post'],
            'division' => $_POST['division'],
            'category' => $_POST['category'],
            'director' => $_POST['director'],
            'dateHiring' => $_POST['dateHiring'],
            'dateBirth' => $_POST['dateBirth'],
            'SNILS' => $_POST['SNILS'],
            'exp' => $_POST['exp'],
            'email' => $_POST['email'],
            'passport' => $_POST['passport'],
            'address' => $_POST['address'],
            'combining' => $_POST['combining'],
            'disability' => $_POST['disability'],
            'maternity' => $_POST['maternity'],
            'pregnancy' => $_POST['pregnancy'],
            'easywork' => $_POST['easywork'],
            'addInfo' => $_POST['addInfo']
        ];

        $img = $_FILES['img'];

        if($img['size'] > 0) {
            $sql = "SELECT * FROM `staff` ORDER BY `id_staff` DESC LIMIT 1";
            $res = $pdo -> query($sql);
            $staff_line = $res -> fetch();
    
            $idAdded = $staff_line['id_staff'];
    
            $absPath = $_SERVER['DOCUMENT_ROOT'];
            $imgTmp = $img['tmp_name'];
            $imgName = $img['name'];
    
            if(file_exists($absPath.'/assets/img/staff/'.$idAdded)) {
                foreach(glob($absPath.'/assets/img/staff/'.$idAdded.'/*') as $file) {
                    unlink($file);
                }
            } else {
                mkdir($absPath."/assets/img/staff/$idAdded");
            }
    
            move_uploaded_file($imgTmp, $absPath."/assets/img/staff/$idAdded/$imgName");
            $pathDB = "/assets/img/staff/$idAdded/$imgName";

            $sql = "UPDATE `staff` SET `img` = ? WHERE `id_staff` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($pathDB, $idAdded));
            
        } else {

            if(!$data['FIO']) {
                $data['FIO'] = '';
            }
        
            if(!$data['post']) {
                $data['post'] = '';
            }
        
            if(!$data['division']) {
                $data['division'] = '';
            }
        
            if(!$data['category']) {
                $data['category'] = '';
            }
        
            if(!$data['director']) {
                $data['director'] = '';
            }
        
            if(!$data['dateHiring']) {
                $data['dateHiring'] = '1970-01-01';
            }
        
            if(!$data['dateBirth']) {
                $data['dateBirth'] = '1970-01-01';
            }
        
            if(!$data['SNILS']) {
                $data['SNILS'] = '0';
            } else {
                $data['SNILS'] = str_replace('-', '', str_replace(' ', '', $data['SNILS']));
            }
        
            if(!$data['exp']) {
                $data['exp'] = '';
            }
        
            if(!$data['email']) {
                $data['email'] = '';
            }
        
            if(!$data['passport']) {
                $data['passport'] = '0';
            } else {
                $data['passport'] = str_replace(' ', '', $data['passport']);
            }
        
            if(!$data['address']) {
                $data['address'] = '';
            }
        
            if($data['combining'] == 'on') {
                $data['combining'] = '1';
            } else {
                $data['combining'] = '0';
            }
        
            if($data['disability'] == 'on') {
                $data['disability'] = '1';
            } else {
                $data['disability'] = '0';
            }
        
            if($data['maternity'] == 'on') {
                $data['maternity'] = '1';
            } else {
                $data['maternity'] = '0';
            }
        
            if($data['pregnancy'] == 'on') {
                $data['pregnancy'] = '1';
            } else {
                $data['pregnancy'] = '0';
            }
        
            if($data['easywork'] == 'on') {
                $data['easywork'] = '1';
            } else {
                $data['easywork'] = '0';
            }
        
            if(!$data['addInfo']) {
                $data['addInfo'] = '';
            }
        
            $sql = "INSERT INTO `staff` SET `FIO` = ?, `img` = '',
            `post` = ?, `division` = ?, `personnel_category` = ?, `director` = ?, `date_hiring` = ?, `date_birth` = ?, `SNILS` = ?, `experience` = ?, `email` = ?, `№_passport` = ?, `address` = ?, `combining` = ?, `disability` = ?, `maternity_leave` = ?, `pregnancy` = ?, `easy_work` = ?, `add_information` = ?, `archive` = 0, `date_archive` = '1970-01-01'";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($data['FIO'], $data['post'], $data['division'], $data['category'], $data['director'], $data['dateHiring'], $data['dateBirth'], $data['SNILS'], $data['exp'], $data['email'], $data['passport'], $data['address'], $data['combining'], $data['disability'], $data['maternity'], $data['pregnancy'], $data['easywork'], $data['addInfo']));
        }

        echo 'Сотрудник успешно создан';
    } catch(Exception $e) {
        echo 'Ошибка - '.$e;
    }
    
    // header("Location: ../../../pages/admin/staff_new/index.php");
?>