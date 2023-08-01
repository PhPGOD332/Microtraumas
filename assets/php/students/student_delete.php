<?php
    session_start();
    require_once('../connect/logic.php');

    try {
        $absPath = $_SERVER['DOCUMENT_ROOT'];
        $idStudent = $_POST['idStudent'];
        $action = $_POST['actionDel'];

        if($action == 'delete') {
            $sql = "DELETE FROM `students` WHERE `id_student` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($idStudent));

            foreach(glob($absPath.'/assets/img/students/'.$idStudent.'/*') as $file) {
                unlink($file);
            }
        
            foreach(glob($absPath.'/assets/img/students/*') as $dir) {
                if(end(explode('/', $dir)) == $idStudent) {
                    rmdir($dir);
                }
            }

            $sql = "SELECT * FROM `microtraumas` WHERE `id_student` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($idStudent));
            $microtr_lines = $res -> fetchAll();

            foreach($microtr_lines as $microtr) {
                $idJournal = $microtr['id_journal'];

                $sql = "DELETE FROM `microtraumas` WHERE `id_microtr` = ?";
                $res = $pdo -> prepare($sql);
                $res -> execute(array($microtr['id_microtr']));

                $sqlJ = "SELECT * FROM `journals` WHERE `id_journal` = ?";
                $res = $pdo -> prepare($sqlJ);
                $res -> execute(array($idJournal));
                $journal = $res -> fetch();

                if($journal['archive'] == 1) {
                    $sqlJournal = "SELECT * FROM `microtraumas` WHERE `id_journal` = ?";
                    $resJournal = $pdo -> prepare($sqlJournal);
                    $resJournal -> execute(array($idJournal));
                    $journal_line = $resJournal -> fetchAll();
    
                    if(count($journal_line) <= 0) {
                        $sqlDelJournal = "DELETE FROM `journals` WHERE `id_journal` = ?";
                        $resDelJournal = $pdo -> prepare($sqlDelJournal);
                        $resDelJournal -> execute(array($idJournal));
                    }
                }
            }

            echo 'Студент успешно удален';
        } else if($action == 'archive') {
            $date = date('Y-m-d');

            $sql = "UPDATE `students` SET `archive` = 1, `date_archive` = ? WHERE `id_student` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($date, $idStudent));

            echo 'Студент успешно перенесен в архив';
        }
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;
    }

    // $sql = "UPDATE `students` SET `id_group` = 0 WHERE `id_student` = ?";
    // $res = $pdo -> prepare($sql);
    // $res -> execute(array($idStudent));

    // $sql = 'SELECT * FROM `students` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group` WHERE `students`.`id_group` = ?';
    // $res = $pdo -> prepare($sql);
    // $res -> execute(array($idGroup));
    // $students_line = $res -> fetchAll();

    // $countLines = count($students_line);

    // $sql2 = 'SELECT * FROM `groups` WHERE `id_group` = ?';
    // $res2 = $pdo -> prepare($sql2);
    // $res2 -> execute(array($idGroup));
    // $lineGroup = $res2 -> fetch();

    // $absPath = $_SERVER['DOCUMENT_ROOT'];
?>