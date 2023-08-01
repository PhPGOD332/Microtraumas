<?php
    session_start();
    require_once('../connect/logic.php');

    $search = $_GET['search'];
    $archive = $_GET['archive'];

    $sql = "SELECT * FROM `staff`";
    $filter = '';
    $where = " WHERE";
    $array = array();

    if($search) {
        if($filter != '') {
            $filter .= ' AND `FIO` LIKE ?';
        } else {
            $filter .= ' `FIO` LIKE ?';
        }
        array_push($array, "%$search%");
    }

    if($status == null) {
        $status = '';
    }

    if($archive != null) {
        if($filter != '') {
            $filter .= ' AND `archive` = ?';
        } else {
            $filter .= ' `archive` = ?';
        }
        array_push($array, $archive);
    }

    if($date) {
        $date = date('Y-m-d', strtotime($date));
    } 

    if($filter != '') {
        $sql .= $where;
        $sql .= $filter;
        $sql .= ' ORDER BY `archive` ASC, `FIO` ASC';
        $res = $pdo -> prepare($sql);
        $res -> execute($array);
        $staff_line = $res -> fetchAll();
    }

    $countStaff = count($staff_line);

    if($countStaff > 0) {
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
        echo '<span class="error">Действующих сотрудников с таким ФИО не найдено</span>';
    } else if($countLines == 0 && $archive == 1) {
        echo '<span class="error">Сотрудников в архиве с таким ФИО не найдено</span>';
    }
?>