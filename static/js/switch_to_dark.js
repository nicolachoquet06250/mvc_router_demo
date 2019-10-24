function init_darkTheme(first = false) {
    let dark = sessionStorage.getItem('dark_theme') === 'true';
    let switch2dark = document.querySelector('#dark-theme');
    if(first && dark) switch2dark.setAttribute('checked', 'checked');
    let site_container = document.querySelector('.mdl-layout');
    let loader_container = document.querySelector('.loader-container');

    let switchPrism = dark => {
        let prismCSS = document.querySelector('link[href="/static/css/prism.css"]');
        let prismCSSDark = document.querySelector('link[href="/static/css/prism-dark.css"]');
        let baseHrefPrism = prismCSS ? prismCSS.getAttribute('data-base_href')
            : (prismCSSDark ? prismCSSDark.getAttribute('data-base_href') : false);

        let prismJS = document.querySelector('script[src="/static/js/prism.js"]');
        let prismJSDark = document.querySelector('script[src="/static/js/prism-dark.js"]');
        let baseSrcPrism = prismJS !== null ? prismJS.getAttribute('data-base_src')
            : (prismJSDark !== null ? prismJSDark.getAttribute('data-base_src') : false);

        let prismHref = prismCSS !== null ? prismCSS.getAttribute('href')
            : (prismCSSDark !== null ? prismCSSDark.getAttribute('href') : false);
        let prismSrc = prismJS !== null ? prismJS.getAttribute('src')
            : (prismJSDark !== null ? prismJSDark.getAttribute('src') : false);

        if(prismCSS !== null || prismCSSDark !== null) {
            if((dark || prismHref !== baseHrefPrism) && (!dark || prismHref === baseHrefPrism)) {
                prismHref = prismHref.substr((prismHref.split('.')[0]).length - '-dark'.length, '-dark'.length) === '-dark'
                    ? prismHref.replace('-dark', '') : `${prismHref.split('.')[0]}-dark.css`;
            }
        }

        if(prismJS !== null || prismJSDark !== null) {
            if((dark || prismSrc !== baseSrcPrism) && (!dark || prismSrc === baseSrcPrism)) {
                prismSrc = prismSrc.substr((prismSrc.split('.')[0]).length - '-dark'.length, '-dark'.length) === '-dark'
                    ? prismSrc.replace('-dark', '') : `${prismSrc.split('.')[0]}-dark.js`;
            }
        }

        prismCSS !== null ? prismCSS.setAttribute('href', prismHref)
            : (prismCSSDark !== null ? prismCSSDark.setAttribute('href', prismHref) : null);

        prismJS !== null ? prismJS.setAttribute('src', prismSrc)
            : (prismJSDark !== null ? prismJSDark.setAttribute('src', prismSrc) : null);
    };

    dark ? site_container.classList.add('theme--dark')
        : site_container.classList.remove('theme--dark');
    dark ? loader_container.classList.add('loader-container--dark')
        : loader_container.classList.remove('loader-container--dark');

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

    switchPrism(dark);
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