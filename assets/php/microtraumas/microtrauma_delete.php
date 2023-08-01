<?php
    session_start();
    require_once('../connect/logic.php');

    try {
        $idMicrotr = $_POST['idMicrotr'];
        $action = $_POST['actionDel'];

        if($action == 'delete') {
            $sql = "SELECT * FROM `microtraumas` WHERE `id_microtr` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($idMicrotr));
            $microtr_line = $res -> fetch();

            $idJournal = $microtr_line['id_journal'];

            $sql = "DELETE FROM `microtraumas` WHERE `id_microtr` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($idMicrotr));

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

            echo 'Микротравма успешно удалена';
        } else if($action == 'archive') {
            $sql = "UPDATE `microtraumas` SET `status` = 'Завершено' WHERE `id_microtr` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($idMicrotr));

            echo 'Микротравма успешно перенесена в архив';
        }
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;
    }
?>