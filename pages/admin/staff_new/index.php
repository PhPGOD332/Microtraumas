<?php session_start(); ?>
<?php require_once('../../../assets/php/connect/logic.php'); ?>
<?php if($_SESSION['autorized'] == true && $_SESSION['role'] == 'admin'): ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Добавление сотрудника</title>
        <link rel="stylesheet" href="/assets/css/style.css">
        <script src="/assets/js/jquery-3.6.0.min.js"></script>
        <script src="/assets/js/jspdf.min.js"></script>
        <script src="/assets/js/jQuery-Mask-Plugin-master/src/jquery.mask.js"></script>
        <script type="text/javascript" src="/assets/js/html2canvas.min.js"></script>
        <script type="text/javascript" src="/assets/js/script.js"></script>
        <script src="https://use.fontawesome.com/d55499613e.js"></script>
    </head>
    <body id="student-new-body">
        <div class="wrapper-block">
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
            <section class="section main-section">
                <div class="section-title section-title">
                    <div class="title-col left-col">
                        <div class="title-block">
                            <h1 class="section-title__title">Добавление сотрудника</h1>
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
                <div class="section-content section-content-student">
                    <div class="profile-block" id="staff-content">
                        
                    </div>
                </div>
            </section>
        </div>
    </body>
    <script type="text/javascript">
        $(document).ready(() => {
            const modalMessage = $(document).find('#modal-message');
            let fileName;
            let messageTimeout;

            // Отправка формы
            const submitForm = function submitForm(fileName) {
                $.ajax({
                    url: '/assets/php/staff/staff_new_handler.php',
                    cache: false,
                    type: 'POST',
                    data: {
                        fio : $(document).find('#fio-input').val(),
                        post : $(document).find('#post-input').val(),
                        division : $(document).find('#division-input').val(),
                        category : $(document).find('#category-input').val(),
                        director : $(document).find('#director-input').val(),
                        dateHiring : $(document).find('#hiring-input').val(),
                        dateBirth : $(document).find('#birth-input').val(),
                        SNILS : $(document).find('#snils-input').val(),
                        exp : $(document).find('#exp-input').val(),
                        email : $(document).find('#email-input').val(),
                        passport : $(document).find('#passport-input').val(),
                        address : $(document).find('#address-input').val(),
                        combining : $(document).find('#combining-checkbox').val(),
                        disability : $(document).find('#disability-checkbox').val(),
                        maternity : $(document).find('#maternity-checkbox').val(),
                        pregnancy : $(document).find('#pregnancy-checkbox').val(),
                        easywork : $(document).find('#easywork-checkbox').val(),
                        addInfo : $(document).find('#addinfo-input').val(),
                    },
                    success: (res) => {
                        $(document).find('#success-content').html(res);

                        modalMessage.css('display', 'flex').hide().fadeIn(500);
                        messageTimeout = setTimeout(() => {
                            modalMessage.fadeOut(500);
                        }, 3000);
                    }
                })

                var fd = new FormData;
                fd.append('img', $(document).find('#file-input')[0].files[0]);
                $.ajax({
                    url: '/assets/php/staff/staff_new_handler.php',
                    data: fd,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function(data) {
                        $(document).find('#success-content').html(data);
                    }
                })
            }

            // Отправка формы без картинки
            const submitFormNonImage = function submitFormNonImage(fileName) {
                $.ajax({
                    url: '/assets/php/staff/staff_new_handler_nonImage.php',
                    cache: false,
                    type: 'POST',
                    data: {
                        fio : $(document).find('#fio-input').val(),
                        post : $(document).find('#post-input').val(),
                        division : $(document).find('#division-input').val(),
                        category : $(document).find('#category-input').val(),
                        director : $(document).find('#director-input').val(),
                        dateHiring : $(document).find('#hiring-input').val(),
                        dateBirth : $(document).find('#birth-input').val(),
                        SNILS : $(document).find('#snils-input').val(),
                        exp : $(document).find('#exp-input').val(),
                        email : $(document).find('#email-input').val(),
                        passport : $(document).find('#passport-input').val(),
                        address : $(document).find('#address-input').val(),
                        combining : $(document).find('#combining-checkbox').val(),
                        disability : $(document).find('#disability-checkbox').val(),
                        maternity : $(document).find('#maternity-checkbox').val(),
                        pregnancy : $(document).find('#pregnancy-checkbox').val(),
                        easywork : $(document).find('#easywork-checkbox').val(),
                        addInfo : $(document).find('#addinfo-input').val(),
                    },
                    success: (res) => {
                        $(document).find('#success-content').html(res);

                        modalMessage.css('display', 'flex').hide().fadeIn(500);
                        messageTimeout = setTimeout(() => {
                            modalMessage.fadeOut(500);
                        }, 3000);
                    }
                })
            }

            // Вывод формы
            const form = function form() {
                $.ajax({
                    url: '/assets/php/staff/staff_new.php',
                    cache: false,
                    success: (res) => {
                        $(document).find('#staff-content').html(res);
                        $(document).find('#snils-input').mask('999-999-999 99', {placeholder: '___-___-___ __'});
                        $(document).find('#passport-input').mask('99 99 999999', {placeholder: '__ __ ______'});

                        checkboxes = $(document).find('input[type="checkbox"]');

                        $.each(checkboxes, function(index, value) {
                            $(this).prop('checked', false);
                            $(this).val('');
                        })
                    }
                })
            }

            form();

            // Обработка выбора чекбокса
            $(document).on('click', '.check-box', function(e) {
                if($(this).siblings('input').prop('checked') == true) {
                    
                    $(this).siblings('input').prop('checked', false);
                    console.log($(this).siblings('input').prop('checked'));
                    $(this).siblings('input').val('');
                } else {
                    
                    $(this).siblings('input').prop('checked', true);
                    console.log($(this).siblings('input').prop('checked'));
                    $(this).siblings('input').val('on');
                }
            })
            
            // Обработка выбора чекбокса через label
            $(document).on('click', '.check-span', function() {
                if($(this).siblings('input').prop('checked') == true) {
                    $(this).siblings('input').prop('checked', false);
                    console.log($(this).siblings('input').prop('checked')+'f');
                    // $(this).siblings('input').prop('checked', false);
                    // $(this).siblings('input').val('');
                } else {
                    $(this).siblings('input').prop('checked', true);
                    console.log($(this).siblings('input').prop('checked')+'t');
                    
                    // $(this).siblings('input').val('on');
                }
            })

            // Название загружаемого файла
            $(document).on('change', '#file-input', function() {
                $(document).find('#choose-file').html($(this)[0].files[0].name);
            })

            // Отправка формы
            $(document).on('submit', '#form-new-staff', function() {
                if($(document).find('#fio-input').val() != '') {
                    if($(document).find('#file-input')[0].files[0]) {
                        submitForm();
                        form();
                    } else {
                        fileName = 'staff_new_handler_nonImage.php';
                        submitFormNonImage();
                        form();
                    }
                } else {
                    $(this).find('#error-fio').html('Введите ФИО');
                }

                return false;
            })

            // Закрытие модального окна сообщения
            $(document).on('click', function(e) {
                if($(e.target).is('.bg-block')) {
                    clearTimeout(messageTimeout);
                    modalMessage.fadeOut(500);
                }
            })

            $(document).on('click', '#close-message-btn', () => {
                clearTimeout(messageTimeout);
                modalMessage.fadeOut(500);
            })

            $(document).on('click', '#ok-btn', () => {
                clearTimeout(messageTimeout);
                modalMessage.fadeOut(500);
            })

            // Вывод превью фото
            // $(document).on('change', '#file-input', () => {
            //     var formData = new FormData();
            //     formData.append('file', $(this)[0].files[0])

            //     $.ajax({
            //         type: 'POST',
            //         url: '/assets/php/students/profile_show/img.php',
            //         cache: false,
            //         contentType: false,
            //         processData: false,
            //         data: formData,
            //         success: (res) => {
            //             $(document).find('#img-block').prepend(res);
            //         }
            //     })
            // })

            // Заполнение возраста при изменении даты рождения
            $(document).on('change', '.birth-input', function() {
                $.ajax({
                    url: '/assets/php/students/profile_show/age.php',
                    cache: false,
                    method: 'POST',
                    data: {
                        dateBirth : $(this).val()
                    },
                    success: (res) => {
                        $(document).find('.age-input').val(res)
                    }
                })
            })
        })
    </script>
</html>
<?php else: ?>
    <script>
        location.href="/assets/php/autorization/index.php";
    </script>
<?php endif; ?>