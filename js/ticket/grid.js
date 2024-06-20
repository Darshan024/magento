function save(value, id, column) {
    var id = { 'value': value, 'id': id, 'column': column };
    new Ajax.Request(url, {
        method: 'post',
        parameters: id,
        onSuccess: function (response) {
            var responseData = JSON.parse(response.responseText);
            if (responseData['message'] === 'success') {
                var statusCell = document.getElementById('status_code');
                statusCell.style.backgroundColor = responseData['colour'];
            }
        },
    });
}
function addFilter() {
    document.getElementById('addFilter_form').style.display = 'block';
}
function closePopupFilter() {
    document.getElementById('addFilter_form').style.display = 'none';
}
function filter() {
    var titleFilter = document.getElementById("titleFilter").value.toLowerCase();
    var descriptionFilter = document.getElementById('descriptionFilter').value.toLowerCase();
    var assignByFilter = document.getElementById('assignByFilter').value.toLowerCase();
    var assignToFilter = document.getElementById('assignToFilter').value.toLowerCase();
    var priorityFilter = document.getElementById('priorityFilter').value.toLowerCase();
    var statusFilter = document.getElementById('statusFilter').value.toLowerCase();
    var rows = document.querySelectorAll(".ticket-row");

    rows.forEach(function (row) {
        var title = row.querySelector(".title").textContent.toLowerCase();
        var description = row.querySelector(".description").textContent.toLowerCase();
        var assignBy = row.querySelector('.assign-by').textContent.toLowerCase();
        var assignTo = row.querySelector('.assign-to').textContent.toLowerCase();
        var priority = row.querySelector('.priority').textContent.toLowerCase();
        var status = row.querySelector('.status').textContent.toLowerCase();
        if (title.indexOf(titleFilter) !== -1 && description.indexOf(descriptionFilter) !== -1 && assignBy.indexOf(assignByFilter) !== -1
            && assignTo.indexOf(assignToFilter) !== -1 && priority.indexOf(priorityFilter) !== -1 && status.indexOf(statusFilter) !== -1) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}