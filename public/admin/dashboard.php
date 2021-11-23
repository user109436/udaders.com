<?php

include('../../private/initialize.php');
session_start();
include('shared/header.php');

?>

<script type="text/javascript">
  // function success (){
  //   console.log('success');
  // }

  setTimeout(function() {
    $('#loading').detach();
  }, 4800);
  index = 0;
  setInterval(function() {
    $('#load_dashboard').load('load_dashboard.php');
    index = index + 1;
    console.log(index + ' update');
  }, 5000);
</script>

<body style="background:url(../img/bg-index9.svg) no-repeat fixed;background-size:cover; overflow-y:auto;" class="mask rgba-white-slight waves-effect waves-light">
  <h1 class="white-text text-center mt-5" id="loading">Loading Real Time Update...</h1>

  <div class="container-fluid">
    <div class="row mt-5 animated rotateInDownLeft delay-5s fast" id="load_dashboard">
    </div>
  </div>
</body>