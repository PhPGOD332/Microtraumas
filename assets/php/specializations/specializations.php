<?php
    require_once('../connect/logic.php');

    $count = count($specializations_line);

    if($count > 0) {
        foreach($specializations_line as $spec) {
?>
            <div class="student-row">
                <button class="row-table row-btn-table spec-btn archive-row" id="<?=$spec['id_specialization']; ?>">
                    <input type="hidden" class="id-spec" id="id-spec" value="<?=$spec['id_specialization']; ?>">
                    <div class="body-item body-fio">
                        <span><?=$spec['title_specialization']; ?></span>
                    </div>
                </button>
                <button class="del-btn" id="del-spec">
                    <i class="fa fa-close"></i>
                </button>
            </div>
<?php
        }
    } else {
        echo '<span class="error">Специальностей не найдено</span>';
    }
?>