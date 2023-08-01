<?php 
    session_start(); 
    require_once('../../../assets/php/connect/logic.php');
?>
<?php if($_SESSION['autorized'] == true && $_SESSION['role'] == 'medicial'): ?>
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
            <!-- </div> -->
            <section class="section main-section">
                <div class="section-title">
                    <div class="title-col left-col">
                        <div class="title-block">
                            <h1 class="section-title__title">Оформление микротравмы</h1>
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
                            <span>Дата и время обращения</span>
                            <input type="datetime-local" id="date-app" value="">
                            <span class="error" id="date-app-error"></span>
                        </label>
                        <label for="">
                            <span>Установление повреждения здоровья</span>
                            <input type="text" id="trauma" value="">
                            <span class="error" id="trauma-error"></span>
                        </label>
                        <label for="">
                            <span>Обстоятельства</span>
                            <input type="text" id="circumstances" value="">
                        </label>
                    </div>
                    <div class="btn-block">
                        <button class="btn save-btn" id="save-btn">Отправить</button>
                    </div>
                </div>
            </section>
        </div>
    </body>
    <script>
        $(document).ready(() => {
            const 
                modalMessage = $(document).find('#modal-message'),
                modalConfirm = $(document).find('#modal-confirm');

            const 
                modalChoose = $(document).find('#modal-choose'),
                modal = modalChoose.find('.modal'),
                studentsBlock = modal.find('#students-content'),
                staffBlock = modal.find('#staff-content'),
                studentsBtn = modal.find('#students-btn'),
                staffBtn = modal.find('#staff-btn'),
                studentsContent = modal.find('#students-table'),
                staffContent = modal.find('#staff-table'),
                userInput = $(document).find('#fio-microtr');

            // Сохранение формы
            const saveEdit = function saveEdit(action) {
                let 
                    place = $(document).find('#place-microtr').val(),
                    dateMicr = $(document).find('#date-microtr').val(),
                    dateApp = $(document).find('#date-app').val(),
                    trauma = $(document).find('#trauma').val(),
                    circ = $(document).find('#circumstances').val(),
                    idUser = userInput.attr('idUser'),
                    typeUser = userInput.attr('typeUser');

                if(userInput.val() == '' || place == '' || dateMicr == '' || dateApp == '' || trauma == '') {
                    if(userInput.val() == '') {
                        $(document).find('#fio-error').html('Выберите пострадавшего');
                    }
                    if(place == '') {
                        $(document).find('#place-error').html('Заполните поле');
                    }
                    if(dateMicr == '') {
                        $(document).find('#date-microtr-error').html('Заполните поле');
                    }
                    if(dateApp == '') {
                        $(document).find('#date-app-error').html('Заполните поле');
                    }
                    if(trauma == '') {
                        $(document).find('#trauma-error').html('Заполните поле');
                    }

                } else {
                    $.ajax({
                        url: '/pages/medicial/main/handler.php',
                        cache: false,
                        method: 'POST',
                        data: {
                            place : place,
                            dateMicr : dateMicr,
                            dateApp : dateApp,
                            trauma : trauma,
                            circ : circ,
                            idUser : idUser,
                            typeUser : typeUser

                        },
                        success: (res) => {
                            $(document).find('#success-content').html(res);

                            modalMessage.css('display', 'flex').hide().fadeIn(500);
                            $(document).find('input').val('');

                            messageTimeout = setTimeout(() => {
                                modalMessage.fadeOut(500);
                            }, 3000);
                        }
                    })
                }
            }

            $(document).on('click', '#back-btn', function() {
                history.back();
            })

            // Модальное окно
            $(document).on('click', '#modal-btn', () => {
                modalChoose.fadeIn(500);

            })

            $(document).on('click', (e) => {
                if($(e.target).is('.modal-block')) {
                    modalChoose.fadeOut(500);
                }

                if($(e.target).is('.modal-block .exit-btn') || $(e.target).is('.modal-block .exit-btn i')) {
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

            $(document).on('click', '#save-btn', () => {
                saveEdit();
            })
        })
    </script>
</html>
<?php else: ?>
    <?php header('Location:/assets/php/autorization/index.php'); ?>
<?php endif; ?>