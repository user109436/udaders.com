<?php
if (isset($_SESSION['user_id'])) {
  if (isset($_SESSION['user_id' . $_SESSION['user_id']])) {
    $user_id = $_SESSION['user_id'];
    $avatar = '';
    $sql = "SELECT avatar,username FROM users WHERE id=$user_id";
    $result = $conn->query($sql);
    if ($conn->query($sql)) {
      if ($result->num_rows > 0) {
        // print_arr($result=$result->fetch_object());
        // print_arr($result->username);
        // print_arr($result->avatar);
        // die;
        $result = $result->fetch_object();
        $name = $result->username;
        $avatar = $result->avatar;
      } else {
        die('failed');
      }
    }
    $coins = read('coins', 'user_id', $user_id);
  }
}
?>
<div class="page-wrapper chiller-theme">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
    <i class="fa fa-bars"></i>
  </a>
  <nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="#">Udaders</a>
        <div id="close-sidebar">
          <i class="fa fa-times"></i>
        </div>
      </div>
      <div class="sidebar-header">
        <div class="user-pic">
          <img class="img-responsive img-rounded" src="./img/avatars/<?php echo $avatar . '.png' ?>" alt="User picture">
        </div>
        <div class="user-info">
          <span class="user-name"><?php echo $name ?>
          </span>
          <span class="user-status">
            <i class="fa fa-circle"></i>
            <span>Online</span>
          </span>
        </div>
      </div>
      <!-- sidebar-header  -->
      <div class="row d-flex justify-content-center">
        <a href="dashboard.php?user_id=<?php echo $_SESSION['user_id']; ?>&logout=true" class="btn btn-red btn-sm">Log Out</a>
      </div>
      <!-- sidebar-search  -->
      <div class="sidebar-menu">
        <ul>
          <li class="header-menu">
            <span>General</span>
          </li>
          <li>
            <a href="dashboard.php">
              <i class="fa fa-tachometer-alt"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <li>
            <a href="read.php">
              <i class="fa fa-book"></i>
              <span>Library</span>
            </a>
          </li>
          <li>
            <a href="shop.php">
              <i class="fa fa-shopping-cart"></i>
              <span>Shop</span>
            </a>
          </li>
          <li>

            <!-- <li class="sidebar-dropdown">
            <a href="#">
              <i class="far fa-gem"></i>
              <span>Components</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">General</a>
                </li>
                <li>
                  <a href="#">Panels</a>
                </li>
                <li>
                  <a href="#">Tables</a>
                </li>
                <li>
                  <a href="#">Icons</a>
                </li>
                <li>
                  <a href="#">Forms</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-chart-bar"></i>
              <span>Charts</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Pie chart</a>
                </li>
                <li>
                  <a href="#">Line chart</a>
                </li>
                <li>
                  <a href="#">Bar chart</a>
                </li>
                <li>
                  <a href="#">Histogram</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-globe"></i>
              <span>Maps</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Google maps</a>
                </li>
                <li>
                  <a href="#">Open street map</a>
                </li>
              </ul>
            </div>
          </li> -->
          <li class="header-menu">
            <span>Extra</span>
          </li>
          <li>
            <a href="documentation.php">
              <i class="fa fa-book"></i>
              <span>Documentation</span>
            </a>
          </li>
        </ul>
      </div>
      <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
    <div class="sidebar-footer">
      <a href="#">
        <i class="fa fa-bell"></i>
        <span class="badge badge-pill badge-warning notification">3</span>
      </a>
      <a href="#">
        <i class="fa fa-envelope"></i>
        <span class="badge badge-pill badge-success notification">7</span>
      </a>
      <a href="#">
        <i class="fa fa-cog"></i>
        <span class="badge-sonar"></span>
      </a>
      <a href="#">
        <i class="fa fa-power-off"></i>
      </a>
    </div>
  </nav>