<?php
    require_once('../connect/logic.php');
    $search = $_GET['search'];

    $sql = "SELECT * FROM `groups` WHERE `title_group` LIKE ? ORDER BY `title_group` ASC";
    $res = $pdo -> prepare($sql);
    $res -> execute(array("%$search%"));
    $groups_line = $res -> fetchAll();

    $countLines = count($groups_line);

    if($countLines > 0) {
        foreach($groups_line as $line) {
?>
        <div class="group-block">
            <a href="/pages/admin/group_detailed/index.php?idGroup=<?=$line['id_group']; ?>" id="<?=$line['id_group']; ?>" class="btn group-btn archive-row">
                <input type="hidden" class="id-group" value="<?=$line['id_group']; ?>">
                <span><?=$line['title_group']; ?></span>
            </a>
            <button class="del-btn" id="del-group">
                <i class="fa fa-close"></i>
            </button>
        </div>
<?php
}
    } else {
        echo '<span class="error">Групп с таким названием не найдено</span>';
    }
?>