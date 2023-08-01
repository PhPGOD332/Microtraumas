<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Главная</title>
        <link rel="stylesheet" href="/assets/css/style.css">
        <script type="text/javascript" src="/assets/js/script.js"></script>
        <script src="/assets/js/jquery-3.6.0.min.js"></script>
        <script src="https://use.fontawesome.com/d55499613e.js"></script>
    </head>
    <body id="authorization-body">
        <div class="bg-block autorization-bg"></div>
        <div class="autorization-parent-block">
            <div class="autorization-form">
                <div class="form-block form-title-block">
                    <span class="form-title">Авторизация</span>
                </div>
                <div class="form-block form-content-block">
                    <div class="data-block login-block">
                        <div class="input-block">
                            <label class="icon-block" for="login">
                                <i class="fa fa-solid fa-user" id="loginIcon"></i>
                            </label>
                            <input type="text" id="login" placeholder="Логин">
                        </div>
                        <div class="error-block">
                            <span class="error error-span" id="errorLogin"></span>
                        </div>
                    </div>
                    <div class="data-block pass-block">
                        <div class="input-block">
                            <label class="icon-block" for="password">
                                <i class="fa fa-solid fa-lock" id="passIcon"></i>
                            </label>
                            <input type="password" id="password" placeholder="Пароль">
                        </div>
                        <div class="error-block">
                            <span class="error error-span" id="errorPass"></span>
                        </div>
                    </div>
                </div>
                <div class="error-block error-form-block">
                    <span class="error error-span" id="errorForm"></span>
                </div>
                <div class="form-submit-block">
                    <button id="submit-btn" class="btn submit-btn">Войти</button>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript">
        $(document).ready(() => {
            const 
                submitBtn = $(document).find('#submit-btn'),
                login = $(document).find('#login'),
                pass = $(document).find('#password'),
                loginError = $(document).find('#errorLogin'),
                passError = $(document).find('#errorPass'),
                formError = $(document).find('#errorForm'),
                loginIcon = $(document).find('#loginIcon'),
                passIcon = $(document).find('#passIcon');

            $(document).on('click', '#submit-btn', function() {
                if(!login.val() && !pass.val()) {
                    loginError.html('Введите логин');
                    passError.html('Введите пароль');
                    loginIcon.css('color', 'rgb(185, 0, 0)');
                    passIcon.css('color', 'rgb(185, 0, 0)');
                } else if(login.val() && !pass.val()) {
                    passError.html('Введите пароль');
                    passIcon.css('color', 'rgb(185, 0, 0)');
                } else if(!login.val() && pass.val()) {
                    loginError.html('Введите логин');
                    loginIcon.css('color', 'rgb(185, 0, 0)');
                } else {
                    $.ajax({
                        url: '/assets/php/autorization/handler.php',
                        cache: false,
                        method: 'POST',
                        data: {
                            login : login.val(),
                            pass : pass.val()
                        },
                        success: (res) => {
                            if(res == 'Логин или пароль не верны') {
                                loginIcon.css('color', 'rgb(185, 0, 0)');
                                passIcon.css('color', 'rgb(185, 0, 0)');
                            }
                            formError.html(res);
                        }
                    });
                }
            })

            $(document).on('click', function(e) {
                if(!$(e.target).is('#loginIcon') && !$(e.target).is('#passIcon') && !$(e.target).is('#submit-btn')) {
                    loginError.html('');
                    passError.html('');
                    formError.html('');
                    loginIcon.css('color', '#404040');
                    passIcon.css('color', '#404040');
                }
            })
        })
    </script>
</html>
