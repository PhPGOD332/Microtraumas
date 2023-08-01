<?php
    require_once('../connect/logic.php');
    $idStudent = $_GET['idStudent'];

    $sql = "SELECT * FROM `students` WHERE `id_student` = ?";
    $result = $pdo -> prepare($sql);
    $result -> execute(array($idStudent));
    $student_line = $result -> fetch();

    if($student_line['id_group'] == 0) {
        // Вывод данных из таблицы "Микротравмы + Пользователи + Группы"
        $sqlLast = 'SELECT * FROM `microtraumas` INNER JOIN `students` ON `microtraumas`.`id_student` = `students`.`id_student` WHERE `students`.`id_student` = ? AND `microtraumas`.`status` = "В рассмотрении"';
        $resLast = $pdo -> prepare($sqlLast);
        $resLast -> execute(array($idStudent));
        $microtraumas_student_last_line = $resLast -> fetchAll();

        // Вывод данных из таблицы "Микротравмы + Пользователи + Группы"
        $sqlEnd = 'SELECT * FROM `microtraumas` INNER JOIN `students` ON `microtraumas`.`id_student` = `students`.`id_student` WHERE `students`.`id_student` = ? AND `microtraumas`.`status` = "Завершено"';
        $resEnd = $pdo -> prepare($sqlEnd);
        $resEnd -> execute(array($idStudent));
        $microtraumas_student_archive_line = $resEnd -> fetchAll();
    } else {
        // Вывод данных из таблицы "Микротравмы + Пользователи + Группы"
        $sqlLast = 'SELECT * FROM `microtraumas` INNER JOIN `students` ON `microtraumas`.`id_student` = `students`.`id_student` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group` WHERE `students`.`id_student` = ? AND `microtraumas`.`status` = "В рассмотрении"';
        $resLast = $pdo -> prepare($sqlLast);
        $resLast -> execute(array($idStudent));
        $microtraumas_student_last_line = $resLast -> fetchAll();

        // Вывод данных из таблицы "Микротравмы + Пользователи + Группы"
        $sqlEnd = 'SELECT * FROM `microtraumas` INNER JOIN `students` ON `microtraumas`.`id_student` = `students`.`id_student` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group` WHERE `students`.`id_student` = ? AND `microtraumas`.`status` = "Завершено"';
        $resEnd = $pdo -> prepare($sqlEnd);
        $resEnd -> execute(array($idStudent));
        $microtraumas_student_archive_line = $resEnd -> fetchAll();
    }

    if(count($microtraumas_student_last_line) == 0 && count($microtraumas_student_archive_line) == 0) {
        echo '<span class="error">У данного студента нет микротравм</span>';
    }

    foreach($microtraumas_student_last_line as $line) { 
?>
        <div class="row-microtr">
            <a href="/pages/admin/microtraumas_detailed/index.php?id_microtr=<?=$line['id_microtr']; ?>" class="row-table last-row">
                <div class="body-item FIO-body">
                    <span><?=$line['FIO']; ?></span>
                </div>
                <div class="body-item descr-body">
                    <span><?=$line['trauma']; ?></span>
                </div>
                <div class="body-item date-body">
                    <span><?=date('d.m.Y H:i', strtotime($line['date_microtr'])); ?></span>
                </div>
                <div class="body-item status-body">
                    <span><?=$line['status']; ?></span>
                </div>
            </a>
            <button class="del-btn archive-btn" id="archivation-microtr">
                <i class="fa fa-folder-open"></i>
            </button>
        </div>
<?php    
    }

    foreach($microtraumas_student_archive_line as $line) { 
?>
        <div class="row-microtr">
            <a href="/pages/admin/microtraumas_detailed/index.php?id_microtr=<?=$line['id_microtr']; ?>" class="row-table archive-row">
                <div class="body-item FIO-body">
                    <span><?=$line['FIO']; ?></span>
                </div>
                <div class="body-item descr-body">
                    <span><?=$line['trauma']; ?></span>
                </div>
                <div class="body-item date-body">
                    <span><?=date('d.m.Y H:i', strtotime($line['date_microtr'])); ?></span>
                </div>
                <div class="body-item status-body">
                    <span><?=$line['status']; ?></span>
                </div>
            </a>
            <button class="del-btn del-btn" id="del-microtr">
                <i class="fa fa-close"></i>
            </button>
        </div>
<?php    
    }
?>