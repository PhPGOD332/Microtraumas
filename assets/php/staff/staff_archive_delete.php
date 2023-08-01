<?php
    require_once('../connect/logic.php');

    try {
        $absPath = $_SERVER['DOCUMENT_ROOT'];
        $action = $_POST['actionDel'];
        $years = $_POST['yearsCount'];

        $sql = "SELECT * FROM `staff` WHERE `archive` = 1 AND `date_archive` <= NOW() - INTERVAL ? YEAR AND `date_archive` > '1970-01-01'";
        $res = $pdo -> prepare($sql);
        $res -> execute(array($years));
        $staff_line = $res -> fetchAll();

        foreach($staff_line as $staff) {
            $sql = "DELETE FROM `staff` WHERE `id_staff` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($staff['id_staff']));
            foreach(glob($absPath.'/assets/img/staff/'.$staff['id_staff'].'/*') as $file) {
                unlink($file);
            }
        
            foreach(glob($absPath.'/assets/img/staff/*') as $dir) {
                if(end(explode('/', $dir)) == $staff['id_staff']) {
                    rmdir($dir);
                }
            }

            $sql = "DELETE FROM `microtraumas` WHERE `id_staff` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($staff['id_staff']));
        }

        echo 'Сотрудники успешно удалены';
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;
    }
?>