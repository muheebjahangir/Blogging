    <?php

    session_start();
    if (!isset($_SESSION['email'])) {
        header('location: login_signup.php');
    }
    if (isset($_POST['signout']) && $_POST['signout'] == 1)  {

    session_unset();
    session_destroy();
    header('location: login_signup.php');
    exit();
    }


    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <title>Document</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

            * {
                padding: 0;
                margin: 0;
                box-sizing: border-box;
                font-family: 'Roboto', sans-serif;
            }

            body {
                background-color: #eee;
            }

            .container {
                min-height: 100vh;
                padding: 20px 0;
                display: flex;
                align-items: center;
                justify-content: center
            }

            p {
                margin: 0px
            }

            .card {
                width: 280px;
                height: 520px;
                box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
                background: #fff;
                transition: all 0.5s ease;
                cursor: pointer;
                user-select: none;
                z-index: 10;
                overflow: hidden
            }

            .card .backgroundEffect {
                bottom: 0;
                height: 0px;
                width: 100%
            }

            .card:hover {
                color: #fff;
                transform: scale(1.025);
                box-shadow: rgba(0, 0, 0, 0.24) 0px 5px 10px
            }

            .card:hover .backgroundEffect {
                bottom: 0;
                height: 320px;
                width: 100%;
                position: absolute;
                z-index: -1;
                background: #1b9ce3;
                animation: popBackground 0.3s ease-in
            }

            @keyframes popBackground {
                0% {
                    height: 20px;
                    border-top-left-radius: 50%;
                    border-top-right-radius: 50%
                }

                50% {
                    height: 80px;
                    border-top-left-radius: 75%;
                    border-top-right-radius: 75%
                }

                75% {
                    height: 160px;
                    border-top-left-radius: 85%;
                    border-top-right-radius: 85%
                }

                100% {
                    height: 320px;
                    border-top-left-radius: 100%;
                    border-top-right-radius: 100%
                }
            }

            .card .pic {
                position: relative
            }

            .card .pic img {
                width: 100%;
                height: 280px;
                object-fit: cover
            }

            .card .date {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                width: 50px;
                height: 70px;
                background-color: #1b9ce3;
                color: white;
                position: absolute;
                bottom: 0px;
                transition: all ease
            }

            .card .date .day {
                font-size: 14px;
                font-weight: 600
            }

            .card .date .month,
            .card .date .year {
                font-size: 10px
            }

            .card .text-muted {
                font-size: 12px
            }

            .card:hover .text-muted {
                color: #fff !important
            }

            .card .content {
                padding: 0 20px
            }

            .card .content .btn {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 5px 10px;
                background-color: #1b9ce3;
                border-radius: 25px;
                font-size: 12px;
                border: none
            }

            .card:hover .content .btn {
                background: #fff;
                color: #1b9ce3;
                box-shadow: #0000001a 0px 3px 5px
            }

            .card .content .btn .fas {
                font-size: 10px;
                padding-left: 5px
            }

            .card .content .foot .admin {
                color: #1b9ce3;
                font-size: 12px
            }

            .card:hover .content .foot .admin {
                color: #fff
            }

            .card .content .foot .icon {
                font-size: 12px
            }
        </style>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-0 py-3">
            <div class="container-xl">
                <a class="navbar-brand" href="#">
                    BLOGING
                </a>
                <!-- Navbar toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <!-- Nav -->
                    <div class="navbar-nav mx-lg-auto">
                        <a class="nav-item nav-link active" href="#" aria-current="page">Home</a>
                        <a class="nav-item nav-link" href="#">Product</a>
                        <a class="nav-item nav-link" href="#">Features</a>
                    </div>
                    <!-- Right navigation -->
                    <form action="" method="post" id="signoutForm">
                    <div class="navbar-nav ms-lg-4">
        <!-- Submit Button for Signout -->
        <input type="button" class="btn btn-outline-primary" value="Signout" onclick="confirmSignout()">
    </div>
                    </form>

                    <!-- Action -->
                    <div class="d-flex align-items-lg-center mt-3 mt-lg-0">
                        <a href="login_signup.php" class="btn btn-sm btn-outline-primary w-full w-lg-auto">
                            Register
                        </a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container">


            <div class="d-lg-flex">
                <div class="card border-0 me-lg-4 mb-lg-0 mb-4">
                    <div class="backgroundEffect"></div>
                    <div class="pic"> <img class="" src="https://images.pexels.com/photos/374016/pexels-photo-374016.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=500" alt="">
                        <div class="date"> <span class="day">26</span> <span class="month">June</span> <span class="year">2019</span> </div>
                    </div>
                    <div class="content">
                        <p class="h-1 mt-4">Finance And Legal Working Streams Occur Throughout</p>
                        <p class="text-muted mt-3">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <div class="d-flex align-items-center justify-content-between mt-3 pb-3">
                            <div class="btn btn-primary">Read More<span class="fas fa-arrow-right"></span></div>
                            <div class="d-flex align-items-center justify-content-center foot">
                                <p class="admin">Admin</p>
                                <p class="ps-3 icon text-muted"><span class="fas fa-comment-alt pe-1"></span>3</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 me-lg-4 mb-lg-0 mb-4">
                    <div class="backgroundEffect"></div>
                    <div class="pic"> <img class="" src="https://images.pexels.com/photos/1560932/pexels-photo-1560932.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=500" alt="">
                        <div class="date"> <span class="day">26</span> <span class="month">June</span> <span class="year">2019</span> </div>
                    </div>
                    <div class="content">
                        <p class="h-1 mt-4">Finance And Legal Working Streams Occur Throughout</p>
                        <p class="text-muted mt-3">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <div class="d-flex align-items-center justify-content-between mt-3 pb-3">
                            <div class="btn btn-primary">Read More<span class="fas fa-arrow-right"></span></div>
                            <div class="d-flex align-items-center justify-content-center foot">
                                <p class="admin">Admin</p>
                                <p class="ps-3 icon text-muted"><span class="fas fa-comment-alt pe-1"></span>3</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 mb-lg-0 mb-4">
                    <div class="backgroundEffect"></div>
                    <div class="pic"> <img class="" src="https://images.pexels.com/photos/4491881/pexels-photo-4491881.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=500" alt="">
                        <div class="date"> <span class="day">26</span> <span class="month">June</span> <span class="year">2019</span> </div>
                    </div>
                    <div class="content">
                        <p class="h-1 mt-4">Finance And Legal Working Streams Occur Throughout</p>
                        <p class="text-muted mt-3">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <div class="d-flex align-items-center justify-content-between mt-3 pb-3">
                            <div class="btn btn-primary">Read More<span class="fas fa-arrow-right"></span></div>
                            <div class="d-flex align-items-center justify-content-center foot">
                                <p class="admin">Admin</p>
                                <p class="ps-3 icon text-muted"><span class="fas fa-comment-alt pe-1"></span>3</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
    function confirmSignout() {
        // Confirm the action
        var isConfirmed = confirm("Are you sure you want to sign out?");
        if (isConfirmed) {
            // If confirmed, set the signout value and submit the form
            var signoutInput = document.createElement("input");
            signoutInput.type = "hidden";
            signoutInput.name = "signout";
            signoutInput.value = "1";
            document.getElementById("signoutForm").appendChild(signoutInput);
            document.getElementById("signoutForm").submit();  // Now submit the form
        }
    }
</script>
    </body>


    </html>