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
        <title>Группа <?=$groupLine['title_group']; ?></title>
        <link rel="stylesheet" href="/assets/css/style.css">
        <script src="/assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="/assets/js/script.js"></script>
        <script src="https://use.fontawesome.com/d55499613e.js"></script>
    </head>
    <body id="groups-body">
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
            <section class="section main-section">
                <div class="section-title section-title-border">
                    <div class="title-col left-col">
                        <div class="title-block">
                            <h1 class="section-title__title">Группа <?=$groupLine['title_group']; ?></h1>
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
                <div class="section-content section-content-groups">
                    <div class="content-block" id="content-block">
                        <fieldset class="fieldset-parameters">
                            <legend>Параметры</legend>
                            <div class="group-parameters">
                                <div class="parameter">
                                    <label for="title-group">Название</label>
                                    <label for="course-group">Курс</label>
                                    <label for="spec-group">Староста</label>
                                    <label for="spec-group">Специальность</label>
                                    <label for="spec-group">Последний курс</label>
                                </div>
                                <div class="parameter-value">
                                    <input type="text" id="title-group" value="<?=$groupLine['title_group']; ?>" placeholder="Название группы">
                                    <input type="number" id="course-group" value="<?=$groupLine['course']; ?>">
                                    <input type="text" id="elder-group" value="<?=$groupLine['elder']; ?>" placeholder="ФИО старосты">
                                    <select name="" id="spec-group">
                                        <option value="<?=$groupLine['id_specialization']; ?>" selected disabled><?=$groupLine['title_specialization']; ?></option>
                                    <?php foreach($specializations_line as $line): ?>
                                        <option value="<?=$line['id_specialization']; ?>"><?=$line['title_specialization']; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                    <input type="number" id="course-max" value="<?=$groupLine['max_course']; ?>">
                                </div>
                            </div>
                            <div class="group-btn">
                                <button class="btn" id="group-save">Сохранить</button>
                            </div>
                        </fieldset>
                        <fieldset class="fieldset-students">
                            <legend>Студенты в группе <?=$groupLine['title_group']; ?></legend>
                            <div class="table-body scroll-block">
                                
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
                title = $(document).find('#title-group'),
                course = $(document).find('#course-group'),
                elder = $(document).find('#elder-group'),
                spec = $(document).find('#spec-group'),
                maxCourse = $(document).find('#course-max'),
                modalMessage = $(document).find('#modal-message'),
                modalConfirm = $(document).find('#modal-confirm');

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

            // Вывод студентов
            const students = function students() {
                $.ajax({
                    url: '/assets/php/groups/students_group.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        idGroup : idGroup
                    },
                    success: (res) => {
                        $(document).find('.table-body').html(res);
                    }
                })
            }
            students();

            // $(document).find('#content-block').outerHeight($(document).outerHeight() - ($(document).find('.section').outerHeight() - $(document).find('.section').height()) - $(document).find('.section-title').height() - 42);

            // Изменение специальности
            $(document).on('change', '#spec-group', function() {
                specID = $(this).val();
                count += 1;
            })

            // Сохранение группы
            $(document).on('click', '#group-save', () => {
                if(specID == null) {
                    specID = spec.children(':first-of-type').val();
                }

                $.ajax({
                    url: '/assets/php/groups/save_group.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        title : title.val(),
                        course : course.val(),
                        elder : elder.val(),
                        spec : specID,
                        maxCourse : maxCourse.val(),
                        idGroup : idGroup
                    },
                    success: (res) => {
                        $(document).find('#success-content').html(res);

                        modalMessage.css('display', 'flex').hide().fadeIn(500);

                        messageTimeout = setTimeout(() => {
                            modalMessage.fadeOut(500);
                        }, 3000);
                    }
                })
            })

            // Удаление студента
            $(document).on('click', '#archivation-student', function() {
                modalConfirm.find('#confirm-content').html('Вы точно хотите отправить студента в архив?');
                modalConfirm.css('display', 'flex').hide().fadeIn(500);
                confirm = $(this).siblings('.row-table').attr('id');
            })

            // Подтверждение удаления
            $(document).on('click', '#yes-btn', () => {
                modalConfirm.fadeOut(500);
                $.ajax({
                    url: '/assets/php/groups/student_delete.php',
                    cache: false,
                    method: 'POST',
                    data: {
                        idStudent : confirm
                    },
                    success: (res) => {
                        $(document).find('#success-content').html(res);

                        modalMessage.css('display', 'flex').hide().fadeIn(500);
                        students();
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
        })
    </script>
</html>
<?php else: ?>
    <script>
        location.href="/assets/php/autorization/index.php";
    </script>
<?php endif; ?>