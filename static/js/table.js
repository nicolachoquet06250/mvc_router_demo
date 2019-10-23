function toggleCell(selected, current) {
    selected.querySelector("td").classList.contains("hide")
        ? current.querySelector('.material-icons').innerHTML = 'keyboard_arrow_up' : current.querySelector('.material-icons').innerHTML = 'keyboard_arrow_down';
    selected.querySelector("td").classList.contains("hide")
        ? selected.querySelector("td").classList.remove("hide") : selected.querySelector("td").classList.add("hide")
}