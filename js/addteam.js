var Scheme = window.location.protocol;
var hostname = window.location.hostname + ":" + window.location.port;
var SchemeAndHttpHost = Scheme + '//' + hostname;

let Group = document.querySelector(".Group button");
let page = document.querySelector('.page');
let icon_i = document.querySelector('.icon i');
let footer = document.querySelector('.main_footer');
let list_ul = document.querySelectorAll(".list ul li");
let sub_color = document.querySelector('.sub_color');
let outer_all = document.querySelector('.outer_all');
let outer_main_div = document.querySelector('.outer_main_div');
let main_player = document.querySelector('.main_player');
let outer_button = document.querySelector('.btn');
let add_player = document.querySelector('.list_2 .btn button');
let list_1 = document.querySelector('.list_1');
let list_1_input = document.querySelector('.list_1 input');

let list_2_input = document.querySelectorAll('.list_2 input');
let message = document.querySelector('.outer_all .message');
let player_name = document.querySelector('.paladiya');


list_1_input.addEventListener('input',() => {
    let file = list_1_input.files[0];
    let formData = new FormData();
    formData.append('playerProfile',file);
    window.uploadedFormData = formData;
});

list_1.addEventListener('click',() => {
    list_1_input.click();
})

outer_button.onclick = function () {
    window.location.href = "selectcaption.html";
}

Group.onclick = function () {
    main_player.classList.add("adduser");
    page.classList.add("openuser");
    footer.style.display = "none";
}

icon_i.onclick = function () {
    page.classList.remove("openuser");
    footer.style.display = "flex";
}

window.addEventListener('DOMContentLoaded', () => {
    list_ul[0].classList.add('sub_color');
});

function resetactive() {
    list_ul.forEach((li_btn) => {
        li_btn.classList.remove('sub_color');

    });
}

icon_i.onclick = function () {
    window.location.href = "startmatch.html";
}


list_ul[0].onclick = function () {
    resetactive();
    list_ul[0].classList.add('sub_color');
    outer_all.innerHTML = `
            <div class="main_list">
                <div class="list_1">
                    <img src="img/Vector (32).png" alt="">
                    <p>Add Team Logo</p>
                    <input type="file" name="playerProfile" id="playerProfile" accept=".jpg,image/jpg">
                </div>
                <div class="list_2">
                    <p>Player Name*</p>
                    <input type="text" class="playername" style="padding: 0.5rem;">
                    <p>Valid Phone Number*</p>
                    <input type="text" class="mobileNumber" style="padding: 0.5rem;">
                    <p>Valid Email*</p>
                    <input type="email" class="email" style="padding: 0.5rem;">
                    <div class="btn">
                        <button>ADD PLAYERS</button>
                    </div>
                </div>
            </div>
    `;
}

list_ul[1].onclick = function () {
    resetactive();
    list_ul[1].classList.add('sub_color');
    outer_all.innerHTML = `
        <div class="input_serch">
            <input type="search" placeholder="Search by player name....">
        </div>
        <div class="buttons">
            <button>ADD TEAM</button>
        </div>
        <div class="search_resul">nikhil</div>`;
}
list_ul[2].onclick = function () {
    resetactive();
    list_ul[2].classList.add('sub_color');
    outer_all.innerHTML = `
            <div class="box">
                <div class="box_1">
                    <p>Player Name*</p>
                    <p>Valid Phone Number*</p>
                </div>
                <div class="box_1">
                    <p>Player Name*</p>
                    <p>Valid Phone Number*</p>
                </div>
            </div>
            <div class="box">
                <div class="box_1">
                    <p>Player Name*</p>
                    <p>Valid Phone Number*</p>
                </div>
                <div class="box_1">
                    <p>Player Name*</p>
                    <p>Valid Phone Number*</p>
                </div>
            </div>
            <div class="buttons">
                <button> ADD PLAYERS</button>
            </div>`;
}

const playersUrl = 'php/admin/showplayer.php';

var players = () => {
    fetch(playersUrl,{
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            // console.log(json);
            var arr = json.arr;
            if(json.status_code == 200)
            {
                player_name.innerHTML = arr.map(val => {
                    let{ playerName,playerProfile } = val;

                    return `
                    <div class="member">
                        <div class="member_1">
                            <img src="${SchemeAndHttpHost}/cricscorer_website/php/${playerProfile}" alt="">
                            <div class="second">
                                <b>${playerName}</b>
                                <p>All Rounder</p>
                            </div>
                        </div>
                    </div>
                    `;
                }).join('');
            }
            else
            {
                console.log(json.message);
            }
        })
}

players();

const addplayerUrl = 'php/addplayer.php';

var playerInfo = (playerProfile) => {
    fetch(addplayerUrl,{
        method: 'POST',
        body: playerProfile,
    })
        .then(response => response.json())
        .then(json => {
            // console.log(json);
            if(json.status_code == 200)
            {
                message.style.display = 'flex';
                message.classList.add('alert-success');
                document.querySelector('.message p').textContent = json.message; 
                setTimeout(() => {
                    message.style.display = 'none';
                },3000);
            }   
            else
            {
                message.style.display = 'flex';
                message.classList.add('alert-danger');
                document.querySelector('.message p').textContent = json.message;
                setTimeout(() => {
                    message.style.display = 'none';
                },3000);
            }
        })
}

add_player.onclick = () => {
    const imageFile = window.uploadedFormData;
    imageFile.append('playerName',list_2_input[0].value);
    imageFile.append('mobileNumber',list_2_input[1].value);
    imageFile.append('playerEmail',list_2_input[2].value);
    playerInfo(imageFile);
}