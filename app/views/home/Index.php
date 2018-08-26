<div class="jumbotron">
    <a href="/news/add" class="btn btn-success btn-lg float-right" tabindex="-1" role="button">Добавить новость</a>
    <div class="clearfix"></div>
    <?php if (!empty($news)): ?>
        <?php foreach ($news as $n): ?>
            <div class="card bg-light news-card">
                <div class="card-body">
                    <h5 class="card-title"><?= $n['title'] ?></h5>
                    <small class="card-subtitle mb-2 text-muted"><?= $n['author'] ?>,
                        <i><?= date("d.m.Y", strtotime($n['date'])) ?></i></small>
                    <p class="card-text"><?= $n['short_text'] ?></p>
                    <a href="/news/<?= $n['id'] ?>" class="card-link">Подробнее</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        Еще нет новостей
    <?php endif; ?>
    <?php if ($news_pages > 1): ?>
        <nav class="text-center news-pagination">
            <?php echo sc()->getPagination(array('total' => $news_pages, 'page' => $news_page, 'nb' => 4, 'attrs' => array('class' => 'pagination justify-content-center'))); ?>
        </nav>
    <?php endif; ?>
</div>
