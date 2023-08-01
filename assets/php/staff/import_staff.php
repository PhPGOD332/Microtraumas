<?php
    session_start();
    require_once('../connect/logic.php');

    try {
        $absPath = $_SERVER['DOCUMENT_ROOT'];
        $file = $_FILES['file'];
        $fileDir = $absPath."/assets/docs/";
        $newFile = $fileDir.basename($file['name']);
        $fileBDName = $fileDir.basename($file['name']);
        move_uploaded_file($file['tmp_name'], $newFile);
        $f = fopen($newFile, "r") or die("не удалось открыть файл");
    
        $iteration = 0;
        //51
        while(!feof($f)){
            if ($iteration > -1){
                $studLine = htmlentities(fgets($f));
                $studLine = explode(";", $studLine);
                $date = date('Y-m-d', strtotime('1970-01-01'));
                $dateBirth = date('Y-m-d', strtotime($studLine[2]));

                if($studLine[0] == '') {
                    continue;
                }
    
                if($dateBirth == '') {
                    $dateBirth = date('Y-m-d', strtotime('1970-01-01'));
                } 
    
                $sqlStaff = "SELECT * FROM `staff` WHERE `FIO` LIKE ?";
                $resStaff = $pdo -> prepare($sqlStaff);
                $resStaff -> execute(array("$studLine[0]"));
                $staff_line = $resStaff -> fetchAll();
    
                $count = 0;
    
                foreach($staff_line as $staff) {
                    if($studLine[0] == $staff['FIO']) {
                        $count++;
                    }
                }
    
                if($count > 0) {
                    continue;
                }
    
                $query = "INSERT INTO `staff` VALUES(NULL, ?, '', ?, '', '', '', '$date', ?, '', '', '', '', '', 0, 0, 0, 0, 0, '', 0, '1970-01-01')";
                $data = $pdo->prepare($query);
                $data->execute(array(
                    $studLine[0],
                    $studLine[1],
                    $dateBirth
                ));
            }
            else{
                $studLine = htmlentities(fgets($f));
            }
            $iteration++;
        }
        fclose($f);

        echo 'Импорт успешно завершен';
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;
    }
    
    // header("Location: ../../AdminPanel.php");
?>