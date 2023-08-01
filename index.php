<?php
    session_start();
    
    if($_SESSION['autorized'] == true && $_SESSION['role'] == 'admin') {
        header('Location:/pages/admin/main/index.php');
    } else if($_SESSION['autorized'] == true && $_SESSION['role'] == 'medicial') {
        header('Location:/pages/medicial/main/index.php');
    } else {
        header('Location:/assets/php/autorization/index.php');
    }
?>