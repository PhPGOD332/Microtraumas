<?php
    session_start();
    require_once('../connect/logic.php');

    $archive = $_GET['archive'];
    $_SESSION['archiveStaff'] = $archive;

    $sql = 'SELECT * FROM `staff` WHERE `archive` = ? ORDER BY `archive` ASC, `FIO` ASC';
    $res = $pdo -> prepare($sql);
    $res -> execute(array($archive));
    $staff_line = $res -> fetchAll();

    $countLines = count($staff_line);

    if($countLines > 0) {
?>
        
        
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
            
<?php
        foreach($staff_line as $line) {
            if($line['archive'] == 0) {
?>
                <div class="student-row">
                    <a href="/pages/admin/staff_detailed/index.php?idStaff=<?=$line['id_staff']; ?>" class="row-table archive-row">
                        <input type="hidden" id="id-staff" value="<?=$line['id_staff']; ?>">
                        <div class="body-item body-fio">
                            <span><?=$line['FIO']; ?></span>
                        </div>
                        <div class="body-item body-fio">
                            <span><?=$line['post']; ?></span>
                        </div>
                    </a>
                    <button class="del-btn archive-btn" id="archivation-staff">
                        <i class="fa fa-folder-open"></i>
                    </button>
                </div>
<?php
            } else {
?>
                <div class="student-row">
                    <a href="/pages/admin/staff_detailed/index.php?idStaff=<?=$line['id_staff']; ?>" class="row-table archive-row">
                        <input type="hidden" id="id-staff" value="<?=$line['id_staff']; ?>">
                        <div class="body-item body-fio">
                            <span><?=$line['FIO']; ?></span>
                        </div>
                        <div class="body-item body-fio">
                            <span><?=$line['post']; ?></span>
                        </div>
                    </a>
                    <button class="del-btn" id="del-staff">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
<?php
            }
        }
    } else if($countLines == 0 && $archive == 0) {
        echo '<span class="error">Действующих сотрудников не найдено</span>';
    } else if($countLines == 0 && $archive == 1) {
        echo '<span class="error">Сотрудников в архиве не найдено</span>';
    }
?>

    