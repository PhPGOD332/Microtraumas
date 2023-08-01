<?php
    require_once('../connect/logic.php');

    foreach($microtraumas_line as $line) {
        if($line['id_student'] == 0 && $line['id_staff'] != 0) {
            $sqlMen = "SELECT * FROM `staff` WHERE `id_staff` = ?";
            $resMen = $pdo -> prepare($sqlMen);
            $resMen -> execute(array($line['id_staff']));
            $manLine = $resMen -> fetch();

            $difference = 'post';
        }
        if($line['id_staff'] == 0 && $line['id_student'] != 0) {
            $sqlMen = "SELECT * FROM `students` WHERE `id_student` = ?";
            $resMen = $pdo -> prepare($sqlMen);
            $resMen -> execute(array($line['id_student']));
            $manLine = $resMen -> fetch();

            if($manLine['id_group'] != 0) {
                $sqlMen = "SELECT * FROM `students` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group` WHERE `id_student` = ?";
                $resMen = $pdo -> prepare($sqlMen);
                $resMen -> execute(array($line['id_student']));
                $manLine = $resMen -> fetch();
            }

            $difference = 'title_group';
        }
        
?>
        <a href="/pages/admin/microtraumas_detailed/index.php?id_microtr=<?=$line['id_microtr']; ?>" class="row-table last-row">
            <div class="body-item FIO-body">
                <span><?=$manLine['FIO']; ?></span>
            </div>
            <div class="body-item difference-body">
                <span><?=$manLine["$difference"] == '' ? 'Архив': $manLine["$difference"]; ?></span>
            </div>
            <div class="body-item date-body">
                <span><?=date('d.m.Y H:i', strtotime($line['date_microtr'])); ?></span>
            </div>
        </a>
<?php
    }

    foreach($microtraumas_archive_line as $line) {
        if($line['id_student'] == 0 && $line['id_staff'] != 0) {
            $sqlMen = "SELECT * FROM `staff` WHERE `id_staff` = ?";
            $resMen = $pdo -> prepare($sqlMen);
            $resMen -> execute(array($line['id_staff']));
            $manLine = $resMen -> fetch();

            $difference = 'post';
        }
        if($line['id_staff'] == 0 && $line['id_student'] != 0) {
            $sqlMen = "SELECT * FROM `students` WHERE `id_student` = ?";
            $resMen = $pdo -> prepare($sqlMen);
            $resMen -> execute(array($line['id_student']));
            $manLine = $resMen -> fetch();

            if($manLine['id_group'] != 0) {
                $sqlMen = "SELECT * FROM `students` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group` WHERE `id_student` = ?";
                $resMen = $pdo -> prepare($sqlMen);
                $resMen -> execute(array($line['id_student']));
                $manLine = $resMen -> fetch();
            }

            $difference = 'title_group';
        }
        
?>
        <a href="/pages/admin/microtraumas_detailed/index.php?id_microtr=<?=$line['id_microtr']; ?>" class="row-table archive-row">
            <div class="body-item FIO-body">
                <span><?=$manLine['FIO']; ?></span>
            </div>
            <div class="body-item difference-body">
                <span><?=$manLine["$difference"] == '' ? 'Архив': $manLine["$difference"]; ?></span>
            </div>
            <div class="body-item date-body">
                <span><?=date('d.m.Y H:i', strtotime($line['date_microtr'])); ?></span>
            </div>
        </a>
<?php
    }
?>
