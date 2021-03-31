<?php require_once 'connect.php'; ?>
<nav class="navbar navbar-expand navbar-light bg-white text-dark">
  <a id="menu-toggle"><i class="fas fa-bars"></i></a>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
      <li class="nav-item">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <?php if (isLogin()) { ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo $_SESSION['user']->getProfile(); ?>" class="rounded-circle" width="20" alt="Profile"> <?php echo $_SESSION['user']->getName(); ?></a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <div class="dropdown-divider"></div>
          <button class="dropdown-item text-danger" id="logoutBtn">ออกจากระบบ <i class="fas fa-sign-out-alt"></i></button>
        </div>
      </li>
      <?php } else { ?>
      <li class="nav-item">
        <a class="nav-link" href="../login/">Login</a>
      </li>
      <?php } ?>
    </ul>
  </div>
</nav>
<script>
  $("#menu-toggle").click(function (e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });
</script>