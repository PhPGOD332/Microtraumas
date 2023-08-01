<?php
    session_start();
    require_once('../connect/logic.php');

    $search = $_GET['search'];
    $group = $_GET['group'];
    $date = $_GET['date'];
    $action = $_GET['action'];

    if($action == 'students') {
        if($date) {
            $date = date('Y-m-d', strtotime($date));
        } 
        $status = $_GET['status'];
    
        $sql = 'SELECT * FROM `microtraumas` INNER JOIN `students` ON `microtraumas`.`id_student` = `students`.`id_student` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group`';
        $query_cond = '`status` = "Завершено"';

        if($search) {
            if($query_cond != '') {
                $query_cond .= " AND `FIO` LIKE '%$search%'";
            }
            else {
                $query_cond .= " `FIO` LIKE '%$search%'";
            }
        }
    
        if($group) {
            if($query_cond != '') {
                $query_cond .= " AND `title_group` LIKE '%$group%'";
            } else {
                $query_cond .= " `title_group` LIKE '%$group%'";
            }
        }
    
        if($date) {
            if($query_cond != '') {
                $query_cond .= " AND DATE(`date_microtr`) = '$date'";
            } else {
                $query_cond .= " DATE(`date_microtr`) = '$date'";
            }
        }

        if(!empty($query_cond)){
            $query_cond = " WHERE ".$query_cond;
    
            $sql= $sql.$query_cond;
            $sthqrow2 = $sthqrow2.$query_cond;
    
        }
    
        $res = $pdo->prepare("$sql"." ORDER BY `date_microtr` DESC");
        $res->execute();
        $items = $res->fetchAll(PDO::FETCH_ASSOC);
        $count = count($items);
    
        if($count > 0) {
            foreach($items as $line) {
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
            echo "<span class='error'>Результатов, соответствующих запросу не найдено</span>";
        }
    } else if($action == 'staff') {
        if($date) {
            $date = date('Y-m-d', strtotime($date));
        } 
        $status = $_GET['status'];
    
        $sql = 'SELECT * FROM `microtraumas` INNER JOIN `staff` ON `microtraumas`.`id_staff` = `staff`.`id_staff`';
        $query_cond = '`status` = "Завершено"';

        if($search) {
            if($query_cond != '') {
                $query_cond .= " AND `FIO` LIKE '%$search%'";
            }
            else {
                $query_cond .= " `FIO` LIKE '%$search%'";
            }
        }
    
        if($date) {
            if($query_cond != '') {
                $query_cond .= " AND DATE(`date_microtr`) = '$date'";
            } else {
                $query_cond .= " DATE(`date_microtr`) = '$date'";
            }
        }

        if(!empty($query_cond)){
            $query_cond = " WHERE ".$query_cond;
    
            $sql= $sql.$query_cond;
            $sthqrow2 = $sthqrow2.$query_cond;
    
        }
    
        $res = $pdo->prepare("$sql"." ORDER BY `date_microtr` DESC");
        $res->execute();
        $items = $res->fetchAll(PDO::FETCH_ASSOC);
        $count = count($items);

        if($count > 0) {
            foreach($items as $line) {
?>
                <div class="row-microtr">
                    <a href="/pages/admin/microtraumas_detailed/index.php?id_microtr=<?=$line['id_microtr']; ?>" class="table-row archive-row">
                        <div class="body-item FIO-body">
                            <span><?=$line['FIO']; ?></span>
                        </div>
                        <div class="body-item group-body">
                            <span><?=$line['post']; ?></span>
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
            echo "<span class='error'>Результатов, соответствующих запросу не найдено</span>";
        }
    }
?>