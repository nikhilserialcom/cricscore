let btn_2 = document.querySelector('.btn_2');
let main_play = document.querySelector('.main_play');
let heading_i = document.querySelector('.heading i');
let btn = document.querySelector('.btn');
let outer_all = document.querySelector('.outer_all');


btn_2.onclick = function () {
    main_play.classList.add("user");
}

heading_i.onclick = function () {
    alert("fjdfhsd");

}

btn.onclick = function () {
    outer_all.innerHTML = `
                        <div class="outer_select">
                        <div class="sub_select">
                            <div class="heading">
                                <h3>Match Officials <i class="fa-solid fa-circle-xmark"></i></h3>
                            </div>
                            <div class="title">
                                <p>Select Umpires</p>
                                <div class="images">
                                    <div class="img_1">
                                        <img src="img/Group 10466.png" alt="">
                                    </div>
                                    <div class="img_1">
                                        <img src="img/Group 10466.png" alt="">
                                    </div>
                                    <div class="img_1">
                                        <img src="img/Group 10466.png" alt="">

                                    </div>
                                    <div class="img_1">
                                        <img src="img/Group 10466.png" alt="">
                                    </div>

                                </div>
                                <div class="title">
                                    <p>Select Umpires</p>
                                    <div class="images_1">
                                        <div class="img_2">
                                            <img src="img/Group 10473.png" alt="">
                                        </div>
                                        <div class="img_2">
                                            <img src="img/Group 10473.png" alt="">
                                        </div>
                                    </div>
                                </div>

                                <div class="title">
                                    <p>Select Umpires</p>
                                    <div class="images_1">
                                        <div class="img_2">
                                            <img src="img/Group 10477.png" alt="">
                                        </div>
                                        <div class="img_2">
                                            <img src="img/Group 10476.png" alt="">
                                        </div>
                                        <div class="img_2">
                                            <img src="img/Group 10475.png" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="btn">
                                    <button>DONE</button>

                                </div>
                            </div>
                        </div>
                    </div>`;
}