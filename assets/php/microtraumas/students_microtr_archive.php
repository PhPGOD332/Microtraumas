<?php
    session_start();
    require_once('../connect/logic.php');

    $_SESSION['tab-microtr'] = 'students';
    $type = $_GET['type'];

    if($type == 'archive') {
        $count = count($microtraumas_student_archive_line);

        if($count > 0) {
            foreach($microtraumas_student_archive_line as $line) {
?>
                <div class="row-microtr">
                    <a href="/pages/admin/microtraumas_detailed/index.php?id_microtr=<?=$line['id_microtr']; ?>" class="table-row archive-row">
                        <div class="body-item FIO-body">
                            <span><?=$line['FIO']; ?></span>
                        </div>
                        <div class="body-item group-body">
                            <span><?=$line['title_group']; ?></span>
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
        } else {
            echo '<span class="error">Данные микротравмы не найдены</span>';
        }
    }
?>