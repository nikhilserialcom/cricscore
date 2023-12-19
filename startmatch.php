<?php require_once('layout/header.php'); ?>
        <div class="outer_main_div">
            <div class="center">
                <div class="heading">
                    <h1>Start a Match</h1>
                    <div class="main_sci">
                        <div class="sci">
                            <img src="img/Group 10452.png" alt="">
                            <p>SCI</p>
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
                <div class="outer_all">
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
                
            </div>
        </div>
    </div>
    <script src="js/select team.js" defer></script>

<?php require_once('layout/footer.php'); ?>