<div class="jumbotron">
    <h1 class="text-center"><?= $news['title'] ?></h1>
    <h4 class="text-center"><?= $news['author'] ?>,
        <small><i><?= date("d.m.Y", strtotime($news['date'])) ?></i></small>
    </h4>
    <p class="lead"><?= $news['full_text'] ?></p>
    <hr/>
    <button type="button" class="btn btn-primary float-right"
            data-toggle="modal" data-target="#add-comment" data-parent="0" data-depth="0">Комментировать
    </button>
    Комментарии: <span id="no-comments"<?php if (empty(!$comments)) echo ' class="d-none"'; ?>>Нет комментариев</span>
    <div id="news-comment-block">
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $c): ?>
                <div class="card bg-light news-card block-comment" data-comment="<?= $c['id'] ?>">
                    <div class="card-body">
                        <button type="button" class="btn btn-secondary float-right"
                                data-toggle="modal" data-target="#add-comment" data-parent="<?= $c['id'] ?>"
                                data-depth="1">Ответить
                        </button>
                        <h6 class="card-subtitle mb-2 text-muted"><?= $c['author'] ?></h6>
                        <small><i><?= date("d.m.Y H:i", strtotime($c['date'])) ?></i></small>
                        <p class="card-text"><?= $c['text'] ?></p>
                    </div>
                </div>
                <?php if (!empty($c['childs'])): ?>
                    <?php foreach ($c['childs'] as $cc): ?>
                        <div class="card bg-light news-card block-comment block-comment-child">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted"><?= $cc['author'] ?></h6>
                                <small><i><?= date("d.m.Y H:i", strtotime($cc['date'])) ?></i></small>
                                <p class="card-text"><?= $cc['text'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<div class="modal fade" id="add-comment" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ваш комментарий</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="author-field">Автор</label>
                        <input type="text" class="form-control" id="author-field" name="author"
                               value="<?php if (empty(!$author)) echo $author; ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="comment-field">Комментарий</label>
                        <textarea class="form-control" id="comment-field" name="text" rows="3"></textarea>
                    </div>
                    <input type="hidden" name="news_id" value="<?= $news['id']; ?>"/>
                    <input type="hidden" name="parent" value="0"/>
                    <input type="hidden" name="depth" value="0"/>
                </form>
                <div id="form-text-error" class="text-danger"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="add-comment-btn">Сохранить</button>
            </div>
        </div>
    </div>
</div>
