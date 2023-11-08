

let sub_header_li = document.querySelectorAll(".sub_header ul li");
let outer_main_div = document.querySelector('.outer_main_div');
let sub_color = document.querySelector('.sub_color');


window.addEventListener('DOMContentLoaded', () => {
    sub_header_li[0].classList.add('sub_color');
});


function resetactive() {
    sub_header_li.forEach((li_btn) => {
        li_btn.classList.remove('sub_color');

    });
}

sub_header_li[0].onclick = function () {
    resetactive();
    sub_header_li[0].classList.add('sub_color');
    outer_main_div.innerHTML = `
                                <div class="main_members">
                                <div class="main_1">
                                    <div class="container">
                                        <div class="multi_image">
                                            <div class="icon">
                                                <i class="fa-solid fa-check"></i>
                                            </div>
                                            <img src="img/Group 2198 (3).png" alt="">
                                            <p>Rakesh Paladiya</p>
                                        </div>

                                        <div class="multi_image">
                                            <img src="img/Group 2198 (3).png" alt="">
                                            <p>Atul Ghevariya</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (3).png" alt="">
                                            <p>Bhavesh Gorasiya</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (3).png" alt="">
                                            <p>Dinesh Narola</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (3).png" alt="">
                                            <p>Kamlesh Lathiya</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (3).png" alt="">
                                            <p>Krunal Patel</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (3).png" alt="">
                                            <p>Nikunj Gadhiya</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (3).png" alt="">
                                            <p>Naitik Golakiya</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (3).png" alt="">
                                            <p>Paresh Virani</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (3).png" alt="">
                                            <p>Raj Khunt</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (3).png" alt="">
                                            <p>Shubham Patel</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (3).png" alt="">
                                            <p>Vishal Gajera</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (3).png" alt="">
                                            <p>Hasmukh Jayani</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (3).png" alt="">
                                            <p>Jonty</p>
                                        </div>
                                    </div>

                                </div>

                                </div>`;
}
sub_header_li[1].onclick = function () {
    resetactive();
    sub_header_li[1].classList.add('sub_color');
    outer_main_div.innerHTML = `
                                 
                            <div class="outer">
                            <div class="outer-1">
                           <div class="sub_outer_1">
                                     <div class="main_cricket">
                                        <div class="sub_cricket">
                                            <h4>Night Cricket Tournament</h4>
                                             <div class="sub_cricket_2"></div>
                                             <div class="w-33">
                                             <p>SRK Sports Complex, Surat <br>02-Apr-23 05:36 PM, 6 Over</p>
                                                 <button>RESULT</button>
                                             </div>
                                             <span>Super Knockout</span>
                                             <div class="little">
                                                 <p>CRICBOYZ</p>
                                                 <p>171/8 (18.5)</p>
                                             </div>
                                             <div class="little">
                                                 <p>TEAM UNIQUE </p>
                                                 <p>130/5 (15.1)</p>
                                             </div>
                                             <div class="last"></div>
                                            <h4>MANTRA LIONS needs 12 runs in 7 balls</h4>

                                        </div>
                                        <div class="sub_cricket">
                                            <h4>Night Cricket Tournament</h4>
                                            <div class="sub_cricket_2"></div>
                                            <div class="w-33">
                                                <p>SRK Sports Complex, Surat <br>02-Apr-23 05:36 PM, 6 Over</p>
                                                <button>RESULT</button>
                                            </div>
                                            <span>Super Knockout</span>
                                            <div class="little">
                                                <p>CRICBOYZ</p>
                                                <p>171/8 (18.5)</p>
                                            </div>
                                            <div class="little">
                                                <p>TEAM UNIQUE </p>
                                                <p>Yet to bat</p>
                                            </div>
                                            <div class="last"></div>
                                            <h4>CRICBOYZ won the toss and elected to bat</h4>

                                        </div>
                                        <div class="sub_cricket_1">
                                            <h4>Night Cricket Tournament</h4>
                                            <div class="sub_cricket_2"></div>
                                            <div class="w-33">
                                                <p>SRK Sports Complex, Surat <br>02-Apr-23 05:36 PM, 6 Over</p>
                                                <button>RESULT</button>
                                            </div>
                                            <span>Super Knockout</span>
                                            <div class="little">
                                                <p>CRICBOYZ</p>
                                                <p>171/8 (18.5)</p>
                                            </div>
                                            <div class="little">
                                                <p>TEAM UNIQUE </p>
                                                <p>Yet to bat</p>
                                            </div>
                                            <div class="last"></div>
                                            <h4>CRICBOYZ won the toss and elected to bat</h4>
                                        </div>

                                    </div>
                                </div>

                                <div class="sub_outer_1">
                                    <div class="main_cricket">
                                        <div class="sub_cricket">
                                            <h4>Night Cricket Tournament</h4>
                                            <div class="sub_cricket_2"></div>
                                            <div class="w-33">
                                                <p>SRK Sports Complex, Surat <br>02-Apr-23 05:36 PM, 6 Over</p>
                                                <button>RESULT</button>
                                            </div>
                                            <span>Super Knockout</span>
                                            <div class="little">
                                                <p>CRICBOYZ</p>
                                                <p>171/8 (18.5)</p>
                                            </div>
                                            <div class="little">
                                                <p>TEAM UNIQUE </p>
                                                <p>Yet to bat</p>
                                            </div>
                                            <div class="last"></div>
                                            <h4>MANTRA LIONS needs 12 runs in 7 balls</h4>

                                        </div>
                                        <div class="sub_cricket">
                                            <h4>Night Cricket Tournament</h4>
                                            <div class="sub_cricket_2"></div>
                                            <div class="w-33">
                                                <p>SRK Sports Complex, Surat <br>02-Apr-23 05:36 PM, 6 Over</p>
                                                <button>RESULT</button>
                                            </div>
                                            <span>Super Knockout</span>
                                            <div class="little">
                                                <p>CRICBOYZ</p>
                                                <p>171/8 (18.5)</p>
                                            </div>
                                            <div class="little">
                                                <p>TEAM UNIQUE</p>
                                                <p>Yet to bat</p>
                                            </div>
                                            <div class="last"></div>
                                            <h4>CRICBOYZ won the toss and elected to bat</h4>

                                        </div>
                                        <div class="sub_cricket_1">
                                            <h4>Night Cricket Tournament</h4>
                                            <div class="sub_cricket_2"></div>
                                            <div class="w-33">
                                                <p>SRK Sports Complex, Surat <br>02-Apr-23 05:36 PM, 6 Over</p>
                                                <button>RESULT</button>
                                            </div>
                                            <span>Super Knockout</span>
                                            <div class="little">
                                                <p>CRICBOYZ</p>
                                                <p>171/8 (18.5)</p>
                                            </div>
                                            <div class="little">
                                                <p>TEAM UNIQUE </p>
                                                <p>Yet to bat</p>
                                            </div>
                                            <div class="last"></div>
                                            <h4>CRICBOYZ won the toss and elected to bat</h4>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div> `;

}

sub_header_li[2].onclick = function () {
    resetactive();
    sub_header_li[2].classList.add('sub_color');
    outer_main_div.innerHTML = `
                                <div class="main_stat">
                                <div class="mian_2">
                                    <div class="main">
                                        <div class="iteams">
                                            <h1>4</h1>
                                            <p>MATCHES</p>
                                        </div>
                                        <div class="iteams">
                                            <h1>0</h1>
                                            <p>MATCHES</p>
                                        </div>
                                        <div class="iteams">
                                            <h1>3</h1>
                                            <p>WON</p>
                                        </div>
                                        <div class="iteams">
                                            <h1>0</h1>
                                            <p>TIE</p>
                                        </div>
                                        <div class="iteams">
                                            <h1>0</h1>
                                            <p>DRAWN</p>
                                        </div>
                                        <div class="iteams">
                                            <h1>2</h1>
                                            <p>TOSS WON</p>
                                        </div>
                                        <div class="iteams">
                                            <h1>1</h1>
                                            <p>BAT FIRST</p>
                                        </div>
                                        <div class="iteams">
                                            <h1>1</h1>
                                            <p>FIELD FIRST</p>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
}

sub_header_li[3].onclick = function () {
    resetactive();
    sub_header_li[3].classList.add('sub_color');
    outer_main_div.innerHTML = `
                            <div class="outer">
                            <div class="main_camera">
                                <img src="img/Group.png" alt="">

                            </div>

                            <div class="main_tetx">
                                <div class="tetx_1">
                                <p>Oops...It's empty in here.</p>
                                <p>Scorer has not uploaded any photos yet.</p>
                            </div>
                        </div>
                        </div>  `;
}

sub_header_li[4].onclick = function () {
    resetactive();
    sub_header_li[4].classList.add('sub_color');
    outer_main_div.innerHTML = `
                                <div class="main_profile">
                                <div class="profile_1">
                                    <div class="profile_2">
                                        <p>LOCATIONS</p>
                                        <p>Surat - Capital Lawns</p>
                                    </div>
                                    <div class="profile_3">
                                        <p>SINCE</p>
                                        <p>22-Mar,2022</p>
                                    </div>
                                </div>

                            </div> `;
}