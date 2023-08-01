<?php session_start(); ?>
<?php if($_SESSION['autorized'] == true && $_SESSION['role'] == 'admin'): ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Микротравмы</title>
        <link rel="stylesheet" href="/assets/css/style.css">
        <script src="/assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="/assets/js/script.js"></script>
        <script src="https://use.fontawesome.com/d55499613e.js"></script>
    </head>
    <body id="microtraumas-body">
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
            <div class="modal-message-block bg-block" id="modal-report">
                <div class="modal-message">
                    <button class="exit-btn" id="close-report-btn">
                        <i class="fa fa-close"></i>
                    </button>
                    <div class="form-block">
                        <div class="title-block">
                            <span>Отчетность по микротравмам</span>
                        </div>
                        <div class="modal-message-content" id="report-content">
                            <div class="parameters-block">
                                <div class="dates-block">
                                    <span>Диапазон дат</span>
                                    <div class="date-inner">
                                        <label for="">
                                            <!-- Дата начала -->
                                            <input type="date" id="date-start">
                                        </label>
                                        <span>—</span>
                                        <label for="">
                                            <!-- Дата окончания -->
                                            <input type="date" id="date-end">
                                        </label>
                                    </div>
                                </div>
                                <div class="status-block">
                                    <span>Статус</span>
                                    <label for="">
                                        <select name="" id="status-report-select">
                                            <option value="" selected disabled>Выберите статус микротравм в отчёте</option>
                                            <option value="В рассмотрении">Незавершенные</option>
                                            <option value="Завершено">В архиве</option>
                                            <option value="">Все</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-block">
                        <button class="btn" id="print-btn">Печать</button>
                        <!-- <button class="btn" id="close-btn">Закрыть</button> -->
                    </div>
                </div>
            </div>
            <input type="hidden" id="tab-input" value="<?=$_SESSION['tab-microtr']; ?>">
            <section class="section main-section">
                <div class="section-title">
                    <div class="title-col left-col">
                        <div class="title-block">
                            <h1 class="section-title__title">Микротравмы</h1>
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
                        <button class="tab-btn tab-btn-selected" id="students-tab">Студенты</button>
                        <button class="tab-btn" id="staff-tab">Работники</button>
                    </div>
                    <div class="btn-block">
                        <a href="/pages/admin/microtraumas_archive/index.php" class="btn">Архив</a>
                        <a href="/pages/admin/microtrauma_new/index.php" class="btn design-btn">Оформить микротравму</a>
                        <!-- <a href="/pages/admin/microtrauma_report/index.php" class="btn report-btn" id="report-btn">Отчетность</a> -->
                        <button class="btn report-btn" id="report-btn">Отчетность</button>
                        <a href="/pages/admin/journals/index.php" class="btn journal-btn">Журналы учета</a>
                    </div>
                </div>
                <div class="section-content">
                    <div class="students-content" id="students-content" status="">
                        <div class="section-sort">
                            <div class="filter-block">
                                <div class="sort-block group-block">
                                    <label for="group-sort-input">Группа</label>
                                    <input type="text" id="group-sort-input" class="group-input" placeholder="Поиск">
                                </div>
                                <div class="sort-block status-block">
                                    <label for="status-select">Статус</label>
                                    <select name="status-select" id="status-select">
                                        <option value="Статус" selected disabled>Выберите статус</option>
                                        <option value="В рассмотрении">В рассмотрении</option>
                                        <option value="Завершено">Завершено</option>
                                        <option value="Показать всё">Показать всё</option>
                                    </select>
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
                                <!-- <div class="table-head">
                                    <button class="head-item head-FIO">
                                        <span>ФИО</span>
                                        <i class="fa fa-solid fa-caret-up"></i>
                                    </button>
                                    <button class="head-item head-group">
                                        <span>Группа</span>
                                        <i class="fa fa-solid fa-caret-up"></i>
                                    </button>
                                    <button class="head-item head-descr">
                                        <span>Описание</span>
                                        <i class="fa fa-solid fa-caret-up"></i>
                                    </button>
                                    <button class="head-item head-group">
                                        <span>Дата</span>
                                        <i class="fa fa-solid fa-caret-up"></i>
                                    </button>
                                </div> -->
                                <div class="table-body">
                                    <fieldset class="table-last-microtr scroll-block">
                                        <legend>Нерассмотренные микротравмы</legend>
                                        <div class="last-microtr-body" id="last-microtr-body">

                                        </div>
                                    </fieldset>
                                    <fieldset class="table-archive-microtr scroll-block">
                                        <legend>Микротравмы в архиве (последние 2 недели)</legend>
                                        <div class="archive-microtr-body" id="archive-microtr-body">

                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="staff-content" id="staff-content" status="">
                        <div class="section-sort">
                            <div class="filter-block">
                                <div class="sort-block status-block">
                                    <label for="status-select">Статус</label>
                                    <select name="status-select" id="status-select">
                                        <option value="Статус" selected disabled>Выберите статус</option>
                                        <option value="В рассмотрении">В рассмотрении</option>
                                        <option value="Завершено">Завершено</option>
                                        <option value="Показать всё">Показать всё</option>
                                    </select>
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
                                    <fieldset class="table-last-microtr scroll-block">
                                        <legend>Нерассмотренные микротравмы</legend>
                                        <div class="last-microtr-body" id="last-microtr-body">

                                        </div>
                                    </fieldset>
                                    <fieldset class="table-archive-microtr scroll-block">
                                        <legend>Микротравмы в архиве (последние 2 недели)</legend>
                                        <div class="archive-microtr-body" id="archive-microtr-body">

                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="preload-block" id="preview-content" style="display: none;">

            </div>
        </div>
    </body>
    <script>
        $(document).ready(() => {
            const 
                dateStart = $(document).find('#date-start'),
                dateEnd = $(document).find('#date-end'),
                status = $(document).find('#status-report-select'),
                preview = $(document).find('#preview-content'),
                modalReport = $(document).find('#modal-report'),
                modalMessage = $(document).find('#modal-message'),
                modalConfirm = $(document).find('#modal-confirm');

            let tab = $(document).find('#tab-input');
            let search = false;
            let messageTimeout;
            let confirm;
            let actionDel;

            // Загрузка PDF
            function makePDF() {
                let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=150');

                mywindow.document.write('<html><head><title>Печать отчета</title>');
                mywindow.document.write('</head><body>');
                mywindow.document.write(document.getElementById('capture').innerHTML);
                mywindow.document.write('</body></html>');
                mywindow.document.close();
                mywindow.focus();

                mywindow.print();
                mywindow.close();

                // let preview = $(document).find('#capture');
                // // window.html2canvas = html2canvas;
                // // window.jsPDF = window.jspdf.jsPDF;

                // html2canvas(document.querySelector('#capture'), {
                //     // allowTaint: true,
                //     // useCORS: true,
                //     // scale: 5
                // }).then(canvas => {
                //     let img = canvas.toDataURL('image/jpeg');

                //     let doc = new jsPDF('p', 'px', 'a4');
                //     doc.setFont('Times New Roman');
                //     doc.addImage(img, 'JPEG', 0, 0, 430, Number(preview.outerHeight()) / 2);
                //     doc.save('Отчет.pdf');
                // })

                return true;
            }
            
            const students = function students() {
                let type;

                type = 'last';
                // Вывод нерассмотренных микротравм студентов
                $.ajax({
                    url: '/assets/php/microtraumas/students_microtr.php',
                    cache: false,
                    type: 'GET',
                    data: {
                        type : type
                    },
                    success: (res) => {
                        $(document).find('#students-content .last-microtr-body').html(res);
                    }
                })

                type = 'archive';
                // Вывод архивных микротравм студентов
                $.ajax({
                    url: '/assets/php/microtraumas/students_microtr.php',
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

                type = 'last';
                // Вывод нерассмотренных микротравм работников
                $.ajax({
                    url: '/assets/php/microtraumas/staff_microtr.php',
                    cache: false,
                    type: 'GET',
                    data: {
                        type : type
                    },
                    success: (res) => {
                        $(document).find('#staff-content .last-microtr-body').html(res);
                    }
                })

                type = 'archive';
                // Вывод архивных микротравм работников
                $.ajax({
                    url: '/assets/php/microtraumas/staff_microtr.php',
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

                // Вывод нерассмотренных микротравм
                $.ajax({
                    url: '/assets/php/microtraumas/filter.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        search : searchInput.val(),
                        group : groupInput.val(),
                        date : dateInput.val(),
                        // status : statusSelect.val(),
                        action : action,
                        typeMicrotr : 'last'
                    },
                    success: (res) => {
                        if(action == 'students') {
                            $(document).find('#students-content .last-microtr-body').html(res);
                        } else if(action == 'staff') {
                            $(document).find('#staff-content .last-microtr-body').html(res);
                        }
                        
                        // $(document).find('#archive-microtr-body').append(res);
                    }
                })

                // Вывод архивных микротравм
                $.ajax({
                    url: '/assets/php/microtraumas/filter.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        search : searchInput.val(),
                        group : groupInput.val(),
                        date : dateInput.val(),
                        // status : statusSelect.val()
                        action : action,
                        typeMicrotr : 'archive'
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

            $(document).on('change', '#status-select', function() {
                if($(this).val() == 'В рассмотрении') {
                    $(document).find('.table-archive-microtr').slideUp(500);
                    $(document).find('.table-last-microtr').slideDown(500);
                } else if($(this).val() == 'Завершено') {
                    $(document).find('.table-last-microtr').slideUp(500);
                    $(document).find('.table-archive-microtr').slideDown(500);
                } else if($(this).val() == 'Показать всё') {
                    $(document).find('.table-last-microtr').slideDown(500);
                    $(document).find('.table-archive-microtr').slideDown(500);
                }
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

            // Отчетность
            $(document).on('click', '#report-btn', function() {
                modalReport.css('display', 'flex').hide().fadeIn(500);
            })

            // Печать отчета
            $(document).on('click', '#print-btn', function() {
                if(dateStart.val() == '') {
                    dateStart.css('color', 'rgb(201, 0, 0)');
                    messageTimeout = setTimeout(() => {
                        dateStart.css('color', '#404040');
                    }, 2000);
                    
                } else {
                    $.ajax({
                        url: '/assets/php/microtraumas/report.php',
                        cache: false,
                        method: 'POST',
                        data: {
                            dateStart : dateStart.val(),
                            dateEnd : dateEnd.val(),
                            status : status.val()
                        },
                        success: (res) => {
                            preview.html(res);
                            // $(document).find('#preview').slideDown(1000);
                            makePDF();
                        }
                    })
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

            // Выбор даты старта
            $(document).on('change', dateStart, function() {
                dateStart.css('color', '#404040');
            })

            // Отмена удаления
            $(document).on('click', '#no-btn', () => {
                modalConfirm.fadeOut(500);
            })

            $(document).on('click', '#close-confirm-btn', () => {
                modalConfirm.fadeOut(500);
            })

            // Закрытие окна отчета
            $(document).on('click', '#close-report-btn', () => {
                modalReport.fadeOut(500);
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
                if($(e.target).is('#modal-report')) {
                    clearTimeout(messageTimeout);
                    modalReport.fadeOut(500);
                }
            })
        })
    </script>
</html>
<?php else: ?>
    <?php header('Location:/assets/php/autorization/index.php'); ?>
<?php endif; ?>