<!-- <iframe src="" name="iframe-profile" frameborder="0" style="display: none;"></iframe> -->
<form method="POST" enctype="multipart/form-data" class="profile-form" id="form-new-staff">
        <div class="up-block">
            <div class="img-block" id="img-block">
                <div class="img-load-block">
                    <div class="img-input-block">
                        <span>Фото</span>
                        <input type="file" id="file-input" name="img" style="display: none;">
                        <label for="file-input" id="file-label" class="btn">
                            <span class="fa-span"><i id="fa-load" class="fa fa-solid fa-download"></i></span>
                            <span id="choose-file">Выберите файл</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="data-block data1-block">
                <label for="">
                    <span>ФИО</span>
                    <textarea rows="2" type="text" class="fio-input" name="fio" id="fio-input" value=""></textarea>
                    <span class="error" id="error-fio"></span>
                </label>
                <label for="">
                    <span>Дата рождения</span>
                    <input type="date" class="birth-input" name="dateBirth" id="birth-input" value="">
                </label>
                <label for="">
                    <span>Возраст</span>
                    <input type="text" class="age-input" value="" placeholder="Выберите дату рождения" disabled>
                </label>
                <label for="">
                    <span>Должность</span>
                    <input type="text" value="" id="post-input" name="post" placeholder="Напишите должность">
                </label>
                <label for="">
                    <span>Отделение</span>
                    <input type="text" value="" id="division-input" name="division" placeholder="Напишите отделение">
                </label>
                <label for="">
                    <span>Опыт работы</span>
                    <input type="text" value="" id="exp-input" name="exp" placeholder="Напишите опыт работы">
                </label>
                <label for="">
                    <span>Категория</span>
                    <input type="text" value="" id="category-input" name="category" placeholder="Напишите категорию">
                </label>
                <label for="">
                    <span>Руководитель</span>
                    <input type="text" value="" id="director-input" name="director" placeholder="Напишите ФИО руководителя">
                </label>
            </div>
            <div class="data-block data2-block">
                <label for="">
                    <span>Дата принятия на работу</span>
                    <input type="date" class="hiring-input" id="hiring-input" name="dateHiring" value="">
                </label>
                <label for="">
                    <span>СНИЛС</span>
                    <input type="text" value="" id="snils-input" name="SNILS" placeholder="Номер СНИЛС">
                </label>
                <label for="">
                    <span>№ пасспорта</span>
                    <input type="text" value="" id="passport-input" name="passport" placeholder="Номер пасспорта">
                </label>
                <label for="">
                    <span>Эл. почта</span>
                    <input type="text" id="email-input" name="email" placeholder="Введите почту">
                </label>
                <label for="">
                    <span>Адреса</span>
                    <textarea rows="2" type="text" class="address-input" id="address-input" name="address"></textarea>
                </label>
                <fieldset style="padding-bottom: 5px;">
                    <legend>Дополнительная информация</legend>
                    <div class="check-block">
                        <div class="checkbox-label">
                            <input type="checkbox" id="combining-checkbox" name="combining">
                            <div class="check-box"></div>
                            <label for="combining-checkbox" class="check-span">Совмещение</label>
                        </div>
                        <div class="checkbox-label">
                            <input type="checkbox" id="disability-checkbox" name="disability">
                            <div class="check-box"></div>
                            <label for="disability-checkbox" class="check-span">Инвалидность</label>
                        </div>
                        <div class="checkbox-label">
                            <input type="checkbox" id="maternity-checkbox" name="maternity">
                            <div class="check-box"></div>
                            <label for="maternity-checkbox" class="check-span">Декретный отпуск</label>
                        </div>
                        <div class="checkbox-label">
                            <input type="checkbox" id="pregnancy-checkbox" name="pregnancy">
                            <div class="check-box"></div>
                            <label for="pregnancy-checkbox" class="check-span">Беременность</label>
                        </div>
                        <div class="checkbox-label">
                            <input type="checkbox" id="easywork-checkbox" name="easywork">
                            <div class="check-box"></div>
                            <label for="easywork-checkbox" class="check-span">Лёгкий труд</label>
                        </div>
                        <label for="" style="display: flex; flex-direction: column; width: calc(100% - 20px);">
                            <span>Доп. информация</span>
                            <textarea rows="2" type="text" class="addinfo-input" id="addinfo-input" name="addInfo" style="width: 100%;"></textarea>
                        </label>
                    </div>
                </fieldset>
                <!-- <label for="">
                    <span>Информация</span>
                    <select name="" id="">
                        <option value="Совмещение">Совмещение</option>
                        <option value="Инвалидность">Инвалидность</option>
                        <option value="Декретный отпуск">Декретный отпуск</option>
                        <option value="Беременность">Беременность</option>
                        <option value="Лёгкий труд">Лёгкий труд</option>
                    </select>
                    <input type="text" value="" id="passport-input" name="passport" placeholder="Номер пасспорта">
                </label>
                <label for="">
                    <span>Телефоны</span>
                    <textarea rows="3" type="text" class="phone-input" name="phone"></textarea>
                </label> -->
            </div>
        </div>
        <div class="section-btns section-bottom-btns">
            <div class="btn-block">
                <button type="submit" class="btn edit-btn" id="save-staff">Добавить</button>
                <!-- <button type="button" class="btn download-btn" id="close-btn">Назад</button> -->
            </div>
        </div>
    </form>