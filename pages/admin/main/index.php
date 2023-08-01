<?php session_start(); ?>
<?php if($_SESSION['autorized'] == true && $_SESSION['role'] == 'admin'): ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Главная</title>
        <link rel="stylesheet" href="/assets/css/style.css">
        <script src="/assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="/assets/js/script.js"></script>
        <script src="https://use.fontawesome.com/d55499613e.js"></script>
    </head>
    <body id="main-body">
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
            <div class="modal-message-block modal-select bg-block" id="modal-microtr-del">
                <div class="modal-message">
                    <button class="exit-btn" id="close-microtr-del-btn">
                        <i class="fa fa-close"></i>
                    </button>
                    <div class="form-block">
                        <div class="title-block">
                            <span>Удаление микротравм</span>
                        </div>
                        <div class="modal-message-content" id="microtr-del-content">
                            <div class="parameters-block">
                                <div class="status-block">
                                    <label for="">
                                        <span>Возраст микротравм</span>
                                        <select name="" id="microtr-del-select">
                                            <option value="0" selected disabled>Возраст микротравм, которые необходимо удалить</option>
                                            <option value="1">1 год и более</option>
                                            <option value="2">2 года и более</option>
                                            <option value="3">3 года и более</option>
                                            <option value="4">4 года и более</option>
                                        </select>
                                        <span class="error" id="error-microtr-del-span"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-block">
                        <button class="btn" id="microtr-del-btn">Удалить</button>
                        <!-- <button class="btn" id="close-btn">Закрыть</button> -->
                    </div>
                </div>
            </div>
            <div class="modal-message-block modal-select bg-block" id="modal-user-del">
                <div class="modal-message">
                    <button class="exit-btn" id="close-user-del-btn">
                        <i class="fa fa-close"></i>
                    </button>
                    <div class="form-block">
                        <div class="title-block">
                            <span id="modal-title-user-del">Удаление студентов</span>
                        </div>
                        <div class="modal-message-content" id="user-del-content">
                            <div class="parameters-block">
                                <div class="status-block">
                                    <label for="">
                                        <span>Время нахождения в архиве</span>
                                        <select name="" id="user-del-select">
                                            <option value="0" selected disabled>Время нахождения в архиве</option>
                                            <option value="1">1 год и более</option>
                                            <option value="2">2 года и более</option>
                                            <option value="3">3 года и более</option>
                                            <option value="4">4 года и более</option>
                                        </select>
                                        <span class="error" id="error-user-del-span"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-block">
                        <button class="btn" id="user-del-btn">Удалить</button>
                        <!-- <button class="btn" id="close-btn">Закрыть</button> -->
                    </div>
                </div>
            </div>
            <section class="section main-section">
                <div class="section-title">
                    <div class="title-col left-col">
                        <div class="title-block">
                            <h1 class="section-title__title">Главная</h1>
                        </div>
                    </div>
                    <div class="title-col right-col user-col">
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
                    <div class="col left-col ">
                        <fieldset class="fieldset-sections">
                            <legend>Разделы</legend>
                            <div class="section-content">
                                <div class="content-col content-left">
                                    <a href="/pages/admin/microtraumas/index.php" class="btn field-btn">Микротравмы</a>
                                </div>
                                <div class="content-col content-right">
                                    <a href="/pages/admin/groups/index.php" class="btn field-btn">Группы</a>
                                </div>
                                <div class="content-col content-left">
                                    <a href="/pages/admin/students/index.php" class="btn field-btn">Студенты</a>
                                </div>
                                <div class="content-col content-right">
                                    <a href="/pages/admin/staff/index.php" class="btn field-btn">Сотрудники</a>
                                </div>
                                <div class="sections-block up-block">
                                    
                                </div>
                                <div class="sections-block bottom-block">
                                    
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="fieldset-oper">
                            <legend>Операции</legend>
                            <div class="section-content">
                                <button class="btn" id="transfer-btn">Перевести всех студентов на следующий курс</button>
                                <button class="btn" id="students-archive-delete">Удалить студентов из архива</button>
                                <button class="btn" id="staff-archive-delete">Удалить cотрудников из архива</button>
                                <button class="btn" id="microtraumas-3year-delete">Удалить микротравмы с определенным возрастом</button>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col right-col">
                        <fieldset class="scroll-block">
                            <legend>Последние микротравмы</legend>
                            <div class="section-content micro-content" id="last-microtraumas">
                                
                            </div>
                        </fieldset>
                        <!-- <fieldset class="">
                            <legend>Истек срок инструктажа</legend>
                            <div class="section-content micro-content" id="last-microtraumas">
                                
                            </div>
                        </fieldset> -->
                    </div>
                </div>            
            </section>
        </div>
    </body>
    <script type="text/javascript">
        $(document).ready(() => {
            let messageTimeout;
            let confirm;
            let transfer;
            let yearsCount;
            let typeUserDel;

            const 
                modalMessage = $(document).find('#modal-message'),
                modalConfirm = $(document).find('#modal-confirm'),
                modalMicrotrDel = $(document).find('#modal-microtr-del'),
                modalUserDel = $(document).find('#modal-user-del');

            const microtraumas = function microtraumas() {
                $.ajax({
                    url: '/assets/php/main/microtraumas.php',
                    cache: false,
                    method: 'POST',
                    success: (res) => {
                        $('#last-microtraumas').html(res);
                    }
                });
            }

            microtraumas();

            setInterval(() => {
                microtraumas();
            }, 5000);
            
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
                if($(e.target).is('#modal-microtr-del')) {
                    modalMicrotrDel.fadeOut(500);
                }
                if($(e.target).is('#modal-user-del')) {
                    modalUserDel.fadeOut(500);
                }
            })

            // Модальные окна удаления

            $(document).on('click', '#close-microtr-del-btn', () => {
                modalMicrotrDel.fadeOut(500);
            })

            $(document).on('click', '#close-user-del-btn', () => {
                modalUserDel.fadeOut(500);
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

            // Удаление сотрудников в архиве (выбор)
            $(document).on('click', '#students-archive-delete', () => {
                typeUserDel = 'students';
                modalUserDel.find('#modal-title-user-del').html('Удаление студентов');
                modalUserDel.css('display', 'flex').hide().fadeIn(500);
                
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

            // Удаление сотрудников в архиве (выбор)
            $(document).on('click', '#staff-archive-delete', () => {
                typeUserDel = 'staff';
                modalUserDel.find('#modal-title-user-del').html('Удаление сотрудников');
                modalUserDel.css('display', 'flex').hide().fadeIn(500);
                
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

            $(document).on('change', '#user-del-select', function() {
                $(document).find('#error-user-del-span').html('');
            })

            // Удаление студентов/сотрудников в архиве
            $(document).on('click', '#user-del-btn', () => {
                yearsCount = $(document).find('#user-del-select').val();

                if(yearsCount > 0) {
                    action = 'users-delete';
                
                    if(typeUserDel == 'students') {
                        modalConfirm.find('#confirm-content').html('Вы точно хотите безвозвратно удалить студентов, которые находятся в архиве ' + yearsCount + ' и более  лет? Все микротравмы, связанные с ними так же будут удалены');
                        modalConfirm.css('display', 'flex').hide().fadeIn(500);
                    } else if(typeUserDel == 'staff') {
                        modalConfirm.find('#confirm-content').html('Вы точно хотите безвозвратно удалить сотрудников, которые находятся в архиве ' + yearsCount + ' и более  лет? Все микротравмы, связанные с ними так же будут удалены');
                        modalConfirm.css('display', 'flex').hide().fadeIn(500);
                    }
                    
                } else {
                    $(document).find('#error-user-del-span').html('Выберите один из вариантов');
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

            // Удаление всех микротравм с возрастом (выбор)
            $(document).on('click', '#microtraumas-3year-delete', () => {
                modalMicrotrDel.css('display', 'flex').hide().fadeIn(500);
                
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

            $(document).on('change', '#microtr-del-select', function() {
                $(document).find('#error-microtr-del-span').html('');
            })

            // Удаление всех микротравм с возрастом
            $(document).on('click', '#microtr-del-btn', () => {
                yearsCount = $(document).find('#microtr-del-select').val();

                if(yearsCount > 0) {
                    action = 'microtr-delete';
                
                    if(action == 'microtr-delete') {
                        modalConfirm.find('#confirm-content').html('Вы точно хотите безвозвратно удалить микротравмы, которым ' + yearsCount + ' и более  лет?');
                        modalConfirm.css('display', 'flex').hide().fadeIn(500);
                    }
                    
                } else {
                    $(document).find('#error-microtr-del-span').html('Выберите один из вариантов');
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

            // Подтверждение операции
            $(document).on('click', '#yes-btn', () => {
                if(action == 'transfer') {
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
                } else if(action == 'users-delete') {
                    if(typeUserDel == 'students') {
                        $.ajax({
                            url: '/assets/php/students/students_archive_delete.php',
                            cache: false,
                            method: 'POST',
                            data: {
                                yearsCount : yearsCount
                            },
                            success: (res) => {
                                $(document).find('#success-content').html(res);
                                modalConfirm.fadeOut(500);
                                modalMessage.css('display', 'flex').hide().fadeIn(500);
                                modalUserDel.fadeOut(500);
                                messageTimeout = setTimeout(() => {
                                    modalMessage.fadeOut(500);
                                }, 3000);
                            }
                        })
                    } else if(typeUserDel == 'staff') {
                        $.ajax({
                            url: '/assets/php/staff/staff_archive_delete.php',
                            cache: false,
                            method: 'POST',
                            data: {
                                yearsCount : yearsCount
                            },
                            success: (res) => {
                                $(document).find('#success-content').html(res);
                                modalConfirm.fadeOut(500);
                                modalMessage.css('display', 'flex').hide().fadeIn(500);
                                modalUserDel.fadeOut(500);
                                messageTimeout = setTimeout(() => {
                                    modalMessage.fadeOut(500);
                                }, 3000);
                            }
                        })
                    }
                } else if(action == 'microtr-delete') {
                    $.ajax({
                        url: '/assets/php/microtraumas/microtr_3year_delete.php',
                        cache: false,
                        method: 'GET',
                        data: {
                            yearsCount : yearsCount
                        },
                        success: (res) => {
                            $(document).find('#success-content').html(res);
                            modalConfirm.fadeOut(500);
                            modalMessage.css('display', 'flex').hide().fadeIn(500);
                            modalMicrotrDel.fadeOut(500);
                            messageTimeout = setTimeout(() => {
                                modalMessage.fadeOut(500);
                            }, 3000);
                        }
                    })
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