const join_sign_div = document.querySelector('.join_sign_in_div');
const icon_img_div = document.querySelector('.icon_image');

const demo_url = 'php/demo.php';

 check_session = () =>  {
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
                join_sign_div.style.display = "none";
                icon_img_div.style.display = "block";
            }
            else if (json.status_code == 400) {
                join_sign_div.style.display = "block";
                icon_img_div.style.display = "none";
                window.location.href = 'signin.php';
            }
        })
}

check_session();