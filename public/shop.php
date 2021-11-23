<?php
include('../private/initialize.php');
session_start();
include('shared/header.php');
include('shared/nav.php');

?>

<?php
//if shop is available
$shops = read_all('rewards');
if ($shops->num_rows > 0) {


?>

    <body>

    </body>
<?php
    //if shop is upcoming
} else {


?>

    <body style="background:url(img/upcoming.svg) no-repeat center center fixed;background-size:cover" ;class="mask rgba-white-slight waves-effect waves-light">
        <main class="page-content">
            <div class="row d-flex justify-content-center">
                <img src="img/sad-tear-regular.svg" alt="" class="animated pulse infinite text-center">
            </div>
            <div class=" row d-flex justify-content-center">
                <p class=" btn btn-info btn-red">Shop is still Upcoming, Sorry for the inconvenience</p>
                <div class="container d-flex justify-content-center">
                    <a href="dashboard.php" class="btn btn-success btn-rounded animated bounce infinite">
                        <h1>&laquo</h1> Return
                    </a>
                </div>
            </div>
        </main>
        </div>
    </body>
<?php
}
include('shared/footer.php');

?>