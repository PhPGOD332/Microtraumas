<?php session_start(); ?>
<?php if($_SESSION['autorized'] == true && $_SESSION['role'] == 'admin'): ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Формирование отчета</title>
        <link rel="stylesheet" href="/assets/css/style.css">
        <script src="/assets/js/jquery-3.6.0.min.js"></script>
        <script src="/assets/js/jspdf.min.js"></script>
        <script type="text/javascript" src="/assets/js/html2canvas.min.js"></script>
        <script type="text/javascript" src="/assets/js/script.js"></script>
        <script src="https://use.fontawesome.com/d55499613e.js"></script>
    </head>
    <body id="report-body">
        <div class="modal-block bg-block">
            <div class="modal">
                <iframe src="" name="iframe-import" frameborder="0" style="display: none;"></iframe>
                <form class="import-form" action="/assets/php/students/import_students.php" target="iframe-import" method="POST"  enctype="multipart/form-data" id="form-import">
                    <input type="file" id="import-input" name="import-input" style="display: none;">
                    <label for="import-input" id="import-label" class="btn">
                        <span class="fa-span"><i id="fa-load" class="fa fa-solid fa-download"></i></span>
                        <span id="choose-file">Выберите файл</span>
                    </label>
                    <button type="submit" class="btn" name="import-submit">Импорт</button>
                </form>
            </div>
        </div>
        <section class="section main-section">
            <div class="section-title section-title-border">
                <div class="title-col left-col">
                    <div class="title-block">
                        <h1 class="section-title__title">Формирование отчета</h1>
                    </div>
                    <div class="back-block">
                        <button onclick="history.back();" class="btn back-btn">
                            <i class="fa fa-solid fa-rotate-left"></i>
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
                <div class="content">
                    <div class="parameters-block">
                        <label for="">
                            Дата начала
                            <input type="date" id="date-start">
                        </label>
                        <label for="">
                            Дата окончания
                            <input type="date" id="date-end">
                        </label>
                        <label for="">
                            Статус
                            <select name="" id="status-select">
                                <option value="" selected disabled>Выберите статус в отчёте</option>
                                <option value="В рассмотрении">В рассмотрении</option>
                                <option value="Завершено">Завершено</option>
                                <option value="">Показать всё</option>
                            </select>
                        </label>
                        <button class="btn" id="report-btn">Сформировать</button>
                    </div>
                    <div class="preload-block" id="preview-content">

                    </div>
                </div>
            </div>
        </section>
    </body>
    <script type="text/javascript">
        $(document).ready(() => {
            // Загрузка PDF
            function makePDF() {
                let preview = $(document).find('#capture');
                // window.html2canvas = html2canvas;
                // window.jsPDF = window.jspdf.jsPDF;

                html2canvas(document.querySelector('#capture'), {
                    // allowTaint: true,
                    // useCORS: true,
                    // scale: 5
                }).then(canvas => {
                    let img = canvas.toDataURL('image/jpeg');

                    let doc = new jsPDF('p', 'px', 'a4');
                    doc.setFont('Times New Roman');
                    doc.addImage(img, 'JPEG', 0, 0, 430, Number(preview.outerHeight()) / 2);
                    doc.save('Отчет.pdf');
                })
            }

            const 
                dateStart = $(document).find('#date-start'),
                dateEnd = $(document).find('#date-end'),
                status = $(document).find('#status-select'),
                preview = $(document).find('#preview-content');

            $(document).on('click', '#report-btn', () => {
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
                        $(document).find('#preview').slideDown(1000);
                    }
                })
            })

            $(document).on('click', '#download-btn', () => {
                makePDF();
            })

            $(document).on('click', '#close-btn', () => {
                $(document).find('#preview').slideUp(1000);
            })
        })
    </script>
</html>
<?php else: ?>
    <script>
        location.href="/assets/php/autorization/index.php";
    </script>
<?php endif; ?>