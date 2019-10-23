function init_darkTheme(first = false) {
    let dark = sessionStorage.getItem('dark_theme') === 'true';
    if(first && dark) {
        document.querySelector('#dark-theme').setAttribute('checked', 'checked');
    }
    let site_container = document.querySelector('.mdl-layout');
    let loader_container = document.querySelector('.loader-container');

    dark ? site_container.classList.add('demo-layout-waterfall--dark') : site_container.classList.remove('demo-layout-waterfall--dark');
    dark ? loader_container.classList.add('loader-container--dark') : loader_container.classList.remove('loader-container--dark');

    document.querySelectorAll('.logo').forEach(elem => {
        let img = elem.querySelector('img');
        let src = img.getAttribute('src');
        let base_src = img.getAttribute('data-base_src');
        if((dark || src !== base_src) && (!dark || src === base_src)) {
            src = src.substr((src.split('.')[0]).length - '_white'.length, '_white'.length) === '_white'
                ? src.replace('_white', '_black') : src.replace('_black', '_white');
        }
        elem.querySelector('img').setAttribute('src', src);
    });
}

function switch2dark() {
    if(sessionStorage.getItem('dark_theme') === null) sessionStorage.setItem('dark_theme', 'false');
    sessionStorage.setItem('dark_theme', (sessionStorage.getItem('dark_theme') === 'false' ? 'true' : 'false'));
    init_darkTheme(false);
}

function handleVisibilityChange() {
    let href = document.querySelector('link[rel=icon]').getAttribute('href');
    href = href.substr((href.split('.')[0]).length - '_white'.length, '_white'.length) === '_white'
        ? href.replace('_white', '_black') : href.replace('_black', '_white');
    document.querySelector('link[rel=icon]').setAttribute('href', href);
}

window.addEventListener('load', () => {
    new Promise(resolve => {
        (() => {
            let visibilityChange = (() => {
                let visibilityChange;
                if (typeof document.hidden !== "undefined") { // Opera 12.10 and Firefox 18 and later support
                    visibilityChange = "visibilitychange";
                } else if (typeof document.msHidden !== "undefined") {
                    visibilityChange = "msvisibilitychange";
                } else if (typeof document.webkitHidden !== "undefined") {
                    visibilityChange = "webkitvisibilitychange";
                }
                return visibilityChange;
            })();
            if(typeof visibilityChange !== undefined)
                document.addEventListener(visibilityChange, handleVisibilityChange, false);
        })();
        init_darkTheme(true);
        resolve();
    }).then(fadeOutLoader);
});