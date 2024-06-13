
document.observe('dom:loaded', function () {
    $$('.editable').each(function (element) {
        element.observe('click', function (event) {
            var span = event.element();
            var id = span.getAttribute('data-id');
            var value = span.innerHTML;
            var column = span.getAttribute('data-column');

            var input = document.createElement('input');
            input.type = 'text';
            input.value = value;
            input.setAttribute('data-id', id);
            input.setAttribute('data-column', column);
            input.setAttribute('class', 'inline-edit');

            var submit = document.createElement('input');
            submit.type = 'submit';
            submit.value = 'Save'; // Or any text you want on the button
            submit.observe('click', function (event) {
                saveChanges(event);
            });
            span.innerHTML = ''; // Clear the span
            span.appendChild(input); // Add the input field
            span.appendChild(submit); // Add the submit button
            input.focus(); // Set focus to the input field
        });
    });
});

function saveChanges(event) {
    var submitButton = event.element();
    var span = submitButton.parentNode;
    var input = span.querySelector('input[type="text"]'); 
    var id = input.getAttribute('data-id');
    var column = input.getAttribute('data-column');
    var value = input.value;
    // Send AJAX request to save the changes
    new Ajax.Request('http://127.0.0.1/my_magento/index.php/admin/salesman/inlineEdit/key/4908335304bb73d6c458d35fe631682c/', {
        method: 'post',
        parameters: {
            id: id,
            column: column,
            value: value
        },
        onSuccess: function (response) {
            var jsonResponse = response.responseText.evalJSON();
            if (jsonResponse.success) {
                span.innerHTML = ''; // Clear the content
                span.appendChild(document.createTextNode(value)); // Add the updated value as text node
            } 
        }
    });
}
