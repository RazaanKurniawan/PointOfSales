<nav class="navbar navbar-expand-lg bg-white shadow">
  <div class="container-fluid px-4">
    <a class="navbar-brand" href="#">Point Of Sales</a>
    <!-- Memberikan margin kanan menggunakan kelas "me-auto" -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0"> <!-- Memindahkan item-menu ke bagian kanan -->
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <?php if (isset($_SESSION['loggedIn'])): ?>
          <li class="nav-item">
            <a class="nav-link active" href="admin/index.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><?= $_SESSION['loggedInUser']['nama'] ?></a>
          </li>
          <li class="nav-item">
            <a class="btn btn-danger" href="logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>