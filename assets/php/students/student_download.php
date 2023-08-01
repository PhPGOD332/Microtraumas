<?php
    session_start();
    require_once('../connect/logic.php');

    $idStudent = $_POST['idStudent'];

    $sql = 'SELECT * FROM `students` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group` WHERE `id_student` = ?';
    $res = $pdo -> prepare($sql);
    $res -> execute(array($idStudent));
    $student_line = $res -> fetch();
?>
    <div class="profile-block" id="student-preview">
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
                <img src="<?=$student_line['img']; ?>" alt="">
            </div>
            <div class="data-block">
                <div class="fio-block">
                    <fieldset>
                        <legend>ФИО:</legend>
                        <span><?=$student_line['FIO']; ?></span>
                    </fieldset>
                </div>
                <div class="group-block">
                    <fieldset>
                        <legend>Группа:</legend>
                        <span><?=$student_line['title_group']; ?></span>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    <div class="btn-block">
        <button class="btn" id="preview-download">Печать</button>
        <button class="btn" id="preview-close">Закрыть</button>
    </div>