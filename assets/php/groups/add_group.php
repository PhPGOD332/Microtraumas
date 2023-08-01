<?php
    require_once('../connect/logic.php');

    try {
        $title = $_GET['titleGroup'];
        $course = $_GET['courseGroup'];
        $spec = $_GET['specGroup'];
        $elder = $_GET['elderGroup'];
        $maxCourse = $_GET['maxCourse'];
    
        $sql = "INSERT INTO `groups` VALUES (NULL, ?, ?, ?, ?, ?)";
        $res = $pdo -> prepare($sql);
        $res -> execute(array($title, $course, $maxCourse, $spec, $elder));
    
        echo "Группа успешно добавлена";
    } catch(Exception $e) {
        echo 'Найдена ошибка - '.$e;
    }

    
?>