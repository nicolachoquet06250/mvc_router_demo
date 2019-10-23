function fadeOut(elem, ms) {
    let fadeEffect = setInterval(() => {
        if(elem.style.opacity === '') {
            elem.style.opacity = '1';
        }
        elem.style.opacity < 0.1 ? (clearInterval(fadeEffect), elem.style.display = 'none') : (elem.style.opacity -= 0.1.toString());
    }, ms);
}

function fadeOutLoader() {
    fadeOut(document.querySelector('.loader-container'), 200);
}