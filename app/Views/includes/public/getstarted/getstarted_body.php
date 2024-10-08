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
                  <div class="container">
                    <h1>Welcome Onboard! <br> 
                        <span id="user_name"></span>
                    </h1>
                    <p>MoscProtec is a open platform developed to help the community in breakout of Mosquito borne diseases. <br>
                      By Signing up as a member, you will be able to contribute to the society just by sharing your surrounding information with others.
                      <br>
                      We are tend to build a better community, better city and a better future.
                    </p>
                    <br>
                    <a class="btn btn-lg btn-success btn-block" href="<?= site_url('/user/uploadphoto'); ?>">Get Started</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Fetch the user status from the server
        fetch('<?= site_url("/login/checkStatus"); ?>')
          .then(response => response.json())
          .then(data => {
            // Check if the user is logged in
            if (data.status === "success") {
              // Select the elements to update
              const userNameElement = document.getElementById('user_name');
              // Set the Name
              if (userNameElement) {
                userNameElement.textContent = data.data.name;
              }
              // Show other menu items if needed or update them dynamically
            } else {
              // Redirect to the login page if not authenticated
              window.location.href = '<?= site_url("/login"); ?>';
            }
          })
          .catch(error => {
            console.error('Error fetching user status:', error);
            // Handle errors, such as displaying a message to the user or showing a notification
          });
      });
    </script>