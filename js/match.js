let nav_ul = document.querySelector('.nav-ul');
let fa_bars = document.querySelector('.fa-bars');
let fa_xmark = document.querySelector('.fa-xmark');
let search_icon = document.querySelector('.fa-magnifying-glass');
let search = document.querySelector('.search');

fa_bars.onclick = function () {
    search.classList.remove('search_active');
    search_icon.classList.replace('fa-xmark', 'fa-magnifying-glass');
    nav_ul.classList.add('nav_ul_active');
}

fa_xmark.onclick = function () {
    nav_ul.classList.remove('nav_ul_active');
}

search_icon.onclick = function () {
    search.classList.toggle('search_active');
    nav_ul.classList.remove('nav_ul_active');
    if (search.classList.contains('search_active')) {
        return search_icon.classList.replace('fa-magnifying-glass', 'fa-xmark');
    }
    search_icon.classList.replace('fa-xmark', 'fa-magnifying-glass');
}


let outer_main_div = document.querySelector('.outer_main_div');
let sub_header_li = document.querySelectorAll('.sub_header ul li');
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
                            <div class="outer">
                            <div class="outer-1">
                                <div class="sub_outer">
                                    <a href="http://127.0.0.1:5500/match.html">LIVE</a>
                                    <a href="http://127.0.0.1:5500/match-1.html" class="btn-1">UPCOMING</a>
                                    <a href="http://127.0.0.1:5500/match-2.html" class="btn-1">COMPLETED</a>
                                </div>

                                <div class="sub_outer_1">

                                    <div class="main_cricket">
                                        <div class="sub_cricket">
                                            <h4>Night Cricket Tournament</h4>
                                            <div class="sub_cricket_2"></div>
                                            <div class="w-33">
                                                <p>SRK Sports Complex, Surat <br>02-Apr-23 05:36 PM, 6 Over</p>
                                                <button>LIVE</button>
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
                                                <button>LIVE</button>
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
                                        <div class="sub_cricket_1">
                                            <h4>Night Cricket Tournament</h4>
                                            <div class="sub_cricket_2"></div>
                                            <div class="w-33">
                                                <p>SRK Sports Complex, Surat <br>02-Apr-23 05:36 PM, 6 Over</p>
                                                <button>LIVE</button>
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

                                    </div>

                                    <div class="main_cricket">
                                        <div class="sub_cricket">
                                            <h4>Night Cricket Tournament</h4>
                                            <div class="sub_cricket_2"></div>
                                            <div class="w-33">
                                                <p>SRK Sports Complex, Surat <br>02-Apr-23 05:36 PM, 6 Over</p>
                                                <button>LIVE</button>
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
                                                <button>LIVE</button>
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
                                        <div class="sub_cricket_1">
                                            <h4>Night Cricket Tournament</h4>
                                            <div class="sub_cricket_2"></div>
                                            <div class="w-33">
                                                <p>SRK Sports Complex, Surat <br>02-Apr-23 05:36 PM, 6 Over</p>
                                                <button>LIVE</button>
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

                                    </div>

                                    <div class="main_cricket">
                                        <div class="sub_cricket">
                                            <h4>Night Cricket Tournament</h4>
                                            <div class="sub_cricket_2"></div>
                                            <div class="w-33">
                                                <p>SRK Sports Complex, Surat <br>02-Apr-23 05:36 PM, 6 Over</p>
                                                <button>LIVE</button>
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
                                                <button>LIVE</button>
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
                                        <div class="sub_cricket_1">
                                            <h4>Night Cricket Tournament</h4>
                                            <div class="sub_cricket_2"></div>
                                            <div class="w-33">
                                                <p>SRK Sports Complex, Surat <br>02-Apr-23 05:36 PM, 6 Over</p>
                                                <button>LIVE</button>
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

                                    </div>

                                    <div class="main_cricket">
                                        <div class="sub_cricket">
                                            <h4>Night Cricket Tournament</h4>
                                            <div class="sub_cricket_2"></div>
                                            <div class="w-33">
                                                <p>SRK Sports Complex, Surat <br>02-Apr-23 05:36 PM, 6 Over</p>
                                                <button>LIVE</button>
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
                                                <button>LIVE</button>
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
                                        <div class="sub_cricket_1">
                                            <h4>Night Cricket Tournament</h4>
                                            <div class="sub_cricket_2"></div>
                                            <div class="w-33">
                                                <p>SRK Sports Complex, Surat <br>02-Apr-23 05:36 PM, 6 Over</p>
                                                <button>LIVE</button>
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

                                    </div>

                                    <div class="main_cricket">
                                        <div class="sub_cricket">
                                            <h4>Night Cricket Tournament</h4>
                                            <div class="sub_cricket_2"></div>
                                            <div class="w-33">
                                                <p>SRK Sports Complex, Surat <br>02-Apr-23 05:36 PM, 6 Over</p>
                                                <button>LIVE</button>
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
                                                <button>LIVE</button>
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
                                        <div class="sub_cricket_1">
                                            <h4>Night Cricket Tournament</h4>
                                            <div class="sub_cricket_2"></div>
                                            <div class="w-33">
                                                <p>SRK Sports Complex, Surat <br>02-Apr-23 05:36 PM, 6 Over</p>
                                                <button>LIVE</button>
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

                                    </div>

                                </div>

                            </div>
                        </div>`;
}


sub_header_li[1].onclick = function () {

    resetactive();
    sub_header_li[1].classList.add('sub_color');

    outer_main_div.innerHTML = `
                                <div class="main_menu">
                                    <div class="main_menu_1">
                                        <div class="main_team">
                                            <div class="team">
                                                <p>team</p>
                                            </div>
                                            <div class="latest_5">
                                                <ul>
                                                    <li>Mat</li>
                                                    <li>Won</li>
                                                    <li>Lost</li>
                                                    <li>Drawn</li>
                                                    <li>Tied</li>
                                                    <li>NRR</li>
                                                    <li>Pts</li>
                                                    <li>Last 5</li>

                                                </ul>
                                            </div>
                                        </div>

                                        <div class="main_taj">
                                            <div class="taj">
                                                <p>1</p>
                                                <h5>TAJ BROTHERS</h5>
                                            </div>
                                            <div class="taj_1">
                                                <ul>
                                                    <li>90</li>
                                                    <li>35</li>
                                                    <li>5</li>
                                                    <li>4</li>
                                                    <li>90</li>
                                                    <li>266.67</li>
                                                    <li>5</li>
                                                    <li><i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check" style="color:#FF0000;"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                    </li>
                                                    <li><i class="fa-solid fa-chevron-up" onclick="show_hide()"></i></li>

                                                </ul>
                                                <script src="/hide.js"></script>
                                            </div>
                                        </div>


                                        <div id="mian_div">
                                            <div id="div">
                                                <div id="div_1">
                                                    <p>6 Apr 2022</p>
                                                    <p>v RADHA KRISHNA XI</p>
                                                </div>
                                                <div id="div_2">
                                                    <p>Won by 45 runs</p>
                                                </div>
                                            </div>
                                            <div id="div">
                                                <div id="div_1">
                                                    <p>8 Apr 2022</p>
                                                    <p>v MADHAV AVENGERS</p>
                                                </div>
                                                <div id="div_2">
                                                    <p style="color: #FF0000;">Lose by 15 runs</p>
                                                </div>
                                            </div>
                                            <div id="div">
                                                <div id="div_1">
                                                    <p>9 Apr 2022</p>
                                                    <p>v SURAT SUPER KINGS</p>
                                                </div>
                                                <div id="div_2">
                                                    <p>Won by 5 runs</p>
                                                </div>
                                            </div>
                                            <div id="div">
                                                <div id="div_1">
                                                    <p>10 Apr 2022</p>
                                                    <p>v TEAM UNIQUE</p>
                                                </div>
                                                <div id="div_2">
                                                    <p>Won by 26 runs</p>
                                                </div>
                                            </div>
                                            <div id="div">
                                                <div id="div_1">
                                                    <p>12 Apr 2022</p>
                                                    <p>v TAPOVAN TITANS</p>
                                                </div>
                                                <div id="div_2">
                                                    <p>Won by 10 runs</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="main_taj">
                                            <div class="taj">
                                                <p>2</p>
                                                <h5>RADHA KRISHNA XI</h5>
                                            </div>
                                            <div class="taj_1">
                                                <ul>
                                                    <li>80</li>
                                                    <li>55</li>
                                                    <li>4</li>
                                                    <li>3</li>
                                                    <li>80</li>
                                                    <li>246.67</li>
                                                    <li>4</li>
                                                    <li><i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check" style="color:#FF0000;"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check" style="color:#FF0000;"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                    </li>
                                                    <li><i class="fa-solid fa-chevron-up"></i></li>

                                                </ul>
                                            </div>
                                        </div>

                                        <div class="main_taj">
                                            <div class="taj">
                                                <p>3</p>
                                                <h5>MADHAV AVENGERS</h5>
                                            </div>
                                            <div class="taj_1">
                                                <ul>
                                                    <li>60</li>
                                                    <li>35</li>
                                                    <li>4</li>
                                                    <li>5</li>
                                                    <li>60</li>
                                                    <li>226.67</li>
                                                    <li>4</li>
                                                    <li><i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check" style="color:#FF0000;"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                    </li>
                                                    <li><i class="fa-solid fa-chevron-up"></i></li>

                                                </ul>
                                            </div>
                                        </div>

                                        <div class="main_taj">
                                            <div class="taj">
                                                <p>4</p>
                                                <h5>SURAT SUPER KINGS</h5>
                                            </div>
                                            <div class="taj_1">
                                                <ul>
                                                    <li>20</li>
                                                    <li>15</li>
                                                    <li>1</li>
                                                    <li>1</li>
                                                    <li>20</li>
                                                    <li>26.67</li>
                                                    <li>1</li>
                                                    <li><i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check" style="color:#FF0000;"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                    </li>
                                                    <li><i class="fa-solid fa-chevron-up"></i></li>

                                                </ul>
                                            </div>
                                        </div>

                                        <div class="main_taj">
                                            <div class="taj">
                                                <p>5</p>
                                                <h5>ASHADEEP AVENGERS</h5>
                                            </div>
                                            <div class="taj_1">
                                                <ul>
                                                    <li>20</li>
                                                    <li>15</li>
                                                    <li>1</li>
                                                    <li>0</li>
                                                    <li>20</li>
                                                    <li>25.67</li>
                                                    <li>1</li>
                                                    <li><i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check" style="color:#FF0000;"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check" style="color:#FF0000;"></i>
                                                    </li>
                                                    <li><i class="fa-solid fa-chevron-up"></i></li>

                                                </ul>
                                            </div>
                                        </div>

                                        <div class="main_taj">
                                            <div class="taj">
                                                <p>6</p>
                                                <h5>TEAM UNIQUE</h5>
                                            </div>
                                            <div class="taj_1">
                                                <ul>
                                                    <li>10</li>
                                                    <li>25</li>
                                                    <li>0</li>
                                                    <li>0</li>
                                                    <li>10</li>
                                                    <li>16.67</li>
                                                    <li>0</li>
                                                    <li><i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check" style="color:#FF0000;"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                    </li>
                                                    <li><i class="fa-solid fa-chevron-up"></i></li>

                                                </ul>
                                            </div>
                                        </div>

                                        <div class="main_taj">
                                            <div class="taj">
                                                <p>7</p>
                                                <h5>CAPITAL KINGS</h5>
                                            </div>
                                            <div class="taj_1">
                                                <ul>
                                                    <li>50</li>
                                                    <li>25</li>
                                                    <li>3</li>
                                                    <li>2</li>
                                                    <li>50</li>
                                                    <li>216.67</li>
                                                    <li>3</li>
                                                    <li><i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check" style="color:#FF0000;"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                    </li>
                                                    <li><i class="fa-solid fa-chevron-up"></i></li>

                                                </ul>
                                            </div>
                                        </div>

                                        <div class="main_taj">
                                            <div class="taj">
                                                <p>8</p>
                                                <h5>TAPOVAN TITANS</h5>
                                            </div>
                                            <div class="taj_1">
                                                <ul>
                                                    <li>60</li>
                                                    <li>35</li>
                                                    <li>4</li>
                                                    <li>2</li>
                                                    <li>60</li>
                                                    <li>196.67</li>
                                                    <li>4</li>
                                                    <li><i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check" style="color:#FF0000;"></i>
                                                        <i class="fa-solid fa-circle-check" style="color:#FF0000;"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                    </li>
                                                    <li><i class="fa-solid fa-chevron-up"></i></li>


                                                </ul>

                                            </div>
                                        </div>

                                        <div class="main_taj">
                                            <div class="taj">
                                                <p>9</p>
                                                <h5>G.B. XI</h5>
                                            </div>
                                            <div class="taj_1">
                                                <ul>
                                                    <li>10</li>
                                                    <li>15</li>
                                                    <li>0</li>
                                                    <li>0</li>
                                                    <li>0</li>
                                                    <li>-1.67</li>
                                                    <li>0</li>
                                                    <li><i class="fa-solid fa-circle-check" style="color:#FF0000;"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check" style="color:#FF0000;"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        <i class="fa-solid fa-circle-check"></i>
                                                    </li>
                                                    <li><i class="fa-solid fa-chevron-up" style="padding-left:1rem;"></i></li>


                                                </ul>

                                            </div>
                                        </div>
                                    </div>

                                </div> `;
}

sub_header_li[2].onclick = function () {
    resetactive();
    sub_header_li[2].classList.add('sub_color');

    outer_main_div.innerHTML = `
                                <div class="team">
                                <div class="team_heading">

                                    <div class="main">
                                        <div class="team_heading_1">
                                            <div class="team_1">
                                                <p style="color:#920000;">TAJ BROTHERS</p>
                                                <ul>
                                                <li>VIEW PROFILE </li>
                                                </ul>
                                            </div>
                                            <div class="icon">
                                                <i class="fa-solid fa-chevron-up"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <script src="/team.js"></script>



                                    <div id="container">
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (6).png" alt="">
                                            <p>Rakesh Paladiya</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (4).png" alt="">
                                            <p>Atul Ghevariya</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (4).png" alt="">
                                            <p>Bhavesh Gorasiya</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (4).png" alt="">
                                            <p>Dinesh Narola</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (4).png" alt="">
                                            <p>Shubham Patel</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (4).png" alt="">
                                            <p>Vishal Gajera</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (4).png" alt="">
                                            <p>Kamlesh Lathiya</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (4).png" alt="">
                                            <p>Krunal Patel</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (4).png" alt="">
                                            <p>Nikunj Gadhiya</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (4).png" alt="">
                                            <p>Naitik Golakiya</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (4).png" alt="">
                                            <p>Paresh Virani</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (4).png" alt="">
                                            <p>Raj Khunt</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (4).png" alt="">
                                            <p>Hasmukh Jayani</p>
                                        </div>
                                        <div class="multi_image">
                                            <img src="img/Group 2198 (4).png" alt="">
                                            <p>Jonty</p>
                                        </div>
                                    </div>

                                    <div class="main">
                                        <div class="team_heading_1">
                                            <div class="team_1">
                                                <p>MADHAV AVENGERS</p>
                                                <a href="">VIEW PROFILE</a>


                                            </div>
                                            <div class="icon">
                                                <i class="fa-solid fa-chevron-up"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="main">
                                        <div class="team_heading_1">
                                            <div class="team_1">
                                                <p>SURAT SUPER KINGS</p>
                                                <a href="">VIEW PROFILE</a>

                                            </div>
                                            <div class="icon">
                                                <i class="fa-solid fa-chevron-up"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="main">
                                        <div class="team_heading_1">
                                            <div class="team_1">
                                                <p>ASHADEEP AVENGERS</p>
                                                <a href="">VIEW PROFILE</a>

                                            </div>
                                            <div class="icon">
                                                <i class="fa-solid fa-chevron-up"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="main">
                                        <div class="team_heading_1">
                                            <div class="team_1">
                                                <p>TEAM UNIQUE</p>
                                                <a href="">VIEW PROFILE</a>

                                            </div>
                                            <div class="icon">
                                                <i class="fa-solid fa-chevron-up"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="main">
                                        <div class="team_heading_1">
                                            <div class="team_1">
                                                <p>CAPITAL KINGS</p>
                                                <a href="">VIEW PROFILE</a>

                                            </div>
                                            <div class="icon">
                                                <i class="fa-solid fa-chevron-up"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="main">
                                        <div class="team_heading_1">
                                            <div class="team_1">
                                                <p>TAPOVAN TITANS</p>
                                                <a href="">VIEW PROFILE</a>

                                            </div>
                                            <div class="icon">
                                                <i class="fa-solid fa-chevron-up"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="main">
                                        <div class="team_heading_1">
                                            <div class="team_1">
                                                <p>G.B. XI</p>
                                                <a href="">VIEW PROFILE</a>

                                            </div>
                                            <div class="icon">
                                                <i class="fa-solid fa-chevron-up"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="main">
                                        <div class="team_heading_1">
                                            <div class="team_1">
                                                <p>CAPITAL KINGS</p>
                                                <a href="">VIEW PROFILE</a>

                                            </div>
                                            <div class="icon">
                                                <i class="fa-solid fa-chevron-up"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="main">
                                        <div class="team_heading_1">
                                            <div class="team_1">
                                                <p>TAPOVAN TITANS</p>
                                                <a href="">VIEW PROFILE</a>

                                            </div>
                                            <div class="icon">
                                                <i class="fa-solid fa-chevron-up"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="main">
                                        <div class="team_heading_1">
                                            <div class="team_1">
                                                <p>G.B. XI</p>
                                                <a href="">VIEW PROFILE</a>

                                            </div>
                                            <div class="icon">
                                                <i class="fa-solid fa-chevron-up"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            </div>`;

    let team_1_ul = document.querySelector('.team_1 ul li');

    team_1_ul.onclick = function () {
        window.location.href = "members.html";
        resetactive();
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

}

sub_header_li[3].onclick = function () {

    resetactive();
    sub_header_li[3].classList.add('sub_color');
    outer_main_div.innerHTML = `
                                <div id="container">
                                <div class="multi_image">
                                    <img src="img/1675084953641_kFBqHxNelLjF.png" alt="">
                                </div>
                                <div class="multi_image">
                                    <img src="img/1680029544738_Xc1V4auRQk8u.png" alt="">
                                </div>
                                <div class="multi_image">
                                    <img src="img/1675084953641_kFBqHxNelLjF.png" alt="">
                                </div>
                                <div class="multi_image">
                                    <img src="img/1680029544738_Xc1V4auRQk8u.png" alt="">
                                </div>
                                <div class="multi_image">
                                    <img src="img/1675084953641_kFBqHxNelLjF.png" alt="">
                                </div>
                                <div class="multi_image">
                                    <img src="img/1680029544738_Xc1V4auRQk8u.png" alt="">
                                </div>

                                <div class="multi_image">
                                    <img src="img/1675084953641_kFBqHxNelLjF.png" alt="">
                                </div>
                                <div class="multi_image">
                                    <img src="img/1680029544738_Xc1V4auRQk8u.png" alt="">
                                </div>
                                <div class="multi_image">
                                    <img src="img/1675084953641_kFBqHxNelLjF.png" alt="">
                                </div>
                                <div class="multi_image">
                                    <img src="img/1680029544738_Xc1V4auRQk8u.png" alt="">
                                </div>
                                <div class="multi_image">
                                    <img src="img/1675084953641_kFBqHxNelLjF.png" alt="">
                                </div>
                                <div class="multi_image">
                                    <img src="img/1680029544738_Xc1V4auRQk8u.png" alt="">
                                </div>
                            </div> `;

}

sub_header_li[4].onclick = function () {

    resetactive();
    sub_header_li[4].classList.add('sub_color');

    outer_main_div.innerHTML = `
                                <div class="main_div">
                                <div class="main_div_1">
                                    <p>Organizer's Detail</p>
                                    <div class="sub_title">
                                        <p>NAME</p>
                                        <p>Jatin Patel</p>
                                    </div>

                                    <div class="sub_heading">
                                        <p>Tournament's Detail</p>
                                        <div class="title">
                                            <p>NAME</p>
                                            <p>DATES <br> 06-Apr-22 to 10-Apr-22</p>
                                            <p>LOCATIONS <br>Surat - Capital Lawns </p>
                                            <p>BALL TYPE <br>Tennis</p>
                                        </div>
                                    </div>
                                </div> `;
}
