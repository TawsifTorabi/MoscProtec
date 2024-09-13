<header>
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="home"><img src="<?= site_url('assets/img/white_logo.png');?>" alt="Mosc Protec Logo" style="height: 1.9em;"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a class="nav-link" href="<?= site_url('/#features');?>">Features</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= site_url('/#community');?>">Community</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= site_url('/#partners');?>">Our Partners</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= site_url('/#about');?>">About</a></li>
          <li class="nav-item"><a class="nav-link btn btn-danger" style="color: #fff;" href="<?= site_url('/logout');?>">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
</header>