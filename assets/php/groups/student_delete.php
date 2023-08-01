<?php
    session_start();
    require_once('../connect/logic.php');

    try {
        $absPath = $_SERVER['DOCUMENT_ROOT'];
        $idStudent = $_POST['idStudent'];
    
        $sql = "UPDATE `students` SET `archive` = 1 WHERE `id_student` = ?";
        $res = $pdo -> prepare($sql);
        $res -> execute(array($idStudent));

        // foreach(glob($absPath.'/assets/img/students/'.$idStudent.'/*') as $file) {
        //     unlink($file);
        // }
    
        // foreach(glob($absPath.'/assets/img/students/*') as $dir) {
        //     if(end(explode('/', $dir)) == $idStudent) {
        //         rmdir($dir);
        //     }
        // }

        echo 'Студент успешно перенесен в архив';
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;
    }

    // $sql = "UPDATE `students` SET `id_group` = 0 WHERE `id_student` = ?";
    // $res = $pdo -> prepare($sql);
    // $res -> execute(array($idStudent));

    // $sql = 'SELECT * FROM `students` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group` WHERE `students`.`id_group` = ?';
    // $res = $pdo -> prepare($sql);
    // $res -> execute(array($idGroup));
    // $students_line = $res -> fetchAll();

    // $countLines = count($students_line);

    // $sql2 = 'SELECT * FROM `groups` WHERE `id_group` = ?';
    // $res2 = $pdo -> prepare($sql2);
    // $res2 -> execute(array($idGroup));
    // $lineGroup = $res2 -> fetch();

    // $absPath = $_SERVER['DOCUMENT_ROOT'];
?>