<?php require_once('layout/header.php'); ?>

    <div class="main_outer">
        <div class="sub_outer">
            <div class="box">
                <h1>Sign in</h1>

                <div class="select_country_div">
                    <label for="">Country</label>
                    <div class="select_country_inner_div" id="">
                        <div class="selected_country_and_i_div">
                            <p>india</p>
                            <i class="fa-solid fa-angle-down"></i>
                        </div>
                    </div>

                    <div class="input_of_country_div">
                        <input type="text">
                        <div class="error country_error"></div>
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

                <div class="contact_no_div">
                    <label for="mobile_number">Contact number</label>
                    <div class="country_code_and_input_div">
                        <div class="country_code_div">+91</div>
                        <input type="tel" id="mobile_number" class="mobile_number" pattern="[0-9]{10}" required>
                    </div>
                    <div class="error mobile_error"></div>
                </div>



                <b>We will send an SMS code to verify your number</b>
                <button class="continue_btn">Continue</button>
            </div>
        </div>
    </div>
    <script src="js/signin.js" defer></script>

    <!-- <script>

        const nav_ul = document.querySelector('.nav-ul');
        const nav_ul_i = document.querySelector('.nav-ul i');
        const fa_bars = document.querySelector('.fa-bars');
        const fa_xmark = document.querySelector('.fa-xmark');
        const search_icon = document.querySelector('.fa-magnifying-glass');
        const search_div_outer = document.querySelector('.search_div_outer');
        const select_country_inner_div = document.querySelector('.select_country_inner_div');
        const input_of_country_div = document.querySelector('.input_of_country_div');
        const input_of_country_div_input = document.querySelector('.input_of_country_div input');
        const input_of_country_div_p = document.querySelector('.input_of_country_div p');
        const country_list_div = document.querySelector('.country_list_div');


        search_icon.addEventListener('click', () => {
            search_div_outer.classList.toggle('active');
            if (search_div_outer.classList.contains('active')) {
                search_icon.classList.replace('fa-magnifying-glass', 'fa-xmark')// fa-xmark
                nav_ul.style.left = '-250px';
            } else {
                search_icon.classList.replace('fa-xmark', 'fa-magnifying-glass');
            }
        })

        fa_bars.addEventListener('click', () => {
            nav_ul.style.left = '0px';
            search_div_outer.classList.remove('active');
            search_icon.classList.replace('fa-xmark', 'fa-magnifying-glass');
        })

        nav_ul_i.addEventListener('click', () => {
            nav_ul.style.left = '-250px';
        })

        select_country_inner_div.addEventListener('click', () => {
            input_of_country_div.style.display = 'flex';
        })



        const url = 'php/try.php';


        function searchAPI(searchQuery) {
            // const searchQuery = document.querySelector('.input_of_country_div input').value;


            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ search_query: searchQuery })
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        input_of_country_div_input.addEventListener('input', () => {
            input_of_country_div_p.textContent = 'Searching...';
            country_list_div.style.display = 'flex';
            const searchQuery = input_of_country_div_input.value;
            searchAPI(searchQuery);

        })

    </script> -->
<?php require_once('layout/footer.php'); ?>