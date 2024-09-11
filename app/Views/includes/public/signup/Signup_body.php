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
                    <li class="nav-item"><a class="nav-link btn btn-warning" style="color: #595959;" href="login">Log In</a></li>
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
                  <style>
                    .signup_form{
                        margin-top: 15%;
                    }
                  </style>
                <div class="col-md-7 signup_form">
                    <form class="form-signin" id="signupForm">
                        <h1 class="h3 mb-3 font-weight-normal">Sign Up</h1>
                        
                        <!-- Alert Message Placeholder -->
                        <div id="alertPlaceholder"></div>

                        <label for="inputName" class="sr-only">Full Name</label>
                        <input type="text" id="inputName" class="form-control" placeholder="Full Name" required>

                        <label for="inputEmail" class="sr-only">Email address</label>
                        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>

                        <label for="inputPhone" class="sr-only">Phone Number</label>
                        <input type="tel" id="inputPhone" class="form-control" placeholder="Your 11 Digit Phone Number" required>

                        <label for="inputDob" class="sr-only">Date of Birth</label>
                        <input type="date" id="inputDob" class="form-control" placeholder="Date of Birth" required>

                        <label for="inputGender" class="sr-only">Gender</label>
                        <select id="inputGender" style="font-size: 14px;" class="form-control" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>

                        <label for="inputBloodGroup" class="sr-only">Blood Group</label>
                        <select id="inputBloodGroup" style="font-size: 14px;" class="form-control" required>
                            <option value="">Select Blood Group</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>

                        <label for="inputPassword" class="sr-only">Password</label>
                        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required minlength="6">

                        <label for="inputConfirmPassword" class="sr-only">Confirm Password</label>
                        <input type="password" id="inputConfirmPassword" class="form-control" placeholder="Confirm Password" required minlength="6">

                        <button class="btn btn-lg btn-success btn-block" id="signupButton" type="submit">Sign Up</button>
                        <br>
                        <a href="login">Already have an account? Sign In</a>
                        <p class="mt-5 mb-3 text-muted">&copy; 2024-2025</p>
                    </form>
                </div>

                <script>
                document.getElementById('signupForm').addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent the default form submission

                    var email = document.getElementById('inputEmail').value;
                    var name = document.getElementById('inputName').value;
                    var phone = document.getElementById('inputPhone').value;
                    var dob = document.getElementById('inputDob').value;
                    var gender = document.getElementById('inputGender').value;
                    var bloodGroup = document.getElementById('inputBloodGroup').value;
                    var password = document.getElementById('inputPassword').value;
                    var confirmPassword = document.getElementById('inputConfirmPassword').value;
                    var signupButton = document.getElementById('signupButton');
                    var alertPlaceholder = document.getElementById('alertPlaceholder');

                    // Function to show Bootstrap alert
                    function showAlert(message, type) {
                        alertPlaceholder.innerHTML = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                            message + 
                            '</div>';
                    }

                    // Client-side validation
                    if (!email || !name || !phone || !dob || !gender || !bloodGroup || !password || !confirmPassword) {
                        showAlert('Please fill out all fields.', 'warning');
                        return;
                    }

                    if (!validateEmail(email)) {
                        showAlert('Please enter a valid email address.', 'danger');
                        return;
                    }

                    if (password.length < 6) {
                        showAlert('Password must be at least 6 characters long.', 'danger');
                        return;
                    }

                    if (password !== confirmPassword) {
                        showAlert('Passwords do not match.', 'danger');
                        return;
                    }

                    // Disable the signup button to prevent multiple clicks
                    signupButton.disabled = true;

                    // Send a POST request to the API using fetch
                    fetch('<?= site_url('signup/process'); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            email: email,
                            name: name,
                            phone: phone,
                            dob: dob,
                            gender: gender,
                            blood_group: bloodGroup,
                            password: password,
                            confirmPassword: confirmPassword
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            showAlert('Signup successful! Redirecting...', 'success');
                            setTimeout(() => window.location.href = '<?= site_url('user/getstarted'); ?>', 2000);
                        } else {
                            showAlert(data.message, 'danger'); // Show error message
                            signupButton.disabled = false; // Re-enable the signup button
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('An error occurred. Please try again later.', 'danger');
                        signupButton.disabled = false; // Re-enable the signup button
                    });
                });

                function validateEmail(email) {
                    // Basic email validation regex
                    var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                    return re.test(String(email).toLowerCase());
                }
                </script>

                </div>
            </div>
          </div>
        </div>
      </div>
    </main>
