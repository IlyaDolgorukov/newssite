<div class="jumbotron">
    <h1 class="text-center"><?= $news['title'] ?></h1>
    <h4 class="text-center"><?= $news['author'] ?>, <small><i><?= date("d.m.Y", strtotime($news['date'])) ?></i></small></h4>
    <p class="lead"><?= $news['full_text'] ?></p>
    <hr />
    Комментарии:
    <?php if(!empty($comments)): ?>
        <?php foreach ($comments as $c): ?>
            <div class="card bg-light news-card" style="margin-left: <?= $c['depth'] * 30 ?>px;">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted"><?= $c['author'] ?></h6>
                    <small><i><?= date("d.m.Y H:i", strtotime($c['date'])) ?></i></small>
                    <p class="card-text"><?= $c['text'] ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        Нет комментариев
    <?php endif; ?>
</div>
