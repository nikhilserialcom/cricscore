var Scheme = window.location.protocol;
var hostname = window.location.hostname + ":" + window.location.port;
var SchemeAndHttpHost = Scheme + '//' + hostname;

let Group = document.querySelector(".Group");
let page = document.querySelector('.page');
let icon_i = document.querySelector('.icon i');
let footer = document.querySelector('.main_footer');
let outer_main_div = document.querySelector('.outer_main_div');
let list_ul = document.querySelectorAll(".list ul li");
let sub_color = document.querySelector('.sub_color');
let outer_all = document.querySelector('.outer_all');
let list_1 = document.querySelector('.list_1');
let list_1_input = document.querySelector('.list_1 input');

let list_2 = document.querySelector('.list_2');
let list_2_select = document.querySelector('.list_2 .state');
let list_2_city_select = document.querySelector('.list_2 .city');
let list_2_input = document.querySelector('.list_2 input');

// console.log(list_2_city_select);
let country_id = localStorage.getItem('country_id');
var selectState;
var selectCity;


var file_formData;

list_1_input.addEventListener('input', () => {
    // console.log(list_1_input.files);   
    
    let file = list_1_input.files[0];
    let formData = new FormData();
    formData.append('imageFile',file);
    window.uploadedFormData = formData;
   
})


list_1.addEventListener('click', () => {
    list_1_input.click();
})

const stateUrl ='php/admin/showstate.php';

var showState = (countryId) => {
    fetch(stateUrl, {
        method: 'POST',
        body: JSON.stringify({
            country_id: countryId
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            // console.log(json);
            var arr = json.arr;
            if(json.status_code == "200")
            {
                list_2_select.innerHTML = arr.map(val => {
                    let {state} =val;
                    let stateId = val.id;
                    return `
                        <option value="${stateId.$oid}">${state}</option>
                    `;
                }).join('');
            }
        })
}

const cityUrl = 'php/showcity.php';

const showcity = (stateId) => {
    fetch(cityUrl,{
        method: 'POST',
        body: JSON.stringify({
            state_id: stateId,
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            // console.log(json);
            let arr =json.arr;
            if(json.status_code == 200)
            {
                list_2_city_select.innerHTML = arr.map(val => {
                    let {city} =val;
                    let cityId = val.id;
                    return `
                    <option value="${cityId.$oid}">${city}</option>
                    `;
                }).join('');
            }
        })
}

const getstatevalue = () => {
    selectState = list_2_select.value;
    showcity(selectState);
    // console.log(selectState);
 }
Group.onclick = function () {
    // console.log(country_id);
    page.classList.add("openuser");
    footer.style.display = "none";
    showState(country_id);
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

list_ul[0].onclick = function () {
    resetactive();
    list_ul[0].classList.add('sub_color');
    outer_all.style.overflow = 'unset';
    outer_all.innerHTML = `
            <div class="main_list">
                <div class="list_1">
                    <img src="img/Vector (32).png" alt="">
                    <p>Add Team Logo</p>
                    <input type="file" name="imageFIle" id="imageFIle" accept=".png, .jpg, image/png, image/jpeg">
                </div>
                <div class="list_2">
                    <p>Team Name*</p>
                    <input type="text">
                    <div class="option">
                        <p>state*</p>
                        <select class="state" onchange="getstatevalue()">
                            <option value="">surat</option>
                            <option value="">surat</option>
                            <option value="">surat</option>
                            <option value="">surat</option>
                            <option value="">surat</option>
                            <option value="">surat</option>
                        </select>

                        <p>City/Town*</p>
                        <select class="city" onchange="getCityValue()">
                            <option value="">Select city</option>
                            <!-- <option value="">surat</option>
                            <option value="">surat</option>
                            <option value="">surat</option>
                            <option value="">surat</option>
                            <option value="">surat</option> -->
                        </select>
                        <div class="btn">
                            <button>ADD TEAM</button>
                        </div>
                    </div>
                </div>
            </div>`;
        // const list_2_select = document.querySelector('.list_2 .state');   
        console.log(list_2_select);
    showState(country_id);
}

const showteamUrl = 'php/admin/showteam.php';

var showAllteam = (main_barcode) => {
    fetch(showteamUrl,{
        method: 'POST',
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
            var arr = json.arr;
            if(json.status_code == 200)
            {
                main_barcode.innerHTML = arr.map(val => {
                    let { teamName,teamState,teamCity,teamProfile } = val;

                    return `
                        <div class="div">
                            <div class="div_1">
                                <div class="main_barcode">
                                    <div class="img_1">
                                        <img src="${SchemeAndHttpHost}/cricscorer_website/php/${teamProfile}" alt="">
                                        <h3>${teamName}</h3>

                                    </div>

                                    <div class="barcode">
                                        <img src="img/Vector (33).png" alt="">
                                    </div>
                                </div>
                                <div class="ul_text">
                                    <ul>
                                        <li> <i class="fa-solid fa-location-dot"></i><span>${teamState}</span></li>
                                        <li> <i class="fa-solid fa-c"></i><span>${teamCity}</span></li>
                                        <li style="color: #920000; border-bottom:1px solid #920000 ;">Members</li>

                                    </ul>
                                </div>

                            </div>
                        </div>


                        `;
                }).join('');
            }
        })
}



main_barcode.appendChild()

list_ul[1].onclick = function () {
    resetactive();

    list_ul[1].classList.add('sub_color');
    // outer_all.style.overflow = 'auto';
    outer_all.innerHTML = `
  
                <div class="div">
                    <div class="div_1">
                        <div class="main_barcode">
                            <div class="img_1">
                                <img src="img/Group 10452.png" alt="">
                                <h3>CRICBOYZ</h3>

                            </div>

                            <div class="barcode">
                                <img src="img/Vector (33).png" alt="">
                            </div>
                        </div>
                        <div class="ul_text">
                            <ul>
                                <li> <i class="fa-solid fa-location-dot"></i><span>Surat</span></li>
                                <li> <i class="fa-solid fa-c"></i><span>Surat</span></li>
                                <li style="color: #920000; border-bottom:1px solid #920000 ;">Members</li>

                            </ul>
                        </div>
                    </div>
                </div>
                `;
    const main_barcode = document.querySelector('.outer_all');
    // console.log(main_barcode);

    showAllteam(main_barcode);
}

const searchteamUrl = 'php/admin/searchteam.php';
var searchteam = (team_input) => {
    fetch(searchteamUrl,{
        method: 'POST',
        body: JSON.stringify({
            team_name: team_input
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
list_ul[2].onclick = function () {
    resetactive();
    list_ul[2].classList.add('sub_color');
    outer_all.innerHTML = `
            <div class="input_serch">
                <input type="search" placeholder="search">
            </div>
            <div class="buttons">
                <button>ADD TEAM</button>
            </div>
            <p class="or">or</p>
            <p class="or">Do you have team's QR code? If yes,try following</p>
            <div class="btn_1">
                <button> SCAN A CODE</button>
            </div>`;
    
    const team_input = document.querySelector('.input_serch input');
    // console.log(team_input); 

    team_input.addEventListener('input', () => {
        // console.log(team_input.value);
        searchteam(team_input.value);
    })

}

const teamInfoUrl = 'php/addteam.php';

const teamInfo = (formDataToSend) => {
    fetch(teamInfoUrl,{
        method : 'POST',
        body: formDataToSend,
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
            if(json.status_code == 200) {
                // console.log(json.message);
                window.location.href = 'selectplayer.html';
            }
            else if(json.status_code == 422){
                let message = document.querySelector('.message');
                message.style.display = 'flex';
                document.querySelector('.message p').textContent = json.message;

                setTimeout(() => {
                    message.style.display = 'none';
                },3000);
            }
        })
}

const getCityValue = () => {
   selectCity = list_2_city_select.value;
//    console.log(selectCity);
}
let buttons = document.querySelector('.btn button');

buttons.onclick = function () {
    const teamname = list_2_input.value;
    window.location.href = 'selectplayer.html';
    const formDataToSend = window.uploadedFormData;
    formDataToSend.append('teamName',teamname);
    formDataToSend.append('teamstate',selectState);
    formDataToSend.append('teamcity',selectCity);
    // teamInfo(formDataToSend);
}
