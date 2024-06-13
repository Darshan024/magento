varienGrid.prototype.doFilter = function () {
    var from_date = document.getElementById('from_date');
    var to_date = document.getElementById('to_date');
    if (from_date.value ==="") {
        alert('Select From Date');
        return;
    }
    if (to_date.value === "") {
        alert('Select To Date');
        return;
    }
    var filters = $$('#' + this.containerId + ' .filter input', '#' + this.containerId + ' .filter select');
    filters.push(from_date);
    filters.push(to_date);
   

    var elements = [];
    for (var i in filters) {
        if (filters[i].value && filters[i].value.length) elements.push(filters[i])
    }
    if (!this.doFilterCallback || (this.doFilterCallback && this.doFilterCallback())) {
        this.reload(this.addVarToUrl(this.filterVar, encode_base64(Form.serializeElements(elements))));
    }
}




