<?php 
    session_start(); 
    require_once('../../../assets/php/connect/logic.php');
?>
<?php if($_SESSION['autorized'] == true && $_SESSION['role'] == 'admin'): ?>
<?php $id_microtr = $_GET['id_microtr']; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Оформление микротравмы</title>
        <link rel="stylesheet" href="/assets/css/style.css">
        <script src="/assets/js/jquery-3.6.0.min.js"></script>
        <script src="/assets/js/jspdf.min.js"></script>
        <script type="text/javascript" src="/assets/js/html2canvas.min.js"></script>
        <script type="text/javascript" src="/assets/js/script.js"></script>
        <script src="https://use.fontawesome.com/d55499613e.js"></script>
    </head>
    <body id="microtr-detailed-body">
        <div class="wrapper-block">
            <!-- <div class="modal-block"> -->
                <div class="modal-block bg-block" id="modal-choose">
                    <div class="modal">
                        <div class="form-block">
                            <div class="title-block">
                                <span>Выбор пострадавшего</span>
                            </div>
                            <div class="modal-content">
                                <button class="exit-btn">
                                    <i class="fa fa-close"></i>
                                </button>
                                <div class="choose-block">
                                    <button class="btn" id="students-btn">Студенты</button>
                                    <button class="btn" id="staff-btn">Работники</button>
                                </div>
                                <div class="type-block students-block" id="students-content">
                                    <div class="search-block">
                                        <input type="text" class="search-input" id="search-students" placeholder="Поиск по ФИО" action="students">
                                        <button class="search-btn">
                                            <i class="fa fa-solid fa-search"></i>
                                        </button>
                                    </div>
                                    <div class="content-block" id="students-table">
                                    
                                    </div>
                                </div>
                                <div class="type-block staff-block" id="staff-content">
                                    <div class="search-block">
                                        <input type="text" class="search-input" id="search-students" placeholder="Поиск по ФИО" action="staff">
                                        <button class="search-btn">
                                            <i class="fa fa-solid fa-search"></i>
                                        </button>
                                    </div>
                                    <div class="content-block" id="staff-table">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-message-block bg-block" id="modal-message">
                    <div class="modal-message">
                        <button class="exit-btn" id="close-message-btn">
                            <i class="fa fa-close"></i>
                        </button>
                        <div class="form-block">
                            <div class="title-block">
                                <span>Внимание</span>
                            </div>
                            <div class="modal-message-content" id="success-content">
                                
                            </div>
                        </div>
                        <div class="btn-block">
                            <button class="btn" id="ok-btn">ОК</button>
                        </div>
                    </div>
                </div>
            <!-- </div> -->
            <section class="section main-section">
                <div class="section-title">
                    <div class="title-col left-col">
                        <div class="title-block">
                            <h1 class="section-title__title">Оформление микротравмы</h1>
                        </div>
                        <div class="back-block">
                            <button onclick="history.back();" class="btn back-btn">
                                <i class="fa fa-solid fa-reply"></i>
                            </button>
                            <a href="/index.php" class="btn home-btn">
                                <span>На главную</span>
                                <i class="fa fa-solid fa-home"></i>
                            </a>
                        </div>
                    </div>
                    <div class="title-col right-col">
                        <div class="user-block">
                            <div class="nickname-block">
                                <span class="name-user" id="nickname"></span>
                            </div>
                            <div class="btn-exit">
                                <button class="btn exit" id="user-exit">
                                    <i class="fa fa-solid fa-sign-out"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-content">
                    <div class="form-block" idMicrotr="<?=$id_microtr; ?>">
                        <label for="">
                            <span>Пострадавший</span> 
                            <div class="name-block">
                                <input type="text" id="fio-microtr" value="" disabled>
                                <button class="btn name-btn" id="modal-btn">
                                    Выбрать
                                </button>
                            </div>
                            <span class="error" id="fio-error"></span>
                        </label>
                        <label for="">
                            <span>Место травмы</span>  
                            <input type="text" id="place-microtr" value="">
                            <span class="error" id="place-error"></span>
                        </label>
                        <label for="">
                            <span>Дата и время микротравмы</span>
                            <input type="datetime-local" id="date-microtr" value="">
                            <span class="error" id="date-microtr-error"></span>
                        </label>
                        <label for="">
                            <span>Первая помощь</span>
                            <input type="text" id="first-aid" value="">
                            <span class="error" id="first-error"></span>
                        </label>
                        <label for="">
                            <span>Дата и время обращения</span>
                            <input type="datetime-local" id="date-app" value="">
                            <span class="error" id="date-app-error"></span>
                        </label>
                        <label for="">
                            <span>Наименование медучреждения</span>
                            <input type="text" id="medicial" value="">
                        </label>
                        <label for="">
                            <span>Установление повреждения здоровья</span>
                            <input type="text" id="trauma" value="">
                            <span class="error" id="trauma-error"></span>
                        </label>
                        <label for="">
                            <span>Освобождение от учебы (кол-во часов или до конца дня)</span>
                            <input type="text" id="release" value="">
                        </label>
                        <label for="">
                            <span>Обстоятельства</span>
                            <input type="text" id="circumstances" value="">
                        </label>
                        <label for="">
                            <?php
                                $sqlReasons = "SELECT * FROM `reasons`";
                                $res = $pdo -> query($sqlReasons);
                                $line_reasons = $res -> fetchAll();
                            ?>
                            <span>Причины</span>

                            <select name="" id="reasons-select">
                            <option value="0" selected disabled>Выберите причину</option>
                                <?php foreach($line_reasons as $line): ?>
                                    <option value="<?=$line['id_reason']; ?>"><?=$line['reason_title']; ?></option>
                                <?php endforeach; ?>
                                <option value="0">Другое</option>
                            </select>
                            <input type="text" id="reason" value="<?=$lineMicrotr['custom_reason']; ?>" style="display: none;" placeholder="Напишите свою причину">
                        </label>
                        <label for="">
                            <?php
                                $sqlTypes = "SELECT * FROM `types_main`";
                                $res = $pdo -> query($sqlTypes);
                                $line_types = $res -> fetchAll();
                            ?>
                            <span>Виды</span>
                            <select name="" id="types-select">
                                <option value="0" selected disabled>Выберите тип микротравмы</option>
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
                            <input type="text" id="type" value="<?=$lineMicrotr['custom_type']; ?>" style="display: none;" placeholder="Напишите свой вид">
                        </label>
                        <label for="">
                            <span>Предложения по устранению причин</span>
                            <input type="text" id="suggestions" value="">
                        </label>
                    </div>
                    <div class="btn-block">
                        <button class="btn save-btn" id="save-btn">Сохранить</button>
                        <button class="btn end-btn" id="back-btn">Назад</button>
                    </div>
                    <div class="preload-block" id="preview-content">
                        
                    </div>
                </div>
            </section>
        </div>
    </body>
    <script>
        $(document).ready(() => {
            let messageTimeout;
            let confirm;
            let idReason = 0;
            let idTypeMain = 0;
            let idType = 0;
            let types = $(document).find('#types-select option');

            const 
                modalChoose = $(document).find('#modal-choose'),
                modal = modalChoose.find('.modal'),
                studentsBlock = modal.find('#students-content'),
                staffBlock = modal.find('#staff-content'),
                studentsBtn = modal.find('#students-btn'),
                staffBtn = modal.find('#staff-btn'),
                studentsContent = modal.find('#students-table'),
                staffContent = modal.find('#staff-table'),
                userInput = $(document).find('#fio-microtr'),
                modalMessage = $(document).find('#modal-message');

            // Сохранение формы
            const saveEdit = function saveEdit(action) {
                let 
                    place = $(document).find('#place-microtr').val(),
                    dateMicr = $(document).find('#date-microtr').val(),
                    firstAid = $(document).find('#first-aid').val(),
                    dateApp = $(document).find('#date-app').val(),
                    medicial = $(document).find('#medicial').val(),
                    trauma = $(document).find('#trauma').val(),
                    release = $(document).find('#release').val(),
                    circ = $(document).find('#circumstances').val(),
                    reason = $(document).find('#reason').val(),
                    type = $(document).find('#type').val(),
                    suggestions = $(document).find('#suggestions').val(),
                    idUser = userInput.attr('idUser'),
                    typeUser = userInput.attr('typeUser');

                if(userInput.val() == '' || place == '' || dateMicr == '' || firstAid == '' || dateApp == '' || trauma == '') {
                    if(userInput.val() == '') {
                        $(document).find('#fio-error').html('Выберите пострадавшего');
                    }
                    if(place == '') {
                        $(document).find('#place-error').html('Заполните поле');
                    }
                    if(dateMicr == '') {
                        $(document).find('#date-microtr-error').html('Заполните поле');
                    }
                    if(firstAid == '') {
                        $(document).find('#first-error').html('Заполните поле');
                    }
                    if(dateApp == '') {
                        $(document).find('#date-app-error').html('Заполните поле');
                    }
                    if(trauma == '') {
                        $(document).find('#trauma-error').html('Заполните поле');
                    }

                } else {
                    $.ajax({
                        url: '/assets/php/microtrauma_new/save_microtr.php',
                        cache: false,
                        method: 'POST',
                        data: {
                            place : place,
                            dateMicr : dateMicr,
                            firstAid : firstAid,
                            dateApp : dateApp,
                            medicial : medicial,
                            trauma : trauma,
                            release : release,
                            circ : circ,
                            idReason : idReason,
                            reason : reason,
                            idTypeMain : idTypeMain,
                            idType : idType,
                            type : type,
                            suggestions : suggestions,
                            idUser : idUser,
                            typeUser : typeUser

                        },
                        success: (res) => {
                            $(document).find('#success-content').html(res);

                            modalMessage.css('display', 'flex').hide().fadeIn(500);
                            messageTimeout = setTimeout(() => {
                                modalMessage.fadeOut(500);
                            }, 3000);
                            $(document).find('input').val('');
                            $(document).find('select:first-of-type option').prop('selected', false);
                            $(document).find('select:last-of-type option').prop('selected', false);

                            $(document).find('select:first-of-type option:first-of-type').prop('selected', true);
                            $(document).find('select:last-of-type option:first-of-type').prop('selected', true);
                            // location.href = '/pages/admin/microtraumas/index.php';
                        }
                    })
                }
            }

            // Обработка выбора причины
            $(document).on('change', '#reasons-select', function() {
                if($(this).val() == 0) {
                    $(document).find('#reason').slideDown(500);
                } else {
                    $(document).find('#reason').slideUp(500);
                }

                idReason = $(this).val();
            })

            // Обработка выбора типа
            $(document).on('change', '#types-select', function() {
                if($(this).val() == 0) {
                    $(document).find('#type').slideDown(500);
                } else {
                    $(document).find('#type').slideUp(500);
                }

                idType = $(this).val();

                $.each(types, function(index, value) {
                    if($(value).prop('selected') == true) {
                        if($(value).parent().prop('class') == 'propgroup') {
                            idTypeMain = $(value).parent().prop('id');
                        } else if($(value).parent().prop('id') == 'types-select') {
                            idTypeMain = idType;
                            idType = 0;
                        } else {
                            idTypeMain = $(value).parent().prop('id');
                        }
                    }
                })
            })

            $(document).on('click', '#back-btn', function() {
                history.back();
            })

            // Модальное окно
            $(document).on('click', '#modal-btn', () => {
                modalChoose.fadeIn(500);

            })

            // Закрытие окна сообщения
            $(document).on('click', '#ok-btn', () => {
                clearTimeout(messageTimeout);
                modalMessage.fadeOut(500);
            })

            $(document).on('click', '#close-message-btn', () => {
                clearTimeout(messageTimeout);
                modalMessage.fadeOut(500);
            })

            $(document).on('click', (e) => {
                if($(e.target).is('#modal-message')) {
                    clearTimeout(messageTimeout);
                    modalMessage.fadeOut(500);
                }
            })

            $(document).on('click', (e) => {
                if($(e.target).is('#modal-choose')) {
                    modalChoose.fadeOut(500);
                }

                if($(e.target).is('#modal-choose .exit-btn') || $(e.target).is('.modal-block .exit-btn i')) {
                    modalChoose.fadeOut(500);
                }

                if($(e.target).is('.modal #students-btn')) {
                    studentsBlock.slideDown(500);
                    staffBlock.slideUp(500);
                    studentsBtn.addClass('selected');
                    staffBtn.removeClass('selected');
                } else if($(e.target).is('.modal #staff-btn')) {
                    staffBlock.slideDown(500);
                    studentsBlock.slideUp(500);
                    staffBtn.addClass('selected');
                    studentsBtn.removeClass('selected');
                }
            })

            $(document).on('click', '.search-btn', function() {
                let 
                    search = $(this).siblings('.search-input').val(),
                    action = $(this).siblings('.search-input').attr('action');
                $.ajax({
                    url: '/assets/php/microtrauma_new/modal_filter.php',
                    cache: false,
                    method: 'POST',
                    data: {
                        search : search,
                        action : action
                    },
                    success: (res) => {
                        if(action == 'students') {
                            studentsContent.html(res);
                        } else if(action == 'staff') {
                            staffContent.html(res);
                        }
                    }
                })
            })

            $(document).on('click', '.row-table', function() {
                let 
                    typeUser = $(this).attr('typeUser'),
                    id = $(this).attr('id'),
                    fio = $(this).children('.body-fio').children('span').html();

                userInput.val(fio).attr('idUser', id).attr('typeUser', typeUser);
                modalChoose.fadeOut(500);
            })

            $(document).on('click', '#save-btn', () => {
                saveEdit();
            })
        })
    </script>
</html>
<?php else: ?>
    <?php header('Location:/assets/php/autorization/index.php'); ?>
<?php endif; ?>