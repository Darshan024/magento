function addReplyButton(commentId, ticketId, userId) {
    var replySection = document.querySelector('#replySection-' + commentId);
    if (!replySection) {
        var row = document.querySelector('[data-comment-id="' + commentId + '"]').closest('tr');
        var newRow = document.createElement('tr');
        newRow.innerHTML = `
        <td colspan="2" id="replySection-${commentId}">
        <textarea class="replyTextarea" data-field="replies-`+ commentId + `"></textarea>
        <button class="saveReplyButton" onclick="saveReply(${commentId},${ticketId},${userId})">Save</button>
        <button onclick="cancel(${commentId})">Cancel</button>
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
function completeComment(commentId) {
    data = { 'comment_id': commentId };
    new Ajax.Request(saveCompleteUrl, {
        method: 'post',
        parameters: data,
        onSuccess: function (response) {
            window.location.reload();
        },
    });
}
function savelock(level) {
    data = { 'level': level };
    new Ajax.Request(saveLockUrl, {
        method: 'post',
        parameters: data,
        onSuccess: function (response) {
            window.location.reload();
        },
    })
}
function cancel(commentId) {
    var replySection = document.querySelector('#replySection-' + commentId);
    if (replySection) {
        replySection.remove();
    }
}
function addQue(level,ticketId,userId) {
    var buttondiv = document.querySelector('#question');
    var quediv = document.createElement('div');
    quediv.innerHTML =
        `<textarea class="question" data-field="question-`+level+`"></textarea>
    <button  onclick="saveQue(${level},${ticketId},${userId})">Save</button>
    <button onclick="cancel(${level})">Cancel</button>`;
    buttondiv.append(quediv);
}
function saveQue(level,ticketId,userId) {
    var replyTextarea = document.querySelector('textarea[data-field="question-' +level + '"]');
    var replyContent = replyTextarea.value;
    data = { 'level': level ,'comment':replyContent,'ticketId':ticketId,'userId':userId};
    new Ajax.Request(saveQueUrl, {
        method: 'post',
        parameters: data,
        onSuccess: function (response) {
            window.location.reload();
        },
    });
}
