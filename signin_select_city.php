<?php require_once('layout/header.php'); ?>

    <div class="main_outer select_city_outer">
        <div class="sub_outer">
            <div class="box">
                <h1>Sign in</h1>

                <div class="select_state">
                    <label for="">Select state</label>
                    <div class="select_state_box">
                        <div class="selected_state_show">
                            <p>Select State</p>
                            <i class="fa-solid fa-angle-down"></i>
                        </div>
                    </div>
                    <div class="input_state_box">
                        <input type="text" >
                        <p>Please enter 1 or more characters.</p>
                        <div class="state_list_box">
                            <!-- <span class="active">Gujarat</span>
                            <span>Gujarat</span>
                            <span>Gujarat</span>
                            <span>Gujarat</span>
                            <span>Gujarat</span> -->
                        </div>
                    </div>
                </div>
                <div class="select_country_div">
                    <label for="">Select City</label>
                    <div class="select_country_inner_div" id="">
                        <div class="selected_country_and_i_div">
                            <p>Select City</p>
                            <i class="fa-solid fa-angle-down"></i>
                        </div>
                    </div>

                    <div class="input_of_country_div">
                        <input type="text">
                        <p>Please enter 1 or more characters.</p>
                        <div class="country_list_div">
                            <!-- <span class="active">india</span>
                            <span>indonashia</span>
                            <span>iran</span>
                            <span>iraq</span>
                            <span>iraq</span>
                            <span>iraq</span>
                            <span>iraq</span> -->
                        </div>
                    </div>
                </div>
                
                <div class="name_div">
                    <label for="">Name</label>
                    <input type="text" placeholder="Enter name" required>
                    <div class="name_error"></div>
                </div>

                <div class="email_div">
                    <label for="">e-mail</label>
                    <input type="text" placeholder="E-mail hare" required>
                    <div class="email_error"></div>
                </div>

                <b>We will send an SMS code to verify your number</b>
                <button class="continue_btn">Continue</button>
            </div>
        </div>
    </div>
    <script src="js/signin_select_city.js"defer></script>
<?php require_once('layout/footer.php'); ?>