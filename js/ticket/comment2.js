var j = jQuery.noConflict();

j(document).ready(function () {
    var demoIdCounter = 1;
    var addReplyCounter = 1;
    
    // Event delegation for dynamically created add-reply buttons
    j("body").on("click", function (event) {
        var target = j(event.target);
        if (target.hasClass(`add-reply-btn-${addReplyCounter}`)) {
            var button = target;
            var demoId = demoIdCounter++;
            addReplyRow(button, demoId);
        }
    });
    
    j("body").on("click", ".save-reply-btn", function () {
        saveReply(j(this));
    });
    
    j("body").on("click", ".cancel-reply-btn", function () {
        cancelReply(j(this));
    });

    j("body").on("click", ".complete-reply-btn", function () {
        completeReply(j(this));
    });
    
    j("body").on("change", ".reply-lock", function () {
        lockComments(j(this));
    });
    
    function addReplyRow(button, demoId) {
        var tr = button.closest('tr');
        var lockTr = j('tbody');
    
        var replyRow = j('<tr class="reply-row">');
        var commentCell = tr.find('.comment-text');
        var rowspan = commentCell.attr('rowspan') || 1;
        commentCell.attr('rowspan', parseInt(rowspan) + 1);
    
        var lockRowExists = j('table').find('.lock-row').length > 0;
        if (!lockRowExists) {
            var lockRow = j('<tr class="lock-row">');
            lockRow.html(`
                <td colspan="2" style="text-align: center;">
                    <input type="checkbox" class="reply-lock"> Lock
                </td>
            `);
            lockTr.after(lockRow);
        }
    
        replyRow.html(`
            <td colspan="2">
                <textarea id="reply-${demoId}" class="reply-textarea"></textarea>
                <button class="save-reply-btn" data-demo-id="${demoId}">Save</button>
                <button class="cancel-reply-btn">Cancel</button>
            </td>
        `);
    
        tr.after(replyRow);
    
        CKEDITOR.replace(`reply-${demoId}`, {
            toolbar: [
                { name: "basicstyles", items: ["Bold", "Italic", "Underline"] },
                { name: "styles", items: ["Format"] },
                { name: "paragraph", items: ["NumberedList", "BulletedList", "-", "Blockquote"] },
                { name: "links", items: ["Link", "Unlink"] },
                { name: "insert", items: ["Image"] },
                { name: "tools", items: ["Maximize"] },
                { name: "editing", items: ["Undo", "Redo"] },
            ],
        });
    }
    
    function saveReply(button) {
        var tr = button.closest('tr');
        var demoId = button.data('demo-id');
        var editor = CKEDITOR.instances[`reply-${demoId}`];
        if (editor) {
            var replyText = editor.getData();
            var replyRow = j('<tr class="comment-row">');
            var newAddBtnName = `add-reply-btn-${addReplyCounter+1}`;
            replyRow.html(`
                <td class="comment-text">${replyText}</td>
                <td class="add-reply-td">
                    <button class="${newAddBtnName}" data-demo-id="${demoId}">Add Reply</button>
                    <button class="complete-reply-btn">Complete</button>
                </td>
            `);
    
            tr.find('textarea.reply-textarea').closest('td').html(replyRow);
            CKEDITOR.instances[`reply-${demoId}`].destroy(true);
    
            var lockbox = j('table').find('.reply-lock');
            if (!lockbox.is(":checked")) {
                var newAddReplyTd = j('table').find('.' + newAddBtnName).parent();
                newAddReplyTd.hide();
            }
        } else {
            console.error('CKEditor instance not found for reply textarea.');
        }
    }
    
    function cancelReply(button) {
        var tr = button.closest('tr');
        removeReplyRow(tr);
    }
    
    function removeReplyRow(replyRow) {
        var commentCell = replyRow.prev().find('.comment-text');
        var rowspan = commentCell.attr('rowspan') || 2;
        commentCell.attr('rowspan', parseInt(rowspan) - 1);
    
        replyRow.prev().find('.add-reply-btn').show();
        replyRow.remove();
    }
    
    function lockComments(lockCheckbox) {
        var table = j('table');
        if (lockCheckbox.is(":checked")) {
            table.find(`.add-reply-btn-${addReplyCounter}`).parent().hide();
            var newAddBtnName = `add-reply-btn-${addReplyCounter+1}`;
            table.find('.' + newAddBtnName).parent().show();
            table.find('.lock-row').remove();
            addReplyCounter++;
        }
    }
    
});
