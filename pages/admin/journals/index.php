<?php session_start(); ?>
<?php if($_SESSION['autorized'] == true && $_SESSION['role'] == 'admin'): ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Журналы учета микротравм</title>
        <link rel="stylesheet" href="/assets/css/style.css">
        <script src="/assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="/assets/js/script.js"></script>
        <script src="https://use.fontawesome.com/d55499613e.js"></script>
    </head>
    <body id="journals-body">
        <div class="wrapper-block">
            <input type="hidden" id="tab-input" value="<?=$_SESSION['journal']; ?>">
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
                    </div>
                    <div class="btn-block">
                        <button class="btn" id="ok-btn">ОК</button>
                    </div>
                </div>
            </div>
            <div class="modal-message-block bg-block" id="modal-choose">
                <div class="modal-message">
                    <button class="exit-btn" id="close-choose-btn">
                        <i class="fa fa-close"></i>
                    </button>
                    <div class="form-block">
                        <div class="title-block">
                            <span>Внимание</span>
                        </div>
                        <div class="modal-message-content" id="choose-content">
                            Журнал учета чьих микротравм вы хотите создать?
                        </div>
                    </div>
                    <div class="btn-block">
                        <button class="btn choose-btn" id="students">Студенты</button>
                        <button class="btn choose-btn" id="staff">Сотрудники</button>
                    </div>
                </div>
            </div>
            <section class="section main-section">
                <div class="section-title section-title-border">
                    <div class="title-col left-col">
                        <div class="title-block">
                            <h1 class="section-title__title">Журналы учета микротравм</h1>
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
                    <div class="nav-block">
                        <button class="tab-btn tab-btn-selected" id="students-tab">Студенты</button>
                        <button class="tab-btn" id="staff-tab">Работники</button>
                    </div>
                    <div class="btn-block">
                        <button id="new-journal-btn" class="btn">Начать вести новый журнал</button>
                    </div>
                </div>
                <div class="section-content section-content-students">
                    <div class="content" id="content">
                        <div class="tab-content" id="tab-students">
                            <div class="title-block">
                                <span class="title">Журналы учета микротравм студентов</span>
                            </div>
                            <div class="students-content" id="students-content">

                            </div>
                        </div>
                        <div class="tab-content" id="tab-staff">
                            <div class="title-block">
                                <span class="title">Журналы учета микротравм сотрудников</span>
                            </div>
                            <div class="staff-content" id="staff-content">

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </body>
    <script type="text/javascript">
        $(document).ready(() => { 
            let tab = $(document).find('#tab-input');
            let messageTimeout;

            const students = function students() {
                $.ajax({
                    url: '/assets/php/journals/journals_students.php',
                    cache: false,
                    method: 'GET',
                    success: (res) => {
                        $(document).find('#students-content').html(res);
                    }
                })
            }

            const staff = function staff() {

                $.ajax({
                    url: '/assets/php/journals/journals_staff.php',
                    cache: false,
                    method: 'GET',
                    success: (res) => {
                        $(document).find('#staff-content').html(res);
                    }
                })
            }

            if(tab.val() == '') {
                tab.val('students');
                $(document).find('#tab-staff').fadeOut(500);
                students();
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

            // Функция фильтра
            const filter = function filter() {
                search = searchInput.val();
                status = statusSelect.val();

                $.ajax({
                    url: '/assets/php/staff/filter.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        search : search,
                        status : status
                    },
                    success: (res) => {
                        $(document).find('#staff-table-body').html(res);
                    }
                })
            }

            const 
                modalImport = $(document).find('#modal-import'),
                modal = modalImport.find('.modal'),
                statusSelect = $(document).find('#status-select'),
                searchInput = $(document).find('#search-students'),
                modalMessage = $(document).find('#modal-message'),
                modalConfirm = $(document).find('#modal-confirm'),
                modalChoose = $(document).find('#modal-choose');

            let search;
            let confirm;
            let status = searchInput.find('option:last-of-type').val();
            let typeChoose;

            if(tab.val() == 'students') {
                $(document).find('#students-tab').addClass('tab-btn-selected');
                $(document).find('#staff-tab').removeClass('tab-btn-selected');
                $(document).find('#tab-students').css('display', 'block');
                $(document).find('#tab-staff').css('display', 'none');
                students();
            } else if(tab.val() == 'staff') {
                $(document).find('#staff-tab').addClass('tab-btn-selected');
                $(document).find('#students-tab').removeClass('tab-btn-selected');
                $(document).find('#tab-staff').css('display', 'block');
                $(document).find('#tab-students').css('display', 'none');
                staff();
            }

            setInterval(() => {
                if(tab.val() == 'students') {
                    students();
                } else if(tab.val() == 'staff') {
                    staff();
                }
            }, 5000);

            $(document).on('click', '#new-journal-btn', () => {
                modalChoose.css('display', 'flex').hide().fadeIn('500');
            })

            $(document).on('click', '.choose-btn', function() {
                let typeChoose = $(this).attr('id');
                $.ajax({
                    url: '/assets/php/journals/new_journal.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        type : typeChoose
                    },
                    success: (res) => {
                        $(document).find('#success-content').html(res);

                        if(tab.val() == 'students') {
                            $(document).find('#students-tab').addClass('tab-btn-selected');
                            $(document).find('#staff-tab').removeClass('tab-btn-selected');
                            $(document).find('#tab-students').css('display', 'block');
                            $(document).find('#tab-staff').fadeOut(500);
                        } else if(tab.val() == 'staff') {
                            $(document).find('#staff-tab').addClass('tab-btn-selected');
                            $(document).find('#students-tab').removeClass('tab-btn-selected');
                            $(document).find('#tab-staff').css('display', 'block');
                            $(document).find('#tab-students').fadeOut(500);
                        }

                        modalChoose.fadeOut(500);

                        modalMessage.css('display', 'flex').hide().fadeIn(500);
                        if(tab.val() == 'students') {
                            students();
                        } else if(tab.val() == 'staff') {
                            staff();
                        }
                        messageTimeout = setTimeout(() => {
                            modalMessage.fadeOut(500);
                        }, 3000);
                    }
                })
                // modalChoose.css('display', 'flex').hide().fadeIn(500);
            })

            $(document).on('click', (e) => {
                if($(e.target).is('#modal-choose')) {
                    modalChoose.fadeOut(500);
                }

                if($(e.target).is('#modal-choose .exit-btn') || $(e.target).is('#modal-choose .exit-btn i')) {
                    modalChoose.fadeOut(500);
                }
            })

            // Вкладка "Студенты"
            $(document).on('click', '#students-tab', function() {
                tab.val('students');
                $(this).addClass('tab-btn-selected');
                $(this).siblings('#staff-tab').removeClass('tab-btn-selected');

                $(document).find('#tab-staff').fadeOut(250);
                setTimeout(() => {
                    $(document).find('#tab-students').fadeIn(250);
                }, 250);

                students();
            })

            // Вкладка "Сотрудники"
            $(document).on('click', '#staff-tab', function() {
                tab.val('staff');
                $(this).addClass('tab-btn-selected');
                $(this).siblings('#students-tab').removeClass('tab-btn-selected');

                $(document).find('#tab-students').fadeOut(250);
                setTimeout(() => {
                    $(document).find('#tab-staff').fadeIn(250);
                }, 250);

                staff();
            })

            // Удаление сотрудника
            $(document).on('click', '#del-staff', function() {
                modalConfirm.find('#confirm-content').html('Вы точно хотите перенести сотрудника в архив?');
                modalConfirm.css('display', 'flex').hide().fadeIn(500);
                confirm = $(this).siblings('.row-table').children('#id-staff').val();
            })

            // Отмена удаления
            $(document).on('click', '#no-btn', () => {
                modalConfirm.fadeOut(500);
            })

            $(document).on('click', '#close-confirm-btn', () => {
                modalConfirm.fadeOut(500);
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
                if($(e.target).is('#modal-confirm')) {
                    modalConfirm.fadeOut(500);
                }
                if($(e.target).is('#modal-message')) {
                    clearTimeout(messageTimeout);
                    modalMessage.fadeOut(500);
                }
                if($(e.target).is('#modal-import')) {
                    modalImport.fadeOut(500);
                }
            })
        })
    </script>
</html>
<?php else: ?>
    <script>
        location.href="/assets/php/autorization/index.php";
    </script>
<?php endif; ?>