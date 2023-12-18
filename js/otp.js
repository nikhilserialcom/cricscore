const continue_btn = document.querySelector('.continue_btn');
const input = document.querySelectorAll('.otp_input');
const inputField = document.querySelector('.box_1');
const mobile_number_p = document.querySelector('.signin p');
var verifyOTP_url = 'php/verifyOtp.php';
var userId;

console.log(localStorage.getItem('situation'));

mobile_number_p.textContent = `We sent a confirmation code to ${localStorage.getItem('mobileNo')} `;

let inputCount = 0,
    finalCount = "";

const updateInputConfig = (element, disabledStatus) => {
    element.disabled = disabledStatus;
    if(!disabledStatus) {
        element.focus();
    } else {
        element.blur();
    }
}


input.forEach((element) => {
    element.addEventListener("keyup", (e) => {
        e.target.value = e.target.value.replace(/[^0-9]/g, "");
        let { value } = e.target;

        if(value.length == 1) {
            updateInputConfig(e.target, true);
            if (inputCount <= 3 && e.key != "Backspace") {
                finalCount += value;
                if(inputCount < 3) {
                    updateInputConfig(e.target.nextElementSibling, false);
                }
            }
            inputCount += 1;
        } else if (value.length == 0 && e.key == "Backspace") {
            finalInput = finalInput.substring(0, finalInput.length - 1);
            if (inputCount == 0) {
                updateInputConfig(e.target, false);
                return false;
            }
            updateInputConfig(e.target, true);
            e.target.previousElementSibling.value = "";
            updateInputConfig(e.target.previousElementSibling, false);
            inputCount -= 1;
        } else if (value.length > 1) {
            e.target.value = value.split("")[0];
        }
        continue_btn.classList.add("hide");
    });

});

window.addEventListener("keyup", (e) => {
    if (inputCount > 3) {
        continue_btn.classList.remove("hide");
        continue_btn.classList.add("show");
        if (e.key == "Backspace") {
            finalInput = finalInput.substring(0, finalInput.length - 1);
            updateInputConfig(inputField.lastElementChild, false);
            inputField.lastElementChild.value = "";
            inputCount -= 1;
            submitButton.classList.add("hide");
        }
    }
});

const validateOTP = (input) => {
    let inputElement = input; 
    let userInput = "";

    inputElement.forEach((input) => {
        userInput += input.value;
    });

    return userInput;
    // console.log(userInput);
};

//Start
const startInput = () => {
    inputCount = 0;
    finalInput = "";
    input.forEach((element) => {
        element.value = "";
    });
    updateInputConfig(inputField.firstElementChild, false);
};

window.onload = startInput();

 // Timer

 const TIME_LIMIT = 30;

 let timeLeft = TIME_LIMIT;
 let timerInterval;

 timerInterval = setInterval(() => {

     const seconds = timeLeft % 60;

     let formattedTime = `${Math.floor(timeLeft / 60)
         .toString()
         .padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

     let timer = document.getElementById("timer");
     timer.innerHTML = `${formattedTime}`;

     //document.getElementsByClassName("otp_resend").addEventListener("click", otp_resend);

     // let resend = document.getElementById("resend_link");

     timeLeft--;

     if (timeLeft < 0) {
         timer.innerHTML = `00:00`;
     }
 }, 1000);


const verifyOTP = (mobile_number,otp) => {
    fetch(verifyOTP_url,{
        method: 'POST',
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
        body: JSON.stringify({
            mobileNo: mobile_number,
            userOtp: otp
        })
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
            if(json.status_code == 200)
            {
                if(localStorage.getItem('situation') == "update")
                {
                    window.location.href = "demo.html";
                }
                else{
                    window.location.href = 'signin_select_city.html';  
                }
            }
            else {
                const otp_error = document.querySelector('.otp_error');
                return otp_error.innerHTML = json.message;
            }
        })
}

continue_btn.addEventListener('click', () => {
    const mobile_number = localStorage.getItem('mobileNo');
    const otp = validateOTP(input);
    console.log(otp);
    verifyOTP(mobile_number,otp);
})