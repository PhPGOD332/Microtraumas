<?php
    session_start();
    require_once('../connect/logic.php');

    $user = $_POST['user'];
    $idMicrotr = $_POST['idMicrotr'];

    $sql = "SELECT * FROM `microtraumas` WHERE `id_microtr` = ?";
    $res = $pdo -> prepare($sql);
    $res -> execute(array($idMicrotr));
    $microtr_line = $res -> fetch();

    if($microtr_line['id_reason'] == 0) {
        $reason_value = $microtr_line['custom_reason'];
    } else {
        $sqlReason = "SELECT * FROM `reasons` WHERE `id_reason` = ?";
        $resReason = $pdo -> prepare($sqlReason);
        $resReason -> execute(array($microtr_line['id_reason']));
        $line_reason = $resReason -> fetch();

        $reason_value = $line_reason['reason_title'];
    }

    if($microtr_line['id_type_secondary'] == 0) {
        $type_value = $microtr_line['custom_type'];
    } else {
        $sqlType = "SELECT * FROM `types_secondary` INNER JOIN `types_main` ON `types_secondary`.`id_type_main` = `types_main`.`id_type_main` WHERE `id_type_secondary` = ?";
        $resType = $pdo -> prepare($sqlType);
        $resType -> execute(array($microtr_line['id_type_secondary']));
        $line_type = $resType -> fetch();

        $type_value = $line_type['type_main_title'].$line_type['type_secondary_title'];
    }
?>
    <div class="preview" id="preview">
<?php

    if($user == 'id_student') {
        $sql = "SELECT * FROM `microtraumas` INNER JOIN `students` ON `microtraumas`.`id_student` = `students`.`id_student` WHERE `id_microtr` = ?";
        $res = $pdo -> prepare($sql);
        $res -> execute(array($idMicrotr));
        $microtr_line = $res -> fetch();

        if($microtr_line['id_group'] != 0) {
            $sql = "SELECT * FROM `microtraumas` INNER JOIN `students` ON `microtraumas`.`id_student` = `students`.`id_student` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group` INNER JOIN `specializations` ON `groups`.`id_specialization` = `specializations`.`id_specialization` WHERE `id_microtr` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($idMicrotr));
            $microtr_line = $res -> fetch();
        } 

?>
        <div class="preview-title-block">
            <div class="title-block">
                <span>Предпросмотр справки</span>
            </div>
        </div>
        <div class="preload-view" id="capture">
            <style>
                .preview-inner {
                    background-color: #fff;
                    font-family: 'Times New Roman', sans-serif;
                    padding: 20px 30px 30px 50px;
                    font-size: 20px;
                    font-weight: 500;
                }

                .preview-inner .title-block {
                    text-align: center;
                    font-weight: 600;
                }

                .preview-inner .text-block {
                    position: relative;
                    margin-bottom: 10px;
                }

                .preview-inner .text-block p {
                    text-align: justify;
                }

                .preview-inner .signature p {
                    margin-bottom: -8px;
                }

                .preview-inner .signature .sub-text {
                    display: inline-block;
                    /* position: absolute; */
                    margin-top: 10px;
                    font-size: 13px;
                    width: 100%;
                    text-align: center;
                }
            </style>
            <div class="preview-inner" >
                <div class="title-block">
                    <p>Справка о рассмотрении причин и обстоятельств,  приведших к возникновению микроповреждения (микротравмы) обучающегося</p>
                </div>
                <div class="text-block">
                <?php
                    if($microtr_line['id_group'] == 0) {
                ?>
                        <p>Пострадавший обучающийся _____<u><?=$microtr_line['FIO'].', '.date('Y', strtotime($microtr_line['date_birth'])).' года рождения'?></u>______________________________</p>
                <?php
                    }    
                ?>
                    <p>Пострадавший обучающийся _____<u><?=$microtr_line['FIO'].', '.date('Y', strtotime($microtr_line['date_birth'])).' года рождения, группа - '.$microtr_line['title_group'].', специальность обучения - '.$microtr_line['title_specialization'].', курс обучения - '.$microtr_line['course'];?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Место получения обучающимся микроповреждения (микротравмы): _____<u><?=$microtr_line['place_microtr'];?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Дата, время получения обучающимся микроповреждения (микротравмы): _____<u><?=date('d.m.Y H:i', strtotime($microtr_line['date_microtr']));?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Действия по оказанию первой помощи: _____<u><?=$microtr_line['first_aid'];?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Дата, время обращения за оказанием медицинской помощи (если пострадавший обучающийся обращался за медицинской помощью): _____<u><?=date('d.m.Y H:i', strtotime($microtr_line['date_of_application']));?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Наименование медучреждения, где оказывалась медицинская помощь: _____<u><?=$microtr_line['title_medicial'];?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Установнление повреждения здоровья: _____<u><?=$microtr_line['trauma'];?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Освобождение от учебы: _____<u><?=$microtr_line['duration_release'];?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Обстоятельства: _____<u><?=$microtr_line['circumstances'];?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Причины, приведшие к микроповреждению (микротравме): _____<u><?=$reason_value;?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Тип микроповреждения (микротравмы): _____<u><?=$type_value;?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Предложения по устранению причин, приведших к микроповреждению (микротравме): _____<u><?=$microtr_line['suggestions'];?></u>______________________________</p>
                </div>
                <div class="text-block signature">
                    <p>Подпись: _____________________________________________________</p>
                    <span class="sub-text">(Фамилия, инициалы, должность, дата)</span>
                </div>
            </div>
        </div>
<?php
    } else if($user == 'id_staff') {
        $sql = "SELECT * FROM `microtraumas` INNER JOIN `staff` ON `microtraumas`.`id_staff` = `staff`.`id_staff` WHERE `id_microtr` = ?";
        $res = $pdo -> prepare($sql);
        $res -> execute(array($idMicrotr));
        $microtr_line = $res -> fetch();

?>
        <div class="preview-title-block">
            <div class="title-block">
                <span>Предпросмотр справки</span>
            </div>
        </div>
        <div class="preload-view" id="capture">
            <style>
                .preview-inner {
                    background-color: #fff;
                    font-family: 'Times New Roman', sans-serif;
                    padding: 20px 30px 30px 50px;
                    font-size: 20px;
                    font-weight: 500;
                }

                .preview-inner .title-block {
                    text-align: center;
                    font-weight: 600;
                }

                .preview-inner .text-block {
                    position: relative;
                    margin-bottom: 10px;
                }

                .preview-inner .text-block p {
                    text-align: justify;
                }

                .preview-inner .signature p {
                    margin-bottom: -8px;
                }

                .preview-inner .signature .sub-text {
                    display: inline-block;
                    /* position: absolute; */
                    margin-top: 10px;
                    font-size: 13px;
                    width: 100%;
                    text-align: center;
                }
            </style>
            <div class="preview-inner">
                <div class="title-block">
                    <p>Справка о рассмотрении причин и обстоятельств,  приведших к возникновению микроповреждения (микротравмы) работника</p>
                </div>
                <div class="text-block">
                    <p>Пострадавший работник _____<u><?=$microtr_line['FIO'].', '.date('Y', strtotime($microtr_line['date_birth'])).' года рождения, '.$microtr_line['post'].', '.$microtr_line['division'].', стаж работы: '.$microtr_line['experience'];?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Место получения работником микроповреждения (микротравмы): _____<u><?=$microtr_line['place_microtr'];?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Дата, время получения работником микроповреждения (микротравмы): _____<u><?=date('d.m.Y H:i', strtotime($microtr_line['date_microtr']));?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Действия по оказанию первой помощи: _____<u><?=$microtr_line['first_aid'];?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Дата, время обращения за оказанием медицинской помощи (если пострадавший работник обращался за медицинской помощью): _____<u><?=date('d.m.Y H:i', strtotime($microtr_line['date_of_application']));?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Наименование медучреждения, где оказывалась медицинская помощь: _____<u><?=$microtr_line['title_medicial'];?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Установнление повреждения здоровья: _____<u><?=$microtr_line['trauma'];?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Освобождение от работы: _____<u><?=$microtr_line['duration_release'];?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Обстоятельства: _____<u><?=$microtr_line['circumstances'];?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Причины, приведшие к микроповреждению (микротравме): _____<u><?=$reason_value;?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Тип микроповреждения (микротравмы): _____<u><?=$type_value;?></u>______________________________</p>
                </div>
                <div class="text-block">
                    <p>Предложения по устранению причин, приведших к микроповреждению (микротравме): _____<u><?=$microtr_line['suggestions'];?></u>______________________________</p>
                </div>
                <div class="text-block signature">
                    <p>Подпись: _____________________________________________________</p>
                    <span class="sub-text">(Фамилия, инициалы, должность, дата)</span>
                </div>
            </div>
        </div>
<?php
    }
?>   
        <div class="btn-block">
            <button class="btn load-btn" id="download-doc">Скачать</button>
            <button class="btn load-btn" id="close-preload">Свернуть</button>
        </div>             
    </div>