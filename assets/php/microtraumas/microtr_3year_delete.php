<?php
    session_start();
    require_once('../connect/logic.php');

    try {
        $years = $_GET['yearsCount'];
        $date = date('Y-m-d');

        $sql = "DELETE FROM `microtraumas` WHERE `date_microtr` <= NOW() - INTERVAL ? YEAR";
        $res = $pdo -> prepare($sql);
        $res -> execute(array($years));

        echo 'Микротравмы успешно удалены';
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;
    }
?>