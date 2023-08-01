<?php
    session_start();
    require_once('../connect/logic.php');
    $action = $_GET['action'];

    if($action == 'searchStudents') {
        $idGroup = $_GET['idGroup'];
        $archive = $_GET['archive'];
        $search = $_GET['search'];

        $sql = "SELECT * FROM `students`";
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

        if($idGroup) {
            if($filter != '') {
                $filter .= ' AND `id_group` = ?';
            } else {
                $filter .= ' `id_group` = ?';
            }
            array_push($array, $idGroup);
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
            $sql .= ' ORDER BY `FIO` ASC';
            $res = $pdo -> prepare($sql);
            $res -> execute($array);
            $students_line = $res -> fetchAll();
        }
    
        $countStudents = count($students_line);
    
        if($countStudents > 0) {
            foreach($students_line as $line) {
                if($line['archive'] == 0) {
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
                } else {
?>
                    <div class="student-row">
                        <a href="/pages/admin/student_detailed/index.php?idStudent=<?=$line['id_student']; ?>" class="row-table archive-row">
                        <input type="hidden" id="id-student" value="<?=$line['id_student']; ?>">
                            <div class="body-item body-fio">
                                <span><?=$line['FIO']; ?></span>
                            </div>
                        </a>
                        <button class="del-btn archive-btn" id="del-student">
                            <i class="fa fa-close"></i>
                        </button>
                    </div>
<?php
                }
            }
        } else {
            echo '<span class="error">Студентов с таким ФИО в данной группе не найдено</span>';
        }
    } else if($action == 'searchGroups') {
        $search = $_GET['search'];

        $sql = 'SELECT * FROM `groups` WHERE `title_group` LIKE ? ORDER BY `title_group` ASC';
        $res = $pdo -> prepare($sql);
        $res -> execute(array("%$search%"));
        $groups_line = $res -> fetchAll();

        $countGroups = count($groups_line);
?>
        <!-- <button class="btn group-btn" idGroup="" archive="1" style="margin-bottom: 10px;">Архив</button> -->
<?php
        if($countGroups > 0) {
            foreach($groups_line as $line) {
?>  
                <button class="btn group-btn" idGroup="<?=$line['id_group']; ?>" archive=""><?=$line['title_group']; ?></button>
<?php
            }
        } else {
            echo '<span class="error">таких групп нет</span>';
        }
    }
?>