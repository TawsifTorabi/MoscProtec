<header>
     <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="home"><img src="assets/img/white_logo.png" alt="Mosc Protec Logo" style="height: 1.9em;"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Community</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Our Partners</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-warning" style="color: #595959;" href="signup">Sign up for free</a></li>
                </ul>
            </div>
        </div>
    </nav>
    </header>

    <main role="main">

      <div id="myCarousel" class="carousel slide" data-ride="carousel">        
        <div class="carousel-inner">
          <div class="carousel-item hero-bg active">
            <img class="first-slide max-w-img" src="assets/img/bg_Element.png" alt="First slide">
            <div class="container">
                <div class="row featurette">
                  
                  <div class="col-md-5 login_hero_image">
                    <img class="featurette-image img-fluid mx-auto" src="assets/img/black_logo.png" alt="Generic placeholder image">
                  </div>
                
                  <div class="col-md-7 login_form">
                    <form class="form-signin" action="" id="loginForm" method="post">
                      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
                      <label for="inputEmail" class="sr-only">Email address</label>
                      <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                      <label for="inputPassword" class="sr-only">Password</label>
                      <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                      <div class="checkbox mb-3">
                        <label>
                          <input type="checkbox" value="remember-me"> Remember me
                        </label>
                      </div>
                      <button class="btn btn-lg btn-success btn-block" type="submit">Sign in</button>
                      <br>
                      <div id="alertContainer"></div>
                      <br>
                      <a href="signup">Don't have an account? Sign Up</a>
                      <p class="mt-5 mb-3 text-muted">&copy; 2024-2025</p>
                    </form>
                  </div>

                </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    
    
