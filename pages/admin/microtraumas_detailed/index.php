<?php 
    session_start(); 
    require_once('../../../assets/php/connect/logic.php');
?>
<?php if($_SESSION['autorized'] == true && $_SESSION['role'] == 'admin'): ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Оформление микротравмы</title>
        <link rel="stylesheet" href="/assets/css/style.css">
        <script src="/assets/js/jquery-3.6.0.min.js"></script>
        <script src="/assets/js/jspdf.min.js"></script>
        <script type="text/javascript" src="/assets/js/html2canvas.min.js"></script>
        <script type="text/javascript" src="/assets/js/script.js"></script>
        <script src="https://use.fontawesome.com/d55499613e.js"></script>
    </head>
    <body id="microtr-detailed-body">
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
                <div class="section-title">
                    <div class="title-col left-col">
                        <div class="title-block">
                            <h1 class="section-title__title">Оформление микротравмы</h1>
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
                <div class="section-content" id="microtrauma-content">

                </div>
            </section>
        </div>
    </body>
    <script>
        $(document).ready(() => {
            let messageTimeout;
            let idReason;
            let idType;
            let idTypeMain;
            let confirm;
            let types;

            const 
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

            let idMicrotr = getUrlParameter('id_microtr');

            // Вывод формы
            const form = function form() {
                $.ajax({
                    url: '/assets/php/microtraumas/microtrauma_detailed.php',
                    cache: false,
                    method: 'GET',
                    data: {
                        id_microtr : idMicrotr
                    },
                    success: (res) => {
                        $(document).find('#microtrauma-content').html(res);

                        idReason = $(document).find('#reasons-select').children('option:selected').val();
                        idType = $(document).find('#types-select').children('option:selected').val();
                        types = $(document).find('#types-select option');

                        $.each(types, (index, value) => {
                            if($(value).prop('selected') == false && $(value).attr('value') == idType) {
                                
                                if($(value).parent().prop('id') != 'types-select') {
                                    idTypeMain = $(value).parent().prop('id');
                                }
                                
                            }
                        })

                        if(idTypeMain == undefined) {
                            idTypeMain = 0;
                        }
                    }
                })
            }

            // Сохранение формы
            const saveEdit = function saveEdit(action) {
                let 
                    place = $(document).find('#place-microtr').val(),
                    dateMicr = $(document).find('#date-microtr').val(),
                    firstAid = $(document).find('#first-aid').val(),
                    dateApp = $(document).find('#date-app').val(),
                    medicial = $(document).find('#medicial').val(),
                    trauma = $(document).find('#trauma').val(),
                    release = $(document).find('#release').val(),
                    circ = $(document).find('#circumstances').val(),
                    reason = $(document).find('#reason').val(),
                    type = $(document).find('#type').val(),
                    suggestions = $(document).find('#suggestions').val();

                if(idReason != $(document).find('#reasons-select').children(':first-of-type').val()) {
                    console.log('sadf');
                    idReason = $(document).find('#reasons-select').val();
                } 

                if(idType != $(document).find('#types-select').children(':first-of-type').val()) {
                    idType = $(document).find('#types-select').val();
                }

                $.ajax({
                    url: '/assets/php/microtraumas/save_microtr.php',
                    cache: false,
                    method: 'POST',
                    data: {
                        place : place,
                        dateMicr : dateMicr,
                        firstAid : firstAid,
                        dateApp : dateApp,
                        medicial : medicial,
                        trauma : trauma,
                        release : release,
                        circ : circ,
                        idReason : idReason,
                        reason : reason,
                        idType : idType,
                        idTypeMain : idTypeMain,
                        type : type,
                        suggestions : suggestions,
                        idMicrotr : idMicrotr,
                        action : action
                    },
                    success: (res) => {
                        $(document).find('#success-content').html(res);

                        modalMessage.css('display', 'flex').hide().fadeIn(500);
                        form();
                        messageTimeout = setTimeout(() => {
                            modalMessage.fadeOut(500);
                        }, 3000);
                    }
                })
            }

            const savePreview = function savePreview(action) {
                let 
                    place = $(document).find('#place-microtr').val(),
                    dateMicr = $(document).find('#date-microtr').val(),
                    firstAid = $(document).find('#first-aid').val(),
                    dateApp = $(document).find('#date-app').val(),
                    medicial = $(document).find('#medicial').val(),
                    trauma = $(document).find('#trauma').val(),
                    release = $(document).find('#release').val(),
                    circ = $(document).find('#circumstances').val(),
                    reason = $(document).find('#reason').val(),
                    type = $(document).find('#type').val(),
                    suggestions = $(document).find('#suggestions').val();

                if(idReason != $(document).find('#reasons-select').children(':first-of-type').val()) {
                    idReason = $(document).find('#reasons-select').val();
                } 

                if(idType != $(document).find('#types-select').children(':first-of-type').val()) {
                    idType = $(document).find('#types-select').val();
                }

                $.ajax({
                    url: '/assets/php/microtraumas/save_microtr.php',
                    cache: false,
                    method: 'POST',
                    data: {
                        place : place,
                        dateMicr : dateMicr,
                        firstAid : firstAid,
                        dateApp : dateApp,
                        medicial : medicial,
                        trauma : trauma,
                        release : release,
                        circ : circ,
                        idReason : idReason,
                        reason : reason,
                        idType : idType,
                        type : type,
                        suggestions : suggestions,
                        idMicrotr : idMicrotr,
                        action : action
                    },
                    success: (res) => {
                        form();
                    }
                })
            }

            form();

            // Загрузка PDF
            function makePDF() {
                let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=150');

                mywindow.document.write('<html><head><title>Печать карточки</title>');
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
                //     doc.save('Справка микротравмы.pdf');
                // })
                return true;
            }

            $(document).on('click', '#download-doc', function() {
                makePDF();
            })

            $(document).on('click', '#save-btn', () => {
                saveEdit('save');
            })

            // Обработка выбора причины
            $(document).on('change', '#reasons-select', function() {
                if($(this).val() == 0) {
                    $(document).find('#reason').slideDown(500);
                } else {
                    $(document).find('#reason').slideUp(500);
                }

                idReason = $(this).val();
            })

            // Обработка выбора типа
            $(document).on('change', '#types-select', function() {
                if($(this).val() == 0) {
                    $(document).find('#type').slideDown(500);
                } else {
                    $(document).find('#type').slideUp(500);
                }

                idType = $(this).val();

                $.each(types, function(index, value) {
                    if($(value).prop('selected') == true) {
                        if($(value).parent().prop('class') == 'propgroup') {
                            idTypeMain = $(value).parent().prop('id');
                        } else if($(value).parent().prop('id') == 'types-select') {
                            idTypeMain = idType;
                            idType = 0;
                        } else {
                            idTypeMain = $(value).parent().prop('id');
                        }
                    }
                })

                // if(idTypeMain == 0) {
                //     idTypeMain = idType;
                //     idType = 0;
                // }
            })
            
            // Загрузка предпросмотра
            $(document).on('click', '.preload-btn', function(e) {
                let 
                    user = $(this).attr('user');

                savePreview('save');

                setTimeout(() => {
                    $.ajax({
                        url: '/assets/php/microtraumas/preview.php',
                        cache: false,
                        method: 'POST',
                        data: {
                            user : user,
                            idMicrotr : idMicrotr
                        },
                        success: (res) => {
                            $(document).find('#preview-content').html(res);
                            // $(document).find('#preview').slideDown(1000);
                            makePDF();
                        }
                    }) 
                }, 1000);

            })

            // Завершение микротравмы
            $(document).on('click', '#end-btn', function() {
                type = 'end';
                modalConfirm.find('#confirm-content').html('Вы точно хотите перенести микротравму в архив?');
                modalConfirm.css('display', 'flex').hide().fadeIn(500);
                confirm = $(document).find('.form-block').attr('idMicrotr');
            })

            // Возврат микротравмы
            $(document).on('click', '#return-btn', function() {
                type = 'return';
                modalConfirm.find('#confirm-content').html('Вы точно хотите вернуть микротравму из архива?');
                modalConfirm.css('display', 'flex').hide().fadeIn(500);
                confirm = $(document).find('.form-block').attr('idMicrotr');
            })

            // Подтверждение удаления
            $(document).on('click', '#yes-btn', () => {
                if(type == 'end') {
                    modalConfirm.fadeOut(500);
                    saveEdit('end');
                } else if(type == 'return') {
                    modalConfirm.fadeOut(500);
                    saveEdit('return');
                }
            })

            // Отмена завершения
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
            })

            // Закрытие предпросмотра
            $(document).on('click', '#close-preload', () => {
                $(document).find('#preview').slideUp(1000);
            })
        })
    </script>
</html>
<?php else: ?>
    <?php header('Location:/assets/php/autorization/index.php'); ?>
<?php endif; ?>