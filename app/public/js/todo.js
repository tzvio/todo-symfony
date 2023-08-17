$(document).ready(function() {
    const modal = $('#deleteTaskConfirmationModal');
    
    modal.find('.modal-close, #confirmYes, #confirmNo').click(function() {
      modal.removeClass('is-active');
    });
    
    modal.find('#confirmYes').click(function(){
        $.ajax({
            url: '/task/delete/' + modal.data('taskid'),
            type: 'DELETE',
            dataType: 'json',
            success: function(response) {
                console.log(response);
                window.location.href = "/";
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });

    $('.delete-task').click(function() {
        modal.addClass('is-active');
        modal.data('taskid', $(this).data('taskid'));
    });

    $('.edit-task').click(function () {
        const taskId =  $(this).data('taskid');
        $('.edit-task-input-' + taskId).removeClass('is-hidden');
        $('.edit-task-input-' + taskId + ' input').focus();
        $('.todo-desc-' + taskId).addClass('is-hidden');
        $('.todo-buttons .edit-task.taskid-' + taskId ).addClass('is-hidden');
        $('.todo-buttons .delete-task.taskid-' + taskId ).addClass('is-hidden');
        $('.todo-buttons .save-task.taskid-' + taskId ).removeClass('is-hidden');

    })
    $('.save-task').click(function () {
        const taskId =  $(this).data('taskid');
        const desc = $('.edit-task-input-' + taskId + ' input').val();
        $.ajax({
            url: '/task/update/' + taskId,
            type: 'PATCH',
            dataType: 'json',
            data: JSON.stringify({desc: desc}),
            success: function(response) {
                console.log(response);
                window.location.href = "/";
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
        
    })
});