function addReplyButton(commentId, ticketId, userId) {
    var replySection = document.querySelector('#replySection-' + commentId);
    if (!replySection) {
        var row = document.querySelector('[data-comment-id="' + commentId + '"]').closest('tr');
        var newRow = document.createElement('tr');
        newRow.innerHTML = `
        <td colspan="2" id="replySection-${commentId}">
        <textarea class="replyTextarea" data-field="replies-`+ commentId + `"></textarea>
        <button class="saveReplyButton" onclick="saveReply(${commentId},${ticketId},${userId})">Save</button>
        </td>
    `;
        row.parentNode.insertBefore(newRow, row.nextSibling);
    }
}

function saveReply(commentId, ticketId, userId) {
    var replyTextarea = document.querySelector('textarea[data-field="replies-' + commentId + '"]');
    var replyContent = replyTextarea.value;
    data = { 'parent_id': commentId, 'comment': replyContent, 'ticket_id': ticketId, 'user_id': userId };
    new Ajax.Request(savecommentUrl, {
        method: 'post',
        parameters: data,
        onSuccess: function (response) {
            window.location.reload();
        },
    });
}
function lockComment(commentId) {
    data = { 'comment_id': commentId };
    new Ajax.Request(saveLockUrl, {
        method: 'post',
        parameters: data,
        onSuccess: function (response) {
            window.location.reload();
        },
    });
}
