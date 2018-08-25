$(function () {
    function insertCommentBlock(data){
        var html = '<div class="card bg-light news-card block-comment" data-comment="' + data.id + '">';
        html += '<div class="card-body">';
        html += '<h6 class="card-subtitle mb-2 text-muted">' + data.author + '</h6>';
        html += '<small><i>' + data.date + '</i></small>';
        html += '<p class="card-text">' + data.text + '</p>';
        html += '</div></div>';
        if(data.parent > 0){
            var el = $('#news-comment-block').children('[data-comment="' + data.parent + '"]');
            var comment = $(html).insertAfter(el);
            comment.addClass('block-comment-child');
        }else{
            var btn = '<button type="button" class="btn btn-secondary float-right" data-toggle="modal" data-target="#add-comment" data-parent="' + data.id + '" data-depth="1">Ответить</button>';
            var comment = $(html).prependTo($('#news-comment-block'));
            comment.find('.card-body').prepend(btn);
        }
        $('#no-comments').addClass('d-none');
    }
    function showCommentErrors(form, errors){
        console.log(errors);
    }
    $('#add-comment').on('show.bs.modal', function(e){
        var form = $(this).find('form');
        var btn = $(e.relatedTarget);
        form.find('input[name="parent"]').val(btn.data('parent'));
        form.find('input[name="depth"]').val(btn.data('depth'));
    });
    $('#add-comment-btn').click(function () {
        var container = $(this).closest('.modal-content');
        var modalCloseBtn = container.find('button.close');
        var commentForm = container.find('form');
        $.post('/ajax', commentForm.serialize(), function(r){
            commentForm.trigger('reset');
            if(r.status == 'ok'){
                insertCommentBlock(r.data);
                modalCloseBtn.click();
            }else{
                showCommentErrors(commentForm, r.errors);
            }
        }, 'json');
    });
});
