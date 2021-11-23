<?php include('shared/header.php') ?>
<div class="modal-container" style="display: block;">
  <div class="modal-content">
    <span class="close-btn">×</span>


    <div id="answer" class=" container text-center">

      <div class="row d-flex justify-content-center">
        <div class="col-md-3 col-3">
          <p class="light-blue-text display-2 my-1 pr-3 text-center animated fadeIn delay-3s "><i class="far fa-smile-wink animated bounce infinite"></i><i class="fas fa-check animated fadeIn pl-3 my-1"></i></p>
        </div>
        <div class="col-md-5 col-xs-12 col-10">
          <img class="card-img-top animated fadeIn slow" src="../public/img/avatars/avatar/resize/6.png">
          <div class="card-body animated fadeIn slow delay-1s">
            <h4 class="card-title">Card title</h4>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia reiciendis voluptatem similique soluta facere eveniet. Sapiente adipisci magni et dolor aut dolores reprehenderit sed placeat velit, repellat, eligendi nostrum quibusdam.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<div class="container d-flex justify-content-center"><a href="question.php?page=2"><button class="btn btn-primary">Next</button></a></div>
</div>
</div>
<?php include('shared/footer.php') ?>
<script type="text/javascript">
  $(document).ready(function() {

    $('.modal-container').css('display', 'block');

  });
</script>
<?php die(); ?>