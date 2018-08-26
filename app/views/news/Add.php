<?php $news_author = (!empty($values['author'])) ? $values['author'] : (!empty($author)) ? $author : ''; ?>
<form method="post" action="">
    <div class="form-group">
        <label for="author-field">Автор</label>
        <input type="text" class="form-control<?php if (in_array('author', $errors)) echo ' is-invalid'; ?>"
               id="author-field" name="form_data[author]" value="<?= $news_author; ?>"/>
    </div>
    <div class="form-group">
        <label for="title-field">Заголовок</label>
        <input type="text" class="form-control<?php if (in_array('title', $errors)) echo ' is-invalid'; ?>"
               id="title-field" name="form_data[title]"
               value="<?php if (!empty($values['title'])) echo $values['title']; ?>"/>
    </div>
    <div class="form-group">
        <label for="short-text-field">Краткое описание</label>
        <textarea class="form-control<?php if (in_array('short_text', $errors)) echo ' is-invalid'; ?>"
                  id="short-text-field"
                  name="form_data[short_text]"
                  rows="3"><?php if (!empty($values['short_text'])) echo $values['short_text']; ?></textarea>
    </div>
    <div class="form-group">
        <label for="full-text-field">Краткое описание</label>
        <textarea class="form-control<?php if (in_array('full_text', $errors)) echo ' is-invalid'; ?>"
                  id="full-text-field"
                  name="form_data[full_text]"
                  rows="5"><?php if (!empty($values['full_text'])) echo $values['full_text']; ?></textarea>
    </div>
    <button class="btn btn-success" type="submit">Добавить</button>
</form>
