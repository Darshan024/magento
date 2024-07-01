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
    data = { 'isAjax': 'true', 'productId': productId };
    new Ajax.Request(showurl, {
        method: 'post',
        parameters: data,
        onSuccess: function (response) {
           document.getElementById('productviewgrid').innerHTML=response.responseText;
        },
    });
}