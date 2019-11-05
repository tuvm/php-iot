<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" routerLink="/" style="color:white">Monitoring System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
      aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="sidebar-nav">
        <li class="active">
          <a class="nav-link" routerLink="/detail"><span class="fas fa-info-circle"></span>&nbsp; Detail</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" routerLink="/control"><span class="fas fa-toggle-on"></span>&nbsp; Control</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" routerLink="/chart"><span class="fas fa-chart-line"></span>&nbsp; Graphic</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" routerLink="/manage"><span class="fas fa-user-alt"></span>&nbsp; Manage</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<script>
  function openTab(id) {
    $('.sidebar-nav li').removeClass('active');
    $('#li-' + id).addClass('active');
  }
</script>

<body>
</body>