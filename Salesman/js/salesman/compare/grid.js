var varienSalesmanComparison = Class.create({
  initialize: function (actionUrl) {
    this.actionUrl = actionUrl;
    this.bindEvents();
  },

  bindEvents: function () {
    var form = $('salesman-form');
    form.observe('submit', this.submitForm.bind(this));
  },

  submitForm: function (event) {
    event.preventDefault();
    var formData = this.serializeForm($('salesman-form'));
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
    var tableData = responseJson[0]['tableData'];
    this.updateTable(tableData);
    if ($('showChart').checked) {
      this.drawChart(responseJson[1]['chartData']);
    }
  },

  handleFailure: function () {
    console.error("Error occurred while sending data to server.");
  },

  updateTable: function (gridData) {
    var tableContainer = $('table-container');
    tableContainer.update('');
    var table = new Element('table', { border: '1' });
    var tableHeader = new Element('tr');
    var headers = Object.keys(gridData[0]);
    headers.forEach(function (header) {
      tableHeader.insert(new Element('th').update(header.charAt(0).toUpperCase()+header.slice(1)));
    });
    table.insert(tableHeader);
    gridData.forEach(function (value) {
      var row = new Element('tr');
      var cells = headers.map(function (header) {
        var cell = new Element('td').update(value[header]);
        if (header !== 'metric' && header!=='difference') {
          cell.observe('click', function () {
            this.getMetricPopup(header, value['metric']);
          }.bind(this));
        }
        return cell;
      }.bind(this));

      cells.reduce(function (row, cell) {
        row.insert(cell);
        return row;
      }, row);
      table.insert(row);
    }.bind(this));

    tableContainer.insert(table);
  },
  drawChart: function (chartData) {
    google.charts.load('current', { 'packages': ['corechart'] });
    google.charts.setOnLoadCallback(function () {
      var data = google.visualization.arrayToDataTable(chartData);
      var options = {
        title: 'Salesman Comparison',
        curveType: 'function',
        legend: { position: 'bottom' }
      };
      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    });
  },
  getMetricPopup: function (name, metric) {
    var popupContent = $('popup-content');
    popupContent.update('');
    var formData = this.serializeForm($('salesman-form'));
    formData['metric'] = metric;
    formData['name'] = name;
    console.log(formData);
    new Ajax.Request(metricUrl, {
      method: 'post',
      parameters: formData,
      onSuccess: function (response) {
        var responseData = response.responseText;
        var data = JSON.parse(responseData);
        var table = new Element('table', { border: '1' });
        var tableHeader = new Element('tr');
        tableHeader.insert(new Element('td').update('Order_id'));
        tableHeader.insert(new Element('td').update(metric));
        table.insert(tableHeader);
        data.forEach(function (order) {
          var row = new Element('tr');
          var anchor = new Element('a', {
            href: 'http://127.0.0.1/my_magento/index.php/admin/sales_order/view/order_id/' + order['order_id'],
            target: '_blank'
          }).update(order['order_id']);
          var tdWithAnchor = new Element('td').insert(anchor);
          row.insert(tdWithAnchor);
          row.insert(new Element('td').update(order[metric]));
          table.insert(row);
        });
        popupContent.insert(table);
        $('popup-container').setStyle({ display: 'block' });
        $('popup-container').observe('click', function (event) {
          if (event.target.id === 'close-btn') {
            $('popup-container').hide();
            popupContent.update('');
          }
        });
      }
    });
  },
});

document.observe('dom:loaded', function () {
  var comparison = new varienSalesmanComparison(salesmanOrdersUrl);
});





