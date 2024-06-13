var varienGrid = Class.create({
    initialize: function (eventData) {
        this.ruleCounter = 0;
        this.eventCounter = 0;
        this.count = 0;
        this.bindEvents();
        if (eventData) {
            this.setData(eventData);
        }
    },
    bindEvents: function () {
        var addEvent = $('addEvent');
        addEvent.observe('click', this.addEvent.bind(this))
    },
    addEvent: function (eventData) {
        this.eventCounter++;
        eventId = this.eventCounter;
        var table = new Element('table', { border: '1' });
        var tableContainer = $('grid');
        var addRuleButton = new Element('button', { type: 'button' }).update('Add Rule');
        tableContainer.insert(addRuleButton);
        var event = new Element('input', { type: 'text', id: 'evnt', name: 'event[' + eventId + '][eventname]' });
        if (eventData) {
            event.value = eventData.event;
        }
        tableContainer.insert(event);
        addRuleButton.observe('click', this.addRule.bind(this, table,eventId));
    },
    addRule: function (table,eventId,data) {
        this.ruleCounter++;
        var tableContainer = $('grid');
        var tableRow = new Element('tr');
        var select = new Element('select', { name: 'event[' + eventId + '][rule]['+ this.ruleCounter+'][conditon]' });
        select.insert(new Element('option', { value: 'from' }).update('From'));
        select.insert(new Element('option', { value: 'subject' }).update('Subject'));
        tableRow.insert(select);
        var operation = new Element('select', { name: 'event[' + eventId + '][rule]['+ this.ruleCounter+'][operation]' });
        operation.insert(new Element('option', { value: 'equal' }).update('Equal'));
        operation.insert(new Element('option', { value: 'like' }).update('Like'));
        tableRow.insert(operation);
        var value = new Element('input', { type: 'text', id: 'value', name: 'event[' + eventId + '][rule][' + this.ruleCounter + '][value]' });
        if (data) {
            value.value = data.value;
            operation.checked = data.operator;
            select.checked = data.condition;
        }
        tableRow.insert(value);
        table.insert(tableRow);
        tableContainer.insert(table);
    },
    setData: function (data) {
        data = JSON.parse(data);
        for (var i = 0; i < data.length; i++) {
            var eventData = {
                event_id: data[i].event_id,
                event: data[i].event,
                rules: [{
                    condition: data[i].condition,
                    operator: data[i].operator,
                    value: data[i].value
                }]
            };
            this.addEvent(eventData);
        }

        this.eventCounter++;
        var table = new Element('table', { border: '1', id: 'eventTable_' + eventId });
        var tableContainer = $('grid');
        tableContainer.insert(table);

        this.ruleCounter = 0;
        for (var i = 0; i < data.length; i++) {
            this.addRule(table, eventId, data[i]);
        }
    }
});