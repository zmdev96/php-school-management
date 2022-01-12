<?php
ob_start();
  session_start();
  $app  = 'app-admin';
  $page = 'material';
  require_once('../config.php');
  if (null == authorized()) {
    redirect('login.php');
  }
  $page_title = $lang['page_classes'];
  // Start Content View
  require_once(ADMIN_TEMPLATE_PATH . 'header.php');
  require_once(ADMIN_TEMPLATE_PATH . 'sidebar.php');
  require_once(ADMIN_TEMPLATE_PATH . 'navbar.php');

  $action = isset($_GET['action']) ? $_GET['action'] : 'index';

  if ($action == 'index') {
    hasAccess();
    // Get all Classes From Database
    $all_material = getAll("*", "app_material");
?>
      <!-- Begin Page Content -->
      <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">material</h1>
        <!-- DataTales Example -->
        <div class="row">
          <?php if (messagesGet()):?>
            <div class="col-md-12">
              <div class="alert alert-<?=messagesGet()['type']?>">
                <?=messagesGet()['message']?>
              </div>
            </div>
          <?php endif; ?>
        </div>
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Material Manage</h6>
            <a class="action-item reload btn btn-primary btn-sm"href="material.php?action=create" > <i class="fas fa-plus fa-fw"></i></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Material</th>
                    <th>About</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>

                <tbody>
                  <?php if ($all_material !== false): foreach ($all_material as $info): ?>
                    <tr>
                      <td><?= $info['material_id']?></td>
                      <td><?= $info['material']?></td>
                      <td><?= $info['about']?></td>
                      <td class="text-center">
                        <a class="btn btn-success bt-sm" href="material.php?action=edit&id=<?=$info['material_id']?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger bt-sm" href="material.php?action=delete&id=<?=$info['material_id']?>"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                  <?php endforeach; endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
      <!-- /.container-fluid -->

  <?php }elseif ($action == 'create') {
    hasAccess();
  ?>
    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
      <h1 class="h3 mb-2 text-gray-800">material/create</h1>
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">New Material Details</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-9">
              <div class="form-content">
                <form class="" action="material.php?action=insert" method="post" enctype="multipart/form-data">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputUsername">Material Name</label>
                      <input type="text" name="material_name" class="form-control" id="inputUsername">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="about">About</label>
                      <textarea name="about" rows="8" cols="80" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <button class="btn btn-success" type="submit" name="group_create"><i class="fas fa-plus fa-fw"></i> Create</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- /.container-fluid -->
  <?php } elseif ($action == 'insert') {
    hasAccess();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $name     = $_POST['material_name'];
      $about    = $_POST['about'];

      // insrt The data in database
      $stmt = $con->prepare(" INSERT INTO
                          app_material(material, about)
                          VALUES (:material, :about) ");
      $stmt->execute(array(
        'material'     => $name,
        'about'    => $about,
      ));

      if ($stmt) {
        messagesPut('success', 'Material added successfuly');
        redirect('material.php');
      }else {
        messagesPut('danger', 'Something went wrong! Please try again');
        redirect('back');
      }

    }else {
      redirect('material.php');
    }
  }elseif ($action == 'edit') {
    hasAccess();

    //display id in the title of current page
    $material_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']): 0;
    $check = check('material_id', 'app_material', $material_id);
    if ($check > 0) {
      // get the user info
      $stmt = $con->prepare("SELECT * FROM app_material WHERE material_id = ? ");
      $stmt->execute(array($material_id));
      $material_info = $stmt->fetch();

    ?>
    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
      <h1 class="h3 mb-2 text-gray-800">material/edit</h1>
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Edit Material Details</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-9">
              <div class="form-content">
                <form class="" action="material.php?action=update" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="material_id" value="<?= $material_info['material_id']?>">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputUsername">Material Name</label>
                      <input type="text" name="material_name" class="form-control" id="inputUsername" value="<?= $material_info['material']?>">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="about">About</label>
                      <textarea name="about" rows="8" cols="80" class="form-control"><?= $material_info['about']?></textarea>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <button class="btn btn-success" type="submit"><i class="fas fa-plus fa-fw"></i> Update</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- /.container-fluid -->
  <?php  }else {
        redirect('material.php');

        }
 }elseif ($action == 'update') {
   hasAccess();

   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     $name     = $_POST['material_name'];
     $about    = $_POST['about'];
     $material_id = $_POST['material_id'];
     // update The data in database
     $stmt = $con->prepare("UPDATE app_material SET material = ? , about = ? WHERE material_id = ?");
     $stmt->execute(array($name, $about, $material_id));

     // IF $stmt True Will Be Continue The Block of Code
     if ($stmt) {
       messagesPut('success', 'Material updated successfuly');
       redirect('material.php');
     }else {
       messagesPut('danger', 'Something went wrong! Please try again');
       redirect('back');
     }

   }else {
     redirect('material.php');
   }
 } elseif ($action == 'delete') {
   hasAccess();
   $material_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']): 0;
   $check = check('material_id', 'app_material', $material_id);
   if ($check > 0) {
     $stmt = $con->prepare("DELETE FROM app_material WHERE material_id = :pid");
     $stmt->bindParam(":pid",$material_id );
     $stmt->execute();
     if ($stmt) {
       messagesPut('success', 'Material deleted successfuly');
       redirect('material.php');
     }else {
       messagesPut('danger', 'Something went wrong! Please try again');
       redirect('material.php');
     }
   }else {
     redirect('material.php');
   }
 }else {
    redirect('notfound.php');
  }

  require_once(ADMIN_TEMPLATE_PATH . 'footer.php');
ob_end_flush();
