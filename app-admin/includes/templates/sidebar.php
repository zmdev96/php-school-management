<?php
$all_classes  = getAll("*", "app_classes");

?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon">
      <i class="fas fa-school"></i>
    </div>
    <div class="sidebar-brand-text mx-3">My Project</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="index.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span><?= $lang['sidebar_home']?></span></a>
  </li>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-fw fa-users"></i>
      <span><?= $lang['sidebar_users_manage']?></span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="users.php"><?= $lang['sidebar_users']?></a>
        <a class="collapse-item" href="users_groups.php"><?= $lang['sidebar_users_groups']?></a>
        <a class="collapse-item" href="privileges.php"><?= $lang['sidebar_privileges']?></a>
      </div>
    </div>
  </li>

  <!-- Nav Item - Utilities Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
      <i class="fas fa-fw  fa-user-graduate"></i>
      <span>Students</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="students.php">All Students</a>
        <?php foreach ($all_classes as $class): ?>
          <a class="collapse-item" href="#"><?= $class['name']?> [<?=$class['division']?>]</a>
        <?php endforeach; ?>
      </div>
    </div>
  </li>

  <!-- Nav Item - Tables -->
  <li class="nav-item">
    <a class="nav-link" href="students_reg.php">
      <i class="fas fa-fw fa-user-graduate"><span style="position: absolute;">+</span></i>
      <span>Students registration</span></a>
  </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClasses" aria-expanded="true" aria-controls="collapseClasses">
        <i class="fas fa-fw fa-home"></i>
        <span>Classes & Matrials</span>
      </a>
      <div id="collapseClasses" class="collapse" aria-labelledby="headingClasses" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item" href="classes.php">Calsses</a>
          <a class="collapse-item" href="material.php">Material</a>
        </div>
      </div>
    </li>




  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->
