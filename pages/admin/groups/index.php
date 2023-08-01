<?php session_start(); ?>
<?php require_once('../../../assets/php/connect/logic.php'); ?>
<?php if($_SESSION['autorized'] == true && $_SESSION['role'] == 'admin'): ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Группы</title>
        <link rel="stylesheet" href="/assets/css/style.css">
        <script src="/assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="/assets/js/script.js"></script>
        <script src="https://use.fontawesome.com/d55499613e.js"></script>
        <link rel="stylesheet" href="/assets/css/fontawesome-free-6.1.1-web/js/all.js">
    </head>
    <body id="groups-body">
        <div class="wrapper-block">
            <div class="modal-block bg-block">
                <div class="modal">
                    <button class="exit-btn" id="close-add">
                        <i class="fa fa-close"></i>
                    </button>
                    <div class="form-block">
                        <div class="title-block">
                            <span>Добавление группы</span>
                        </div>
                        <div class="data-block">
                            <label for="">
                                Название
                                <input type="text" id="title-group">
                                <span class="error" id="error-title"></span>
                            </label>
                            <label for="">
                                Курс
                                <input type="number" id="course-group">
                                <span class="error" id="error-course"></span>
                            </label>
                            <label for="">
                                Специальность
                                <select name="" id="spec-group">
                                    <option value="0" selected disabled>Выберите специальность</option>
                                    <?php foreach($specializations_line as $line): ?>
                                        <option value="<?=$line['id_specialization']; ?>"><?=$line['title_specialization']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="error" id="error-spec"></span>
                            </label>
                            <label for="">
                                Староста
                                <input type="text" id="elder-group">
                                <span class="error" id="error-elder"></span>
                            </label>
                            <label for="">
                                Последний курс (например, у серии групп ИС последней группой является ИС-41, то есть 4 курс)
                                <input type="number" id="course-max">
                                <span class="error" id="error-course-max"></span>
                            </label>
                        </div>
                        <div class="btn-block">
                            <button class="btn" id="group-add">Добавить</button>
                        </div>
                    </div>
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
                            <h1 class="section-title__title">Группы</h1>
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
                    <div class="btn-block">
                        <button class="btn" id="add-btn">Добавить группу</button>
                        <a href="/pages/admin/specializations/index.php" class="btn">Специальности</a>
                        <!-- <button class="btn" id="transfer-btn">Перевести всех студентов на следующий курс</button> -->
                    </div>
                    <div class="search-block">
                        <input type="text" class="search-input" id="search-groups" placeholder="Поиск по названию">
                        <button class="search-btn">
                            <i class="fa fa-solid fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="section-content section-content-groups">
                    <div class="content-groups-block">
                        <fieldset>
                            <legend>Группы</legend>
                            <div id="groups-content">

                            </div>
                            
                        </fieldset>
                    </div>
                </div>
            </section>
        </div>
    </body>
    <script type="text/javascript">
        $(document).ready(() => {
            let idGroup;
            let messageTimeout;
            let confirm;
            let transfer;

            // Вывод групп
            const groups = function groups() {
                $.ajax({
                    url: '/assets/php/groups/groups.php',
                    cache: false,
                    success: (res) => {
                        $(document).find('#groups-content').html(res);
                    }
                })
            }

            // Поиск групп
            const filterGroups = function filterGroups() {
                search = searchInput.val();

                $.ajax({
                    url: '/assets/php/groups/filter.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        search : search
                    },
                    success: (res) => {
                        $(document).find('#groups-content').html(res);
                    }
                })
            }

            const 
                searchInput = $(document).find('#search-groups'),
                modal = $(document).find('.modal-block'),
                titleGroup = modal.find('#title-group'),
                courseGroup = modal.find('#course-group'),
                specGroup = modal.find('#spec-group'),
                elderGroup = modal.find('#elder-group'),
                maxCourse = modal.find('#course-max'),
                modalMessage = $(document).find('#modal-message'),
                modalConfirm = $(document).find('#modal-confirm');

            groups();

            // Поиск групп
            $(document).on('input', '#search-groups', function() {
                filterGroups();
            })

            // Поиск групп по кнопке
            $(document).on('click', '.search-btn', () => {
                filterGroups();
            })

            //  Удаление группы
            $(document).on('click', '#del-group', function() {
                action = 'delete';
                if(action == 'delete') {
                    modalConfirm.find('#confirm-content').html('Вы точно хотите безвозвратно удалить группу? Все студенты, находящиеся в данной группе, будут перенесены в архив');
                    modalConfirm.css('display', 'flex').hide().fadeIn(500);
                    confirm = $(this).siblings('.row-table').attr('id');
                }
            })

            // Подтверждение операции
            $(document).on('click', '#yes-btn', () => {
                if(action == 'delete') {
                    modalConfirm.fadeOut(500);
                    $.ajax({
                        url: '/assets/php/groups/group_delete.php',
                        cache: false,
                        method: 'GET',
                        data: {
                            idGroup : confirm
                        },
                        success: (res) => {
                            $(document).find('#success-content').html(res);

                            modalMessage.css('display', 'flex').hide().fadeIn(500);
                            if(searchInput.val() != '') {
                                filterGroups();
                            } else {
                                groups();
                            }
                            messageTimeout = setTimeout(() => {
                                modalMessage.fadeOut(500);
                            }, 3000);
                        }
                    })
                } else if(action == 'transfer') {
                    $.ajax({
                        url: '/assets/php/groups/students_transfer.php',
                        cache: false,
                        method: 'GET',
                        success: (res) => {
                            $(document).find('#success-content').html(res);
                            modalConfirm.fadeOut(500);
                            modalMessage.css('display', 'flex').hide().fadeIn(500);
                            
                            messageTimeout = setTimeout(() => {
                                modalMessage.fadeOut(500);
                            }, 3000);
                        }
                    })
                }
                
            })

            // Модальное окно добавления
            $(document).on('click', '#add-btn', () => {
                modal.css('display', 'flex').hide().fadeIn(500);
            })

            // Закрытие модального окна добавления
            $(document).on('click', function(e) {
                if($(e.target).is('.bg-block')) {
                    modal.fadeOut(500);
                }
            })

            $(document).on('click', '#close-add', () => {
                modal.fadeOut();
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

            // Добавление группы
            $(document).on('click', '#group-add', () => {
                if(!titleGroup.val()) {
                    modal.find('#error-title').html('Введите название');
                }  
                if(!courseGroup.val()) {
                    modal.find('#error-course').html('Введите курс');
                }
                if(!specGroup.val()) {
                    modal.find('#error-spec').html('Выберите специальность');
                }
                if(!maxCourse.val()) {
                    modal.find('#error-course-max').html('Введите последний курс');
                }

                if(titleGroup.val() && courseGroup.val() && specGroup.val() && maxCourse.val()) {
                    $.ajax({
                        url: '/assets/php/groups/add_group.php',
                        cache: false,
                        method: 'GET',
                        data: {
                            titleGroup : titleGroup.val(),
                            courseGroup : courseGroup.val(),
                            specGroup : specGroup.val(),
                            elderGroup : elderGroup.val(),
                            maxCourse : maxCourse.val()
                        },
                        success: (res) => {
                            $(document).find('#success-content').html(res);

                            titleGroup.val('');
                            courseGroup.val('');
                            specGroup.find('option').prop('selected', false);
                            specGroup.find('option:first-of-type').prop('selected', true);
                            elderGroup.val('');
                            modal.fadeOut();

                            modalMessage.css('display', 'flex').hide().fadeIn(500);
                        
                            if(searchInput.val() != '') {
                                filterGroups();
                            } else {
                                groups();
                            }

                            messageTimeout = setTimeout(() => {
                                modalMessage.fadeOut(500);
                            }, 3000);

                            
                        }
                    })
                }
            })

            // Перевод на следующий курс
            $(document).on('click', '#transfer-btn', () => {
                action = 'transfer';

                if(action == 'transfer') {
                    modalConfirm.find('#confirm-content').html('Вы точно хотите совершить перевод всех студентов на следующий курс? Обратить данную операцию будет нельзя');
                    modalConfirm.css('display', 'flex').hide().fadeIn(500);
                }
                
                // if(confirm('Вы точно хотите перевести всех студентов на следующий курс?')) {
                //     $.ajax({
                //         url: '/assets/php/groups/students_transfer.php',
                //         cache: false,
                //         method: 'GET',
                //         success: (res) => {
                //             alert(res);
                //         }
                //     })
                // }
            })
        })
    </script>
</html>
<?php else: ?>
    <script>
        location.href="/assets/php/autorization/index.php";
    </script>
<?php endif; ?>