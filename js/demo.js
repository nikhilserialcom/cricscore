const demo_url = 'php/demo.php';

const demo_data = () => {
    fetch(demo_url, {
        method: 'GET',
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
            if(json.status_code == 400)
            {
                // window.location.href = "signin.html";
            }
        })
}

demo_data();