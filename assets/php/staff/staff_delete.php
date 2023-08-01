<?php
    session_start();
    require_once('../connect/logic.php');

    try {
        $absPath = $_SERVER['DOCUMENT_ROOT'];
        $idStaff = $_POST['idStaff'];
        $action = $_POST['actionDel'];

        if($action == 'delete') {
            $sql = "DELETE FROM `staff` WHERE `id_staff` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($idStaff));

            foreach(glob($absPath.'/assets/img/staff/'.$idStaff.'/*') as $file) {
                unlink($file);
            }
    
            foreach(glob($absPath.'/assets/img/staff/*') as $dir) {
                if(end(explode('/', $dir)) == $idStaff) {
                    rmdir($dir);
                }
            }

            $sql = "SELECT * FROM `microtraumas` WHERE `id_staff` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($idStaff));
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

            echo 'Сотрудник успешно удален';
        } else if($action == 'archive') {
            $date = date('Y-m-d');

            $sql = "UPDATE `staff` SET `archive` = 1, `date_archive` = ? WHERE `id_staff` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($date, $idStaff));

            echo "Сотрудник успешно добавлен в архив";
        }
    } catch(Exception $e) {
        echo "Произошла ошибка - ".$e;
    }
?>