<?php
    session_start();
    require_once('../connect/logic.php');
    $idGroup = $_GET['idGroup'];
    $archive = $_GET['archive'];
    $_SESSION['idGroup'] = $idGroup;
    $_SESSION['archiveStudents'] = $archive;

        $sql = "SELECT * FROM `students` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group` WHERE `students`.`id_group` = ? AND `students`.`archive` = ? ORDER BY `FIO` ASC";
        $res = $pdo -> prepare($sql);
        $res -> execute(array($idGroup, $archive));
        $students_line = $res -> fetchAll();

        $countLines = count($students_line);
    
        // $sql = 'SELECT * FROM `students` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group` WHERE `students`.`id_group` = ? AND `students`.`archive` = ? ORDER BY `FIO` ASC';
        // $res = $pdo -> prepare($sql);
        // $res -> execute(array($idGroup, $archive));
        // $students_line = $res -> fetchAll();

        // $countLines = count($students_line);

        $sql2 = 'SELECT * FROM `groups` WHERE `id_group` = ?';
        $res2 = $pdo -> prepare($sql2);
        $res2 -> execute(array($idGroup));
        $lineGroup = $res2 -> fetch();

    if($countLines > 0) {
?>
        <div class="title-search-block">
            <div class="title-block">
                <span><?=$idGroup == 0 ? 'Студенты в архиве' : 'Студенты в группе '.$lineGroup['title_group']; ?></span>
            </div>
            <div class="search-block">
                <input type="text" class="search-input" id="search-students" idGroup="<?=$idGroup; ?>" archive="<?=$archive; ?>" placeholder="Поиск по ФИО">
                <button class="search-btn">
                    <i class="fa fa-solid fa-search"></i>
                </button>
            </div>
        </div>
        <div class="table-block table-students">
            <!-- <div class="table-head">
                <button class="head-item head-id">
                    <span>ID</span>
                    <i class="fa fa-solid fa-caret-up"></i>
                </button>
                <button class="head-item head-fio">
                    <span>ФИО</span>
                    <i class="fa fa-solid fa-caret-up"></i>
                </button>
            </div> -->
            <div class="table-body scroll-block" id="students-table-body">
<?php
        foreach($students_line as $line) {
            if($archive == 1) {
?>
            <div class="student-row">
                <a href="/pages/admin/student_detailed/index.php?idStudent=<?=$line['id_student']; ?>" class="row-table archive-row archive">
                    <input type="hidden" id="id-student" value="<?=$line['id_student']; ?>">
                    <div class="body-item body-fio">
                        <span><?=$line['FIO']; ?></span>
                    </div>
                </a>
                <button class="del-btn del-btn" id="del-student">
                    <i class="fa fa-close"></i>
                </button>
            </div>
<?php
            } else {
?>
            <div class="student-row">
                <a href="/pages/admin/student_detailed/index.php?idStudent=<?=$line['id_student']; ?>" class="row-table archive-row">
                    <input type="hidden" id="id-student" value="<?=$line['id_student']; ?>">
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
        }
?>
            </div>
        </div>
<?php
    } else if($countLines == 0 && $archive == 0) {
        echo '<span class="error">В группе '.$lineGroup['title_group'].' студентов не найдено</span>';
    } else if($countLines == 0 && $archive == 1) {
        echo '<span class="error">В группе '.$lineGroup['title_group'].' (архив) студентов не найдено</span>';
    }
?>

    