<?php
    require_once('../connect/logic.php');

    try {
        $absPath = $_SERVER['DOCUMENT_ROOT'];
        $action = $_POST['actionDel'];
        $years = $_POST['yearsCount'];

        $sql = "SELECT * FROM `students` WHERE `archive` = 1 AND `date_archive` <= NOW() - INTERVAL ? YEAR AND `date_archive` > '1970-01-01'";
        $res = $pdo -> prepare($sql);
        $res -> execute(array($years));
        $students_line = $res -> fetchAll();

        foreach($students_line as $student) {
            $sql = "DELETE FROM `students` WHERE `id_student` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($student['id_student']));
            foreach(glob($absPath.'/assets/img/students/'.$student['id_student'].'/*') as $file) {
                unlink($file);
            }
        
            foreach(glob($absPath.'/assets/img/students/*') as $dir) {
                if(end(explode('/', $dir)) == $student['id_student']) {
                    rmdir($dir);
                }
            }

            $sql = "DELETE FROM `microtraumas` WHERE `id_student` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($student['id_student']));
        }

        echo 'Студенты успешно удалены';
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;
    }
?>