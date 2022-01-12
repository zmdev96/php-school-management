<?php
ob_start();
  session_start();
  $app  = 'app-admin';
  $page = 'users_groups';
  require_once('../config.php');
  if (null == authorized()) {
    redirect('login.php');
  }
  $page_title = $lang['page_users_groups'];
  // Start Content View
  require_once(ADMIN_TEMPLATE_PATH . 'header.php');
  require_once(ADMIN_TEMPLATE_PATH . 'sidebar.php');
  require_once(ADMIN_TEMPLATE_PATH . 'navbar.php');

  $action = isset($_GET['action']) ? $_GET['action'] : 'index';

  if ($action == 'index') {
    hasAccess();

    $groupsinfo = getAll("*", "app_users_groups");
?>
      <!-- Begin Page Content -->
      <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Users groups</h1>
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
            <h6 class="m-0 font-weight-bold text-primary">Users groups Manage</h6>
            <a class="action-item reload btn btn-primary btn-sm"href="users_groups.php?action=create" > <i class="fas fa-plus fa-fw"></i></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Groups Title [EN]</th>
                    <th>Groups Title [AR]</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>

                <tbody>
                  <?php if ($groupsinfo !== false): foreach ($groupsinfo as $info): ?>
                    <tr>
                      <td><?= $info['group_id']?></td>
                      <td><?= $info['group_title_en']?></td>
                      <td><?= $info['group_title_ar']?></td>
                      <td class="text-center">
                        <a class="btn btn-success bt-sm" href="users_groups.php?action=edit&id=<?= $info['group_id']?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger bt-sm" href="users_groups.php?action=delete&id=<?= $info['group_id']?>"><i class="fa fa-trash"></i></a>
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

    $all_privileges = getAll("*", "app_users_privileges");

  ?>
    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
      <h1 class="h3 mb-2 text-gray-800">users groups/create</h1>
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
          <h6 class="m-0 font-weight-bold text-primary">New Users group Details</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-9">
              <div class="form-content">
                <form class="" action="users_groups.php?action=insert" method="post" enctype="multipart/form-data">
                  <div class="form-row">
                    <div class=" username-field form-group col-md-6">
                      <label for="inputEN">Group Title [EN]</label>
                      <input type="text" name="group_title_en" class="form-control" id="inputEN">
                    </div>
                    <div class=" username-field form-group col-md-6">
                      <label for="inputAR">Group Title [AR]</label>
                      <input type="text" name="group_title_ar" class="form-control" id="inputAR">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="users_groups_privileges">
                      <h3>Choose the Privileges that will be belong to this Users group</h3>
                      <?php if ($all_privileges !== false): foreach ($all_privileges as $privileg): ?>
                        <div class="checkboxes">
                          <input type="checkbox" name="privileges[]" value="<?=$privileg['privilege_id']?>" id="<?=$privileg['privilege_id']?>">
                          <label for="<?=$privileg['privilege_id']?>"><?=$privileg['privilege_title_'.$_SESSION['app_lang'].'']?></label>
                        </div>
                      <?php endforeach; endif; ?>
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
      $title_en = $_POST['group_title_en'];
      $title_ar = $_POST['group_title_ar'];
      $privilege = $_POST['privileges'];
      // insrt The data in database
      $stmt = $con->prepare(" INSERT INTO
                          app_users_groups(group_title_en, group_title_ar)
                          VALUES (:title_en, :title_ar) ");
      $stmt->execute(array(
        'title_en'       => $title_en,
        'title_ar'       => $title_ar,
      ));
      // Register Tha Last Id
      $last_id = $con->lastInsertId();
      // IF $stmt True Will Be Continue The Block of Code
      if ($stmt) {
        foreach ($privilege as $priv) {
          $stmt1 = $con->prepare(" INSERT INTO
                              app_users_groups_privileges(group_id, privilege_id)
                              VALUES (:group, :privilege)");
          $stmt1->execute(array(
            'group'       => $last_id,
            'privilege'   => $priv,
          ));
        }
        messagesPut('success', 'Users Group added successfuly');
        redirect('users_groups.php');
      }else {
        messagesPut('danger', 'Something went wrong! Please try again');
        redirect('back');
      }

    }else {
      redirect('users_groups.php');
    }
  }elseif ($action == 'edit') {
    hasAccess();

    $group_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']): 0;
    $check = check('group_id', 'app_users_groups', $group_id);
    if ($check > 0) {
      $stmt = $con->prepare("SELECT * FROM app_users_groups WHERE group_id = ? ");
      $stmt->execute(array($group_id));
      $groupinfo = $stmt->fetch();
      $all_privileges = getAll("*", "app_users_privileges");
      $stmt1 = $con->prepare("SELECT * FROM app_users_groups_privileges WHERE group_id = $group_id ");
      $stmt1->execute();
      $group_privileges = $stmt1->fetchAll();
      $extracted_group_privileges = [];
      foreach ($group_privileges as $privileg) {
        $extracted_group_privileges[] = $privileg['privilege_id'];
      }
      ?>
      <!-- Begin Page Content -->
      <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">users group/edit</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Editing Users group Details</h6>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-9">
                <div class="form-content">
                  <form class="" action="users_groups.php?action=update" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="group_id" value="<?= $groupinfo['group_id']?>">
                    <div class="form-row">
                      <div class=" username-field form-group col-md-6">
                        <label for="inputEN">Group Title [EN]</label>
                        <input type="text" name="group_title_en" class="form-control" id="inputEN" value="<?= $groupinfo['group_title_en']?>">
                      </div>
                      <div class=" username-field form-group col-md-6">
                        <label for="inputAR">Group Title [AR]</label>
                        <input type="text" name="group_title_ar" class="form-control" id="inputAR" value="<?= $groupinfo['group_title_ar']?>">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="users_groups_privileges">
                        <h3>Choose the Privileges that will be belong to this Users group</h3>
                        <?php if ($all_privileges !== false): foreach ($all_privileges as $privileg): ?>
                          <div class="checkboxes">
                            <input type="checkbox" name="privileges[]" value="<?=$privileg['privilege_id']?>" id="<?=$privileg['privilege_id']?>"
                             <?= in_array($privileg['privilege_id'],$extracted_group_privileges ) ? 'checked' : ''?>>
                            <label for="<?=$privileg['privilege_id']?>"><?=$privileg['privilege_title_'.$_SESSION['app_lang'].'']?></label>
                          </div>
                        <?php endforeach; endif; ?>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-3">
                        <button class="btn btn-success" type="submit" name="group_update"><i class="fas fa-plus fa-fw"></i> Update</button>
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
      redirect('users_groups.php');
    }

  }elseif ($action == 'update') {
    hasAccess();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $group  = $_POST['group_id'];
      $title_en = $_POST['group_title_en'];
      $title_ar = $_POST['group_title_ar'];
      $new_privileges = $_POST['privileges'];
      $check = check('group_id', 'app_users_groups', $group);
      if ($check > 0) {
        $stmt1 = $con->prepare("SELECT * FROM app_users_groups_privileges WHERE group_id = ? ");
        $stmt1->execute(array($group));
        $group_privileges = $stmt1->fetchAll();
        $extracted_group_privileges = [];
        foreach ($group_privileges as $privileg) {
          $extracted_group_privileges[] = $privileg['privilege_id'];
        }
        $stmt = $con->prepare("UPDATE app_users_groups SET group_title_en = ?, group_title_ar = ? WHERE group_id = ?");
        $stmt->execute(array($title_en, $title_ar, $group ));
        if ($stmt) {
          $deleted_privileges = array_diff($extracted_group_privileges, $new_privileges);
          $added_privileges   = array_diff($new_privileges, $extracted_group_privileges);

          foreach ($deleted_privileges as $privi_id ) {
            $stmt2 = $con->prepare("DELETE FROM app_users_groups_privileges WHERE privilege_id = :pid");
            $stmt2->bindParam(":pid",$privi_id );
            $stmt2->execute();
          }
          foreach ($added_privileges as $priv) {
            $stmt1 = $con->prepare(" INSERT INTO
                                app_users_groups_privileges(group_id, privilege_id)
                                VALUES (:group, :privilege)");
            $stmt1->execute(array(
              'group'       => $group,
              'privilege'   => $priv,
            ));
          }
          messagesPut('success', 'Users group updated successfuly');
          redirect('users_groups.php');
        }else {
          messagesPut('danger', 'Something went wrong! Please try again');
          redirect('back');
        }

      }else {
        redirect('users_groups.php');
      }
    }else {
      redirect('users_groups.php');
    }
  }elseif ($action == 'delete') {
    hasAccess();

    //display in title of current pa
    $group_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']): 0;
    $check = check('group_id', 'app_users_groups', $group_id);
    if ($check > 0) {
      $stmt = $con->prepare("DELETE FROM app_users_groups WHERE group_id = :pid");
      $stmt->bindParam(":pid",$group_id );
      $stmt->execute();
      if ($stmt) {
        messagesPut('success', 'Users group deleted successfuly');
        redirect('users_groups.php');
      }else {
        messagesPut('danger', 'Something went wrong! Please try again');
        redirect('users_groups.php');
      }
    }else {
      redirect('users_groups.php');
    }

  }else {
    redirect('notfound.php');
  }
  require_once(ADMIN_TEMPLATE_PATH . 'footer.php');

ob_end_flush();
