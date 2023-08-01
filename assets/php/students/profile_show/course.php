<?php
    session_start();
    require_once('../../connect/logic.php');

    $idGroup = $_POST['idGroup'];

    $sql = "SELECT * FROM `groups` WHERE `id_group` = ?";
    $res = $pdo -> prepare($sql);
    $res -> execute(array($idGroup));
    $group = $res -> fetch();

    echo $group['course'];
?>