
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">

    <title>Registration Form</title>
    <style>
        body {
            background-color: #054f2c;
        }


        label {
            font-family: Montserrat Medium, sans-serif;
            font-size: 16px;
        }

        .form-signup {
            background-color: #034828;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card {
            background-color: #034828;
        }

        .card-title {
            background-color: #034828;
            color: #ffffff;
            padding: 15px;
            text-align: center;
        }
        .mb-3 {
            background-color: #034828;
            color: #ffffff;
            text-align: center;
        }

        .form-signup button[type="submit"] {
            width: 60%;
            max-width: 200px;
            margin-top: 20px;
        }

        .error-message-pass {
            color: #f32020;
            margin-bottom: 10px;
            text-align: center;
        }

        .form-signup button[type="submit"] {
            margin-top: 30px;
        }

        .error-message-email {
            color: #f32020;
            margin-bottom: 10px;
            text-align: center;
        }


    </style>
</head>

<body>

</body>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card">
                <div class="card-body">
                    <div id="login-link" class="text-center my-3">
                        <a href="/login">Вход в личный кабинет</a>
                    </div>
                    <h4 class="card-title text-center mb-4 ">Регистрация</h4>
                    <form action="/signup" class="form-signup" method="POST">

                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                        </div>
                        <div class="mb-3">
                            <label for="first_name" class="form-label">Имя</label>
                            <input type="text" name="first_name" class="form-control" id="first_name" placeholder="Enter your first name" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Фамилия</label>
                            <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Enter your last name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Почта</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="info" class="form-label">Информация</label>
                            <input type="text" name="info" class="form-control" id="info" placeholder="Enter your information">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Телефон</label>
                            <input type="tel" name="phone" class="form-control" id="phone" placeholder="Enter your phone number" required>
                        </div>

                        <?php
                        session_start();
                        if (isset($_SESSION['error-pass'])) {
                            echo '<div class="mb-3 error-message-pass">' . $_SESSION['error-pass'] . '</div>';
                            unset($_SESSION['error-pass']);
                        }

                        if (isset($_SESSION['error-mail'])) {
                            echo '<div class="mb-3 error-message-email">' . $_SESSION['error-mail'] . '</div>';
                            unset($_SESSION['error-mail']);
                        }
                        ?>

                        <button class="btn btn-primary btn-sm mx-auto" type="submit">Завершить регистрацию</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-rrJjKbh+zxkzY9pgp9tX+94t98sl8tE7P4TkEs0rz