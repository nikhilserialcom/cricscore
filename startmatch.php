<?php require_once('layout/header.php'); ?>
<!-- <div class="outer_main_div">
            <div class="center">
                <div class="heading">
                    <h1>Start a Match</h1>
                    <div class="main_sci">
                        <div class="sci">
                            <img src="img/Group 10462.png" alt="">
                            <p>SELECT TEAM A</p>
                            <button>Players (5)</button>
                        </div>
                        <div class="vs">
                            <img src="img/vs.png" alt="">
                        </div>
                        <div class="Group">
                            <img src="img/Group 10462.png" alt="">
                            <p>SELECT TEAM B</p>
                        </div>
                    </div>

                </div>
            </div>
        </div> -->
<div class="outer_main_div spad">
    <div class="center">
        <div class="heading">
            <h1>Start a Match</h1>
            <div class="main_sci">
                <div class="sci">
                    <div class="sci_img_box">
                        <img src="img/Group 10462.png" alt="">
                    </div>
                    <p>SELECT TEAM A</p>
                    <!-- <button>Players (5)</button> -->
                </div>
                <div class="vs">
                    <img src="img/vs.png" alt="">
                </div>
                <div class="Group">
                    <div class="group_img_box">
                        <img src="img/Group 10462.png" alt="">
                    </div>
                    <p>SELECT TEAM B</p>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="page">
    <div class="sub_page">
        <div class="icon">
            <p>Select Team</p>
            <i class="fa-solid fa-circle-xmark"></i>
        </div>
        <div class="list">
            <ul>
                <li>ADD NEW TEAM</li>
                <li>MY TEAMS</li>
                <li>SEARCH TEAM</li>
            </ul>
        </div>
        <div class="message">
            <p>team already exist</p>
        </div>
        <div class="outer_all active">
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
                            <!-- <option value="">surat</option>
                                    <option value="">surat</option>
                                    <option value="">surat</option>
                                    <option value="">surat</option>
                                    <option value="">surat</option> -->
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
            </div>

        </div>
        <div class="my_team">
            <div class="my_team_list">
                <!-- <div class="div">
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
                                <li> <i class="fa-solid fa-location-dot"></i> Surat</li>
                                <li> <i class="fa-solid fa-c"></i> Surat</li>
                                <li style="color: #920000; border-bottom:1px solid #920000 ;">Members</li>

                            </ul>
                        </div>
                    </div> -->
            </div>
            <div class="select_team_btn">
                <button>done</button>
            </div>
        </div>
        <div class="search_team">
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
            </div>
        </div>
    </div>
</div>
<script src="js/select team.js" defer></script>

<?php require_once('layout/footer.php'); ?>