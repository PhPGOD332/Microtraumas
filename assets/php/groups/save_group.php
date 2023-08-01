<?php
    session_start();
    require_once('../connect/logic.php');

    try {
        $title = $_GET['title'];
        $course = $_GET['course'];
        $elder = $_GET['elder'];
        $spec = $_GET['spec'];
        $maxCourse = $_GET['maxCourse'];
        $idGroup = $_GET['idGroup'];
    
        $sql = "UPDATE `groups` SET `title_group` = ?, `course` = ?, `max_course` = ?, `id_specialization` = ?, `elder` = ? WHERE `id_group` = ?";
        $res = $pdo -> prepare($sql);
        $res -> execute(array($title, $course, $maxCourse, $spec, $elder, $idGroup));
        $saves = $res -> fetchAll();
    
        echo 'Группа успешно сохранена';
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;        
    }
?>