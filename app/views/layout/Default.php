<!DOCTYPE html>
<html lang="ru">
    <head>
        <title><?= $title ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php if (!empty($meta)): ?>
            <?php foreach ($meta as $k => $v): ?>
                <meta name="<?= $k ?>" content="<?= $v ?>">
            <?php endforeach; ?>
        <?php endif; ?>
        <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet">
        <link href="/public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/public/css/main.min.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="/public/bootstrap/js/bootstrap.min.js"></script>
        <script src="/public/js/main.min.js"></script>
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">Тестовое задание для разработчика</h1>
                    <h3 class="text-center">Заказчик: Компания СекретКом</h3>
                    <h3 class="text-center">Исполнитель: Долгоруков Илья</h3>
                    <?= $content ?>
                </div>
            </div>
        </div>
    </body>
</html>
