const nav_ul = document.querySelector('.nav-ul');
const nav_ul_i = document.querySelector('.nav-ul i');
const fa_bars = document.querySelector('.fa-bars');
const fa_xmark = document.querySelector('.fa-xmark');
const search_icon = document.querySelector('.fa-magnifying-glass');
const search_div_outer = document.querySelector('.search_div_outer');
const search_div_inner = document.querySelector('.search_div_inner');
const search_div_inner_input = document.querySelector('.search_div_inner input');


var check_window_click = (event) => {
    let target = event.target;

    if(target != search_icon && target != fa_xmark && target != search_div_outer && target != search_div_inner && target != search_div_inner_input) {
        search_div_outer.classList.remove('active');
        search_icon.classList.replace('fa-xmark', 'fa-magnifying-glass');
        window.removeEventListener('click', check_window_click);
    }
}

var func_for_search = () => {
    search_div_outer.classList.toggle('active');
    if (search_div_outer.classList.contains('active')) {
        search_icon.classList.replace('fa-magnifying-glass', 'fa-xmark')// fa-xmark
        nav_ul.style.left = '-250px';
    } else {
        search_icon.classList.replace('fa-xmark', 'fa-magnifying-glass');
    }

    window.addEventListener('click', check_window_click);
}

search_icon.addEventListener('click', func_for_search);

var check_window_click_for_bars = (event) => {
    let target = event.target;
    let valid_click = true;

    let all_ul_inner_tags = nav_ul.querySelectorAll('*');

    all_ul_inner_tags.forEach(element => {
        element.addEventListener('click', () => {
            valid_click = false;
        })
    })

    if(valid_click == true && target != nav_ul && target != fa_bars) {
        nav_ul.style.left = '-250px';
    }
    
}

var func_for_click_on_bars = () => {
    nav_ul.style.left = '0px';
    search_div_outer.classList.remove('active');
    search_icon.classList.replace('fa-xmark', 'fa-magnifying-glass');

    window.addEventListener('click', check_window_click_for_bars)
}

fa_bars.addEventListener('click', func_for_click_on_bars);

nav_ul_i.addEventListener('click', () => {
    nav_ul.style.left = '-250px';
})