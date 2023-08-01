<?php
    require_once('../connect/logic.php');

    try {
        $idSpec = $_GET['idSpec'];

        $sql = "DELETE FROM `specializations` WHERE `id_specialization` = ?";
        $res = $pdo -> prepare($sql);
        $res -> execute(array($idSpec));

        echo 'Удаление успешно завершено';
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;
    }
    
?>