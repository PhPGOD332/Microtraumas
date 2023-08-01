<?php
    require_once('../connect/logic.php');

    $idJournal = $_GET['idJournal'];

    $sql = "SELECT * FROM `microtraumas` WHERE `id_journal` = ?";
    $res = $pdo -> prepare($sql);
    $res -> execute(array($idJournal));
    $microtr_lines = $res -> fetchAll();

    $count = count($microtr_lines);

    foreach($microtr_lines as $microtr) {
        if($microtr['id_staff'] == '0') {
            $sqlStudent = "SELECT * FROM `students` WHERE `id_student` = ?";
            $resStudent = $pdo -> prepare($sqlStudent);
            $resStudent -> execute(array($microtr['id_student']));
            $student_line = $resStudent -> fetch();
    
            $sqlGroup = "SELECT * FROM `groups` WHERE `id_group` = ?";
            $resGroup = $pdo -> prepare($sqlGroup);
            $resGroup -> execute(array($microtr['id_group']));
            $group_line = $resGroup -> fetch();
?>
            <a href="/pages/admin/microtraumas_detailed/index.php?id_microtr=<?=$microtr['id_microtr']; ?>" class="row-table archive-row">
                <input type="hidden" value="<?=$microtr['id_microtr']; ?>">
                <div class="body-item body-title">
                    <span><?=$student_line['FIO']; ?></span>
                </div>
                <div class="body-item body-center">
                    <span><?=$group_line['title_group']; ?></span>
                </div>
                <div class="body-item body-center">
                    <span><?=date('d.m.Y', strtotime($microtr['date_microtr'])); ?></span>
                </div>
            </a>
<?php
        } else {
            $sqlStaff = "SELECT * FROM `staff` WHERE `id_staff` = ?";
            $resStaff = $pdo -> prepare($sqlStaff);
            $resStaff -> execute(array($microtr['id_staff']));
            $staff_line = $resStaff -> fetch();
?>
            <a href="/pages/admin/microtraumas_detailed/index.php?id_microtr=<?=$microtr['id_microtr']; ?>" class="row-table archive-row" style="grid-template-columns: 1fr 1fr;">
                <input type="hidden" value="<?=$microtr['id_microtr']; ?>">
                <div class="body-item body-title">
                    <span><?=$staff_line['FIO']; ?></span>
                </div>
                <div class="body-item body-center">
                    <span><?=date('d.m.Y', strtotime($microtr['date_microtr'])); ?></span>
                </div>
            </a>
<?php
        }
    }

    if($count <= 0) {
        echo '<span class="error">Микротравм в данном журнале нет</span>';
    }
?>