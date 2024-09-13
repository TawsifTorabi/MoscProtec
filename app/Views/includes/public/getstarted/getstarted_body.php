    <main role="main">

      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item hero-bg active">
            <img class="first-slide max-w-img" src="<?= site_url('assets/img/bg_Element.png'); ?>" alt="First slide">
            <div class="container">
              <div class="row featurette">

                <div class="col-md-5 login_hero_image">
                  <img style="margin-top: -100px; border-radius: 40px; box-shadow: -5px 6px 20px 0px #00000036;" class="featurette-image img-fluid mx-auto" src="<?= site_url('assets/img/community.png'); ?>" alt="Generic placeholder image">
                </div>
                <style>
                  .signup_form {
                    margin-top: 15%;
                  }
                </style>
                <div class="col-md-7 signup_form">
                  <form class="form-signin" action="" id="loginForm" method="post">
                    <h1 class="h3 mb-3 font-weight-normal">Welcome Onboard!</h1>
                    <p>MoscProtec is a open platform developed to help the community in breakout of Mosquito borne diseases. <br>
                      By Signing up as a member, you will be able to contribute to the society just by sharing your surrounding information with others.
                      We are tend to build a better community, better city and a better future.
                    </p>
                    <a class="btn btn-lg btn-success btn-block" href="<?= site_url('/user/uploadphoto'); ?>">Get Started</a>
                    <br>
                    <div id="alertContainer"></div>
                    <br>
                  </form>
                </div>



              </div>
            </div>
          </div>
        </div>
      </div>
    </main>