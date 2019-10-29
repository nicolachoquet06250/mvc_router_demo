function inject_button_minimize_maximize(elem, min_size) {
    let buttonBar = document.createElement('div');
    let buttonBarCellCentered = document.createElement('div');
    let buttonBarCell = document.createElement('div');
    let button = document.createElement('button');
    button.classList.add('mdl-button');
    button.classList.add('mdl-js-button');
    button.classList.add('mdl-button--raised');
    button.classList.add('mdl-button--colored');
    button.innerHTML = 'Voir plus';
    button.addEventListener('click', () => {
        if(elem.style.height === `${min_size}px`) {
            elem.style.height = 'auto';
            button.innerHTML = 'Voir moins';
        }
        else {
            elem.style.height = `${min_size}px`;
            button.innerHTML = 'Voir plus';
        }
    });

    buttonBar.classList.add('mdl-grid');

    buttonBarCell.classList.add('mdl-cell');
    buttonBarCell.classList.add('mdl-cell--4-col-desktop');
    buttonBarCell.classList.add('mdl-cell--2-col-tablet');
    buttonBarCell.classList.add('mdl-cell--hide-phone');

    buttonBarCellCentered.classList.add('mdl-cell');
    buttonBarCellCentered.classList.add('mdl-cell--4-col-desktop');
    buttonBarCellCentered.classList.add('mdl-cell--4-col-tablet');
    buttonBarCellCentered.classList.add('mdl-cell--4-col-phone');
    buttonBarCellCentered.style.textAlign = 'center';

    buttonBarCellCentered.appendChild(button);

    buttonBar.appendChild(buttonBarCell);
    buttonBar.appendChild(buttonBarCellCentered);

    elem.parentElement.appendChild(buttonBar);
}

window.addEventListener('load', () => {
    let highlights = document.querySelectorAll('pre[class*=language-]');
    const min_size = 290;
    highlights.forEach(elem => {
        if(elem.clientHeight >= min_size) {
            inject_button_minimize_maximize(elem, min_size);
            elem.style.height = `${min_size}px`;
        }
    });
});