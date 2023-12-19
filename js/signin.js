const select_country_inner_div = document.querySelector('.select_country_inner_div');
const input_of_country_div = document.querySelector('.input_of_country_div');
const input_of_country_div_input = document.querySelector('.input_of_country_div input');
const input_of_country_div_p = document.querySelector('.input_of_country_div p');
const country_list_div = document.querySelector('.country_list_div');
const selected_country_i = document.querySelector('.selected_country_and_i_div .fa-angle-down');
const selected_country_p = document.querySelector('.selected_country_and_i_div p');
const country_code_div = document.querySelector('.country_code_div');
const continue_btn = document.querySelector('.continue_btn');
const mobile_number = document.querySelector('.mobile_number');

var unique_id = '65278051747b3c13af077991';

var validation = () => {
    var countryError = document.querySelector('.country_error');
    var numberError = document.querySelector('.mobile_error');

    var mobilePattern = /^[0-9]{10}$/;

    var isValid = true;

    if (input_of_country_div_input.value.trim() === "") {
        countryError.innerHTML = "Please select a country.";
        isValid = false;
    } else {
        countryError.innerHTML = "";
        isValid = true;
    }

    if (!mobilePattern.test(mobile_number.value)) {
        numberError.innerHTML = "Please enter a valid 10-digit mobile number.";
        isValid = false;
    } else {
        numberError.innerHTML = "";
        isValid = true;
    }

    return isValid;
}



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


var handle_api_data = (json) => {

    // console.log(json.arr);
    var arr = json.arr;

    if (json.status_code == 200) {
        country_list_div.innerHTML = arr.map(val => {

            let { country, country_code } = val;
            let country_id = val.id;
            input_of_country_div_p.style.display = 'none';

            return `
                <span id='${country_code}' data-info='${country_id.$oid}'>${country}</span>
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

                let country_code = active_div.id;

                unique_id = active_div.dataset.info;

                country_code_div.textContent = country_code;

                selected_country_p.textContent = active_div.textContent;

                input_of_country_div.classList.remove('clicked');
                selected_country_i.classList.replace('fa-angle-up', 'fa-angle-down');

            }
        })

        country_list_div_span.forEach(element => {
            element.addEventListener('click', () => {
                func_for_remove_click_on_country_list_div_span();
                element.classList.add('active');

                let country_code = element.id;

                unique_id = element.dataset.info;

                country_code_div.textContent = country_code;

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

var url = 'php/index.php';

input_of_country_div_input.addEventListener('input', (event) => {
    input_of_country_div_p.textContent = 'Searching...';
    country_list_div.style.display = 'flex';
    var country_name_input_value = input_of_country_div_input.value;

    if (country_name_input_value == '') {
        country_list_div.style.display = 'none';
        input_of_country_div_p.style.display = 'flex';
        input_of_country_div_p.textContent = 'Please enter 1 or more characters.';
    }


    fetch(url, {
        method: 'POST',
        body: JSON.stringify({
            input: country_name_input_value,
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },

    })
        .then(response => response.json())
        .then(handle_api_data)

        .catch(error => error)
})

var userInfoUrl = 'php/login.php';

const userInfo = (countryName, mobileNo) => {
    fetch(userInfoUrl, {
        method: 'POST',
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
        body: JSON.stringify({
            country: countryName,
            mobileNumber: mobileNo,
        }),
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
            if (json.status_code == 200) {
                localStorage.setItem('situation', json.situation);
                window.location.href = 'otp.php';
            } else if (json.status_code == 422) {
                // window.location.href = 'otp.php';
            } else {
                alert('somthing went worng');
            }
        })
}
continue_btn.addEventListener('click', () => {
    let validate = validation();
    if (validate == true) {
        let countryName = selected_country_p.textContent;
        let mobileNumber = country_code_div.textContent + mobile_number.value;
        userInfo(countryName,mobileNumber);
        localStorage.setItem('country_id', unique_id);
        localStorage.setItem('mobileNo', mobileNumber);
    }
})