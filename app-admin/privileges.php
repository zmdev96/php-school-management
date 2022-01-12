<?php
ob_start();
  session_start();
  $app  = 'app-admin';
  $page = 'privileges';
  require_once('../config.php');
  if (null == authorized()) {
    redirect('login.php');
  }
  $page_title = $lang['page_privilges'];
  // Start Content View
  require_once(ADMIN_TEMPLATE_PATH . 'header.php');
  require_once(ADMIN_TEMPLATE_PATH . 'sidebar.php');
  require_once(ADMIN_TEMPLATE_PATH . 'navbar.php');

  $action = isset($_GET['action']) ? $_GET['action'] : 'index';

  if ($action == 'index') {
    hasAccess();

    $privilegeinfo = getAll("*", "app_users_privileges");
?>
      <!-- Begin Page Content -->
      <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">privileges</h1>
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
            <h6 class="m-0 font-weight-bold text-primary">Privileges Manage</h6>
            <a class="action-item reload btn btn-primary btn-sm"href="privileges.php?action=create" > <i class="fas fa-plus fa-fw"></i></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Privilege Title [EN]</th>
                    <th>Privilege Title [AR]</th>
                    <th>Privilege Path</th>
                    <th class="text-center">Actions</th>

                  </tr>
                </thead>

                <tbody>
                  <?php if ($privilegeinfo !== false): foreach ($privilegeinfo as $info): ?>
                    <tr>
                      <td><?= $info['privilege_id']?></td>
                      <td><?= $info['privilege_title_en']?></td>
                      <td><?= $info['privilege_title_ar']?></td>

                      <td><?= $info['privilege_path']?></td>
                      <td class="text-center">
                        <a class="btn btn-success bt-sm" href="privileges.php?action=edit&id=<?= $info['privilege_id']?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger bt-sm" href="privileges.php?action=delete&id=<?= $info['privilege_id']?>"><i class="fa fa-trash"></i></a>
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
      <h1 class="h3 mb-2 text-gray-800">privileges/create</h1>
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
          <h6 class="m-0 font-weight-bold text-primary">New Privilege Details</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-9">
              <div class="form-content">
                <form class="" action="privileges.php?action=insert" method="post" enctype="multipart/form-data">
                  <div class="form-row">
                    <div class=" username-field form-group col-md-6">
                      <label for="inputEN">Privilege Title [EN]</label>
                      <input type="text" name="privilege_title_en" class="form-control" id="inputEN">
                    </div>
                    <div class=" username-field form-group col-md-6">
                      <label for="inputAR">Privilege Title [AR]</label>
                      <input type="text" name="privilege_title_ar" class="form-control" id="inputAR">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="inputPath">Privilege Path</label>
                      <input type="text" name="privilege_path" class="form-control" id="inputPath" >
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <button class="btn btn-success" type="submit" name="privilege_create"><i class="fas fa-plus fa-fw"></i> Create</button>
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
      $title_en = $_POST['privilege_title_en'];
      $title_ar = $_POST['privilege_title_ar'];
      $path     = $_POST['privilege_path'];
      // insrt The data in database
      $stmt = $con->prepare(" INSERT INTO
                          app_users_privileges(privilege_path ,privilege_title_en, privilege_title_ar)
                          VALUES (:privilege_path, :title_en, :title_ar) ");
      $stmt->execute(array(
        'privilege_path' => $path,
        'title_en'       => $title_en,
        'title_ar'       => $title_ar,
      ));
      if ($stmt) {
        messagesPut('success', 'Privilege added successfuly');
        redirect('privileges.php');
      }else {
        messagesPut('danger', 'Something went wrong! Please try again');
      }
    }else {
      redirect('privileges.php');
    }
  }elseif ($action == 'edit') {
    hasAccess();

    $priv_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']): 0;
    $check = check('privilege_id', 'app_users_privileges', $priv_id);
    if ($check > 0) {
      $stmt = $con->prepare("SELECT * FROM app_users_privileges WHERE privilege_id = ? ");
      $stmt->execute(array($priv_id));
      $privilegeinfo = $stmt->fetch();?>
      <!-- Begin Page Content -->
      <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">privileges/create</h1>
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
            <h6 class="m-0 font-weight-bold text-primary">Editing Privilege Details</h6>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-9">
                <div class="form-content">
                  <form class="" action="privileges.php?action=update" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="privilege_id" value="<?= $privilegeinfo['privilege_id']?>">
                    <div class="form-row">
                      <div class=" username-field form-group col-md-6">
                        <label for="inputEN">Privilege Title [EN]</label>
                        <input type="text" name="privilege_title_en" class="form-control" id="inputEN" value="<?= $privilegeinfo['privilege_title_en']?>">
                      </div>
                      <div class=" username-field form-group col-md-6">
                        <label for="inputAR">Privilege Title [AR]</label>
                        <input type="text" name="privilege_title_ar" class="form-control" id="inputAR" value="<?= $privilegeinfo['privilege_title_ar']?>">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <label for="inputPath">Privilege Path</label>
                        <input type="text" name="privilege_path" class="form-control" id="inputPath" value="<?= $privilegeinfo['privilege_path']?>" >
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-3">
                        <button class="btn btn-success" type="submit" name="privilege_create"><i class="fas fa-plus fa-fw"></i> Update</button>
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

    <?php }else {
      redirect('privileges.php');
    }

  }elseif ($action == 'update') {
    hasAccess();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $priv_id  = $_POST['privilege_id'];
      $title_en = $_POST['privilege_title_en'];
      $title_ar = $_POST['privilege_title_ar'];
      $path     = $_POST['privilege_path'];
      $check = check('privilege_id', 'app_users_privileges', $priv_id);
      if ($check > 0) {
        $stmt = $con->prepare("UPDATE app_users_privileges SET privilege_path = ?, privilege_title_en = ?, privilege_title_ar = ? WHERE privilege_id = ?");
        $stmt->execute(array($path, $title_en, $title_ar, $priv_id ));
        if ($stmt) {
          messagesPut('success', 'Privilege updated successfuly');
          redirect('privileges.php');
        }else {
          messagesPut('danger', 'Something went wrong! Please try again');
          redirect('back');
        }

      }else {
        redirect('privileges.php');
      }
    }else {
      redirect('privileges.php');
    }
  }elseif ($action == 'delete') {
    hasAccess();

    $priv_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']): 0;
    $check = check('privilege_id', 'app_users_privileges', $priv_id);
    if ($check > 0) {
      $stmt1 = $con->prepare("SELECT * FROM app_users_groups_privileges WHERE privilege_id = ? ");
      $stmt1->execute(array($priv_id));
      $privilege_isset = $stmt1->rowCount();
      if ($privilege_isset > 0) {
        messagesPut('danger', 'The Privilege belong to a Users Groups, Please Delete it from than try again ');
        redirect('privileges.php');
      }else {
        $stmt = $con->prepare("DELETE FROM app_users_privileges WHERE privilege_id = :pid");
        $stmt->bindParam(":pid",$priv_id );
        $stmt->execute();
        if ($stmt) {
          messagesPut('success', 'Privilege deleted successfuly');
          redirect('privileges.php');
        }else {
          messagesPut('danger', 'Something went wrong! Please try again');
          redirect('privileges.php');
        }
      }

    }else {
      redirect('privileges.php');
    }

  }else {
    redirect('notfound.php');
  }
  require_once(ADMIN_TEMPLATE_PATH . 'footer.php');

ob_end_flush();
