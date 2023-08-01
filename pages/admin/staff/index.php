<?php session_start(); ?>
<?php if($_SESSION['autorized'] == true && $_SESSION['role'] == 'admin'): ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Сотрудники</title>
        <link rel="stylesheet" href="/assets/css/style.css">
        <script src="/assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="/assets/js/script.js"></script>
        <script src="https://use.fontawesome.com/d55499613e.js"></script>
    </head>
    <body id="staff-body">
        <div class="wrapper-block">
            <input type="hidden" id="archive-input-exist" value="<?=$_SESSION['archiveStaff']; ?>">
            <div class="modal-block bg-block" id="modal-import">
                <div class="modal">
                    <!-- <iframe src="" name="iframe-import" frameborder="0" style="display: none;"></iframe> -->
                    <form class="import-form" method="POST"  enctype="multipart/form-data" id="form-import">
                        <input type="file" id="import-input" name="import-input" style="display: none;">
                        <label for="import-input" id="import-label" class="btn">
                            <span class="fa-span"><i id="fa-load" class="fa fa-solid fa-download"></i></span>
                            <span id="choose-file">Выберите файл</span>
                        </label>
                        <button type="submit" class="btn" name="import-submit">Импорт</button>
                    </form>
                </div>
            </div>
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
            <section class="section main-section">
                <div class="section-title section-title-border">
                    <div class="title-col left-col">
                        <div class="title-block">
                            <h1 class="section-title__title">Сотрудники</h1>
                        </div>
                        <div class="back-block">
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
                        <button class="tab-btn tab-btn-selected" id="now-tab">Действующие</button>
                        <button class="tab-btn" id="archive-tab">Архив</button>
                    </div>
                    <div class="btn-block">
                        <a href="/pages/admin/staff_new/index.php" class="btn">Добавить сотрудника</a>
                        <button class="btn" id="import-btn">Импортировать сотрудников</button>
                        <!-- <button class="btn" id="export-btn">Выгрузить сотрудников</button> -->
                    </div>
                </div>
                <div class="section-content section-content-students">
                    <div class="content" id="content">
                        <div class="title-search-block">
                            <div class="title-block">
                                <span class="" id="inner-title">asdf</span>
                            </div>
                            <!-- <div class="filter-block"> -->
                                <!-- <label for="status-select">Статус</label>
                                <select name="" id="status-select">
                                    <option value="" selected disabled>Выберите статус</option>
                                    <option value="1">Архив</option>
                                    <option value="0">Действующие</option>
                                    <option value="">Все</option>
                                </select> -->
                            <!-- </div> -->
                            <div class="search-block">
                                <input type="text" class="search-input" id="search-students" idGroup="<?=$idGroup; ?>" placeholder="Поиск по ФИО">
                                <button class="search-btn">
                                    <i class="fa fa-solid fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="table-block table-students">
                            <div class="table-body scroll-block" id="staff-table-body">

                            </div >
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </body>
    <script type="text/javascript">
        $(document).ready(() => {  
            const innerTitle = $(document).find('#inner-title');   
            let messageTimeout;
            let search;
            let confirm;
            let archive = $(document).find('#archive-input-exist');
            let actionDel;
            let contentHeight;
            let contentScroll;

            // Функция фильтра
            const filter = function filter(search, archive) {

                $.ajax({
                    url: '/assets/php/staff/filter.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        search : search,
                        archive : archive,
                        status : status
                    },
                    success: (res) => {
                        $(document).find('#staff-table-body').html(res);
                    }
                })
            }

            // Вывод сотрудников
            const staff = function staff(archive) {
                $.ajax({
                    url: '/assets/php/staff/staff.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        archive : archive
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
                modalConfirm = $(document).find('#modal-confirm');

            let status = searchInput.find('option:last-of-type').val();

            if(archive.val() == 0) {
                $(document).find('#now-tab').addClass('tab-btn-selected');
                $(document).find('#archive-tab').removeClass('tab-btn-selected');
                innerTitle.html('Действующие сотрудники');
            } else if(archive.val() == 1) {
                $(document).find('#archive-tab').addClass('tab-btn-selected');
                $(document).find('#now-tab').removeClass('tab-btn-selected');
                innerTitle.html('Сотрудники в архиве');
            } else {
                archive.val(0);
                $(document).find('#now-tab').addClass('tab-btn-selected');
                $(document).find('#archive-tab').removeClass('tab-btn-selected');
                innerTitle.html('Действующие сотрудники');
            }
            
            staff(archive.val());

            // Вкладка "Действующие"
            $(document).on('click', '#now-tab', function() {
                archive.val(0);
                $(this).addClass('tab-btn-selected');
                $(this).siblings('#archive-tab').removeClass('tab-btn-selected');
                innerTitle.html('Действующие сотрудники');
                search = searchInput.val();
                if(search == '' || search == undefined) {
                    staff(archive.val());
                } else {
                    filter(search, archive.val());
                }
            })

            // Вкладка "Архив"
            $(document).on('click', '#archive-tab', function() {
                archive.val(1);
                $(this).addClass('tab-btn-selected');
                $(this).siblings('#now-tab').removeClass('tab-btn-selected');
                innerTitle.html('Сотрудники в архиве');
                search = searchInput.val();
                if(search == '' || search == undefined) {
                    staff(archive.val());
                } else {
                    filter(search, archive.val());
                }
            })

            // Изменение статуса
            // $(document).on('change', '#status-select', function() {
            //     search = searchInput.val();
            //     filter(archive.val());
            // })

            // Поиск сотрудников
            $(document).on('input', '#search-students', function() {
                search = searchInput.val();
                filter(search, archive.val());
            })

            // Архивация сотрудника
            $(document).on('click', '#archivation-staff', function() {
                modalConfirm.find('#confirm-content').html('Вы точно хотите перенести сотрудника в архив?');
                modalConfirm.css('display', 'flex').hide().fadeIn(500);;
                confirm = $(this).siblings('.row-table').children('#id-staff').val();
                actionDel = 'archive';
            })

            // Удаление сотрудника
            $(document).on('click', '#del-staff', function() {
                modalConfirm.find('#confirm-content').html('Вы точно хотите безвозвратно удалить сотрудника из архива? Все микротравмы, связанные с данным сотрудником будут так же безвозвратно удалены');
                modalConfirm.css('display', 'flex').hide().fadeIn(500);;
                confirm = $(this).siblings('.row-table').children('#id-staff').val();
                actionDel = 'delete';
            })
            
            // Подтверждение удаления
            $(document).on('click', '#yes-btn', () => {
                modalConfirm.fadeOut(500);
                $.ajax({
                    url: '/assets/php/staff/staff_delete.php',
                    cache: false,
                    method: 'POST',
                    data: {
                        idStaff : confirm,
                        actionDel : actionDel
                    },
                    success: (res) => {
                        $(document).find('#success-content').html(res);

                        modalMessage.css('display', 'flex').hide().fadeIn(500);
                        if(search == '' || search == undefined) {
                            staff(archive.val());
                        } else {
                            filter(search, archive.val());
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

            // Смена стиля input['file']
            $(document).on('change', '#import-input', function() {
                if($(this)[0].files) {
                    $(document).find('#fa-load').removeClass('fa-download');
                    $(document).find('#fa-load').addClass('fa-check');
                    $(document).find('#choose-file').html($(this)[0].files[0].name);
                    $(document).find('#import-label').animate({
                        color: '#6de7ac'
                    }, 500);
                } else {
                    $(document).find('#fa-load').removeClass('fa-check');
                    $(document).find('#fa-load').removeClass('fa-download');
                    $(document).find('#import-label').css('background-color', '#7AFFBF');
                }
            })

            // Модальное окно импорта
            $(document).on('click', '#import-btn', () => {
                modalImport.fadeIn(500);
            })

            // Обработка закрытия модального окна импорта
            $(document).on('click', (e) => {
                if($(e.target).is('#modal-import .exit-btn') || $(e.target).is('.modal-block .exit-btn i')) {
                    modalImport.fadeOut(500);
                }
            })

            // Обработка импорта
            $(document).on('submit', '#form-import', () => {
                if($(document).find('#import-input')[0].files[0]) {
                    var fd = new FormData;
                    fd.append('file', $(document).find('#import-input')[0].files[0]);
                    $.ajax({
                        url: '/assets/php/staff/import_staff.php',
                        data: fd,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        success: function(data) {
                            $(document).find('#success-content').html(data);
                            modalMessage.css('display', 'flex').hide().fadeIn(500);
                            staff();
                            messageTimeout = setTimeout(() => {
                                modalMessage.fadeOut(500);
                            }, 3000);
                        }
                    })

                } else {
                    $(document).find('#success-content').html('Сперва выберите файл');
                    modalMessage.css('display', 'flex').hide().fadeIn(500);
                    messageTimeout = setTimeout(() => {
                        modalMessage.fadeOut(500);
                    }, 3000);

                }
                // if($(document).find('#import-input').val()) {
                   
                //     alert('Импорт успешно выполнен');
                // } else {
                //     alert('Сперва выберите файл');
                // }
                return false;
            })

            contentHeight = $(document).find('.section-content').outerHeight($(window).outerHeight() - $(document).find('.section-btns').outerHeight() - $(document).find('.section-title').outerHeight() - 76);
            
            contentScroll = $(document).find('#staff-table-body').outerHeight(contentHeight.outerHeight() - 80);
            $(document).find('.group-content').outerHeight(contentScroll.outerHeight() + $(document).find('.title-search-block').outerHeight() - 60);
        })
    </script>
</html>
<?php else: ?>
    <script>
        location.href="/assets/php/autorization/index.php";
    </script>
<?php endif; ?>