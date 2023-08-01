<?php session_start(); ?>
<?php if($_SESSION['autorized'] == true && $_SESSION['role'] == 'admin'): ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Журналы микротравм</title>
        <link rel="stylesheet" href="/assets/css/style.css">
        <script src="/assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="/assets/js/script.js"></script>
        <script src="https://use.fontawesome.com/d55499613e.js"></script>
    </head>
    <body id="journal-body">
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
            <section class="section main-section">
                <div class="section-title section-title-border">
                    <div class="title-col left-col">
                        <div class="title-block">
                            <h1 class="section-title__title">Журналы микротравм</h1>
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
                <div class="section-content section-content-students">
                    <div class="content" id="content">
                        
                    </div>
                </div>
                <div class="preview">

                </div>
            </section>
        </div>
    </body>
    <script type="text/javascript">
        $(document).ready(() => { 
            let tab = $(document).find('#tab-input');    
            let messageTimeout;

            // Загрузка PDF
            function makePDF() {
                let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=150');

                mywindow.document.write('<html><head><title>Печать карточки</title>');
                mywindow.document.write('</head><body>');
                mywindow.document.write('<style>.report-inner {display: flex; flex-direction: column; } </style>');
                mywindow.document.write(document.getElementById('journal-report').innerHTML);
                mywindow.document.write('</body></html>');
                mywindow.document.close();
                mywindow.focus();

                mywindow.print();
                mywindow.close();

                // let preview = $(document).find('#student-preview').outerHeight();
                // // window.html2canvas = html2canvas;
                // // window.jsPDF = window.jspdf.jsPDF;

                // html2canvas(document.querySelector('#student-preview'), {
                //     // allowTaint: true,
                //     // useCORS: true,
                //     // scale: 5
                // }).then(canvas => {
                //     let img = canvas.toDataURL('image/jpeg');

                //     let doc = new jsPDF({
                //         orientation: 'p',
                //         unit: 'px',
                //         format: 'a4',
                        
                //     });
                //     doc.setFont('Times New Roman');
                //     doc.addImage(img, 'JPEG', 20, 10, 420, Number(preview) / 2);
                //     doc.save('Профиль.pdf');
                // })
                return true;
            }

            if(tab.val() == '') {
                tab.val('students');
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

            $(document).on('click', '#report-btn', () => {
                makePDF();
            })

            let idJournal = getUrlParameter('idJournal');

            $.ajax({
                url: '/assets/php/journals/journal_report.php',
                cache: false,
                method: 'GET',
                data: {
                    idJournal : idJournal
                },
                success: (res) => {
                    $(document).find('.preview').html(res);
                }
            })

            const journal = function journal() {

                $.ajax({
                    url: '/assets/php/journals/journal_detailed.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        idJournal : idJournal
                    },
                    success: (res) => {
                        $(document).find('#content').html(res);
                        microtraumas();
                    }
                })
            }

            const microtraumas = function microtraumas() {
                $.ajax({
                    url: '/assets/php/journals/journal_microtr.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        idJournal : idJournal
                    },
                    success: (res) => {
                        $(document).find('#microtr-body').html(res);
                        
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

            let search;
            let confirm;
            let status = searchInput.find('option:last-of-type').val();

            journal();

            $(document).find('#staff-content').fadeOut(500);

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