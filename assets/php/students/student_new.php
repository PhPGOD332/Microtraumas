<?php
    session_start();
    require_once('../connect/logic.php');
?>

<!-- <iframe src="" name="iframe-profile" frameborder="0" style="display: none;"></iframe> -->
<form method="POST" enctype="multipart/form-data" class="profile-form" id="form-new-student">
    <div class="up-block">
        <div class="img-block" id="img-block">
            <div class="img-load-block">
                <label for="">
                    <span>Фото</span>
                    <input type="file" id="file-input" name="img" style="display: none;">
                    <label for="file-input" id="file-label" class="btn">
                        <span class="fa-span"><i id="fa-load" class="fa fa-solid fa-download"></i></span>
                        <span id="choose-file">Выберите файл</span>
                    </label>
                </label>
            </div>
        </div>
        <div class="data-block data1-block">
            <label for="">
                <span>ФИО</span>
                <textarea rows="2" type="text" class="fio-input" name="fio" id="fio-input" value=""></textarea>
            </label>
            <label for="">
                <span>Дата рождения</span>
                <input type="date" class="birth-input" name="dateBirth" id="birth-input">
            </label>
            <label for="">
                <span>Возраст</span>
                <input type="text" class="age-input" value="<?=$age; ?>" placeholder="Выберите дату рождения" disabled>
            </label>
            <label for="">
                <span>Группа</span>
                <select id="select-groups" name="idGroup">
                    <option value="0" disabled selected>Выберите группу</option>
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
                <input type="text" class="course-input" value="" placeholder="Выберите группу" disabled>
            </label>
            <label for="">
                <span>Специальность</span>
                <textarea rows="2" type="text" class="specialization-input" placeholder="Выберите группу" disabled></textarea>
            </label>
            <label for="">
                <span>Староста</span>
                <input type="text" value="" placeholder="Выберите группу" id="elder-input" disabled>
            </label>
        </div>
        <div class="data-block data2-block">
            <label for="">
                <span>Дата зачисления в колледж</span>
                <input type="date" class="study-input" name="dateStudy" id="admission-input">
            </label>
            <label for="">
                <span>Доп. описание</span>
                <textarea rows="10" type="text" class="info-input" name="addInfo" id="addinfo-input"></textarea>
            </label>
            <label for="">
                <span>Адреса</span>
                <textarea rows="2" type="text" class="address-input" name="address" id="address-input"></textarea>
            </label>
            <label for="">
                <span>Телефоны</span>
                <textarea rows="3" type="text" class="phone-input" name="phone" id="phone-input"></textarea>
            </label>
        </div>
    </div>
    <div class="section-btns section-bottom-btns">
        <div class="btn-block">
            <button type="submit" class="btn edit-btn" id="save-student">Добавить</button>
        </div>
    </div>
</form>