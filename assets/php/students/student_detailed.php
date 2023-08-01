<?php
    session_start();
    require_once('../connect/logic.php');

    $idStudent = $_GET['idStudent'];

    $sqlStudent = "SELECT * FROM `students` WHERE `id_student` = ?";
    $result = $pdo -> prepare($sqlStudent);
    $result -> execute(array($idStudent));
    $lineStudent = $result -> fetch(); 

    if($lineStudent['id_group'] != 0) {
        $sqlStudent = "SELECT * FROM `students` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group` INNER JOIN `specializations` ON `groups`.`id_specialization` = `specializations`.`id_specialization` WHERE `id_student` = ?";
        $result = $pdo -> prepare($sqlStudent);
        $result -> execute(array($idStudent));
        $lineStudent = $result -> fetch(); 
    }

    $date_birth = new DateTime($lineStudent['date_birth']);
    $age = $date_birth->diff(new DateTime)->y;
?>
    <!-- <iframe src="" name="iframe-profile" frameborder="0" style="display: none;"></iframe> -->
    <form method="POST" enctype="multipart/form-data" class="profile-form">
        <input type="hidden" id="idStudent-input" name="idStudent" value="<?=$idStudent; ?>">
        <div class="up-block">
            <div class="img-block">
                <div class="img-bg" id="img-empty">

                </div>
                <img src="<?=$lineStudent['img']; ?>" alt="" id="avatar">
                <div class="img-load-block">
                    <div class="img-input-block">
                        <span>Фото</span>
                        <input type="file" id="file-input" name="img" style="display: none;">
                        <label for="file-input" id="file-label" class="btn">
                            <span class="fa-span"><i id="fa-load" class="fa fa-solid fa-download"></i></span>
                            <span id="choose-file">Выберите файл</span>
                        </label>
                    </div>
                    <div class="checkbox-label">
                        <input type="checkbox" id="archive-checkbox" name="archive">
                        <div class="check-box archive-check-box"></div>
                        <span class="check-status" style="display: none;"><?=$lineStudent['archive']; ?></span>
                        <label for="archive-checkbox" class="check-span">Архив</label>
                    </div>
                </div>
            </div>
            <div class="data-block data1-block">
                <label for="">
                    <span>ФИО</span>
                    <textarea rows="2" type="text" class="fio-input" name="fio" id="fio-input" value=""><?=$lineStudent['FIO']; ?></textarea>
                    <span class="error" id="error-fio"></span>
                </label>
                <label for="">
                    <span>Дата рождения</span>
                    <input type="date" class="birth-input" name="dateBirth" id="date-input" value="<?=$lineStudent['date_birth']; ?>">
                </label>
                <label for="">
                    <span>Возраст</span>
                    <input type="text" class="age-input" value="<?=$age; ?>" disabled>
                </label>
                <label for="">
                    <span>Группа</span>
                    <select id="select-groups" name="idGroup">
                        <option value="<?=$lineStudent['id_group']; ?>" disabled selected><?=$lineStudent['id_group'] == 0 ? 'Студент в архиве' : $lineStudent['title_group']; ?></option>
                        <?php
                            foreach($groups_line as $group) {
                                ?>
                                    <option value="<?=$group['id_group']; ?>"><?=$group['title_group']; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </label>
                <label for="">
                    <span>Курс</span>
                    <input type="text" class="course-input" value="<?=$lineStudent['course']; ?>" disabled>
                </label>
                <label for="">
                    <span>Специальность</span>
                    <textarea rows="2" type="text" class="specialization-input" disabled><?=$lineStudent['title_specialization']; ?></textarea>
                </label>
                <label for="">
                    <?php
                        $sqlElder = "SELECT * FROM `groups` INNER JOIN `students` ON `groups`.`elder` = `students`.`id_student` WHERE `elder` = ?";
                        $resElder = $pdo -> prepare($sqlElder);
                        $resElder -> execute(array($lineStudent['elder']));
                        $lineElder = $resElder -> fetch();
                    ?>
                    <span>Староста</span>
                    <input type="text" value="<?=$lineStudent['elder']; ?>" id="elder-input" disabled>
                </label>
            </div>
            <div class="data-block data2-block">
                <label for="">
                    <span>Дата зачисления в колледж</span>
                    <input type="date" class="study-input" name="dateStudy" id="study-input" value="<?=$lineStudent['admission_to_study']; ?>">
                </label>
                <label for="">
                    <span>Доп. описание</span>
                    <textarea rows="10" type="text" class="info-input" name="addInfo" id="addinfo-input"><?=$lineStudent['add_information']; ?></textarea>
                </label>
                <label for="">
                    <span>Адреса</span>
                    <textarea rows="2" type="text" class="address-input" id="address-input" name="address"><?=$lineStudent['address']; ?></textarea>
                </label>
                <label for="">
                    <span>Телефоны</span>
                    <textarea rows="3" type="text" class="phone-input" name="phone" id="phone-input"><?=$lineStudent['phone']; ?></textarea>
                </label>
            </div>
        </div>
        <div class="section-btns section-bottom-btns">
            <div class="btn-block">
                <button type="submit" class="btn edit-btn" id="save-student">Сохранить</button>
            </div>
        </div>
    </form>