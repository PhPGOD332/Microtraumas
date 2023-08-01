<?php
    require_once('../connect/logic.php');

    try {
        $title = $_GET['title'];

        $sql = "INSERT INTO `specializations` SET `title_specialization` = ?";
        $res = $pdo -> prepare($sql);
        $res -> execute(array($title));

        echo 'Специальность успешно добавлена';
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;
    }
?>