function add() {
    let key = document.querySelector('#key').value;
    let value = document.querySelector('#value').value;

    let form = new FormData();
    form.append('key', key);
    form.append('value', value);
    form.append('add', 1);

    fetch('{$url}?lang={$lang}', {
        method: 'POST',
        body: form
    }).then(() => window.location.href = '{$url}?lang={$lang}')
}

function regenerate_translations() {
    let form = new FormData();
    form.append('regenerate', 1);

    fetch('{$url}/regenerate', {
        method: 'POST',
        body: form,
    }).then(result => result.text())
        .then(text => {
            let html = text.replace("\\n", '<br>');
            document.querySelector('#regenerate_logs').innerHTML += html;
        });
}