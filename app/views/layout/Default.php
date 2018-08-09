<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?php $title ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if(!empty($meta)): ?>
        <?php foreach($meta as $k => $v): ?>
            <meta name="<?php $k ?>" content="<?php $v ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <link href="/public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/css/jquery-ui/jquery-ui.min.css" rel="stylesheet">
    <link href="/public/css/jquery-ui/jquery-ui.structure.min.css" rel="stylesheet">
    <link href="/public/css/jquery-ui/jquery-ui.theme.min.css" rel="stylesheet">
    <link href="/public/css/main.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="/public/bootstrap/js/bootstrap.min.js"></script>
    <script src="/public/js/jquery-ui/jquery-ui.min.js"></script>
    <script src="/public/js/main.js"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php $content ?>
        </div>
    </div>
</div>
</body>
</html>
