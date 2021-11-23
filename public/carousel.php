<?php
/*
the carousel is not yet dyanmic
my idea to make it dynamic

Requirement:rows must be atleast 6

1st idea
Steps
-get the first 3 rows then assign it with to the div element with an active class
- the rest, put it in div without active class


2nd idea
-count all rows
-get the first child
  - add the active on the first child 
  -remove after few seconds
-then move to next child and same process repeats

*/

?>

<div id="multi-item" class="carousel slide carousel-multi-item" data-ride="carousel">

  <div class="controls-top text-center" style="font-size:1.5rem;">
    <a class="white-text" href="#multi-item" data-slide="prev"><i class="fas fa-chevron-circle-left"></i></a>
    <a class="white-text" href="#multi-item" data-slide="next"><i class="fas fa-chevron-circle-right"></i></a>
  </div>
  <ol class="carousel-indicators view overlay hm-white-light z-depth-1-half">
    <li data-target="#multi-item" data-slide-to="0" class="active"></li>
    <li data-target="#multi-item" data-slide-to="1"></li>
    <li data-target="#multi-item" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner" role="listbox">
    <div class="carousel-item active">

      <div class="row col-xs-12">
        <div class="col-md-4 col-4">
          <div class="">
            <img class="card-img-top" id="Luffy" src="../public/img/avatars/avatar/resize/1.png">
            <!-- <div class="card-body">
          <h4 class="card-title">Card title</h4>
        </div> -->
          </div>
        </div>
        <div class="col-md-4 col-4">
          <div class="">
            <img class="card-img-top" id="Sanji" src="../public/img/avatars/avatar/resize/2.png">
            <!-- <div class="card-body">
          <h4 class="card-title">Card title</h4>
        </div> -->
          </div>
        </div>
        <div class="col-md-4 col-4">
          <div class="">
            <img class="card-img-top" id="Kikunojo" src="../public/img/avatars/avatar/resize/3.png">
            <!-- <div class="card-body">
          <h4 class="card-title">Card title</h4>
        </div> -->
          </div>
        </div>
      </div>


    </div>
    <div class="carousel-item">

      <div class="row col-xs-12">
        <div class="col-md-4 col-4">
          <div class="">
            <img class="card-img-top" id="Gatotkaca" src="../public/img/avatars/avatar/resize/4.png">
            <!-- <div class="card-body">
          <h4 class="card-title">Card title</h4>
        </div> -->
          </div>
        </div>
        <div class="col-md-4 col-4">
          <div class="">
            <img class="card-img-top" id="Miya" src="../public/img/avatars/avatar/resize/5.png">
            <!-- <div class="card-body">
          <h4 class="card-title">Card title</h4>
        </div> -->
          </div>
        </div>
        <div class="col-md-4 col-4">
          <div class="">
            <img class="card-img-top" id="Kadita" src="../public/img/avatars/avatar/resize/6.png">
            <!-- <div class="card-body">
          <h4 class="card-title">Card title</h4>
        </div> -->
          </div>
        </div>
      </div>

    </div>
    <div class="carousel-item">

      <div class="row col-xs-12">
        <div class="col-md-4 col-4">
          <div class="">
            <img class="card-img-top" id="Asuna" src="../public/img/avatars/avatar/resize/7.png">
            <!-- <div class="card-body">
      <h4 class="card-title">Card title</h4>
    </div> -->
          </div>
        </div>
        <div class="col-md-4 col-4">
          <div class="">
            <img class="card-img-top" id="Sinon" src="../public/img/avatars/avatar/resize/8.png">
            <!-- <div class="card-body">
      <h4 class="card-title">Card title</h4>
    </div> -->
          </div>
        </div>
        <div class="col-md-4 col-4">
          <div class="">
            <img class="card-img-top" id="Kirito" src="../public/img/avatars/avatar/resize/9.png">
            <!-- <div class="card-body">
      <h4 class="card-title">Card title</h4>
    </div> -->
          </div>
        </div>
      </div>

    </div>

  </div>

</div>
<script>
  $(document).ready(function() {
    $('.carousel').carousel({
      interval: 5000
    });
  });
</script>