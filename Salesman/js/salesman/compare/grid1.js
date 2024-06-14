// varienGrid.prototype.doFilter = function () {
//   var from_date = document.getElementById('from_date');
//   var to_date = document.getElementById('to_date');
//   var salesman1 = document.getElementById('salesman1');
//   var salesman2 = document.getElementById('salesman2');
//   var showChart = document.getElementById('showChart');
//   var filters = $$('#' + this.containerId + ' .filter input', '#' + this.containerId + ' .filter select');
//   filters.push(from_date);
//   filters.push(to_date);
//   var metrics = $$('input[name="metrics[]"]:checked');
//   metrics.each(function (user_id) {
//     filters.push(user_id);
//   });
//   filters.push(salesman1)
//   filters.push(salesman2)
//   filters.push(showChart)
//   var elements = [];
//   for (var i in filters) {
//     if (filters[i].value && filters[i].value.length) elements.push(filters[i])
//   }
//   if (!this.doFilterCallback || (this.doFilterCallback && this.doFilterCallback())) {
//     this.reload(this.addVarToUrl(this.filterVar, encode_base64(Form.serializeElements(elements))));
//   }
// }
document.observe('dom:loaded', function () {
  console.log('dom loaded');
  var form = $('salesman-form');
  form.observe('submit', function (event) {
    event.preventDefault();
    var formData = form.serialize(true);
    console.log(salesmanOrdersUrl);
    new Ajax.Request(salesmanOrdersUrl, {
      method: 'post',
      parameters: formData,
      onSuccess: function (response) {
        var responseData = response.responseText;
        var responseJson = JSON.parse(responseData);
        var tableData = responseJson[0]['tableData'];
        updateTable(tableData);
        if ($('showChart').checked) {
          drawChart(responseJson[1]['chartData']);
        }
      },
    });
  });
  function updateTable(gridData) {
    var tableContainer = $('table-container');
    tableContainer.update('');
    var table = new Element('table', { border: '1' });
    var tableHeader = new Element('tr');
    var headers = Object.keys(gridData[1]);
    headers.forEach(function (header) {
      tableHeader.insert(new Element('th').update(header.charAt(0).toUpperCase() + header.slice(1)));
    });

    table.insert(tableHeader);

    gridData.forEach(function (value) {
      var row = new Element('tr');
      var cells = headers.map(function (header) {
        var cell = new Element('td').update(value[header]);
        cell.observe('click', function () {
          getMetricPopup(header, value['metric']);
        });
        return cell;
      });
      cells.reduce(function (row, cell) {
        row.insert(cell);
        return row;
      }, row);

      table.insert(row);
    });

    tableContainer.insert(table);
  }
  google.charts.load('current', { 'packages': ['corechart'] });
  function drawChart(chartData) {
    var data = google.visualization.arrayToDataTable(chartData);
    var options = {
      title: 'Salesman Comparison',
      curveType: 'function',
      legend: { position: 'bottom' }
    };
    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
  function getSalesmanData(id, orders) {
    var popupContent = $('popup-content');
    popupContent.update('');
    if (typeof orders === 'string') {
      orders = orders.split(',');
    }
    if (Array.isArray(orders)) {
      orders.forEach(function (orderId) {
        var anchor = new Element('a', {
          'href': "http://127.0.0.1/my_magento/index.php/admin/sales_order/view/order_id/" + orderId + "/key/8559418d9043882cc29b73023ceb1e67/",
          'target': '_blank'
        }).update(orderId);
        popupContent.insert(anchor).insert('<br>');
      });
    }
    $('popup-container').setStyle({ display: 'block' });
    $('popup-container').observe('click', function (event) {
      if (event.target.id === 'close-btn') {
        $('popup-container').hide();
        popupContent.update('');
      }
    });
  }
  function getMetricPopup(name, metric) {
    var popupContent = $('popup-content');
    popupContent.update('');
    formData = { 'metric': metric, 'name': name };
    console.log(metricUrl);
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
          var anchor = new Element('a', { href: 'http://127.0.0.1/my_magento/index.php/admin/sales_order/view/order_id/'+order['order_id'],'target': '_blank' }).update(order['order_id']);
          var tdWithAnchor = new Element('td').insert(anchor);
          row.insert(tdWithAnchor);
          row.insert(new Element('td').update(order[metric]));
          table.insert(row);
        });
        console.log(table);
        popupContent.insert(table);
        $('popup-container').setStyle({ display: 'block' });  
        $('popup-container').observe('click', function (event) {
          if (event.target.id === 'close-btn') {
            $('popup-container').hide();
            popupContent.update('');
          }
        })
      },
    });
  }
});




