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

                if($studLine[0] == '') {
                    continue;
                }
    
                $sqlStudents = "SELECT * FROM `students` WHERE `FIO` LIKE ?";
                $resStudents = $pdo -> prepare($sqlStudents);
                $resStudents -> execute(array("$studLine[0]"));
                $students_line = $resStudents -> fetchAll();
    
                $count = 0;
    
                foreach($students_line as $student) {
                    if($studLine[0] == $student['FIO']) {
                        $count++;
                    }
                }
    
                if($count > 0) {
                    continue;
                }
    
                $sqlGroups = "SELECT * FROM `groups` WHERE `title_group` LIKE ?";
                $resGroup = $pdo -> prepare($sqlGroups);
                $resGroup -> execute(array(
                    str_replace("\r\n", "", $studLine[1])
                ));
                $groupLine = $resGroup -> fetch();
    
                $query = "INSERT INTO `students` VALUES(NULL, ?, '', '', '', ?, '$date', '$date', '', '0', '1970-01-01')";
                $data = $pdo->prepare($query);
                $data->execute(array(
                    $studLine[0],
                    $groupLine['id_group']
                ));
            }
            else{
                $studLine = htmlentities(fgets($f));
                echo $studLine;
            }
            $iteration++;
        }
        fclose($f);
        
        echo 'Импорт успешно завершен';
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;
    }
?>