<?php
    require_once('../connect/logic.php');

    foreach($groups_line as $line) {
    ?>
        <div class="group-block">
            <a href="/pages/admin/group_detailed/index.php?idGroup=<?=$line['id_group']; ?>" id="<?=$line['id_group']; ?>" class="btn group-btn archive-row row-table">
                <input type="hidden" class="id-group" id="id-group" value="<?=$line['id_group']; ?>">
                <span><?=$line['title_group']; ?></span>
            </a>
            <button class="del-btn" id="del-group">
                <i class="fa fa-close"></i>
            </button>
        </div>
    <?php
    }
?>