<?php session_start(); ?>
<?php if($_SESSION['autorized'] == true && $_SESSION['role'] == 'admin'): ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Студенты</title>
        <link rel="stylesheet" href="/assets/css/style.css">
        <script src="/assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="/assets/js/script.js"></script>
        <script src="https://use.fontawesome.com/d55499613e.js"></script>
    </head>
    <body id="students-body">
        <div class="wrapper-block">
            <input type="hidden" id="tab-students" value="<?=$_SESSION['tab-students']; ?>">
            <input type="hidden" id="group-input-exist" value="<?=$_SESSION['idGroup']; ?>">
            <input type="hidden" id="archive-input-exist" value="<?=$_SESSION['archiveStudents']; ?>">
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
                            <h1 class="section-title__title">Студенты</h1>
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
                        <a href="/pages/admin/student_new/index.php" class="btn">Добавить студента</a>
                        <button class="btn" id="import-btn">Импортировать студентов</button>
                        <!-- <button class="btn" id="export-btn">Выгрузить студентов</button> -->
                    </div>
                </div>
                <div class="section-content section-content-students">
                    <div class="group-col menu-col">
                        <div class="groups-block menu-block" id="groups-block">
                            
                        </div>
                    </div>
                    <div class="content-col">
                        <div class="content" id="content">
                            
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </body>
    <script type="text/javascript">
        $(document).ready(() => {
            const 
                groupsBlock = $(document).find('#groups-block'),
                modalImport = $(document).find('#modal-import'),
                modal = modalImport.find('.modal'),
                modalMessage = $(document).find('#modal-message'),
                modalConfirm = $(document).find('#modal-confirm');
                

            let idGroup = $(document).find('#group-input-exist').val();
            let archive = $(document).find('#archive-input-exist');
            // let tab = $(document).find('#tab-students');
            let messageTimeout;
            let confirm;
            let searchStud;
            let searchGroup;
            let actionDel;
            let contentHeight;
            let contentScroll;

            // Поиск студентов
            const searchStudents = function searchStudents(idGroup, archive, search) {
                // archive = $(this).attr('archive');

                $.ajax({
                    url: '/assets/php/students/filter.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        idGroup : idGroup,
                        search : search,
                        archive : archive,
                        action : 'searchStudents'
                    },
                    success: (res) => {
                        $(document).find('#students-table-body').html(res);

                        $(document).find('#search-students').val(search);
                    }
                })
            }

            // Поиск групп
            const searchGroups = function searchGroups(search) {
                $.ajax({
                    url: '/assets/php/students/filter.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        search : search,
                        action : 'searchGroups'
                    },
                    success: (res) => {
                        $(document).find('#group-content').html(res);

                        $(document).find('.group-btn').removeClass('selected');
                        $(document).find('.group-btn[idGroup="' + idGroup + '"]').addClass('selected');
                        $(document).find('#search-groups').val(search);
                        // $(document).find('.menu-col').outerHeight($(window).outerHeight() - $(document).find('.section-title').outerHeight() - $(document).find('.section-btns').outerHeight() - ($(document).find('.section').outerHeight() - $(document).find('.section').height()) - 72);
                    }
                })
            }

            // Вывод групп
            const groups = function groups(idGroup, archive) {
                $.ajax({
                    url: '/assets/php/students/groups.php',
                    cache: false,
                    method: 'GET',
                    success: (res) => {
                        $(document).find('#groups-block').html(res);

                        if(idGroup == '') {
                            $(document).find('#content').html('<span class="start-span">Выберите группу</span>');
                            
                        } else {
                            if(searchStud == undefined || searchStud == '') {
                                studentsGroups(idGroup, archive);
                            } else {
                                studentsGroups(idGroup, archive);
                                searchStudents(idGroup, archive, searchStud);
                            }
                            
                        }

                        $(document).find('.group-content').outerHeight($(window).height() - $(document).find('.section-btns').outerHeight() - $(document).find('.section-title').outerHeight() - 145);
                    }
                })
            }

            // Вывод студентов при нажатии на группу
            const studentsGroups = function studentsGroups(idGroup, archive) {
                $(document).find('.group-btn').removeClass('selected');
                $(document).find('.group-btn[idGroup="' + idGroup + '"]').addClass('selected');
                $.ajax({
                    url: '/assets/php/students/students.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        idGroup : idGroup,
                        archive : archive
                    },
                    success: (res) => {
                        $(document).find('#content').html(res);
                        // groupsBlock.outerHeight($(document).outerHeight() - $(document).find('.section-title').outerHeight() - $(document).find('.section-btns').outerHeight() - ($(document).find('.section').outerHeight() - $(document).find('.section').height()));

                        searchStud = '';
                        // if(searchStud != undefined && searchStud != '') {
                        //     searchStudents(idGroup, archive, searchStud);
                        // } 
                        // $(document).find('.content-col').outerHeight($(window).height() - $(document).find('.title-search-block').outerHeight() - $(document).find('.btn-block').outerHeight() - $(document).find('.section-title').outerHeight() - ($(document).find('.section').outerHeight() - $(document).find('.section').height()));
                        contentHeight = $(document).find('.section-content').outerHeight($(window).outerHeight() - $(document).find('.section-btns').outerHeight() - $(document).find('.section-title').outerHeight() - 56);
                        contentScroll = $(document).find('#students-table-body').outerHeight(contentHeight.outerHeight() - 80);
                        // $(document).find('.group-content').outerHeight(contentScroll.outerHeight() + $(document).find('.title-search-block').outerHeight() - 60);
                    }
                })
            }

            if(archive.val() == 0) {
                $(document).find('#now-tab').addClass('tab-btn-selected');
                $(document).find('#archive-tab').removeClass('tab-btn-selected');
            } else if(archive.val() == 1) {
                $(document).find('#archive-tab').addClass('tab-btn-selected');
                $(document).find('#now-tab').removeClass('tab-btn-selected');
            } else {
                archive.val(0);
                $(document).find('#now-tab').addClass('tab-btn-selected');
                $(document).find('#archive-tab').removeClass('tab-btn-selected');
            }
            
            groups(idGroup, archive.val());
            
            
            $(document).on('click', '.group-btn', function(e) {
                idGroup = $(this).attr('idGroup');
                // archive = $(this).attr('archive');
                studentsGroups(idGroup, archive.val());
            })

            // Поиск студентов
            $(document).on('input', '#search-students', function() {
                idGroup = $(this).attr('idGroup');
                searchStud = $(this).val();
                searchStudents(idGroup, archive.val(), searchStud);
            })
            
            // Поиск групп
            $(document).on('input', '#search-groups', function() {
                searchGroup = $(this).val();
                searchGroups(searchGroup);
            })

            $(document).find('.wrapper-block').outerHeight($(window).height());
            // $(document).find('.menu-col').outerHeight($(window).outerHeight() - $(document).find('.section-title').outerHeight() - $(document).find('.section-btns').outerHeight() - ($(document).find('.section').outerHeight() - $(document).find('.section').height()) - 72);

            // Вкладка "Действующие"
            $(document).on('click', '#now-tab', function() {
                searchStud = $(document).find('#search-students').val();
                archive.val(0);
                $(this).addClass('tab-btn-selected');
                $(this).siblings('#archive-tab').removeClass('tab-btn-selected');
                if($(document).find('#search-groups').val() == '' || $(document).find('#search-groups').val() == undefined) {
                    groups(idGroup, archive.val());
                } else {
                    searchGroups(searchGroup);
                }

                if(searchStud == undefined || searchStud == '') {
                    studentsGroups(idGroup, archive.val());
                } else {
                    // studentsGroups(idGroup, archive.val());
                    searchStudents(idGroup, archive.val(), searchStud);
                }
                
            })

            // Вкладка "Архив"
            $(document).on('click', '#archive-tab', function() {
                searchStud = $(document).find('#search-students').val();
                archive.val(1);
                $(this).addClass('tab-btn-selected');
                $(this).siblings('#now-tab').removeClass('tab-btn-selected');
                if($(document).find('#search-groups').val() == '' || $(document).find('#search-groups').val() == undefined) {
                    groups(idGroup, archive.val());
                } else {
                    searchGroups(searchGroup);
                }

                if(searchStud == undefined || searchStud == '') {
                    studentsGroups(idGroup, archive.val());
                } else {
                    // studentsGroups(idGroup, archive.val());
                    searchStudents(idGroup, archive.val(), searchStud);
                }
            })

            //  Удаление студента
            $(document).on('click', '#del-student', function() {
                modalConfirm.find('#confirm-content').html('Вы точно хотите безвозвратно удалить студента из архива? Все микротравмы, связанные с данным студентом будут так же безвозвратно удалены');
                modalConfirm.css('display', 'flex').hide().fadeIn(500);
                confirm = $(this).siblings('.row-table').children('#id-student').val();
                actionDel = 'delete';
                // if(confirm('Вы точно хотите удалить студента?')) {
                //     $.ajax({
                //         url: '/assets/php/students/student_delete.php',
                //         cache: false,
                //         method: 'POST',
                //         data: {
                //             idStudent : $(this).siblings('.row-table').children('#id-student').val(),
                //             idGroup : idGroup
                //         },
                //         success: (res) => {
                //             $(document).find('#content').html(res);
                //         }
                //     })
                // }
            })

            //  Архивация студента
            $(document).on('click', '#archivation-student', function() {
                modalConfirm.find('#confirm-content').html('Вы точно хотите отправить студента в архив?');
                modalConfirm.css('display', 'flex').hide().fadeIn(500);
                confirm = $(this).siblings('.row-table').children('#id-student').val();
                actionDel = 'archive';
                // if(confirm('Вы точно хотите удалить студента?')) {
                //     $.ajax({
                //         url: '/assets/php/students/student_delete.php',
                //         cache: false,
                //         method: 'POST',
                //         data: {
                //             idStudent : $(this).siblings('.row-table').children('#id-student').val(),
                //             idGroup : idGroup
                //         },
                //         success: (res) => {
                //             $(document).find('#content').html(res);
                //         }
                //     })
                // }
            })

            // Подтверждение удаления
            $(document).on('click', '#yes-btn', () => {
                modalConfirm.fadeOut(500);
                $.ajax({
                    url: '/assets/php/students/student_delete.php',
                    cache: false,
                    method: 'POST',
                    data: {
                        idStudent : confirm,
                        actionDel : actionDel
                    },
                    success: (res) => {
                        $(document).find('#success-content').html(res);

                        modalMessage.css('display', 'flex').hide().fadeIn(500);
                        studentsGroups(idGroup, archive.val());
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

            // Модальное окно
            $(document).on('click', '#import-btn', () => {
                modalImport.fadeIn(500);
            })

            // Обработка закрытия модального окна импорта
            $(document).on('click', (e) => {
                if($(e.target).is('.modal-block .exit-btn') || $(e.target).is('.modal-block .exit-btn i')) {
                    modalImport.fadeOut(500);
                }
            })

            // Обработка импорта
            $(document).on('submit', '#form-import', () => {
                if($(document).find('#import-input')[0].files[0]) {
                    
                    var fd = new FormData;
                    fd.append('file', $(document).find('#import-input')[0].files[0]);
                    $.ajax({
                        url: '/assets/php/students/import_students.php',
                        data: fd,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        success: function(data) {
                            $(document).find('#success-content').html(data);
                            studentsGroups(idGroup, archive.val());

                            modalMessage.css('display', 'flex').hide().fadeIn(500);
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
                return false;
            })
        })
    </script>
</html>
<?php else: ?>
    <script>
        location.href="/assets/php/autorization/index.php";
    </script>
<?php endif; ?>