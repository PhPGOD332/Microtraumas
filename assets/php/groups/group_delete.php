<?php
    require_once('../connect/logic.php');

    try {
        $idGroup = $_GET['idGroup'];

        $sql = "UPDATE `students` SET `archive` = 1 WHERE `id_group` = ?";
        $res = $pdo -> prepare($sql);
        $res -> execute(array($idGroup));
    
        $sql = "DELETE FROM `groups` WHERE `id_group` = ?";
        $res = $pdo -> prepare($sql);
        $res -> execute(array($idGroup));
    
        echo 'Группа успешно удалена';
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;
    }
    
?>