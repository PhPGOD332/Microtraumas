<?php
    require_once('../connect/logic.php');

    $idSpec = $_GET['idSpec'];

    $sql = "SELECT * FROM `specializations` WHERE `id_specialization` = ?";
    $res = $pdo -> prepare($sql);
    $res -> execute(array($idSpec));
    $spec_line = $res -> fetch();
?>

<div class="parameters-block">
    <div class="parameter-row">
        <label for="spec-title-input">Название</label>
        <textarea type="text" rows="4" id="spec-title-input" placeholder="Название специальности"><?=$spec_line['title_specialization']; ?></textarea>
    </div>
</div>
<div class="btn-block">
    <button class="btn" id="spec-save">Сохранить</button>
</div>