<?php session_start(); ?>
<?php if($_SESSION['autorized'] == true && $_SESSION['role'] == 'admin'): ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Микротравмы - архив</title>
        <link rel="stylesheet" href="/assets/css/style.css">
        <script src="/assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="/assets/js/script.js"></script>
        <script src="https://use.fontawesome.com/d55499613e.js"></script>
    </head>
    <body id="microtraumas-body" class="microtraumas-archive-body">
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
                    </div>
                    <div class="btn-block">
                        <button class="btn" id="ok-btn">ОК</button>
                    </div>
                </div>
            </div>
            <input type="hidden" id="tab-input" value="<?=$_SESSION['tab-microtr']; ?>">
            <section class="section main-section">
                <div class="section-title">
                    <div class="title-col left-col">
                        <div class="title-block">
                            <h1 class="section-title__title">Микротравмы - архив</h1>
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
                        
                    </div>
                </div>
                <div class="section-content">
                    <div class="students-content" id="students-content" status="">
                        <div class="section-sort" id="sort-students">
                            <div class="filter-block">
                                <div class="sort-block group-block">
                                    <label for="group-sort-input">Группа</label>
                                    <input type="text" id="group-sort-input" class="group-input" placeholder="Поиск">
                                </div>
                                <div class="sort-block date-block">
                                    <label for="date-sort-input">Дата</label>
                                    <input type="date" id="date-sort-input">
                                </div>
                            </div>
                            <div class="search-block">
                                <input type="text" class="search-input" id="search-microtraumas" placeholder="Поиск по ФИО">
                                <button class="search-btn">
                                    <i class="fa fa-solid fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="section-table">
                            <div class="table-microtr">
                                <div class="table-body">
                                    <fieldset class="table-archive-microtr scroll-block">
                                        <legend>Микротравмы студентов в архиве</legend>
                                        <div class="archive-microtr-body" id="archive-microtr-body">

                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="staff-content" id="staff-content" status="">
                        <div class="section-sort" id="sort-staff">
                            <div class="filter-block">
                                <div class="sort-block date-block">
                                    <label for="date-sort-input">Дата</label>
                                    <input type="date" id="date-sort-input">
                                </div>
                            </div>
                            <div class="search-block">
                                <input type="text" class="search-input" id="search-microtraumas" placeholder="Поиск по ФИО">
                                <button class="search-btn">
                                    <i class="fa fa-solid fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="section-table">
                            <div class="table-microtr">
                                <div class="table-body">
                                    <fieldset class="table-archive-microtr scroll-block">
                                        <legend>Микротравмы сотрудников в архиве</legend>
                                        <div class="archive-microtr-body" id="archive-microtr-body">

                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
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

            let tab = $(document).find('#tab-input');
            let search = false;
            let confirm;
            let actionDel;

            const students = function students() {
                let type;

                type = 'archive';
                // Вывод архивных микротравм студентов
                $.ajax({
                    url: '/assets/php/microtraumas/students_microtr_archive.php',
                    cache: false,
                    type: 'GET',
                    data: {
                        type : type
                    },
                    success: (res) => {
                        $(document).find('#students-content .archive-microtr-body').html(res);
                    }
                })
            }

            const staff = function staff() {
                let type;

                type = 'archive';
                // Вывод архивных микротравм работников
                $.ajax({
                    url: '/assets/php/microtraumas/staff_microtr_archive.php',
                    cache: false,
                    type: 'GET',
                    data: {
                        type : type
                    },
                    success: (res) => {
                        $(document).find('#staff-content .archive-microtr-body').html(res);
                    }
                })
            }

            const searchFunc = function searchFunc() {
                let 
                    searchInput,
                    groupInput,
                    dateInput,
                    action;
                if($(document).find('#students-tab').attr('class').split(' ').pop() == 'tab-btn-selected') { 
                    searchInput = $(document).find('#students-content #search-microtraumas');
                    groupInput = $(document).find('#students-content #group-sort-input');
                    dateInput = $(document).find('#students-content #date-sort-input');
                    // statusSelect = $(document).find('#students-content #status-select');
                    action = 'students';
                } else if($(document).find('#staff-tab').attr('class').split(' ').pop() == 'tab-btn-selected') {
                    searchInput = $(document).find('#staff-content #search-microtraumas');
                    dateInput = $(document).find('#staff-content #date-sort-input');
                    groupInput = $(document).find('#students-content #group-sort-input');
                    // statusSelect = $(document).find('#staff-content #status-select');
                    action = 'staff';
                }

                // Вывод архивных микротравм
                $.ajax({
                    url: '/assets/php/microtraumas/filter_archive.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        search : searchInput.val(),
                        group : groupInput.val(),
                        date : dateInput.val(),
                        // status : statusSelect.val()
                        action : action
                    },
                    success: (res) => {
                        if(action == 'students') {
                            $(document).find('#students-content .archive-microtr-body').html(res);
                        } else if(action == 'staff') {
                            $(document).find('#staff-content .archive-microtr-body').html(res);
                        }
                    }
                })
            }

            if(tab.val() == 'students') {
                $(document).find('#students-tab').addClass('tab-btn-selected');
                $(document).find('#staff-tab').removeClass('tab-btn-selected');
                $(document).find('#students-content').css('display', 'block');
                $(document).find('#staff-content').css('display', 'none');
                if(search == true) {
                    searchFunc();
                } else {
                    students();
                }
            } else if(tab.val() == 'staff') {
                $(document).find('#staff-tab').addClass('tab-btn-selected');
                $(document).find('#students-tab').removeClass('tab-btn-selected');
                $(document).find('#staff-content').css('display', 'block');
                $(document).find('#students-content').css('display', 'none');
                if(search == true) {
                    searchFunc();
                } else {
                    staff();
                }
            } else {
                tab.val('students');
                $(document).find('#students-tab').addClass('tab-btn-selected');
                $(document).find('#staff-tab').removeClass('tab-btn-selected');
                $(document).find('#students-content').css('display', 'block');
                $(document).find('#staff-content').css('display', 'none');
                students();
            }

            setInterval(() => {
                if(search == true) {
                    searchFunc();
                } else {
                    if(tab.val() == 'students') {
                        students();
                    } else if(tab.val() == 'staff') {
                        staff();
                    }
                }
            }, 5000);

            // Фильтрация

            // Обработка изменения всех инпутов
            $(document).on('input', 'input', () => {
                search = true;
                searchFunc();
            })

            $(document).on('click', '#students-tab', function() {
                tab.val('students');
                $(this).addClass('tab-btn-selected');
                $(this).siblings('#staff-tab').removeClass('tab-btn-selected');

                if(search == true) {
                    $(document).find('#staff-content').fadeOut(250);
                    setTimeout(() => {
                        $(document).find('#students-content').fadeIn(250);
                        
                    }, 250);
                    searchFunc();
                } else {
                    $(document).find('#staff-content').fadeOut(250);
                    setTimeout(() => {
                        $(document).find('#students-content').fadeIn(250);
                        
                    }, 250);
                    students();
                }
            })

            $(document).on('click', '#staff-tab', function() {
                tab.val('staff');
                $(this).addClass('tab-btn-selected');
                $(this).siblings('#students-tab').removeClass('tab-btn-selected');

                if(search == true) {
                    $(document).find('#staff-content').fadeOut(250);
                    $(document).find('#students-content').fadeOut(250);
                    setTimeout(() => {
                        $(document).find('#staff-content').fadeIn(250);
                        
                    }, 250);
                    searchFunc();
                } else {
                    $(document).find('#students-content').fadeOut(250);
                    setTimeout(() => {
                        $(document).find('#staff-content').fadeIn(250);
                        
                    }, 250);
                    staff();
                }
            })

            // Отправка в архив микротравмы
            $(document).on('click', '#archivation-microtr', function() {
                modalConfirm.find('#confirm-content').html('Вы точно хотите отправить микротравму в архив?');
                modalConfirm.css('display', 'flex').hide().fadeIn(500);
                confirm = $(this).siblings('.table-row').attr('href').split('=').pop();
                actionDel = 'archive';
            })

            // Удаление микротравмы
            $(document).on('click', '#del-microtr', function() {
                modalConfirm.find('#confirm-content').html('Вы точно хотите безвозвратно удалить микротравму из архива?');
                modalConfirm.css('display', 'flex').hide().fadeIn(500);
                confirm = $(this).siblings('.table-row').attr('href').split('=').pop();
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
                        if(tab.val() == 'students') {
                            if(search == true) {
                                searchFunc();
                            } else {
                                students();
                            }
                        } else if(tab.val() == 'staff') {
                            if(search == true) {
                                searchFunc();
                            } else {
                                staff();
                            }
                        }
                        messageTimeout = setTimeout(() => {
                            modalMessage.fadeOut(500);
                        }, 3000);
                    }
                })
            })

            // Отмена удаления
            $(document).on('click', '#no-btn', () => {
                modalConfirm.fadeOut(500);
            })

            $(document).on('click', '#close-confirm-btn', () => {
                modalConfirm.fadeOut(500);
            })

            // Закрытие окна сообщения
            $(document).on('click', '#close-message-btn', () => {
                clearTimeout(messageTimeout);
                modalMessage.fadeOut(500);
            })

            $(document).on('click', '#ok-btn', () => {
                clearTimeout(messageTimeout);
                modalMessage.fadeOut(500);
            })

            $(document).on('click', (e) => {
                if($(e.target).is('#modal-message')) {
                    clearTimeout(messageTimeout);
                    modalMessage.fadeOut(500);
                }
                if($(e.target).is('#modal-confirm')) {
                    modalConfirm.fadeOut(500);
                }
            })
        })
    </script>
</html>
<?php else: ?>
    <?php header('Location:/assets/php/autorization/index.php'); ?>
<?php endif; ?>