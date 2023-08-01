<?php session_start(); ?>
<?php require_once('../../../assets/php/connect/logic.php') ?>
<?php if($_SESSION['autorized'] == true && $_SESSION['role'] == 'admin'): ?>
<?php
    $sqlGroup = "SELECT * FROM `groups` INNER JOIN `specializations` ON `groups`.`id_specialization` = `specializations`.`id_specialization` WHERE `id_group` = ?";
    $resGroup = $pdo -> prepare($sqlGroup);
    $resGroup -> execute(array($_GET['idGroup']));
    $groupLine = $resGroup -> fetch();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Специальности</title>
        <link rel="stylesheet" href="/assets/css/style.css">
        <script src="/assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="/assets/js/script.js"></script>
        <script src="https://use.fontawesome.com/d55499613e.js"></script>
    </head>
    <body id="spec-body">
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
            <div class="modal-message-block bg-block" id="modal-new">
                <div class="modal-message">
                    <button class="exit-btn" id="close-new-btn">
                        <i class="fa fa-close"></i>
                    </button>
                    <div class="form-block">
                        <div class="title-block">
                            <span>Добавление специальности</span>
                        </div>
                        <div class="modal-message-content" id="modal-new-content">
                            <div class="parameters-block">
                                <div class="parameter-row">
                                    <label for="spec-title-input">Название</label>
                                    <textarea type="text" rows="4" id="new-spec-title-input" placeholder="Название специальности"><?=$spec_line['title_specialization']; ?></textarea>
                                    <span class="error" id="error-title"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-block">
                        <button class="btn" id="new-btn">Добавить</button>
                    </div>
                </div>
            </div>
            <section class="section main-section">
                <div class="section-title">
                    <div class="title-col left-col">
                        <div class="title-block">
                            <h1 class="section-title__title">Специальности</h1>
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
                <div class="section-content section-content-specs">
                    <div class="content-block" id="content-block">
                        <fieldset class="fieldset-parameters">
                            <legend>Параметры</legend>
                            <div class="parameters-body" id="parameters-body">
                                <span class="error">Выберите специальность</span>
                            </div>
                        </fieldset>
                        <fieldset class="fieldset-specs scroll-block">
                            <legend>
                                <span>Все специальности</span>
                                <button class="spec-add-btn" id="add-spec-btn">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </legend>
                            <div class="table-body ">
                                
                            </div>
                        </fieldset>
                    </div>
                </div>
            </section>
        </div>
    </body>
    <script type="text/javascript">
        $(document).ready(() => {
            let specID;
            let count = 0;
            let messageTimeout;
            let confirm;

            const 
                modalMessage = $(document).find('#modal-message'),
                modalConfirm = $(document).find('#modal-confirm'),
                modalNew = $(document).find('#modal-new');

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
            let idGroup = getUrlParameter('idGroup');

            // Вывод специальностей
            const specs = function specs() {
                $.ajax({
                    url: '/assets/php/specializations/specializations.php',
                    cache: false,
                    method: 'GET',
                    success: (res) => {
                        $(document).find('.table-body').html(res);
                    }
                })
            }
            specs();

            // $(document).find('#content-block').outerHeight($(document).outerHeight() - ($(document).find('.section').outerHeight() - $(document).find('.section').height()) - $(document).find('.section-title').height() - 42);

            // Сохранение специальности
            $(document).on('click', '#spec-save', () => {
                $.ajax({
                    url: '/assets/php/specializations/spec_save.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        title : $(document).find('#spec-title-input').val(),
                        idSpec : specID,
                    },
                    success: (res) => {
                        $(document).find('#success-content').html(res);

                        modalMessage.css('display', 'flex').hide().fadeIn(500);
                        specs();
                        messageTimeout = setTimeout(() => {
                            modalMessage.fadeOut(500);
                        }, 3000);
                    }
                })
            })

            // Удаление специальности
            $(document).on('click', '#del-spec', function() {
                modalConfirm.find('#confirm-content').html('Вы точно хотите удалить данную специальность?');
                modalConfirm.css('display', 'flex').hide().fadeIn(500);
                confirm = $(this).siblings('.row-table').attr('id');
            })

            // Подтверждение удаления
            $(document).on('click', '#yes-btn', () => {
                modalConfirm.fadeOut(500);
                $.ajax({
                    url: '/assets/php/specializations/spec_delete.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        idSpec : confirm
                    },
                    success: (res) => {
                        $(document).find('#success-content').html(res);

                        modalMessage.css('display', 'flex').hide().fadeIn(500);
                        specs();
                        messageTimeout = setTimeout(() => {
                            modalMessage.fadeOut(500);
                        }, 3000);
                    }
                })

            })

            // Выбор специальности
            $(document).on('click', '.spec-btn', function() {
                specID = $(this).attr('id');
                $(document).find('.spec-btn').css('background-color', '#e7e7e7');
                $(this).css('background-color', '#DCDCDC');

                $.ajax({
                    url: '/assets/php/specializations/parameters.php',
                    type: 'GET',
                    cache: false,
                    data: {
                        idSpec : specID
                    },
                    success: (res) => {
                        $(document).find('#parameters-body').html(res);
                    }
                })
            })

            // Добавление специальности
            $(document).on('click', '#add-spec-btn', function() {
                modalNew.css('display', 'flex').hide().fadeIn(500);
            })

            $(document).on('input', '#new-spec-title-input', function() {
                modalNew.find('#error-title').html('');
            })

            // Подтверждение добавления
            $(document).on('click', '#new-btn', function() {
                if(modalNew.find('#new-spec-title-input').val() != '') {
                    $.ajax({
                        url: '/assets/php/specializations/spec_new.php',
                        type: 'GET',
                        cache: false,
                        data: {
                            title : $(document).find('#new-spec-title-input').val()
                        },
                        success: (res) => {
                            $(document).find('#success-content').html(res);

                            modalNew.fadeOut(500);
                            modalMessage.css('display', 'flex').hide().fadeIn(500);
                            specs();
                            messageTimeout = setTimeout(() => {
                                modalMessage.fadeOut(500);
                            }, 3000);
                        }
                    })
                } else {
                    modalNew.find('#error-title').html('Введите название специальности');
                }
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

            $(document).on('click', '#close-new-btn', () => {
                modalNew.fadeOut(500);
            })
            
            $(document).on('click', (e) => {
                if($(e.target).is('#modal-confirm')) {
                    modalConfirm.fadeOut(500);
                }
                if($(e.target).is('#modal-message')) {
                    clearTimeout(messageTimeout);
                    modalMessage.fadeOut(500);
                }
                if($(e.target).is('#modal-new')) {
                    modalNew.fadeOut(500);
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