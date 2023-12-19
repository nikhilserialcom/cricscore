<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="css/sign in.css"> -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="js/navbar.js" defer></script>
    <title>index page</title>
</head>

<body>

    <nav>
        <div class="inner">
            <div class="logo_ul_div">
                <i class="fa-solid fa-bars"></i>

                <li class="logo">
                    <a href="">cricscorer</a>
                </li>
                <ul class="nav-ul">
                    <i class="fa-solid fa-xmark" id="bars"></i>
                    <li><a href="">Matches</a></li>
                    <li><a href="">Tournament</a></li>
                    <li><a href="">Ecosystem</a></li>
                </ul>
            </div>
            <div class="buttons">
                <div class="search_div_outer">
                    <div class="search_div_inner">
                        <input type="search" placeholder="search">
                    </div>
                </div>

                <div class="search_icon_div">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>

                <div class="join_sign_in_div">
                    <button>join</button>
                    <button><a href="signin.php">Sign in</a></button>
                </div>
                <div class="icon_image">
                    <img src="img/user.png" alt="">
                    <!-- <div class="profile-menu">
                        <ul class="setting">
                            <li><a href="#">My Profile</a></li>
                            <li><a href="#">My Match</a></li>
                            <li><a href="#">My Tournament</a></li>
                            <li><a href="#">Settings</a></li>
                        </ul>
                    </div> -->
                </div>
            </div>

        </div>
    </nav>

    <div class="profile_menu">
        <div class="profile_box">
            <div class="profile_image">
                <img src="img/Group 10462.png" alt="">
            </div>
            <div class="profile_detail">
                <p>nikhil patel</p>
                <button class="profile_btn">edit profile</button>
            </div>
        </div>
        <div class="menu_box">
            <ul>
                <li><a href="startmatch.php">my matches</a></li>
                <li><a href="">my tournaments</a></li>
                <li><a href="">organiser admin</a></li>
            </ul>
        </div>
        <div class="logout_btn"><i class="fa-solid fa-right-from-bracket"></i><span>logout</span></div>
    </div>