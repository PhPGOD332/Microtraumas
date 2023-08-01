<?php
    session_start();
    require_once('../../connect/logic.php');

    $dateBirth = $_POST['dateBirth'];

    $dateBirth = new DateTime($dateBirth);
    $age = $dateBirth->diff(new DateTime)->y;

    echo $age;
?>