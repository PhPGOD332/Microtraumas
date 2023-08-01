<?php
    session_start();
    require_once('../connect/logic.php');
    $idGroup = $_GET['idGroup'];

    $sql = 'SELECT * FROM `students` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group` WHERE `students`.`id_group` = ? AND `students`.`archive` = 0 ORDER BY `FIO` ASC';
    $res = $pdo -> prepare($sql);
    $res -> execute(array($idGroup));
    $students_line = $res -> fetchAll();

    $countLines = count($students_line);

    $sql2 = 'SELECT * FROM `groups` WHERE `id_group` = ?';
    $res2 = $pdo -> prepare($sql2);
    $res2 -> execute(array($idGroup));
    $lineGroup = $res2 -> fetch();

    if($countLines > 0) {
        foreach($students_line as $line) {
?>
            <div class="student-row">
                <a href="/pages/admin/student_detailed/index.php?idStudent=<?=$line['id_student']; ?>" class="row-table archive-row" id="<?=$line['id_student']; ?>">
                    <input type="hidden" class="id-student" id="id-student" value="<?=$line['id_student']; ?>">
                    <div class="body-item body-fio">
                        <span><?=$line['FIO']; ?></span>
                    </div>
                </a>
                <button class="del-btn archive-btn" id="archivation-student">
                    <i class="fa fa-folder-open"></i>
                </button>
            </div>
<?php
        }
    } else {
        echo '<span class="error">В данной группе студентов не найдено</span>';
    }
?>

    