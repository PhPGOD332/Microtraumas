<?php
    require_once('../connect/logic.php');

    try {
        $idSpec = $_GET['idSpec'];
        $title = $_GET['title'];

        $sql = "UPDATE `specializations` SET `title_specialization` = ? WHERE `id_specialization` = ?";
        $res = $pdo -> prepare($sql);
        $res -> execute(array($title, $idSpec));

        echo 'Изменения успешно сохранены';
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;
    }
?>