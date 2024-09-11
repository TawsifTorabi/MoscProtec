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
    
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Make a request to the getRedirectAddress endpoint
        fetch('<?= site_url('login/getRedirectAddress'); ?>')
            .then(response => response.json()) // Parse the JSON from the response
            .then(data => {
                if (data.status === 'success') {
                    // Redirect to the given address if the status is 'success'
                    window.location.href = data.redirect;
                } else {
                    console.log(data.message); // Log the error message if status is 'error'
                }
            })
            .catch(error => console.error('Error:', error)); // Log any network or other errors
    });

    document.getElementById('loginForm').addEventListener('submit', function(event) {
      event.preventDefault(); // Prevent the default form submission

      var email = document.getElementById('inputEmail').value;
      var password = document.getElementById('inputPassword').value;
      var alertContainer = document.getElementById('alertContainer'); // The container where alerts will be displayed
      alertContainer.innerHTML = ''; // Clear any existing alerts

      // Client-side validation
      if (!email || !password) {
          showAlert('danger', 'Please enter both email and password.');
          return;
      }

      if (!validateEmail(email)) {
          showAlert('danger', 'Please enter a valid email address.');
          return;
      }

      if (password.length < 6) {
          showAlert('danger', 'Password must be at least 6 characters long.');
          return;
      }

      // Send a POST request to the API using fetch
      fetch('<?= site_url('login/process'); ?>', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: new URLSearchParams({
              email: email,
              password: password
          })
      })
      .then(response => response.json())
      .then(data => {
          if (data.status === 'success') {
              showAlert('success', data.message);
              setTimeout(function() {
                  window.location.href = data.redirect_url;
              }, 2000); // Redirect after 2 seconds
          } else {
              showAlert('danger', data.message); // Show error message
          }
      })
      .catch(error => {
          console.error('Error:', error);
      });
  });

  function showAlert(type, message) {
      var alertContainer = document.getElementById('alertContainer');
      var alertDiv = document.createElement('div');
      alertDiv.className = `alert alert-${type}`;
      alertDiv.innerHTML = `<strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}`;
      alertContainer.appendChild(alertDiv);
  }

  function validateEmail(email) {
      // Basic email validation regex
      var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
      return re.test(String(email).toLowerCase());
  }
  </script>
