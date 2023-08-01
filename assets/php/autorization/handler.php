<?php
    session_start();
    require_once('../connect/logic.php');

    $login = $_POST['login'];
    $pass = md5($_POST['pass'] . 'klfg4rejq22');
    $count = 0;
    
    if($login != '' && $pass != '') {
        foreach($users_line as $line) {
            if($login == $line['login'] && $pass == $line['password']) {
                $_SESSION['autorized'] = true;
                $_SESSION['role'] = $line['role'];
                $_SESSION['nickname'] = $line['nickname'];
                
                echo '<script>location.href="/index.php"</script>';
                exit;
            } else {
                $count += 1;
                continue;
            }
        }
    }

    if($count > 0) {
        $_SESSION['autorized'] = false;
        $_SESSION['role'] = '';
        echo "Логин или пароль не верны";
    }
?>