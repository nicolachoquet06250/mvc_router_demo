function contact_us() {
    let form = document.querySelector('.contact-form');

    form.addEventListener('submit', e => {
        e.preventDefault();

        let action = form.getAttribute('action');
        let method = form.getAttribute('method');

        let email = form.querySelector('#email').value;
        let first_name = form.querySelector('#first_name').value;
        let last_name = form.querySelector('#last_name').value;
        let message = form.querySelector('#message').value;

        fetch(action, {
            method, body: JSON.stringify({
                email,
                first_name,
                last_name,
                message
            })
        }).then(r => {
            if(r.status >= 200 && r.status < 300) return r.json();
            else {
                let message_div = document.querySelector('#return-message');
                message_div.style.color = 'red';
                message_div.innerHTML = `Une erreur est survenue: ${r.statusText}`;
                message_div.classList.remove('mdl-cell--hide-desktop');
                message_div.classList.remove('mdl-cell--hide-tablet');
                message_div.classList.remove('mdl-cell--hide-phone');

                console.error(`${r.status} ${r.statusText}`);
            }
        }).then(json => {
            if(json) {
                json.message = json.message.replace("\n", '<br />');
                let message_div = document.querySelector('#return-message');
                message_div.innerHTML = json.message;
                message_div.classList.remove('mdl-cell--hide-desktop');
                message_div.classList.remove('mdl-cell--hide-tablet');
                message_div.classList.remove('mdl-cell--hide-phone');
                console.log(json);
            }
        });
    });
}

window.addEventListener('load', () => {
    contact_us();
});