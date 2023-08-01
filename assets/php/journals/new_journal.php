<?php
    session_start();
    require_once('../connect/logic.php');

    $date = date('Y-m-d');

    try {
        $type = $_GET['type'];

        $sql = "SELECT * FROM `journals` WHERE `type_victim` = ? AND `archive` = 0"; 
        $res = $pdo -> prepare($sql);
        $res -> execute(array($type));
        $journal_line = $res -> fetch();

        $idJournal = $journal_line['id_journal'];

        $sql = "SELECT * FROM `microtraumas` WHERE `id_journal` = ?";
        $res = $pdo -> prepare($sql);
        $res -> execute(array($idJournal));
        $microtr_lines = $res -> fetchAll();

        if(count($microtr_lines) <= 0) {
            $sql = "DELETE FROM `journals` WHERE `id_journal` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($idJournal));
        }

        $sql = "UPDATE `journals` SET `archive` = 1, `date_end` = ? WHERE `type_victim` = ? AND `archive` = 0";
        $res = $pdo -> prepare($sql);
        $res -> execute(array($date, $type));

        $sql = "INSERT INTO `journals` VALUES(NULL, ?, ?, '1970-01-01', 0)";
        $res = $pdo -> prepare($sql);
        $res -> execute(array($type, $date));

        echo 'Журнал успешно создан';
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;
    }
?>