var varienGridSeller= Class.create({
    initialize: function (actionUrl, saveUrl, loadUrl) {
        this.loadUrl=loadUrl;
        this.actionUrl = actionUrl;
        this.saveUrl = saveUrl;
        this.bindEvents();
    },

    bindEvents: function () {
        var form = $('seller-form');
        form.observe('submit', this.submitForm.bind(this));
        var assigntoseller = $('assign_to_seller');
        var formData = this.serializeForm($('seller-form'));
        assigntoseller.observe('click', this.assignToSeller.bind(this, formData));
    },

    submitForm: function (event) {
        event.preventDefault();
        var formData = this.serializeForm($('seller-form'));
        this.callAjax(formData);
    },

    serializeForm: function (form) {
        return form.serialize(true);
    },

    callAjax: function (formData) {
        new Ajax.Request(this.actionUrl, {
            method: 'post',
            parameters: formData,
            onSuccess: this.handleSuccess.bind(this),
            onFailure: this.handleFailure.bind(this)
        });
    },

    handleSuccess: function (response) {
        var responseData = response.responseText;
        var responseJson = JSON.parse(responseData);
        var tableData = responseJson;
        this.updateTable(tableData);
    },

    handleFailure: function () {
        console.error("Error occurred while sending data to server.");
    },

    updateTable: function (gridData) {
        // console.log(gridData);
        var tableContainer = $('table-container');
        tableContainer.update('');
        var table = new Element('table', { border: '1' });
        var tableHeader = new Element('tr');
        var headers = Object.keys(gridData[0]);
        headers.forEach(function (header) {
            tableHeader.insert(new Element('th').update(header.charAt(0).toUpperCase() + header.slice(1)));
        });
        table.insert(tableHeader);
        gridData.forEach(function (value) {
            var row = new Element('tr');
            var cells = headers.map(function (header) {
                var cell = new Element('td').update(value[header]);
                return cell;
            });
            cells.reduce(function (row, cell) {
                row.insert(cell);
                return row;
            }, row);
            table.insert(row);
        });
        tableContainer.insert(table);
    },
    save: function () {
        var formData = this.serializeForm($('seller-form'));
        this.sellerAttributesave(formData);
    },
    sellerAttributesave: function (formData) {
        var product_ids = [905, 904, 903];
        formData['product_id'] = product_ids.join(',');
        new Ajax.Request(this.saveUrl, {
            method: 'post',
            parameters: formData,
            // onSuccess: console.log('attribute saved')
        });
    },
    assignToSeller: function (event) {
        var selectedIds = [];
        $$('input[class~="massaction-checkbox"]').each(function (checkbox) {
            if (checkbox.checked) {
                console.log(checkbox.value);
                selectedIds.push(checkbox.value);
            }
        });
        var formData = this.serializeForm($('seller-form'));
        formData['product_id'] = selectedIds.join(',');
        if (selectedIds.length > 0) {
            new Ajax.Request(this.saveUrl, {
                method: 'post',
                parameters: formData,
            });
        }
        else {
            alert('Please select products');
        }
    },
    
});
