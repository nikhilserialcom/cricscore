<?php require_once('layout/header.php'); ?>


    <div class="main_outer">
        <div class="sub_outer">
            <div class="signin">
                <h1>Sign in</h1>
                <div class="box_1">
                    <input type="number" maxlength="1" class="otp_input 1" disabled />
                    <input type="number" maxlength="1" class="otp_input 2" disabled />
                    <input type="number" maxlength="1" class="otp_input 3" disabled />
                    <input type="number" maxlength="1" class="otp_input 4" disabled />
                </div>
                <div class="error otp_error"></div>
                <p></p>
                <button class="continue_btn">Continue</button>
                <b>Resend code in  <span id="timer"></span></b>
            </div>
        </div>
    </div>

    <script src="js/otp.js" defer></script>
<?php require_once('layout/footer.php') ?> 