<div class="jumbotron">
    <?php if(!empty($news)): ?>
        <?php foreach ($news as $n): ?>
            <div class="card bg-light news-card">
                <div class="card-body">
                    <h5 class="card-title"><?= $n['title'] ?></h5>
                    <small class="card-subtitle mb-2 text-muted"><?= $n['author'] ?>, <i><?= date("d.m.Y", strtotime($n['date'])) ?></i></small>
                    <p class="card-text"><?= $n['short_text'] ?></p>
                    <a href="/news/<?= $n['id'] ?>" class="card-link">Подробнее</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        Еще нет новостей
    <?php endif; ?>
</div>
<div class="text-center">
    <a href="/news/add" class="btn btn-success btn-lg" tabindex="-1" role="button">Добавить новость</a>
</div>
