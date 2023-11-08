const select_country_inner_div = document.querySelector('.select_country_inner_div');
const input_of_country_div = document.querySelector('.input_of_country_div');
const input_of_country_div_input = document.querySelector('.input_of_country_div input');
const input_of_country_div_p = document.querySelector('.input_of_country_div p');
const country_list_div = document.querySelector('.country_list_div');
const selected_country_i = document.querySelector('.selected_country_and_i_div .fa-angle-down');
const selected_country_p = document.querySelector('.selected_country_and_i_div p');
const continue_btn = document.querySelector('.continue_btn');
const name_div_input = document.querySelector('.name_div input');
const email_div_input = document.querySelector('.email_div input');

const userId = sessionStorage.getItem('userId');

const select_state_box = document.querySelector('.select_state_box');
const input_state_box = document.querySelector('.input_state_box');
const input_state_box_input = document.querySelector(' .input_state_box input');
const input_state_box_p = document.querySelector('.input_state_box p');
const state_list_box = document.querySelector('.state_list_box');
const selected_state_i = document.querySelector('.selected_state_show .fa-angle-down');
const selected_state_p = document.querySelector('.selected_state_show p');
// console.log(state_list_box);

var stateId;

var remove_state_click_onclick_document = (event) => {
    let target = event.target;
    let valid_click = true;

    const select_state_all_element = select_state_box.querySelectorAll('*');
    const input_state_box_all_element = input_state_box.querySelectorAll('*');
    select_state_all_element.forEach(element => {
        if (target == element) {
            valid_click = false;
        }
    })

    input_state_box_all_element.forEach(element => {
        valid_click = false;
    })

    if (target != select_state_box && target != input_state_box && valid_click == true) {
        input_state_box.classList.remove('clicked');
        document.removeEventListener('click', remove_state_click_onclick_document);
        selected_state_i.classList.replace('fa-angle-up', 'fa-angle-down');
    }
}

var set_click_on_select_state = () => {
    input_state_box.classList.toggle('clicked');

    if (input_state_box.classList.contains('clicked')) {
        selected_state_i.classList.replace('fa-angle-down', 'fa-angle-up');
    } else {
        selected_state_i.classList.replace('fa-angle-up', 'fa-angle-down');
    }

    document.addEventListener('click', remove_state_click_onclick_document);
}

select_state_box.addEventListener('click', set_click_on_select_state);

var stateUrl = 'php/select_state.php';

input_state_box_input.addEventListener('input', (event) => {
    input_state_box_p.textContent = 'Searching...';
    state_list_box.style.display = 'flex';

    var state_name_input_value = input_state_box_input.value;

    if (state_name_input_value == '') {
        state_list_box.style.display = 'none';
        input_state_box_p.style.display = 'flex';
        input_state_box_p.textContent = 'Please enter 1 or more characters.';
    }

    let country_id = localStorage.getItem('country_id');
    // console.log(country_id); 
    fetch(stateUrl, {
        method: 'POST',
        body: JSON.stringify({
            state_input: state_name_input_value,
            country_id: country_id
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(handle_state_data)
        .catch(error => error)
})

var remove_click_onclick_document = (event) => {
    let target = event.target;
    let valid_click = true;

    const select_country_inner_div_all_element = select_country_inner_div.querySelectorAll('*');
    const input_of_country_div_all_element = input_of_country_div.querySelectorAll('*');

    select_country_inner_div_all_element.forEach(element => {
        if (target == element) {
            valid_click = false;
        }
    })

    input_of_country_div_all_element.forEach(element => {
        if (target == element) {
            valid_click = false;
        }
    })

    if (target != select_country_inner_div && target != input_of_country_div && valid_click == true) {
        input_of_country_div.classList.remove('clicked');
        document.removeEventListener('click', remove_click_onclick_document);
        selected_country_i.classList.replace('fa-angle-up', 'fa-angle-down');
    }

}

var set_click_on_select_country = () => {
    input_of_country_div.classList.toggle('clicked');

    if (input_of_country_div.classList.contains('clicked')) {
        selected_country_i.classList.replace('fa-angle-down', 'fa-angle-up');
    } else {
        selected_country_i.classList.replace('fa-angle-up', 'fa-angle-down');
    }

    document.addEventListener('click', remove_click_onclick_document)
}

select_country_inner_div.addEventListener('click', set_click_on_select_country);

var handle_state_data = (json) => {
    console.log(json);
    var arr = json.arr;

    if (json.state_code == 200) {
        state_list_box.innerHTML = arr.map(val => {
            let { state } = val;
            stateId = val.id;
            input_state_box_p.style.display = 'none';

            return `
              <span id='${stateId.$oid}'>${state}</span>
            `;
        }).join('');

        let state_list_box_span = document.querySelectorAll('.state_list_box span');
        state_list_box_span[0].classList.add('active_state');

        var func_for_remove_click_on_state_list_box_span = () => {
            state_list_box_span.forEach(element => {
                element.classList.remove('active');
            })
        }

        let currentFocus = 0;
        var stateAdjustScroll = () => {
            const highlightedstate = document.querySelector('.active_state');
            if (highlightedstate) {
                const containerHeight = state_list_box.offsetHeight;
                const itemTop = highlightedstate.offsetTop;
                const itemHeight = highlightedstate.offsetHeight;

                if (itemTop < state_list_box.scrollTop) {
                    state_list_box.scrollTop = itemTop;
                } else if (itemTop + itemHeight > state_list_box.scrollTop + containerHeight) {
                    state_list_box.scrollTop = itemTop + itemHeight - containerHeight;
                }
            }
        }

        input_state_box_input.addEventListener('keydown', (event) => {
            if (event.key == 'ArrowDown') {
                event.preventDefault();
                highlight_state_div(currentFocus += 1);
                stateAdjustScroll();
            } else if (event.key == 'ArrowDown') {
                event.preventDefault();
                highlight_state_div(currentFocus -= 1);
                stateAdjustScroll();
            } else if (event.key == 'Enter') {
                let active_state_div = document.querySelector('.active_state');

                selected_state_p.textContent = active_state_div.textContent;
                input_state_box.classList.remove('clicked');
                selected_state_i.classList.replace('fa-angle-up', 'fa-angle-down');
            }
        })

        state_list_box_span.forEach(element => {
            element.addEventListener('click', () => {
                func_for_remove_click_on_state_list_box_span();
                element.classList.add('active_state');

                selected_state_p.textContent = element.textContent;
                input_state_box.classList.remove('clicked');
                selected_state_i.classList.replace('fa-angle-up', 'fa-angle-down');
            })
        })

        var highlight_state_div = (index) => {
            let max_index = state_list_box_span.length - 1;

            if (index < 0) {
                index = max_index;
            } else if (index > max_index) {
                index = 0;
            }

            state_list_box_span.forEach((val, num) => {
                if (index == num) {
                    func_for_remove_click_on_state_list_box_span();
                    val.classList.add('active_state');
                }

                currentFocus = index;
            })

           
        }
    }
    else {
        state_list_box.style.display = 'none';
        input_state_box_p.style.display = 'flex';
        input_state_box_p.textContent = json.message;
    }
}

var handle_api_data = (json) => {
    console.log(json);
    var arr = json.arr;

    if (json.status_code == 200) {
        country_list_div.innerHTML = arr.map(val => {

            let { city } = val;
            let city_id = val.id;
            input_of_country_div_p.style.display = 'none';

            return `
                <span id='${city_id.$oid}'>${city}</span>
            `
        }).join('');

        let country_list_div_span = document.querySelectorAll('.country_list_div span');

        country_list_div_span[0].classList.add('active');

        var func_for_remove_click_on_country_list_div_span = () => {
            country_list_div_span.forEach(element => {
                element.classList.remove('active');
            })
        }

        let currentFocus = 0;

        input_of_country_div_input.addEventListener('keydown', (event) => {
            if (event.key == 'ArrowDown') {
                event.preventDefault();
                highlight_div(currentFocus += 1);
                adjustScroll();

            } else if (event.key == 'ArrowUp') {
                event.preventDefault();
                highlight_div(currentFocus -= 1);
                adjustScroll();

            } else if (event.key == 'Enter') {
                let active_div = document.querySelector('.active');

                selected_country_p.textContent = active_div.textContent;

                input_of_country_div.classList.remove('clicked');
                selected_country_i.classList.replace('fa-angle-up', 'fa-angle-down');

            }
        })

        country_list_div_span.forEach(element => {
            element.addEventListener('click', () => {
                func_for_remove_click_on_country_list_div_span();
                element.classList.add('active');

                selected_country_p.textContent = element.textContent;

                input_of_country_div.classList.remove('clicked');
                selected_country_i.classList.replace('fa-angle-up', 'fa-angle-down');

            })
        })

        var highlight_div = (index) => {
            let max_index = country_list_div_span.length - 1;

            if (index < 0) {
                index = max_index;
            } else if (index > max_index) {
                index = 0;
            }


            country_list_div_span.forEach((val, num) => {
                if (index == num) {
                    func_for_remove_click_on_country_list_div_span();
                    val.classList.add('active');
                }
            })

            currentFocus = index;

        }

        var adjustScroll = () => {
            const highlightedItem = document.querySelector('.active');
            if (highlightedItem) {
                const containerHeight = country_list_div.offsetHeight;
                const itemTop = highlightedItem.offsetTop;
                const itemHeight = highlightedItem.offsetHeight;


                if (itemTop < country_list_div.scrollTop) {
                    country_list_div.scrollTop = itemTop;
                } else if (itemTop + itemHeight > country_list_div.scrollTop + containerHeight) {
                    country_list_div.scrollTop = itemTop + itemHeight - containerHeight;
                }
            }
        }

    } else {
        country_list_div.style.display = 'none';
        input_of_country_div_p.style.display = 'flex';
        input_of_country_div_p.textContent = json.message;
    }
}

var url = 'php/select_city.php';

input_of_country_div_input.addEventListener('input', (event) => {
    input_of_country_div_p.textContent = 'Searching...';
    country_list_div.style.display = 'flex';
    var city_name_input_value = input_of_country_div_input.value;

    if (city_name_input_value == '') {
        country_list_div.style.display = 'none';
        input_of_country_div_p.style.display = 'flex';
        input_of_country_div_p.textContent = 'Please enter 1 or more characters.';
    }

    let country_id = localStorage.getItem('country_id');
    // console.log(country_id); 

    fetch(url, {
        method: 'POST',
        body: JSON.stringify({
            city_input: city_name_input_value,
            state_id: stateId.$oid
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },

    })
        .then(response => response.json())
        .then(handle_api_data)
        .catch(error => error)

})

var insertUrl = 'php/userInfo.php';

const userInfo = (city, username, useremail, userId,stateName) => {
    fetch(insertUrl, {
        method: 'POST',
        body: JSON.stringify({
            userId: userId,
            cityName: city,
            name: username,
            email: useremail,
            statename: stateName 
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
        })
}

continue_btn.addEventListener('click', () => {
    let stateName = selected_state_p.textContent;
    let cityName = selected_country_p.textContent;
    let name_input_value = name_div_input.value;
    let email_input_value = email_div_input.value;
    // console.log(stateName);
    userInfo(cityName, name_input_value, email_input_value, userId,stateName);
    // window.location.href = 'matches.html';
})

