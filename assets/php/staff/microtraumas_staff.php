<?php
    require_once('../connect/logic.php');
    $idStaff = $_GET['idStaff'];

    $sql = "SELECT * FROM `staff` WHERE `id_staff` = ?";
    $result = $pdo -> prepare($sql);
    $result -> execute(array($idStaff));
    $staff_line = $result -> fetch();

    // Вывод данных из таблицы "Микротравмы + Пользователи + Группы"
    $sqlLast = 'SELECT * FROM `microtraumas` INNER JOIN `staff` ON `microtraumas`.`id_staff` = `staff`.`id_staff` WHERE `staff`.`id_staff` = ? AND `microtraumas`.`status` = "В рассмотрении"';
    $resLast = $pdo -> prepare($sqlLast);
    $resLast -> execute(array($idStaff));
    $microtraumas_staff_last_line = $resLast -> fetchAll();

    // Вывод данных из таблицы "Микротравмы + Пользователи + Группы"
    $sqlEnd = 'SELECT * FROM `microtraumas` INNER JOIN `staff` ON `microtraumas`.`id_staff` = `staff`.`id_staff` WHERE `staff`.`id_staff` = ? AND `microtraumas`.`status` = "Завершено"';
    $resEnd = $pdo -> prepare($sqlEnd);
    $resEnd -> execute(array($idStaff));
    $microtraumas_staff_archive_line = $resEnd -> fetchAll();

    if(count($microtraumas_staff_last_line) == 0 && count($microtraumas_staff_archive_line) == 0) {
        echo '<span class="error">У данного сотрудника нет микротравм</span>';
    }

    foreach($microtraumas_staff_last_line as $line) { 
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

    foreach($microtraumas_staff_archive_line as $line) { 
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