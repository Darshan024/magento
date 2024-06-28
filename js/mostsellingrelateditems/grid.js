function loadProduct() {
    productId = document.getElementById('productId').value;
    data = { 'isAjax': 'true', 'productId': productId };
    new Ajax.Request(url, {
        method: 'post',
        parameters: data,
        onSuccess: function (response) {    
            document.getElementById('page:main-container').innerHTML = response.responseText;
            document.getElementById('productId').value = productId;
        },
    });
}
function showDetails() {
    productId = document.getElementById('productId').value;
    data = { 'showdetail': 'true', 'productId': productId };
    new Ajax.Request(showurl, {
        method: 'post',
        parameters: data,
        onSuccess: function (response) {
            var viewgrid = document.createElement('div');
            viewgrid.id = 'viewgrid';
            viewgrid.innerHTML=response.responseText
            document.getElementById('right').appendChild(viewgrid);
            document.getElementById('productId').value = productId;
        },
    });
}