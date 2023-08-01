<?php
    session_start();
    require_once('../connect/logic.php');

    $idStaff = $_POST['idStaff'];

    $sql = 'SELECT * FROM `staff` WHERE `id_staff` = ?';
    $res = $pdo -> prepare($sql);
    $res -> execute(array($idStaff));
    $staff_line = $res -> fetch();
?>
    <div class="profile-block" id="staff-preview">
    <style>
            #preview-inner {
                font-family: 'Roboto', sans-serif;
                display: -ms-grid;
                display: grid;
                -ms-grid-columns: 300px 1fr;
                grid-template-columns: 300px 1fr;
            }

            #preview-inner .img-block {
                margin-right: 10px;
            }

            #preview-inner img {
                border-radius: 10px;
                max-width: 100%;
            }

            #preview-inner fieldset {
                border-radius: 10px;
                padding: 20px 10px;
            }

            #preview-inner fieldset legend {
                font-size: 18px;
            }

            #preview-inner fieldset span {
                font-size: 15px;
            }
        </style>
        <div class="preview-inner" id="preview-inner">
            <div class="img-block">
                <img src="<?=$staff_line['img']; ?>" alt="">
            </div>
            <div class="data-block">
                <div class="fio-block">
                    <fieldset>
                        <legend>ФИО:</legend>
                        <span><?=$staff_line['FIO']; ?></span>
                    </fieldset>
                </div>
                <div class="group-block">
                    <fieldset>
                        <legend>Должность:</legend>
                        <span><?=$staff_line['post']; ?></span>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    <div class="btn-block">
        <button class="btn" id="preview-download">Печать</button>
        <button class="btn" id="preview-close">Закрыть</button>
    </div>