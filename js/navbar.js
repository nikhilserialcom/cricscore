const nav_ul = document.querySelector('.nav-ul');
const nav_ul_i = document.querySelector('.nav-ul i');
const fa_bars = document.querySelector('.fa-bars');
const fa_xmark = document.querySelector('.fa-xmark');
const search_icon = document.querySelector('.fa-magnifying-glass');
const search_div_outer = document.querySelector('.search_div_outer');
const search_div_inner = document.querySelector('.search_div_inner');
const search_div_inner_input = document.querySelector('.search_div_inner input');
const join_sign_in_div = document.querySelector('.join_sign_in_div');
const icon_image_div = document.querySelector('.icon_image');
const profile_img = icon_image_div.querySelector('img');
const profile_menu = document.querySelector('.profile_menu');
const logout_btn = document.querySelector('.logout_btn');

const profile_btn = document.querySelector('.profile_btn');

const logout_url = 'php/logout.php';

const user_logout = () => {
    fetch(demo_url, {
        method: 'GET',
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
            if (json.status_code == 200) {
                join_sign_in_div.style.display = "block";
                icon_image_div.style.display = "none";
                window.location.href = 'signin.php';
            }
        })
}

const toggleProfileMenu = () => {
    if (profile_menu.style.display === 'block') {
        profile_menu.style.display = 'none';
        profile_menu.classList.remove('animate__animated', 'animate__backInDown');
    }
    else {
        profile_menu.style.display = 'block';
        profile_menu.classList.add('animate__animated', 'animate__backInDown');
        profile_menu.style.setProperty('--animate-duration', '1s');
    }
}

icon_image_div.addEventListener('click', toggleProfileMenu);

profile_btn.addEventListener('click', () => {
    window.location.href = 'profile.php';
})

var check_window_click = (event) => {
    let target = event.target;

    if (target != search_icon && target != fa_xmark && target != search_div_outer && target != search_div_inner && target != search_div_inner_input) {
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

    if (valid_click == true && target != nav_ul && target != fa_bars) {
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

logout_btn.addEventListener('click', () => {
    user_logout();
})
