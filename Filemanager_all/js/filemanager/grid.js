varienGrid.prototype.doFilter = function () {
    var path = document.getElementById('pathSelect');
    var filters = $$('#' + this.containerId + ' .filter input', '#' + this.containerId + ' .filter select');
    filters.push(path);
    var elements = [];
    for (var i in filters) {
        if (filters[i].value && filters[i].value.length) elements.push(filters[i])
    }
    if (!this.doFilterCallback || (this.doFilterCallback && this.doFilterCallback())) {
        this.reload(this.addVarToUrl(this.filterVar, encode_base64(Form.serializeElements(elements))));
    }
}
varienGrid.prototype.inlineedit = function (event) {
    var span = event.target;
    var path = span.getAttribute('data-basepath');
    var value = span.innerHTML;
    var basename = span.getAttribute('data-basename');

    var input = document.createElement('input');
    input.type = 'text';
    input.value = value;
    input.setAttribute('data-basepath', path);
    input.setAttribute('data-basename', basename);
    input.setAttribute('class', 'edit');

    var submit = document.createElement('button');
    submit.innerHTML = 'Save';

    var cancel = document.createElement('button');
    cancel.innerHTML = 'Cancel';

    span.innerHTML = '';
    span.appendChild(input);
    span.appendChild(submit);
    span.appendChild(cancel);
    input.focus();

    submit.addEventListener('click', function () {
        var editinput = span.querySelector('.edit');
        var path = editinput.getAttribute('data-basepath');
        var basename = editinput.getAttribute('data-basename');
        var value = editinput.value;
        new Ajax.Request(url, {
            method: 'post',
            parameters: {
                basename: basename,
                value: value,
                path: path,
            },
            onSuccess: function() {
                span.innerHTML = value;
                location.reload();
            },
            onFailure: function() {
                span.innerHTML = value; 
            }
        });
    });
    cancel.addEventListener('click', function () {
        span.innerHTML = value;
    });
};



