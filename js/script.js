
document.addEventListener('DOMContentLoaded', function () {

    var responseElement = document.querySelector('#api-response');
    var listFormElement = document.querySelector('#list-form');
    var itemFormElement = document.querySelector('#item-form');
    var createFormElement = document.querySelector('#create-form');

    // Get list
    listFormElement.addEventListener('submit', function (evt) {
        evt.preventDefault();

        var page = listFormElement.querySelector('input[name=page]').value;
        var sort = listFormElement.querySelector('select[name=sort]').value;
        var order = listFormElement.querySelector('select[name=order]').value;

        var url = '/api.php?action=get_list&page=' + encodeURIComponent(page) + '&sort=' + encodeURIComponent(sort) + '&order=' + encodeURIComponent(order);

        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.responseType = 'text';
        xhr.send();

        xhr.onload = function () {
            if (xhr.status != 200) {
                responseElement.textContent = `Ошибка ${xhr.status}: ${xhr.statusText}`;
            } else {
                responseElement.textContent = xhr.response;
            }
        };

        xhr.onerror = function () {
            responseElement.textContent = 'Ошибка запроса';
        }
    });

    // Get item
    itemFormElement.addEventListener('submit', function (evt) {
        evt.preventDefault();

        var id = itemFormElement.querySelector('input[name=id]').value;
        var fields = itemFormElement.querySelector('input[name=fields]').value;

        var url = '/api.php?action=get_item&id=' + encodeURIComponent(id) + '&fields=' + encodeURIComponent(fields);

        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.responseType = 'text';
        xhr.send();

        xhr.onload = function () {
            if (xhr.status != 200) {
                responseElement.textContent = `Ошибка ${xhr.status}: ${xhr.statusText}`;
            } else {
                responseElement.textContent = xhr.response;
            }
        };

        xhr.onerror = function () {
            responseElement.textContent = 'Ошибка запроса';
        }
    });

    // Create item
    createFormElement.addEventListener('submit', function (evt) {
        evt.preventDefault();

        var url = '/api.php?action=create_item';
        var formData = new FormData(createFormElement);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.responseType = 'text';
        xhr.send(formData);

        xhr.onload = function () {
            if (xhr.status != 200) {
                responseElement.textContent = `Ошибка ${xhr.status}: ${xhr.statusText}`;
            } else {
                responseElement.textContent = xhr.response;
            }
        };

        xhr.onerror = function () {
            responseElement.textContent = 'Ошибка запроса';
        }
    });

});
