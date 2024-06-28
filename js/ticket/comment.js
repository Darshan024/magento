function addReplyButton(commentId, ticketId, userId) {
    var replySection = document.querySelector('#replySection-' + commentId);
    if (!replySection) {
        var replyButtonTd = document.querySelector('[button-comment-id="' + commentId + '"]').closest('td');
        var replyDiv = document.createElement('div');
        replyDiv.id = 'replySection-' + commentId;
        replyDiv.innerHTML = `
            <textarea class="replyTextarea" id="replies-` + commentId + `" data-field="replies-` + commentId + `"></textarea>
            <button class="saveReplyButton" onclick="saveReply(${commentId},${ticketId},${userId})">Save</button>
            <button onclick="cancel(${commentId})">Cancel</button>
        `;
        replyButtonTd.appendChild(replyDiv);
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
            var commentDiv = document.getElementById('comment_container');
            commentDiv.innerHTML = response.responseText;
        },
    });
}
function completeComment(commentId, ticketId) {
    data = { 'comment_id': commentId, 'ticket_id': ticketId };
    new Ajax.Request(saveCompleteUrl, {
        method: 'post',
        parameters: data,
        onSuccess: function (response) {
            var commentDiv = document.getElementById('comment_container');
            commentDiv.innerHTML = response.responseText;
        },
    });
}
function savelock(level, ticketId) {
    var hide = document.getElementById('show_hide').value;
    data = { 'level': level, 'ticket_id': ticketId,'hide':hide};
    new Ajax.Request(saveLockUrl, {
        method: 'post',
        parameters: data,
        onSuccess: function (response) {
            var commentDiv = document.getElementById('comment_container');
            commentDiv.innerHTML = response.responseText;
            document.getElementById('show_hide').value = hide;
        },
    })
}
function cancel(commentId) {
    var replySection = document.querySelector('#replySection-' + commentId);
    if (replySection) {
        replySection.remove();
    }
}
function addQue(level, ticketId, userId) {
    var buttondiv = document.querySelector('#question');
    var quediv = document.createElement('div');
    quediv.innerHTML =
        `<textarea class="question" data-field="question-` + level + `"></textarea>
    <button  onclick="saveQue(${level},${ticketId},${userId})">Save</button>
    <button onclick="cancel(${level})">Cancel</button>`;
    buttondiv.append(quediv);
}
function saveQue(level, ticketId, userId) {
    var replyTextarea = document.querySelector('textarea[data-field="question-' + level + '"]');
    var replyContent = replyTextarea.value;
    data = { 'level': level, 'comment': replyContent, 'ticketId': ticketId, 'userId': userId };
    new Ajax.Request(saveQueUrl, {
        method: 'post',
        parameters: data,
        onSuccess: function (response) {
            window.location.reload();
        },
    });
}
function completehide(ticketId) {
    data = { 'hide': 'true', 'ticket_id': ticketId };
    new Ajax.Request(hideComplete, {
        method: 'post',
        parameters: data,
        onSuccess: function (response) {
            var commentDiv = document.getElementById('comment_container');
            commentDiv.innerHTML = response.responseText;
        },
    })
}
