<style>
  .label {
    cursor: pointer;
  }

  .progress {
    display: none;
    margin-bottom: 1rem;
  }

  .alert {
    display: none;
  }

  .img-container img {
    max-width: 100%;
  }

  .spacer {
    height: 3em;
  }
</style>

<main role="main">

  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item hero-bg active">
        <img class="first-slide max-w-img" src="<?= site_url('assets/img/bg_Element.png'); ?>" alt="First slide">
        <div class="container">
          <div class="row featurette">

            <div class="col-md-5 login_hero_image">
              <img style="margin-top: -100px; border-radius: 40px; box-shadow: -5px 6px 20px 0px #00000036;" class="featurette-image img-fluid mx-auto" src="<?= site_url('assets/img/photobooth.jpg'); ?>" alt="Generic placeholder image">
            </div>
            <style>
              .signup_form {
                margin-top: 15%;
              }

              .imageLabel {
                width: 100%;
                border: 3px dotted #adadad;
                border-radius: 11px;
                overflow: hidden;
                background: #ffffffa6;
              }

              .label_btn {
                position: relative;
                color: #979797;
                padding: 20px 48px;
                border-radius: 46px;
              }
            </style>

            <div class="col-md-7 signup_form">

              <h1 class="h3 mb-3 font-weight-normal">Upload Your Profile Photo</h1>
              <p>Upload a Avatar or a photo.</p>
              <label class="label imageLabel" data-toggle="tooltip" title="Change your avatar">
                <img class="rounded" id="avatar" width="200" src="<?= site_url('/global/photos/currentUser'); ?>" alt="avatar">
                <span class="label_btn">Upload Image (.jpg, .png, .gif)</span>
                <input type="file" class="sr-only" id="input" name="image" accept="image/*">
              </label>
              <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
              </div>
              <div class="alert" role="alert"></div>
              <a class="btn btn-lg btn-warning btn-block" href="<?= site_url('/user/onboard'); ?>">I'll upload later</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<div class="container">
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Crop the image</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="img-container">
            <img id="image" src="<?= site_url('/global/photos/currentUser'); ?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="crop">Crop</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= site_url('/assets/dist/js/bootstrap.bundle.min.js'); ?>" crossorigin="anonymous"></script>

<script>
  window.addEventListener('DOMContentLoaded', function() {
    var avatar = document.getElementById('avatar');
    var image = document.getElementById('image');
    var input = document.getElementById('input');
    var $progress = $('.progress');
    var $progressBar = $('.progress-bar');
    var $alert = $('.alert');
    var $modal = $('#modal');
    var cropper;

    // Initialize Bootstrap tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // Handle file input change
    input.addEventListener('change', function(e) {
      var files = e.target.files;
      var done = function(url) {
        input.value = ''; // Clear input value
        image.src = url;
        $alert.hide();
        $modal.modal('show');
      };
      var reader;
      var file;

      // Check if files were selected
      if (files && files.length > 0) {
        file = files[0];

        // Use URL API to create an object URL if supported
        if (URL) {
          done(URL.createObjectURL(file));
        } else if (FileReader) { // Fallback for older browsers
          reader = new FileReader();
          reader.onload = function(e) {
            done(reader.result);
          };
          reader.readAsDataURL(file);
        }
      }
    });

    // Initialize the cropper when modal is shown
    $modal.on('shown.bs.modal', function() {
      cropper = new Cropper(image, {
        aspectRatio: 1,
        viewMode: 1,
      });
    }).on('hidden.bs.modal', function() {
      // Destroy cropper instance when modal is hidden
      cropper.destroy();
      cropper = null;
    });

    // Handle crop button click
    document.getElementById('crop').addEventListener('click', function() {
      var initialAvatarURL;
      var canvas;

      $modal.modal('hide'); // Hide modal

      // Check if cropper is initialized
      if (cropper) {
        canvas = cropper.getCroppedCanvas({
          width: 260,
          height: 260,
        });
        initialAvatarURL = avatar.src; // Store initial avatar URL
        avatar.src = canvas.toDataURL(); // Update avatar preview
        $progress.show(); // Show progress bar
        $alert.removeClass('alert-success alert-warning'); // Reset alert classes

        // Convert canvas to a blob and upload
        canvas.toBlob(function(blob) {
          var formData = new FormData();

          formData.append('avatar', blob, 'avatar.jpg');

          // Perform AJAX request to upload image
          $.ajax({
            url: '<?= site_url('/profile/uploadAvatar'); ?>', // Update to match your route
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,

            xhr: function() {
              var xhr = new XMLHttpRequest();
              xhr.upload.onprogress = function(e) {
                var percent = '0';
                var percentage = '0%';

                if (e.lengthComputable) {
                  percent = Math.round((e.loaded / e.total) * 100);
                  percentage = percent + '%';
                  $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
                }
              };

              return xhr;
            },

            success: function(response) {
              if (response.status === 'success') {
                $alert.show().addClass('alert-success').text(response.message);
                setTimeout(function() {
                  window.location.href = '<?= site_url('/user/onboard'); ?>';
                }, 500);
              } else {
                avatar.src = initialAvatarURL; // Revert avatar preview on error
                $alert.show().addClass('alert-warning').text(response.message);
              }
            },

            error: function() {
              avatar.src = initialAvatarURL; // Revert avatar preview on AJAX error
              $alert.show().addClass('alert-warning').text('Upload error');
            },

            complete: function() {
              $progress.hide(); // Hide progress bar when complete
            }
          });
        });
      }
    });
  });
</script>

</body>

</html>