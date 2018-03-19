<?php
//include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');
//$device_array = array();
//$_SESSION['type'] = "home";

?>

<?php
$staff = null;
ob_start();
session_start();
include_once ($_SERVER['DOCUMENT_ROOT'].'/connections/db_connect8.php');
include_once ($_SERVER['DOCUMENT_ROOT'].'/connections/ldap.php');
include_once ($_SERVER['DOCUMENT_ROOT'].'/class/all_classes.php');
date_default_timezone_set($sv['timezone']);

if( isset($_SESSION['staff']) ){
    $staff = unserialize($_SESSION['staff']);
    $_SESSION['loc'] = $_SERVER['PHP_SELF'];
    //Logout if session has timed out.
    if ($_SESSION["timeOut"] < time()) {
        header("Location:/logout.php");
    } else {
        //echo $_SESSION["timeOut"] ." - ". time();
        $_SESSION["timeOut"] = (intval(time()) + $staff->getTimeLimit());
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if( isset($_POST['s ignBtn']) ){
        if ( empty($_POST["netID"])){
            echo "<script type='text/javascript'> window.onload = function(){goModal('Invalid','No User Name', false)}</script>";
        } elseif (empty($_POST["pass"]) ){
            echo "<script type='text/javascript'> window.onload = function(){goModal('Invalid','Missing Password', false)}</script>";
        } else {
            //Remove 3rd argument, define attribute in ldap.php
            $operator = AuthenticateUser($_POST["netID"],$_POST["pass"]);
            $_SESSION['netID'] = $_POST["netID"];
            if (Users::regexUser($operator)) {
                $staff = Staff::withID($operator);
                //staff get either limit or limit_long as their auto logout timer
                if ($staff->getRoleID() > $sv["LvlOfStaff"])
                    $staff->setTimeLimit( $sv["limit_long"] );
                else
                    $staff->setTimeLimit( $sv["limit"] );
                //set the timeOut = current + limit of login
                $_SESSION["timeOut"] = (intval(time()) + $staff->getTimeLimit());
                $_SESSION["staff"] = serialize($staff);
                if ( isset($_SESSION['loc']) ){
                    header("Location:$_SESSION[loc]");
                }
                if (!headers_sent()){
                    echo "<script>window.location.href='/index.php';</script>";
                }
                exit();
            } else {
                echo "<script type='text/javascript'> window.onload = function(){goModal('Invalid','Invalid user name and/or password!', false)}</script>";
            }
        }
    } elseif( isset($_POST['searchBtn']) ){
        if(filter_input(INPUT_POST, 'searchField')){
            $searchField = filter_input(INPUT_POST, 'searchField');
            if(filter_input(INPUT_POST, 'searchType')){
                $searchType = filter_input(INPUT_POST, 'searchType');
                if(strcmp($searchType, "s_trans") == 0){
                    $trans_id = $searchField;
                    header("location:/pages/lookup.php?trans_id=$trans_id");
                } elseif (strcmp($searchType, "s_operator") == 0){
                    $operator = $searchField;
                    header("location:/pages/lookup.php?operator=$operator");
                } else {
                    echo "<script type='text/javascript'> window.onload = function(){goModal('Invalid','Illegal Search Condition', false)}</script>";
                }
            } else {
                echo "<script type='text/javascript'> window.onload = function(){goModal('Invalid','Illegal Search Condition', false)}</script>";
            }
        } else {
            echo "<script type='text/javascript'> window.onload = function(){goModal('Invalid','Please enter a number.', false)}</script>";
        }
        
    } elseif( filter_input(INPUT_POST, 'pickBtn') !== null ){
        if( filter_input(INPUT_POST, 'pickField') !== null){
            if(!Users::regexUser(filter_input(INPUT_POST, 'pickField'))){
                echo "<script>alert('Invalid ID # php');</script>";
            } else {
                $operator = filter_input(INPUT_POST, 'pickField');
                header("location:/pages/pickup.php?operator=$operator");
            }
        }
    }
}
//Display a Successful message from a previous page
if (isset($_SESSION['success_msg']) && $_SESSION['success_msg']!= ""){
    echo "<script>window.onload = function(){goModal('Success',\"$_SESSION[success_msg]\", true)}</script>";
    unset($_SESSION['success_msg']);
} 
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Material Design Bootstrap</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet"> 
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
<div id="page-wrapper">

<!--Main Navigation-->
<header>

<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-dark blue-grey">
<div class="container">

    <!-- Navbar brand -->
    <a class="navbar-brand" href="#">
        <img src="img/FLlogo_143.PNG" alt="Fablab" style="height:40px">
    </a>

    <!-- Collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <!-- Links -->
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://www.facebook.com/UTAFabLab/">Facebook</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://twitter.com/UTAFabLab">Twitter</a>
            </li>

            <!-- Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Login</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="">
                    <!--<a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a> -->
                    <form role="form" method="POST" action="" autocomplete="off" style="padding: 0px 100px 0px 20px;">
                        <p class="h5 text-center mb-4" style="padding: 0px 0px 0px 75px;">Login</p>
                        <div class="row">
                            <div class="md-form" style="color: #000000;">
                                <div class="col-sm-12">
                                    <i class="fa fa-user prefix grey-text"></i>
                                    <input type="text" id="netID" class="" style="padding: 20px 70px 0px 0px; color: #000000;  border-bottom: 1px solid #bdbdbd;">
                                    <label for="netID" class="control-label" style="padding: 0px 0px 0px 15px; ">NetID</label>
                                </div>
                            </div>
                            <div class="md-form">
                                <div>
                                </div>
                                <div class="col-sm-12">
                                    <i class="fa fa-lock prefix grey-text"></i>
                                    <input type="password" id="pass" class="form-control" style="padding: 20px 70px 0px 0px; color: #000000;">
                                    <label for="pass" class="control-label" style="padding: 0px 0px 0px 15px;">Password</label>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-indigo" name="signBtn">
                                    Sign In <i class="fa fa-paper-plane-o ml-1"></i></button>
                            </div>
                            <div id="forgot-pass">
<!--                                <a href="http://<?php// echo $sv["forgotten"];?>" >Forgot your password?</a>-->
                            </div>
                        </div>
                    </form>
                </div>
            </li>

        </ul>
        <!-- Links -->

        <!-- Search form -->
        <form class="form-inline">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
        </form>
    </div>
    <!-- Collapsible content -->
</div>

</nav>
<!--/.Navbar--> 

</header>
<!--Main Navigation-->

<!--Main layout-->
<main class="mt-5">

        <!--Main container-->
        <div class="container">

            <!--Grid row-->
            <div class="row">

                <!--Grid column-->
                <div class="col-lg-4 col-md-12 mb-4">

                    <!--Card-->
                    <div class="card">

                        <!--Card image https://cdn.pixabay.com/photo/2017/10/12/20/15/photoshop-2845779_960_720.jpg -->
                        <div class="view overlay hm-white-slight">
                            <img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20%282%29.jpg" class="img-fluid" alt="">
                            <a href="#">
                                <div class="mask"></div>
                            </a>
                        </div>

                        <!--Card content-->
                        <div class="card-body">
                            <!--Title-->
                            <h4 class="card-title">Current Wait</h4>
                            <!--Text-->
                            <br>
                            <p class="card-text" style="font-size: 40; text-align: center;">10 Minutes
                            <br>
                            </p>
                            <br>
                            <a href="#" class="btn btn-blue-grey">Get in Line!</a>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-4 col-md-12 mb-4">

                    <!--Card-->
                    <div class="card">

                        <!--Card image-->
                        <div class="view overlay hm-white-slight">
                            <img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(74).jpg" class="img-fluid" alt="">
                            <a href="#">
                                <div class="mask"></div>
                            </a>
                        </div>

                        <!--Card content-->
                        <div class="card-body">
                            <!--Title-->
                            <h4 class="card-title">3D Printers</h4>
                            <!--Text-->
                            <p class="card-text" style="font-size: 72; text-align: center;">#7</p>
                            <a href="#" class="btn btn-blue-grey">Disclaimer</a>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-4 col-md-12 mb-4">

                    <!--Card-->
                    <div class="card">

                        <!--Card image-->
                        <div class="view overlay hm-white-slight">
                            <img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(75).jpg" class="img-fluid" alt="">
                            <a href="#">
                                <div class="mask"></div>
                            </a>
                        </div>

                        <!--Card content-->
                        <div class="card-body">
                            <!--Title-->
                            <h4 class="card-title">Lasers</h4>
                            <!--Text-->
                            <p class="card-text" style="font-size: 72; text-align: center;">#L1</p>
                            <a href="#" class="btn btn-blue-grey">Disclaimer</a>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->
            
            <!--Grid row-->
            <div class="row">

                <!--Grid column-->
                <div class="col-md-7 mb-4">

                    <!--Featured image -->
                    <div class="view overlay hm-white-light z-depth-1-half">
                        <img src="https://mdbootstrap.com/img/Photos/Slides/img%20(70).jpg" class="img-fluid " alt="">
                        <div class="mask"></div>
                    </div>

                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-md-5 mb-4">

                    <h2>Some awesome heading</h2>
                    <hr>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis pariatur quod ipsum atque quam dolorem
                        voluptate officia sunt placeat consectetur alias fugit cum praesentium ratione sint mollitia, perferendis
                        natus quaerat!</p>
                    <a href="https://mdbootstrap.com/" class="btn btn-blue-grey">Get it now!</a>

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

        </div>
        <!--Main container-->

</main>
<!--Main layout-->

<!--Footer-->
<footer>
<footer class="page-footer blue-grey center-on-small-only">

    <!--Footer Links-->
    <div class="container-fluid">
        <div class="row">

            <!--First column-->
            <div class="col-md-6">
                <h5 class="title">Footer Content</h5>
                <p>Here you can use rows and columns here to organize your footer content.</p>
            </div>
            <!--/.First column-->

            <!--Second column-->
            <div class="col-md-6">
                <h5 class="title">Links</h5>
                <ul>
                    <li><a href="#!">Link 1</a></li>
                    <li><a href="#!">Link 2</a></li>
                    <li><a href="#!">Link 3</a></li>
                    <li><a href="#!">Link 4</a></li>
                </ul>
            </div>
            <!--/.Second column-->
        </div>
    </div>
    <!--/.Footer Links-->

    <!--Copyright-->
    <div class="footer-copyright">
        <div class="container-fluid">
            © 2015 Copyright: <a href="https://www.MDBootstrap.com"> MDBootstrap.com </a>

        </div>
    </div>
    <!--/.Copyright-->
</footer>

</footer>
<!--Footer-->


    <!-- Start your project here-->
<!--   <div style="height: 100vh">
        <div class="flex-center flex-column">
            <h1 class="animated fadeIn mb-4">Material Design for Bootstrap</h1>

            <h5 class="animated fadeIn mb-3">Thank you for using our product. We're glad you're with us.</h5>

            <p class="animated fadeIn text-muted">MDB Team</p>
        </div>
    </div> -->
    <!-- /Start your project here-->

    <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>
    </div>
</body>

</html>
<?php
//Standard call for dependencies
//include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
?>