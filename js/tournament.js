let outer_main_div = document.querySelector('.outer_main_div');
let sub_header_1_li = document.querySelectorAll(".sub_header_1 ul li");
let sub_color = document.querySelector('.sub_color');


window.addEventListener('DOMContentLoaded', () => {
    sub_header_1_li[0].classList.add('sub_color');
});

function resetactive() {
    sub_header_1_li.forEach((li_btn) => {
        li_btn.classList.remove('sub_color');

    });
}

sub_header_1_li[0].onclick = function () {
    resetactive();
    sub_header_1_li[0].classList.add('sub_color');
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
                                                        <button style="background-color:#F99F0D;">UP COMING</button>
                                                    </div>
                                                    <span>Super Knockout</span>
                                                    <div class="little">
                                                        <p>CRICBOYZ</p>
                                                        <p>171/8 (18.5)</p>
                                                    </div>
                                                    <div class="little">
                                                        <p>MANTRA LIONS</p>
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
                                                        <button style="background-color:#F99F0D;">UP COMING</button>

                                                    </div>
                                                    <span>Super Knockout</span>
                                                    <div class="little">
                                                        <p>CRICBOYZ</p>
                                                        <p>171/8 (18.5)</p>
                                                    </div>
                                                    <div class="little">
                                                        <p>MANTRA LIONS </p>
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
                                                        <button style="background-color:#F99F0D;">UP COMING</button>

                                                    </div>
                                                    <span>Super Knockout</span>
                                                    <div class="little">
                                                        <p>CRICBOYZ</p>
                                                        <p>171/8 (18.5)</p>
                                                    </div>
                                                    <div class="little">
                                                        <p>MANTRA LIONS </p>
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
                                                        <p>MANTRA LIONS </p>
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
                                                        <p>MANTRA LIONS </p>
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
                                                        <p>MANTRA LIONS </p>
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
                                                        <p>MANTRA LIONS </p>
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
                                                        <p>MANTRA LIONS </p>
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
                                                        <p>MANTRA LIONS </p>
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
                                                        <p>MANTRA LIONS </p>
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
                                                        <p>MANTRA LIONS </p>
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
                                                        <p>MANTRA LIONS </p>
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
                                                        <p>MANTRA LIONS </p>
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
                                                        <p>MANTRA LIONS </p>
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
                                                        <p>MANTRA LIONS </p>
                                                        <p>Yet to bat</p>
                                                    </div>
                                                    <div class="last"></div>
                                                    <h4>CRICBOYZ won the toss and elected to bat</h4>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>`;
}
sub_header_1_li[1].onclick = function () {
    resetactive();
    sub_header_1_li[1].classList.add('sub_color');
    outer_main_div.innerHTML = `
                                <div class="head">
                                <div class="sub">
                                    <div class="buttons">
                                        <ul>
                                            <li class="color"><a onclick="show_hide()">BATTING</a></li>
                                            <script src="/team.js"></script>
                                            <li class="hide"><a href="http://127.0.0.1:5500/bowling.html">BOWLING</a></li>
                                            <li class="hide"><a href="http://127.0.0.1:5500/fileding.html">FIELDING</a></li>

                                        </ul>
                                    </div>
                                    <div id="btn">
                                        <ul>
                                            <li style="margin-top:30px;"><a href="http://127.0.0.1:5500/bowling.html">BOWLING</a></li>
                                            <li style="margin-top:30px;"><a href="http://127.0.0.1:5500/fileding.html">FIELDING</a></li>
                                            <ul>
                                    </div>

                                    <div class="main">
                                        <div class="iteams">
                                            <h1>128</h1>
                                            <p>MATCHES</p>
                                        </div>
                                        <div class="iteams">
                                            <h1>118</h1>
                                            <p>INNINGS</p>
                                        </div>
                                        <div class="iteams">
                                            <h1>60</h1>
                                            <p>NOT OUT</p>
                                        </div>
                                        <div class="iteams">
                                            <h1>4560</h1>
                                            <p>RUNS</p>
                                        </div>
                                        <div class="iteams">
                                            <h1>154</h1>
                                            <p>HIGHEST RUNS</p>
                                        </div>
                                        <div class="iteams">
                                            <h1>45.35</h1>
                                            <p>AVG</p>
                                        </div>
                                        <div class="iteams">
                                            <h1>186.54</h1>
                                            <p>SR</p>
                                        </div>
                                        <div class="iteams">
                                            <h1>40</h1>
                                            <p>50S</p>
                                        </div>
                                        <div class="iteams">
                                            <h1>8</h1>
                                            <p>100S</p>
                                        </div>
                                        <div class="iteams">
                                            <h1>275</h1>
                                            <p>4S</p>
                                        </div>
                                        <div class="iteams">
                                            <h1>346</h1>
                                            <p>6S</p>
                                        </div>
                                        <div class="iteams">
                                            <h1>95</h1>
                                            <p>WON</p>
                                        </div>
                                        <div class="iteams">
                                            <h1>33</h1>
                                            <p>LOSS</p>
                                        </div>

                                    </div>
                                </div> `};
sub_header_1_li[2].onclick = function () {
    resetactive();
    sub_header_1_li[2].classList.add('sub_color');
    outer_main_div.innerHTML = `
                                <div class="main_award">
                                <div class="sub_award">

                                    <div class="sub_award_1">
                                        <div class="award_image">
                                            <img src="img/Group 15.png" alt="">
                                        </div>
                                        <div class="sub_text">
                                            <h3>BEST BATSMAN</h3>
                                            <div class="sub_tetx_1">
                                                <p>MANTRA XI</p>
                                                <p>vs</p>
                                                <p>KAPS CRICKET <br>ACADEMY 2022-23</p>
                                            </div>
                                            <div class="tetx_2">
                                                <p>Batting</p>
                                                <p>63(24) * 5(4s) 6(6s) 262.50 SR</p>
                                            </div>
                                            <div class="tetx_3">
                                                <p>SARDAR PATEL PREMIER LEAGUE SEASON-2 PRESENT BY CAS X</p>
                                                <p>13-Apr,2023</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="sub_award_1">
                                        <div class="award_image">
                                            <img src="img/Group 15.png" alt="">
                                        </div>
                                        <div class="sub_text">
                                            <h3>BEST BATSMAN</h3>
                                            <div class="sub_tetx_1">
                                                <p>MANTRA XI</p>
                                                <p>vs</p>
                                                <p>KAPS CRICKET <br>ACADEMY 2022-23</p>
                                            </div>
                                            <div class="tetx_2">
                                                <p>Batting</p>
                                                <p>63(24) * 5(4s) 6(6s) 262.50 SR</p>
                                            </div>
                                            <div class="tetx_3">
                                                <p>SARDAR PATEL PREMIER LEAGUE SEASON-2 PRESENT BY CAS X</p>
                                                <p>13-Apr,2023</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="sub_award_1">
                                        <div class="award_image">
                                            <img src="img/Group 15.png" alt="">
                                        </div>
                                        <div class="sub_text">
                                            <h3>BEST BATSMAN</h3>
                                            <div class="sub_tetx_1">
                                                <p>MANTRA XI</p>
                                                <p>vs</p>
                                                <p>KAPS CRICKET <br>ACADEMY 2022-23</p>
                                            </div>
                                            <div class="tetx_2">
                                                <p>Batting</p>
                                                <p>63(24) * 5(4s) 6(6s) 262.50 SR</p>
                                            </div>
                                            <div class="tetx_3">
                                                <p>SARDAR PATEL PREMIER LEAGUE SEASON-2 PRESENT BY CAS X</p>
                                                <p>13-Apr,2023</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="sub_award_1">
                                        <div class="award_image">
                                            <img src="img/Group 15.png" alt="">
                                        </div>
                                        <div class="sub_text">
                                            <h3>BEST BATSMAN</h3>
                                            <div class="sub_tetx_1">
                                                <p>MANTRA XI</p>
                                                <p>vs</p>
                                                <p>KAPS CRICKET <br>ACADEMY 2022-23</p>
                                            </div>
                                            <div class="tetx_2">
                                                <p>Batting</p>
                                                <p>63(24) * 5(4s) 6(6s) 262.50 SR</p>
                                            </div>
                                            <div class="tetx_3">
                                                <p>SARDAR PATEL PREMIER LEAGUE SEASON-2 PRESENT BY CAS X</p>
                                                <p>13-Apr,2023</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="sub_award_1">
                                        <div class="award_image">
                                            <img src="img/Group 15.png" alt="">
                                        </div>
                                        <div class="sub_text">
                                            <h3>BEST BATSMAN</h3>
                                            <div class="sub_tetx_1">
                                                <p>MANTRA XI</p>
                                                <p>vs</p>
                                                <p>KAPS CRICKET <br>ACADEMY 2022-23</p>
                                            </div>
                                            <div class="tetx_2">
                                                <p>Batting</p>
                                                <p>63(24) * 5(4s) 6(6s) 262.50 SR</p>
                                            </div>
                                            <div class="tetx_3">
                                                <p>SARDAR PATEL PREMIER LEAGUE SEASON-2 PRESENT BY CAS X</p>
                                                <p>13-Apr,2023</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="sub_award_1">
                                        <div class="award_image">
                                            <img src="img/Group 15.png" alt="">
                                        </div>
                                        <div class="sub_text">
                                            <h3>BEST BATSMAN</h3>
                                            <div class="sub_tetx_1">
                                                <p>MANTRA XI</p>
                                                <p>vs</p>
                                                <p>KAPS CRICKET <br>ACADEMY 2022-23</p>
                                            </div>
                                            <div class="tetx_2">
                                                <p>Batting</p>
                                                <p>63(24) * 5(4s) 6(6s) 262.50 SR</p>
                                            </div>
                                            <div class="tetx_3">
                                                <p>SARDAR PATEL PREMIER LEAGUE SEASON-2 PRESENT BY CAS X</p>
                                                <p>13-Apr,2023</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="sub_award_1">
                                        <div class="award_image">
                                            <img src="img/Group 15.png" alt="">
                                        </div>
                                        <div class="sub_text">
                                            <h3>BEST BATSMAN</h3>
                                            <div class="sub_tetx_1">
                                                <p>MANTRA XI</p>
                                                <p>vs</p>
                                                <p>KAPS CRICKET <br>ACADEMY 2022-23</p>
                                            </div>
                                            <div class="tetx_2">
                                                <p>Batting</p>
                                                <p>63(24) * 5(4s) 6(6s) 262.50 SR</p>
                                            </div>
                                            <div class="tetx_3">
                                                <p>SARDAR PATEL PREMIER LEAGUE SEASON-2 PRESENT BY CAS X</p>
                                                <p>13-Apr,2023</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="sub_award_1">
                                        <div class="award_image">
                                            <img src="img/Group 16.png" alt="">
                                        </div>
                                        <div class="sub_text">
                                            <h3>BEST BATSMAN</h3>
                                            <div class="sub_tetx_1">
                                                <p>MANTRA XI</p>
                                                <p>vs</p>
                                                <p>KAPS CRICKET <br>ACADEMY 2022-23</p>
                                            </div>
                                            <div class="tetx_2">
                                                <p>Batting</p>
                                                <p>63(24) * 5(4s) 6(6s) 262.50 SR</p>
                                            </div>
                                            <div class="tetx_3">
                                                <p>SARDAR PATEL PREMIER LEAGUE SEASON-2 PRESENT BY CAS X</p>
                                                <p>13-Apr,2023</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="sub_award_1">
                                        <div class="award_image">
                                            <img src="img/Group 10428.png" alt="">
                                        </div>
                                        <div class="sub_text">
                                            <h3>BEST BATSMAN</h3>
                                            <div class="sub_tetx_1">
                                                <p>MANTRA XI</p>
                                                <p>vs</p>
                                                <p>KAPS CRICKET <br>ACADEMY 2022-23</p>
                                            </div>
                                            <div class="tetx_2">
                                                <p>Batting</p>
                                                <p>63(24) * 5(4s) 6(6s) 262.50 SR</p>
                                            </div>
                                            <div class="tetx_3">
                                                <p>SARDAR PATEL PREMIER LEAGUE SEASON-2 PRESENT BY CAS X</p>
                                                <p>13-Apr,2023</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="sub_award_1">
                                        <div class="award_image">
                                            <img src="img/Group 10428.png" alt="">
                                        </div>
                                        <div class="sub_text">
                                            <h3>BEST BATSMAN</h3>
                                            <div class="sub_tetx_1">
                                                <p>MANTRA XI</p>
                                                <p>vs</p>
                                                <p>KAPS CRICKET <br>ACADEMY 2022-23</p>
                                            </div>
                                            <div class="tetx_2">
                                                <p>Batting</p>
                                                <p>63(24) * 5(4s) 6(6s) 262.50 SR</p>
                                            </div>
                                            <div class="tetx_3">
                                                <p>SARDAR PATEL PREMIER LEAGUE SEASON-2 PRESENT BY CAS X</p>
                                                <p>13-Apr,2023</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="sub_award_1">
                                        <div class="award_image">
                                            <img src="img/Group 15.png" alt="">
                                        </div>
                                        <div class="sub_text">
                                            <h3>BEST BATSMAN</h3>
                                            <div class="sub_tetx_1">
                                                <p>MANTRA XI</p>
                                                <p>vs</p>
                                                <p>KAPS CRICKET <br>ACADEMY 2022-23</p>
                                            </div>
                                            <div class="tetx_2">
                                                <p>Batting</p>
                                                <p>63(24) * 5(4s) 6(6s) 262.50 SR</p>
                                            </div>
                                            <div class="tetx_3">
                                                <p>SARDAR PATEL PREMIER LEAGUE SEASON-2 PRESENT BY CAS X</p>
                                                <p>13-Apr,2023</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="sub_award_1">
                                        <div class="award_image">
                                            <img src="img/Group 15.png" alt="">
                                        </div>
                                        <div class="sub_text">
                                            <h3>BEST BATSMAN</h3>
                                            <div class="sub_tetx_1">
                                                <p>MANTRA XI</p>
                                                <p>vs</p>
                                                <p>KAPS CRICKET <br>ACADEMY 2022-23</p>
                                            </div>
                                            <div class="tetx_2">
                                                <p>Batting</p>
                                                <p>63(24) * 5(4s) 6(6s) 262.50 SR</p>
                                            </div>
                                            <div class="tetx_3">
                                                <p>SARDAR PATEL PREMIER LEAGUE SEASON-2 PRESENT BY CAS X</p>
                                                <p>13-Apr,2023</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="sub_award_1">
                                        <div class="award_image">
                                            <img src="img/Group 15.png" alt="">
                                        </div>
                                        <div class="sub_text">
                                            <h3>BEST BATSMAN</h3>
                                            <div class="sub_tetx_1">
                                                <p>MANTRA XI</p>
                                                <p>vs</p>
                                                <p>KAPS CRICKET <br>ACADEMY 2022-23</p>
                                            </div>
                                            <div class="tetx_2">
                                                <p>Batting</p>
                                                <p>63(24) * 5(4s) 6(6s) 262.50 SR</p>
                                            </div>
                                            <div class="tetx_3">
                                                <p>SARDAR PATEL PREMIER LEAGUE SEASON-2 PRESENT BY CAS X</p>
                                                <p>13-Apr,2023</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="sub_award_1">
                                        <div class="award_image">
                                            <img src="img/Group 15.png" alt="">
                                        </div>
                                        <div class="sub_text">
                                            <h3>BEST BATSMAN</h3>
                                            <div class="sub_tetx_1">
                                                <p>MANTRA XI</p>
                                                <p>vs</p>
                                                <p>KAPS CRICKET <br>ACADEMY 2022-23</p>
                                            </div>
                                            <div class="tetx_2">
                                                <p>Batting</p>
                                                <p>63(24) * 5(4s) 6(6s) 262.50 SR</p>
                                            </div>
                                            <div class="tetx_3">
                                                <p>SARDAR PATEL PREMIER LEAGUE SEASON-2 PRESENT BY CAS X</p>
                                                <p>13-Apr,2023</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="sub_award_1">
                                        <div class="award_image">
                                            <img src="img/Group 16.png" alt="">
                                        </div>
                                        <div class="sub_text">
                                            <h3>BEST BATSMAN</h3>
                                            <div class="sub_tetx_1">
                                                <p>MANTRA XI</p>
                                                <p>vs</p>
                                                <p>KAPS CRICKET <br>ACADEMY 2022-23</p>
                                            </div>
                                            <div class="tetx_2">
                                                <p>Batting</p>
                                                <p>63(24) * 5(4s) 6(6s) 262.50 SR</p>
                                            </div>
                                            <div class="tetx_3">
                                                <p>SARDAR PATEL PREMIER LEAGUE SEASON-2 PRESENT BY CAS X</p>
                                                <p>13-Apr,2023</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>`;
}
sub_header_1_li[3].onclick = function () {
    resetactive();
    sub_header_1_li[3].classList.add('sub_color');
    outer_main_div.innerHTML = `
                                <div class="main_team">
                                <div class="main_team_1">
                                    <div class="team_1">
                                        <div class="icon">
                                            <img src="img/1672290643834_n7uNXqwvLZSC 1 (1).png" alt="">
                                        </div>
                                        <div class="mantra">
                                            <p>MANTRA XI</p>
                                            <h6>Since 10-Apr,2023</h6>

                                            <div class="last">
                                                <p>Played: 3</p>
                                                <p>Won: 3 </p>
                                                <p>Lost: 0</p>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="team_1">
                                        <div class="icon_1">
                                            <i class="fa-solid fa-m"></i>
                                        </div>
                                        <div class="mantra">
                                            <p>MANTRA XI</p>
                                            <h6>Since 10-Apr,2023</h6>

                                            <div class="last">
                                                <p>Played: 3</p>
                                                <p>Won: 3 </p>
                                                <p>Lost: 0</p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="team_1">
                                        <div class="icon_1">
                                            <i class="fa-solid fa-m"></i>
                                        </div>
                                        <div class="mantra">
                                            <p>MANTRA XI</p>
                                            <h6>Since 10-Apr,2023</h6>

                                            <div class="last">
                                                <p>Played: 3</p>
                                                <p>Won: 3 </p>
                                                <p>Lost: 0</p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="team_1">
                                        <div class="icon_1">
                                            <i class="fa-solid fa-m"></i>
                                        </div>
                                        <div class="mantra">
                                            <p>MANTRA XI</p>
                                            <h6>Since 10-Apr,2023</h6>

                                            <div class="last">
                                                <p>Played: 3</p>
                                                <p>Won: 3 </p>
                                                <p>Lost: 0</p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="team_1">
                                        <div class="icon_1">
                                            <i class="fa-solid fa-m"></i>
                                        </div>
                                        <div class="mantra">
                                            <p>MANTRA XI</p>
                                            <h6>Since 10-Apr,2023</h6>

                                            <div class="last">
                                                <p>Played: 3</p>
                                                <p>Won: 3 </p>
                                                <p>Lost: 0</p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="team_1">
                                        <div class="icon_1">
                                            <i class="fa-solid fa-m"></i>
                                        </div>
                                        <div class="mantra">
                                            <p>MANTRA XI</p>
                                            <h6>Since 10-Apr,2023</h6>

                                            <div class="last">
                                                <p>Played: 3</p>
                                                <p>Won: 3 </p>
                                                <p>Lost: 0</p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="team_1">
                                        <div class="icon_1">
                                            <i class="fa-solid fa-m"></i>
                                        </div>
                                        <div class="mantra">
                                            <p>MANTRA XI</p>
                                            <h6>Since 10-Apr,2023</h6>

                                            <div class="last">
                                                <p>Played: 3</p>
                                                <p>Won: 3 </p>
                                                <p>Lost: 0</p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="team_1">
                                        <div class="icon_1">
                                            <i class="fa-solid fa-m"></i>
                                        </div>
                                        <div class="mantra">
                                            <p>MANTRA XI</p>
                                            <h6>Since 10-Apr,2023</h6>

                                            <div class="last">
                                                <p>Played: 3</p>
                                                <p>Won: 3 </p>
                                                <p>Lost: 0</p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="team_1">
                                        <div class="icon">
                                            <img src="img/1672290643834_n7uNXqwvLZSC 1 (1).png" alt="">
                                        </div>
                                        <div class="mantra">
                                            <p>MANTRA XI</p>
                                            <h6>Since 10-Apr,2023</h6>

                                            <div class="last">
                                                <p>Played: 3</p>
                                                <p>Won: 3 </p>
                                                <p>Lost: 0</p>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="team_1">
                                        <div class="icon_1">
                                            <i class="fa-solid fa-m"></i>
                                        </div>
                                        <div class="mantra">
                                            <p>MANTRA XI</p>
                                            <h6>Since 10-Apr,2023</h6>

                                            <div class="last">
                                                <p>Played: 3</p>
                                                <p>Won: 3 </p>
                                                <p>Lost: 0</p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="team_1">
                                        <div class="icon">
                                            <img src="img/1672290643834_n7uNXqwvLZSC 1 (1).png" alt="">
                                        </div>
                                        <div class="mantra">
                                            <p>MANTRA XI</p>
                                            <h6>Since 10-Apr,2023</h6>

                                            <div class="last">
                                                <p>Played: 3</p>
                                                <p>Won: 3 </p>
                                                <p>Lost: 0</p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="team_1">
                                        <div class="icon_1">
                                            <i class="fa-solid fa-m"></i>
                                        </div>
                                        <div class="mantra">
                                            <p>MANTRA XI</p>
                                            <h6>Since 10-Apr,2023</h6>

                                            <div class="last">
                                                <p>Played: 3</p>
                                                <p>Won: 3 </p>
                                                <p>Lost: 0</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div> `;
}
sub_header_1_li[4].onclick = function () {
    resetactive();
    sub_header_1_li[4].classList.add('sub_color');
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
                                        </div>`;
}
sub_header_1_li[5].onclick = function () {
    resetactive();
    sub_header_1_li[5].classList.add('sub_color');
    outer_main_div.innerHTML = `
                                <div class="main_profile">
                                <div class="profile_1">
                                    <div class="profile_2">
                                        <p>LOCATIONS</p>
                                        <p>Surat - Capital Lawns</p>
                                    </div>
                                    <div class="profile_3">
                                        <p>DOB</p>
                                        <p>06-Apr-22 </p>
                                    </div>
                                    <div class="profile_2">
                                        <p>PLAYING ROLE</p>
                                    </div>
                                    <div class="profile_3">
                                        <p>BATTING STYLE</p>
                                        <p>RHB</p>
                                    </div>
                                    <div class="profile_2">
                                        <p>BOWLING STYLE</p>
                                        <p>Right-arm medium</p>
                                    </div>
                                </div>

                            </div>
                            </div> `;
}