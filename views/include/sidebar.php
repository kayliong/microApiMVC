<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
  <div class="c-sidebar-brand d-lg-down-none">
  	<strong><?php echo ViewController::$user['given_name']. " ".  ViewController::$user['surname'];?></strong>
  </div>
  <ul class="c-sidebar-nav">
    <li class="c-sidebar-nav-title">Dashboard</li>
    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/task">Task List</a>
    </li>
    <li class="c-sidebar-nav-divider"></li>
  </ul>
  <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>