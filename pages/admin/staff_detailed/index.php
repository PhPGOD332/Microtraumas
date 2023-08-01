<?php session_start(); ?>
<?php require_once('../../../assets/php/connect/logic.php'); ?>
<?php if($_SESSION['autorized'] == true && $_SESSION['role'] == 'admin'): ?>
<?php
    $idStaff = $_GET['idStaff'];
    $_SESSION['idStaff'] = $idStaff;

    $sqlStaff = "SELECT * FROM `staff` WHERE `id_staff` = ?";
    $result = $pdo -> prepare($sqlStaff);
    $result -> execute(array($idStaff));
    $lineStaff = $result -> fetch(); 
    $date_birth = new DateTime($lineStaff['date_birth']);
    $age = $date_birth->diff(new DateTime)->y;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?=$lineStaff['FIO']; ?></title>
        <link rel="stylesheet" href="/assets/css/style.css">
        <script src="/assets/js/jquery-3.6.0.min.js"></script>
        <script src="/assets/js/jspdf.min.js"></script>
        <script src="/assets/js/jQuery-Mask-Plugin-master/src/jquery.mask.js"></script>
        <script type="text/javascript" src="/assets/js/html2canvas.min.js"></script>
        <!-- <script type="text/javascript" src="/assets/js/jquery.dialogOptions.js"></script> -->
        <script type="text/javascript" src="/assets/js/script.js"></script>
        <script src="https://use.fontawesome.com/d55499613e.js"></script>
    </head>
    <body id="student-body">
        <div class="wrapper-block">
            <div class="modal-message-block bg-block" id="modal-confirm">
                <div class="modal-message">
                    <button class="exit-btn" id="close-confirm-btn">
                        <i class="fa fa-close"></i>
                    </button>
                    <div class="form-block">
                        <div class="title-block">
                            <span>Внимание</span>
                        </div>
                        <div class="modal-message-content" id="confirm-content">

                        </div>
                    </div>
                    <div class="btn-block">
                        <button class="btn" id="yes-btn">Да</button>
                        <button class="btn" id="no-btn">Нет</button>
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
                        <!-- <iframe src="" name="iframe-profile" class="iframe-handler" frameborder="0" style=""></iframe> -->
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
                            <h1 class="section-title__title"><?=$lineStaff['FIO']; ?></h1>
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
                <div class="section-btns">
                    <div class="btn-block">
                        <!-- <button class="btn edit-btn" id="edit-btn">Редактировать</button> -->
                        <button class="btn download-btn" id="download-btn">Распечатать карточку</button>
                    </div>
                </div>
                <div class="section-content section-content-student">
                    <div class="profile-block" id="staff-content">

                    </div>
                    <div class="preview-block bg-block">
                        <div class="preview" id="preview-card">
                            
                        </div>
                    </div>
                    <div class="bottom-block">
                        <div class="microtraumas-block">
                            <div class="title-col left-col">
                                <div class="title-block">
                                    <h1 class="section-title__title">Микротравмы</h1>
                                </div>
                            </div>
                            <div class="content-block" id="archive-microtr-body">

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </body>
    <script type="text/javascript">
        $(document).ready(() => {
            const 
                modalConfirm = $(document).find('#modal-confirm'),
                modalMessage = $(document).find('#modal-message');

            let checkboxes;
            let messageTimeout;
            let confirm;
            let actionDel;

            // Загрузка PDF
            function makePDF() {
                let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=150');

                mywindow.document.write('<html><head><title>Печать карточки</title>');
                mywindow.document.write('</head><body>');
                mywindow.document.write('<style>.report-inner {display: flex; flex-direction: column; } </style>');
                mywindow.document.write(document.getElementById('staff-preview').innerHTML);
                mywindow.document.write('</body></html>');
                mywindow.document.close();
                mywindow.focus();

                mywindow.print();
                mywindow.close();

                // let preview = $(document).find('#staff-preview').outerHeight();
                // // window.html2canvas = html2canvas;
                // // window.jsPDF = window.jspdf.jsPDF;

                // html2canvas(document.querySelector('#staff-preview'), {
                //     // allowTaint: true,
                //     // useCORS: true,
                //     // scale: 5
                // }).then(canvas => {
                //     let img = canvas.toDataURL('image/jpeg');

                //     let doc = new jsPDF({
                //         orientation: 'p',
                //         unit: 'px',
                //         format: 'a4',
                        
                //     });
                //     doc.setFont('Times New Roman');
                //     doc.addImage(img, 'JPEG', 20, 10, 420, Number(preview) / 2);
                //     doc.save('Профиль.pdf');
                // })
                return true;
            }

            
            //Получение переменных, отправленных в ссылке
            const getUrlParameter = function getUrlParameter(sParam) {
                let sURLPage = window.location.search.substring(1),
                    sURLVariables = sURLPage.split('&'),
                    sParameterName,
                    i;

                for(i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split('=');

                    if(sParameterName[0] === sParam) {
                        return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                    }
                }
                return false;
            };

            let idStaff = getUrlParameter('idStaff');

            // Вывод профиля
            const profile = function profile() {
                $.ajax({
                    url: '/assets/php/staff/staff_detailed.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        idStaff : idStaff
                    },
                    success: (res) => {
                        $(document).find('#staff-content').html(res);
                        // $(document).find('#snils-input').val('');
                        $(document).find('#snils-input').mask('999-999-999 99', {placeholder: '___-___-___ __'});
                        $(document).find('#passport-input').mask('99 99 999999', {placeholder: '__ __ ______'});

                        checkboxes = $(document).find('input[type="checkbox"]');

                        $.each(checkboxes, function(index, value) {
                            if($(this).siblings('.check-status').html() == 1) {
                                $(this).prop('checked', true);
                                $(this).val('on');
                            } else {
                                $(this).prop('checked', false);
                                $(this).val('');
                            }
                        })

                        if($(document).find('#avatar').attr('src') == '') {
                            $(document).find('#img-empty').css('display', 'block');
                            $(document).find('#img-empty').outerHeight($(document).find('#img-empty').outerWidth());
                        } else {
                            $(document).find('#img-empty').fadeOut(500);
                        }
                    }
                })
            }

            const submitForm = function submitForm() {
                $.ajax({
                    url: '/assets/php/staff/staff_edit_handler.php',
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
                        archive : $(document).find('#archive-checkbox').val(),
                        addInfo : $(document).find('#addinfo-input').val(),
                    },
                    success: (res) => {
                        $(document).find('#success-content').html(res);
                        profile();

                        modalMessage.css('display', 'flex').hide().fadeIn(500);
                        messageTimeout = setTimeout(() => {
                            modalMessage.fadeOut(500);
                        }, 3000);
                    }
                })
            }

            profile();
            
            $(window).on('resize', () => {
                $(document).find('#img-empty').outerHeight($(document).find('#img-empty').outerWidth());
            })

            // Обработка выбора чекбокса
            $(document).on('click', '.check-box', function(e) {
                if($(this).siblings('input').prop('checked') == true) {
                    
                    $(this).siblings('input').prop('checked', false);
                    $(this).siblings('input').val('');
                } else {
                    
                    $(this).siblings('input').prop('checked', true);
                    $(this).siblings('input').val('on');
                }
            })
            
            // Обработка выбора чекбокса через label
            $(document).on('click', '.check-span', function() {
                if($(this).siblings('input').prop('checked') == true) {
                    $(this).siblings('input').prop('checked', false);
                    // $(this).siblings('input').prop('checked', false);
                    // $(this).siblings('input').val('');
                } else {
                    $(this).siblings('input').prop('checked', true);
                    
                    // $(this).siblings('input').val('on');
                }
            })

            // Вывод микротравм сотрудника
            const microtrs = function microtrs() {
                $.ajax({
                    url: '/assets/php/staff/microtraumas_staff.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        idStaff : idStaff
                    },
                    success: (res) => {
                        $(document).find('#archive-microtr-body').html(res);
                    }
                })
            }

            microtrs();

            // $(document).on('click', '#close-btn', () => {
            //     $(document).find('.section-bottom-btns').slideUp(500);

            //     $(document).find('input:not(.course-input):not(.age-input), select, textarea:not(.specialization-input)').prop('disabled', true);

            //     setTimeout(() => {
            //         profile();
            //     }, 500);
            // })

            // Отправка формы
            $(document).on('submit', '.profile-form', function() {
                if($(document).find('#fio-input').val() != '') {
                    if($(document).find('#file-input')[0].files[0]) {
                        var fd = new FormData;
                        fd.append('img', $(document).find('#file-input')[0].files[0]);
                        $.ajax({
                            url: '/assets/php/staff/staff_edit_handler.php',
                            data: fd,
                            processData: false,
                            contentType: false,
                            type: 'POST',
                            success: function(data) {
                                $(document).find('#success-content').html(data);
                                submitForm();
                            }
                        })
                    } else {
                        submitForm();
                    }
                } else {
                    $(this).find('#error-fio').html('Введите ФИО');
                }

                return false;
            })

            // Отправка в архив микротравмы
            $(document).on('click', '#archivation-microtr', function() {
                modalConfirm.find('#confirm-content').html('Вы точно хотите отправить микротравму в архив?');
                modalConfirm.css('display', 'flex').hide().fadeIn(500);
                confirm = $(this).siblings('.row-table').attr('href').split('=').pop();
                actionDel = 'archive';
            })

            // Удаление микротравмы
            $(document).on('click', '#del-microtr', function() {
                modalConfirm.find('#confirm-content').html('Вы точно хотите безвозвратно удалить микротравму из архива?');
                modalConfirm.css('display', 'flex').hide().fadeIn(500);
                confirm = $(this).siblings('.row-table').attr('href').split('=').pop();
                actionDel = 'delete';
            })

            // Подтверждение удаления
            $(document).on('click', '#yes-btn', () => {
                modalConfirm.fadeOut(500);
                $.ajax({
                    url: '/assets/php/microtraumas/microtrauma_delete.php',
                    cache: false,
                    method: 'POST',
                    data: {
                        idMicrotr : confirm,
                        actionDel : actionDel
                    },
                    success: (res) => {
                        $(document).find('#success-content').html(res);

                        modalMessage.css('display', 'flex').hide().fadeIn(500);
                        microtrs();
                        messageTimeout = setTimeout(() => {
                            modalMessage.fadeOut(500);
                        }, 3000);
                    }
                })
            })

            // Закрытие модального окна сообщения
            $(document).on('click', function(e) {
                if($(e.target).is('#modal-message')) {
                    clearTimeout(messageTimeout);
                    modalMessage.fadeOut(50);
                }
                if($(e.target).is('.preview-block')) {
                    $(document).find('.preview-block').fadeOut(500);
                }
                if($(e.target).is('#modal-confirm')) {
                    modalConfirm.fadeOut(500);
                }
            })

            // Отмена удаления
            $(document).on('click', '#no-btn', () => {
                modalConfirm.fadeOut(500);
            })

            $(document).on('click', '#close-confirm-btn', () => {
                modalConfirm.fadeOut(500);
            })

            // Закрытие модального окна сообщения
            $(document).on('click', '#close-message-btn', () => {
                clearTimeout(messageTimeout);
                modalMessage.fadeOut(50);
            })

            $(document).on('click', '#ok-btn', () => {
                clearTimeout(messageTimeout);
                modalMessage.fadeOut(50);
            })

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
                        $(document).find('.age-input').val(res);
                    }
                })
            })

            // Загрузка сотрудника
            $(document).on('click', '#download-btn', () => {
                $.ajax({
                    url: '/assets/php/staff/staff_download.php',
                    cache: false,
                    method: 'POST',
                    data: {
                        idStaff : idStaff
                    },
                    success: (res) => {
                        $(document).find('#preview-card').html(res);
                        $(document).find('.preview-block').css('display', 'flex').hide().fadeIn(500);
                    }
                })
            })

            $(document).on('click', '#preview-download', () => {
                makePDF();
            })

            $(document).on('click', '#preview-close', () => {
                $(document).find('.preview-block').fadeOut(500);
            })

            // Название загружаемого файла
            $(document).on('change', '#file-input', function() {
                $(document).find('#choose-file').html($(this)[0].files[0].name);
            })
        })
    </script>
</html>
<?php else: ?>
    <script>
        location.href="/assets/php/autorization/index.php";
    </script>
<?php endif; ?>