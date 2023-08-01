<?php
    session_start();
    require_once('../connect/logic.php');
?>
    <div class="title-block">
        <span>Группы</span>
    </div>
    <div class="search-block">
        <input type="text" class="search-input" id="search-groups" placeholder="Поиск">
    </div>
    <div class="group-content scroll-block" id="group-content">
        <!-- <button class="btn group-btn" idGroup="" archive="1" style="margin-bottom: 10px;">Архив</button> -->
<?php
    foreach($groups_line as $line) {
?>  
        <button class="btn group-btn" idGroup="<?=$line['id_group']; ?>" archive=""><?=$line['title_group']; ?></button>
<?php
    }
?>
    </div>