<?php
    session_start();
    require_once('../connect/logic.php');

    $id_microtr = $_GET['id_microtr'];

    $sqlMicrotrauma = "SELECT * FROM `microtraumas` WHERE `id_microtr` = ?";
    $microtrResult = $pdo -> prepare($sqlMicrotrauma);
    $microtrResult -> execute(array($id_microtr));
    $lineMicortrauma = $microtrResult -> fetch();

    $sqlMicr = "SELECT * FROM `microtraumas` INNER JOIN `reasons` ON `microtraumas`.`id_reason` = `reasons`.`id_reason` INNER JOIN `types_secondary` ON `microtraumas`.`id_type_secondary` = `types_secondary`.`id_type_secondary` WHERE `id_microtr` = ?";
    $result = $pdo -> prepare($sqlMicr);
    $result -> execute(array($id_microtr));
    $lineMicrotr = $result -> fetch();

    if($lineMicortrauma['id_student'] != 0 && $lineMicortrauma['id_staff'] == 0) {
        $sqlMicr = "SELECT * FROM `microtraumas` INNER JOIN `students` ON `microtraumas`.`id_student` = `students`.`id_student` WHERE `id_microtr` = ?";
        $result = $pdo -> prepare($sqlMicr);
        $result -> execute(array($id_microtr));
        $lineMicrotr = $result -> fetch();

        if($lineMicrotr['id_reason'] == 0) {
            $reason = $lineMicrotr['custom_reason'];
        } else {
            $sqlReason = "SELECT * FROM `reasons` WHERE `id_reason` = ?";
            $resReason = $pdo -> prepare($sqlReason);
            $resReason -> execute(array($lineMicrotr['id_reason']));
            $line_reason = $resReason -> fetch();

            $reason = $line_reason['reason_title'];
        }
?>
            <div class="form-block" idMicrotr="<?=$id_microtr; ?>">
                <label for="">
                    <span>Пострадавший обучающийся</span> 
                    <div class="name-block">
                        <input type="text" id="fio-microtr" value="<?=$lineMicrotr['FIO']; ?>" disabled>
                        <a class="btn name-btn" href="/pages/admin/student_detailed/index.php?idStudent=<?=$lineMicrotr['id_student']; ?>">
                            <i class="fa fa-solid fa-user"></i>
                        </a>
                    </div>
                </label>
                <label for="">
                    <span>Место травмы</span>  
                    <input type="text" id="place-microtr" value="<?=$lineMicrotr['place_microtr']; ?>">
                </label>
                <label for="">
                    <span>Дата и время микротравмы</span>
                    <input type="datetime-local" id="date-microtr" value="<?=date('Y-m-d\TH:i:s', strtotime($lineMicrotr['date_microtr'])); ?>">
                </label>
                <label for="">
                    <span>Первая помощь</span>
                    <input type="text" id="first-aid" value="<?=$lineMicrotr['first_aid']; ?>">
                </label>
                <label for="">
                    <span>Дата и время обращения</span>
                    <input type="datetime-local" id="date-app" value="<?=date('Y-m-d\TH:i:s', strtotime($lineMicrotr['date_of_application'])); ?>">
                </label>
                <label for="">
                    <span>Наименование медучреждения</span>
                    <input type="text" id="medicial" value="<?=$lineMicrotr['title_medicial']; ?>">
                </label>
                <label for="">
                    <span>Установление повреждения здоровья</span>
                    <input type="text" id="trauma" value="<?=$lineMicrotr['trauma']; ?>">
                </label>
                <label for="">
                    <span>Освобождение от учебы (кол-во часов или до конца дня)</span>
                    <input type="text" id="release" value="<?=$lineMicrotr['duration_release']; ?>">
                </label>
                <label for="">
                    <span>Обстоятельства</span>
                    <input type="text" id="circumstances" value="<?=$lineMicrotr['circumstances']; ?>">
                </label>
                <label for="">
                    <?php
                        $sqlReasons = "SELECT * FROM `reasons`";
                        $res = $pdo -> query($sqlReasons);
                        $line_reasons = $res -> fetchAll();
                    ?>
                    <span>Причины</span>

                    <?php
                        if($lineMicrotr['id_reason'] == 0) {
                    ?>
                            <select name="" id="reasons-select">
                                <?php foreach($line_reasons as $line): ?>
                                    <option value="<?=$line['id_reason']; ?>"><?=$line['reason_title']; ?></option>
                                <?php endforeach; ?>
                                <option value="0" selected>Другое</option>
                            </select>
                            <input type="text" id="reason" value="<?=$lineMicrotr['custom_reason']; ?>" style="display: block;" placeholder="Напишите свою причину">
                    <?php
                        } else {
                    ?>
                            <select name="" id="reasons-select">
                                <option value="<?=$lineMicrotr['id_reason']; ?>" selected disabled><?=$reason; ?></option>
                                <?php foreach($line_reasons as $line): ?>
                                    <option value="<?=$line['id_reason']; ?>"><?=$line['reason_title']; ?></option>
                                <?php endforeach; ?>
                                <option value="0">Другое</option>
                            </select>
                            <input type="text" id="reason" value="" style="display: none;" placeholder="Напишите свою причину">
                    <?php
                        }
                    ?>
                    
                </label>
                <label for="">
                    <?php
                        $sqlTypes = "SELECT * FROM `types_main`";
                        $res = $pdo -> query($sqlTypes);
                        $line_types = $res -> fetchAll();
                    ?>
                    <span>Виды</span>
                    <?php
                        if($lineMicrotr['id_type_main'] == 0 && $lineMicrotr['id_type_secondary'] == 0) {
                    ?>
                            <select name="" id="types-select">
                                <?php foreach($line_types as $line): ?>
                                    <?php
                                        $sqlSubType = "SELECT * FROM `types_secondary` WHERE `id_type_main` = ?";
                                        $resSubTypes = $pdo -> prepare($sqlSubType);
                                        $resSubTypes -> execute(array($line['id_type_main']));
                                        $linesSubTypes = $resSubTypes -> fetchAll();
                                        $countSubTypes = count($linesSubTypes);
                                    ?>
                                    <?php if($countSubTypes > 0): ?>
                                        <optgroup class="optgroup" id="<?=$line['id_type_main']; ?>" label="<?=$line['type_main_title']; ?>">
                                            <?php foreach($linesSubTypes as $subline): ?>
                                                <option class="sub-option" value="<?=$subline['id_type_secondary']; ?>"><?=$subline['type_secondary_title']; ?></option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php else: ?>
                                        <option value="<?=$line['id_type_main']; ?>"><?=$line['type_main_title']; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <option value="0" selected>Другое</option>
                            </select>
                            <input type="text" id="type" value="<?=$lineMicrotr['custom_type']; ?>" style="display: block;" placeholder="Напишите свой тип">
                    <?php
                        } else if($lineMicrotr['id_type_main'] != 0 && $lineMicrotr['id_type_secondary'] != 0) {
                            $sqlSelectedTypes = "SELECT * FROM `types_main` INNER JOIN `types_secondary` ON `types_main`.`id_type_main` = `types_secondary`.`id_type_main` WHERE `id_type_secondary` = ?";
                            $resSelected = $pdo -> prepare($sqlSelectedTypes);
                            $resSelected -> execute(array($lineMicrotr['id_type_secondary']));
                            $line_selected_types = $resSelected -> fetch();
                    ?>
                            <select name="" id="types-select">
                                <option value="<?=$lineMicrotr['id_type_secondary']; ?>" selected disabled><?=$line_selected_types['type_main_title'].$line_selected_types['type_secondary_title']; ?></option>
                                <?php foreach($line_types as $line): ?>
                                    <?php
                                        $sqlSubType = "SELECT * FROM `types_secondary` WHERE `id_type_main` = ?";
                                        $resSubTypes = $pdo -> prepare($sqlSubType);
                                        $resSubTypes -> execute(array($line['id_type_main']));
                                        $linesSubTypes = $resSubTypes -> fetchAll();
                                        $countSubTypes = count($linesSubTypes);
                                    ?>
                                    <?php if($countSubTypes > 0): ?>
                                        <optgroup class="optgroup" id="<?=$line['id_type_main']; ?>" label="<?=$line['type_main_title']; ?>">
                                            <?php foreach($linesSubTypes as $subline): ?>
                                                <option class="sub-option" value="<?=$subline['id_type_secondary']; ?>"><?=$subline['type_secondary_title']; ?></option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php else: ?>
                                        <option value="<?=$line['id_type_main']; ?>"><?=$line['type_main_title']; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <option value="0">Другое</option>
                            </select>
                            <input type="text" id="type" value="" style="display: none;" placeholder="Напишите свой тип">
                    <?php
                        } else if($lineMicrotr['id_type_main'] != 0 && $lineMicrotr['id_type_secondary'] == 0) {
                            $sqlSelectedTypes = "SELECT * FROM `microtraumas` INNER JOIN `types_main` ON `microtraumas`.`id_type_main` = `types_main`.`id_type_main` WHERE `microtraumas`.`id_type_main` = ?";
                            $resSelected = $pdo -> prepare($sqlSelectedTypes);
                            $resSelected -> execute(array($lineMicrotr['id_type_secondary']));
                            $line_selected_types = $resSelected -> fetch();
                    ?>
                            <select name="" id="types-select">
                                <option value="<?=$lineMicrotr['id_type_secondary']; ?>" selected disabled><?=$line_selected_types['type_main_title']; ?></option>
                                <?php foreach($line_types as $line): ?>
                                    <?php
                                        $sqlSubType = "SELECT * FROM `types_secondary` WHERE `id_type_main` = ?";
                                        $resSubTypes = $pdo -> prepare($sqlSubType);
                                        $resSubTypes -> execute(array($line['id_type_main']));
                                        $linesSubTypes = $resSubTypes -> fetchAll();
                                        $countSubTypes = count($linesSubTypes);
                                    ?>
                                    <?php if($countSubTypes > 0): ?>
                                        <optgroup class="optgroup" id="<?=$line['id_type_main']; ?>" label="<?=$line['type_main_title']; ?>">
                                            <?php foreach($linesSubTypes as $subline): ?>
                                                <option class="sub-option" value="<?=$subline['id_type_secondary']; ?>"><?=$subline['type_secondary_title']; ?></option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php else: ?>
                                        <option value="<?=$line['id_type_main']; ?>"><?=$line['type_main_title']; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <option value="0">Другое</option>
                            </select>
                            <input type="text" id="type" value="" style="display: none;" placeholder="Напишите свой тип">
                    <?php
                        }
                    ?>
                    
                </label>
                <label for="">
                    <span>Предложения по устранению причин</span>
                    <input type="text" id="suggestions" value="<?=$lineMicrotr['suggestions']; ?>">
                </label>
            </div>
            <div class="btn-block">
                <button class="btn preload-btn" user="id_student">Распечатать справку</button>
                <button class="btn save-btn" id="save-btn">Сохранить</button>
                <?php
                    if($lineMicortrauma['status'] == 'В рассмотрении') {
                ?>
                        <button class="btn end-btn" id="end-btn">Отправить в архив</button>
                <?php
                    } else if($lineMicortrauma['status'] == 'Завершено') {
                ?>
                        <button class="btn end-btn" id="return-btn">Вернуть из архива</button>
                <?php
                    }
                ?>
                
            </div>
            <div class="preload-block" id="preview-content">
                
            </div>
<?php

    } else if($lineMicortrauma['id_student'] == 0 && $lineMicortrauma['id_staff'] != 0) {
        $sqlMicr = "SELECT * FROM `microtraumas` INNER JOIN `staff` ON `microtraumas`.`id_staff` = `staff`.`id_staff` WHERE `id_microtr` = ?";
        $result = $pdo -> prepare($sqlMicr);
        $result -> execute(array($id_microtr));
        $lineMicrotr = $result -> fetch();

        if($lineMicrotr['id_reason'] == 0) {
            $reason = $lineMicrotr['custom_reason'];
        } else {
            $sqlReason = "SELECT * FROM `reasons` WHERE `id_reason` = ?";
            $resReason = $pdo -> prepare($sqlReason);
            $resReason -> execute(array($lineMicrotr['id_reason']));
            $line_reason = $resReason -> fetch();

            $reason = $line_reason['reason_title'];
        }
?>
        <div class="form-block" idMicrotr="<?=$id_microtr; ?>">
            <label for="">
                <span>Пострадавший работник</span> 
                <div class="name-block">
                    <input type="text" id="fio-microtr" value="<?=$lineMicrotr['FIO']; ?>" disabled>
                    <a class="btn name-btn" href="/pages/admin/staff_detailed/index.php?idStaff=<?=$lineMicrotr['id_staff']; ?>">
                        <i class="fa fa-solid fa-user"></i>
                    </a>
                </div>
            </label>
            <label for="">
                <span>Место травмы</span>  
                <input type="text" id="place-microtr" value="<?=$lineMicrotr['place_microtr']; ?>">
            </label>
            <label for="">
                <span>Дата и время микротравмы</span>
                <input type="datetime-local" id="date-microtr" value="<?=date('Y-m-d\TH:i:s', strtotime($lineMicrotr['date_microtr'])); ?>">
            </label>
            <label for="">
                <span>Первая помощь</span>
                <input type="text" id="first-aid" value="<?=$lineMicrotr['first_aid']; ?>">
            </label>
            <label for="">
                <span>Дата и время обращения</span>
                <input type="datetime-local" id="date-app" value="<?=date('Y-m-d\TH:i:s', strtotime($lineMicrotr['date_of_application'])); ?>">
            </label>
            <label for="">
                <span>Наименование медучреждения</span>
                <input type="text" id="medicial" value="<?=$lineMicrotr['title_medicial']; ?>">
            </label>
            <label for="">
                <span>Установление повреждения здоровья</span>
                <input type="text" id="trauma" value="<?=$lineMicrotr['trauma']; ?>">
            </label>
            <label for="">
                <span>Освобождение от учебы (кол-во часов или до конца дня)</span>
                <input type="text" id="release" value="<?=$lineMicrotr['duration_release']; ?>">
            </label>
            <label for="">
                <span>Обстоятельства</span>
                <input type="text" id="circumstances" value="<?=$lineMicrotr['circumstances']; ?>">
            </label>
            <label for="">
                <?php
                    $sqlReasons = "SELECT * FROM `reasons`";
                    $res = $pdo -> query($sqlReasons);
                    $line_reasons = $res -> fetchAll();
                ?>
                <span>Причины</span>

                <?php
                    if($lineMicrotr['id_reason'] == 0) {
                ?>
                        <select name="" id="reasons-select">
                            <?php foreach($line_reasons as $line): ?>
                                <option value="<?=$line['id_reason']; ?>"><?=$line['reason_title']; ?></option>
                            <?php endforeach; ?>
                            <option value="0" selected>Другое</option>
                        </select>
                        <input type="text" id="reason" value="<?=$lineMicrotr['custom_reason']; ?>" style="display: block;" placeholder="Напишите свою причину">
                <?php
                    } else {
                ?>
                        <select name="" id="reasons-select">
                            <option value="<?=$lineMicrotr['id_reason']; ?>" selected disabled><?=$reason; ?></option>
                            <?php foreach($line_reasons as $line): ?>
                                <option value="<?=$line['id_reason']; ?>"><?=$line['reason_title']; ?></option>
                            <?php endforeach; ?>
                            <option value="0">Другое</option>
                        </select>
                        <input type="text" id="reason" value="" style="display: none;" placeholder="Напишите свою причину">
                <?php
                    }
                ?>
                
            </label>
            <label for="">
                <?php
                    $sqlTypes = "SELECT * FROM `types_main`";
                    $res = $pdo -> query($sqlTypes);
                    $line_types = $res -> fetchAll();
                ?>
                <span>Виды</span>
                <?php
                        if($lineMicrotr['id_type_main'] == 0 && $lineMicrotr['id_type_secondary'] == 0) {
                    ?>
                            <select name="" id="types-select">
                                <?php foreach($line_types as $line): ?>
                                    <?php
                                        $sqlSubType = "SELECT * FROM `types_secondary` WHERE `id_type_main` = ?";
                                        $resSubTypes = $pdo -> prepare($sqlSubType);
                                        $resSubTypes -> execute(array($line['id_type_main']));
                                        $linesSubTypes = $resSubTypes -> fetchAll();
                                        $countSubTypes = count($linesSubTypes);
                                    ?>
                                    <?php if($countSubTypes > 0): ?>
                                        <optgroup id="<?=$line['id_type_main']; ?>" label="<?=$line['type_main_title']; ?>">
                                            <?php foreach($linesSubTypes as $subline): ?>
                                                <option class="sub-option" value="<?=$subline['id_type_secondary']; ?>"><?=$subline['type_secondary_title']; ?></option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php else: ?>
                                        <option value="<?=$line['id_type_main']; ?>"><?=$line['type_main_title']; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <option value="0" selected>Другое</option>
                            </select>
                            <input type="text" id="type" value="<?=$lineMicrotr['custom_type']; ?>" style="display: block;" placeholder="Напишите свой вид">
                    <?php
                        } else if($lineMicrotr['id_type_main'] != 0 && $lineMicrotr['id_type_secondary'] != 0) {
                            $sqlSelectedTypes = "SELECT * FROM `types_main` INNER JOIN `types_secondary` ON `types_main`.`id_type_main` = `types_secondary`.`id_type_main` WHERE `id_type_secondary` = ?";
                            $resSelected = $pdo -> prepare($sqlSelectedTypes);
                            $resSelected -> execute(array($lineMicrotr['id_type_secondary']));
                            $line_selected_types = $resSelected -> fetch();
                    ?>
                            <select name="" id="types-select">
                                <option value="<?=$lineMicrotr['id_type_secondary']; ?>" selected disabled><?=$line_selected_types['type_main_title'].$line_selected_types['type_secondary_title']; ?></option>
                                <?php foreach($line_types as $line): ?>
                                    <?php
                                        $sqlSubType = "SELECT * FROM `types_secondary` WHERE `id_type_main` = ?";
                                        $resSubTypes = $pdo -> prepare($sqlSubType);
                                        $resSubTypes -> execute(array($line['id_type_main']));
                                        $linesSubTypes = $resSubTypes -> fetchAll();
                                        $countSubTypes = count($linesSubTypes);
                                    ?>
                                    <?php if($countSubTypes > 0): ?>
                                        <optgroup id="<?=$line['id_type_main']; ?>" label="<?=$line['type_main_title']; ?>">
                                            <?php foreach($linesSubTypes as $subline): ?>
                                                <option class="sub-option" value="<?=$subline['id_type_secondary']; ?>"><?=$subline['type_secondary_title']; ?></option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php else: ?>
                                        <option value="<?=$line['id_type_main']; ?>"><?=$line['type_main_title']; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <option value="0">Другое</option>
                            </select>
                            <input type="text" id="type" value="" style="display: none;" placeholder="Напишите свой вид">
                    <?php
                        } else if($lineMicrotr['id_type_main'] != 0 && $lineMicrotr['id_type_secondary'] == 0) {
                            $sqlSelectedTypes = "SELECT * FROM `microtraumas` INNER JOIN `types_main` ON `microtraumas`.`id_type_main` = `types_main`.`id_type_main` WHERE `microtraumas`.`id_type_main` = ?";
                            $resSelected = $pdo -> prepare($sqlSelectedTypes);
                            $resSelected -> execute(array($lineMicrotr['id_type_main']));
                            $line_selected_types = $resSelected -> fetch();
                    ?>
                            <select name="" id="types-select">
                                <option value="<?=$lineMicrotr['id_type_secondary']; ?>" selected disabled><?=$line_selected_types['type_main_title']; ?></option>
                                <?php foreach($line_types as $line): ?>
                                    <?php
                                        $sqlSubType = "SELECT * FROM `types_secondary` WHERE `id_type_main` = ?";
                                        $resSubTypes = $pdo -> prepare($sqlSubType);
                                        $resSubTypes -> execute(array($line['id_type_main']));
                                        $linesSubTypes = $resSubTypes -> fetchAll();
                                        $countSubTypes = count($linesSubTypes);
                                    ?>
                                    <?php if($countSubTypes > 0): ?>
                                        <optgroup id="<?=$line['id_type_main']; ?>" label="<?=$line['type_main_title']; ?>">
                                            <?php foreach($linesSubTypes as $subline): ?>
                                                <option class="sub-option" value="<?=$subline['id_type_secondary']; ?>"><?=$subline['type_secondary_title']; ?></option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php else: ?>
                                        <option value="<?=$line['id_type_main']; ?>"><?=$line['type_main_title']; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <option value="0">Другое</option>
                            </select>
                            <input type="text" id="type" value="" style="display: none;" placeholder="Напишите свой вид">
                    <?php
                        }
                    ?>
                
            </label>
            <label for="">
                <span>Предложения по устранению причин</span>
                <input type="text" id="suggestions" value="<?=$lineMicrotr['suggestions']; ?>">
            </label>
        </div>
        <div class="btn-block">
            <button class="btn preload-btn" user="id_staff">Распечатать справку</button>
            <button class="btn save-btn" id="save-btn">Сохранить</button>
            <?php
                if($lineMicortrauma['status'] == 'В рассмотрении') {
            ?>
                    <button class="btn end-btn" id="end-btn">Отправить в архив</button>
            <?php
                } else if($lineMicortrauma['status'] == 'Завершено') {
            ?>
                    <button class="btn end-btn" id="return-btn">Вернуть из архива</button>
            <?php
                }
            ?>
        </div>
        <div class="preload-block" id="preview-content">
            
        </div>
<?php
    }
?>