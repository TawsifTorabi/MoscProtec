<header>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="assets/img/white_logo.png" alt="Mosc Protec Logo" style="height: 1.9em;"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Community</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Our Partners</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <?php if ($sessionValid == true): ?>
                        <?php
                        // Load User model
                        $userModel = new \App\Models\UserModel();
                        $user = $userModel->find($user_id);
                        ?>
                        <?php if ($user): ?>
                            <li class="nav-item"><a class="nav-link btn btn-warning" href="user/onboard">Go to App</a></li>
                            <li class="nav-item"><a class="nav-link btn btn-danger" href="logout">Logout</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link btn btn-outline-warning" href="login">Login</a></li>
                            <li class="nav-item"><a class="nav-link btn btn-warning" style="color: #595959;" href="signup">Sign up for free</a></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link btn btn-outline-warning" href="login">Login</a></li>
                        <li class="nav-item"><a class="nav-link btn btn-warning" style="color: #595959;" href="signup">Sign up for free</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>


    <main role="main">

      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        
        <div class="carousel-inner">

          <div class="carousel-item hero-bg active">
            <img class="first-slide max-w-img" src="assets/img/bg_Element.png" alt="First slide">
            <div class="container">
                <div class="row featurette">
                    <div class="col-md-7">
                      <h2 class="hero_title">Protect <br> Yourself & <br> <span class="text-muted">Your Family.</span></h2>
                      <p class="lead">From Dangerous Diseases From Mosquitos. <br> Help everyone with the power of AI and Social Community.</p>
                      <br>
                      <a class="btn btn-outline-success large_btn" href="#">Login</a>
                      <a class="btn btn-success large_btn" href="#">Sign up</a>
                    </div>
                    <div class="col-md-5">
                      <img class="featurette-image ban_mosc_img" src="assets/img/Hero_1.png" alt="Generic placeholder image">
                    </div>
                </div>
            </div>
          </div>

          <!-- <div class="carousel-item">
            <img class="second-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Second slide">
            <div class="container">
              <div class="carousel-caption">
                <h1>Another example headline.</h1>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
              </div>
            </div>
          </div> -->

          <!--           
          <div class="carousel-item">
            <img class="third-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Third slide">
            <div class="container">
              <div class="carousel-caption text-right">
                <h1>One more for good measure.</h1>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
              </div>
            </div>
          </div> -->

        </div>

        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>


      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->

      <div class="container marketing">

        <!-- START THE FEATURETTES -->

        <div class="row featurette first_feature">
          <div class="col-md-7">
            <h2 class="featurette-heading">Mosquito <span class="text-muted-2">Heat</span> Map</h2>
            <img src="assets/img/BrushStroke.svg" alt="">
            <p class="lead">Get Real Time Data About The infection rate by mosquitos in your current locations</p>
            <a class="btn btn-danger large_btn" href="#">Explore <b>Heat Map</b></a>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" src="assets/img/Image-container.png" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Mosquito <span class="text-muted-2">LifeCycle.</span></h2>
            <img src="assets/img/BrushStroke.svg" alt="">
            <p class="lead">Knowing the different stages of the mosquito's life will help you prevent mosquitoes around your home and also help you choose the right pesticides for your needs, if you decide to use them</p>
            <a class="btn btn-primary large_btn" href="#">Learn <b>More</b></a>
          </div>
          <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid mx-auto" src="assets/img/mosquito-life-cycle 1.png" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">Identify <span class="text-muted">Mosquito with AI</span></h2>
            <img src="assets/img/BrushStroke.svg" alt="">
            <p class="lead">Use your camera to capture image of Mosquitos and Identify species and life cycle.</p>
            <a class="btn btn-warning large_btn" href="#">Try <b>Now</b></a>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" src="assets/img/Illustration.png" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">
        
        <!-- Three columns of text below the carousel -->
        <div class="row">
            <div class="col-lg-4">
              <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
              <h2>Heading</h2>
              <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.</p>
              <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
              <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
              <h2>Heading</h2>
              <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.</p>
              <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
              <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
              <h2>Heading</h2>
              <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
              <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
            </div><!-- /.col-lg-4 -->
          </div><!-- /.row -->
  
  
        <hr class="featurette-divider">
        
        <!-- /END THE FEATURETTES -->

      </div><!-- /.container -->
      
    </main>