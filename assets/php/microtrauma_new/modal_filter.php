<?php
    session_start();
    require_once('../connect/logic.php');

    $search = $_POST['search'];
    $action = $_POST['action'];
?>
    <fieldset class="table-last-microtr scroll-block">
        <legend>Результаты поиска</legend>
        <div class="" id="">
<?php
    if($action == 'students') {
        $sql = "SELECT * FROM `students` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group` WHERE `FIO` LIKE ? ORDER BY `FIO` ASC";
        $res = $pdo -> prepare($sql);
        $res -> execute(array("%$search%"));
        $students_groups_line = $res -> fetchAll();
        $count = count($students_groups_line);

        if($count > 0) {
            foreach($students_groups_line as $line) {
?>
                <button class="row-table archive-row" id="<?=$line['id_student']?>" typeUser="student">
                    <div class="body-item body-fio">
                        <span><?=$line['FIO']; ?></span>
                    </div>
                    <div class="body-item body-fio">
                        <span><?=$line['title_group']; ?></span>
                    </div>
                </button>
<?php
            }
        } else {
            echo '<span class="error">Результатов не найдено</span>';
        }
    } else if($action == 'staff') {
        $sql = "SELECT * FROM `staff` WHERE `id_staff` LIKE ? ORDER BY `FIO` ASC";
        $res = $pdo -> prepare($sql);
        $res -> execute(array("%$search%"));
        $staff_line = $res -> fetchAll();
        $count = count($staff_line);

        if($count > 0) {
            foreach($staff_line as $line) {
?>
                <button class="row-table archive-row" id="<?=$line['id_staff']?>" typeUser="staff">
                    <div class="body-item body-fio">
                        <span><?=$line['FIO']; ?></span>
                    </div>
                </button>
<?php
            }
        } else {
            echo '<span class="error">Результатов не найдено</span>';
        }
    }
?>
        </div>
    </fieldset>