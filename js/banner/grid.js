varienGrid.prototype.doFilter = function () {
    var filters = $$('#' + this.containerId + ' .filter input', '#' + this.containerId + ' .filter select');
    filters.push(status12);
    var elements = [];
    for (var i in filters) {
        if (filters[i].value && filters[i].value.length) elements.push(filters[i])
        // elements.push($('status'))
    }
    if (!this.doFilterCallback || (this.doFilterCallback && this.doFilterCallback())) {
        this.reload(this.addVarToUrl(this.filterVar, encode_base64(Form.serializeElements(elements))));
    }
}
varienGrid.prototype.xyz = function () {
    console.log('new function is called');
}