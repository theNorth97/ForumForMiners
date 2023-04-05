<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">

    <title>Регистрация успешна</title>
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

        .form-signup button[type="submit"] {
            width: 60%;
            max-width: 200px;
            margin-top: 20px;
        }

        p {
            font-size: 14px;
            color: #ffffff;
            text-align: center;
    </style>
</head>
<body>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center mb-4 ">Регистрация успешна</h4>
                    <!--<p class="centered">Вы успешно зарегистрировались</p>-->
                    <div id="login-link" class="text-center my-3">
                        <a href="/login" class="btn btn-primary btn-sm mx-auto">Войти в личный кабинет</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-rrJjKbh+zxkzY9pgp9tX+94t98sl8tE7P4TkEs0rz"></script>
</body>
</html>
