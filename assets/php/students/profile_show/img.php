<?php
    session_start();
    require_once('../../connect/logic.php');

    $file = 'file';
    $img = $_FILES[$file];
    $imgPath = $img['tmp_name'];
?>
    <img src='<?=$imgPath; ?>' alt=''>