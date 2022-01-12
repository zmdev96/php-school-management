<?php
ob_start();
  session_start();
  $app  = 'app-admin';
  $page = 'classes';
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
    $all_classes = getAll("*", "app_classes");
?>
      <!-- Begin Page Content -->
      <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">classes</h1>
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
            <h6 class="m-0 font-weight-bold text-primary">Classes Manage</h6>
            <a class="action-item reload btn btn-primary btn-sm"href="classes.php?action=create" > <i class="fas fa-plus fa-fw"></i></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Division</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>

                <tbody>
                  <?php if ($all_classes !== false): foreach ($all_classes as $info): ?>
                    <tr>
                      <td><?= $info['class_id']?></td>
                      <td><?= $info['name']?></td>
                      <td><?= $info['division']?></td>
                      <td class="text-center">
                        <a class="btn btn-success bt-sm" href="classes.php?action=edit&id=<?=$info['class_id']?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger bt-sm" href="classes.php?action=delete&id=<?=$info['class_id']?>"><i class="fa fa-trash"></i></a>
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
    $all_material = getAll("*", "app_material");
    // Get All Teachers
    $stmt = $con->prepare("SELECT * FROM  app_users WHERE group_id = 5 ");
    // Execute The Statement
    $stmt->execute();
    // Assign To Variable
    $teachers = $stmt->fetchAll();
  ?>
    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
      <h1 class="h3 mb-2 text-gray-800">classes/create</h1>
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">New Calss Details</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-9">
              <div class="form-content">
                <form class="" action="classes.php?action=insert" method="post" enctype="multipart/form-data">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputUsername">Name</label>
                      <input type="text" name="class_name" class="form-control" id="inputUsername">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputEmail4">Division</label>
                      <input type="text" name="division" class="form-control" id="inputEmail4">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="inputStatus">Material</label>
                      <select class="form-control"  id="inputMaterial">
                        <option value="active" selected>Choose Material</option>
                        <?php foreach ($all_material as $info): ?>
                          <option value="<?=$info['material_id']?>"><?=$info['material']?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputStatus">Teachers</label>
                      <select class="form-control"  id="inputTeacher">
                        <option value="active" selected>Choose Teacher</option>
                        <?php foreach ($teachers as $info): ?>
                          <option value="<?=$info['user_id']?>"><?=$info['first_name']?> <?=$info['last_name']?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group col-md-1">
                      <label for="inputStatus">Add</label>
                      <button class="btn btn-primary form-control" type="button" id="material_teacher">Add</button>
                    </div>
                  </div>
                  <div class="form-row">
                    <div id="class_info">


                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <button class="btn btn-success " type="submit" ><i class="fas fa-plus fa-fw"></i> Create</button>
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
      $name     = $_POST['class_name'];
      $division = $_POST['division'];
      $class_info = $_POST['class_info'];
       foreach ($class_info as $info) {
        $item = explode(',', $info);
        echo 'your material id is: ' . $item[0] . ' and teacher id is: ' . $item[1]. '<br>';
       }
      // insrt The data in database
      $stmt = $con->prepare(" INSERT INTO
                          app_classes(name, division)
                          VALUES (:name, :division) ");
      $stmt->execute(array(
        'name'     => $name,
        'division' => $division,
      ));

      $last_id = $con->lastInsertId();
      if ($stmt) {
        foreach ($class_info as $info) {
         $item = explode(',', $info);
         // insrt The data in database
         $stmt1 = $con->prepare(" INSERT INTO
                             app_classes_material(class_id, material_id, user_id)
                             VALUES (:class, :material, :user) ");
         $stmt1->execute(array(
           'class'    => $last_id,
           'material' =>  $item[0],
           'user'     =>  $item[1]
         ));
        }
        messagesPut('success', 'Class added successfuly');
        redirect('classes.php');
      }else {
        messagesPut('danger', 'Something went wrong! Please try again');
        redirect('back');
      }

    }else {
      redirect('classes.php');
    }
  }elseif ($action == 'edit') {
    hasAccess();

    //display id in the title of current page
    $class_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']): 0;
    $check = check('class_id', 'app_classes', $class_id);
    if ($check > 0) {
      // get the user info
      $stmt = $con->prepare("SELECT * FROM app_classes WHERE class_id = ? ");
      $stmt->execute(array($class_id));
      $class_info = $stmt->fetch();

      $all_material = getAll("*", "app_material");
      // Get All Teachers
      $stmt1 = $con->prepare("SELECT * FROM  app_users WHERE group_id = 5 ");
      // Execute The Statement
      $stmt1->execute();
      // Assign To Variable
      $teachers = $stmt1->fetchAll();
      // get the ,aterial and Teacher
      $stmt2 = $con->prepare("SELECT acm.*, au.first_name,last_name, am.material material
                              FROM app_classes_material acm
                              INNER JOIN app_users au ON acm.user_id = au.user_id
                              INNER JOIN app_material am ON acm.material_id = am.material_id
                              WHERE class_id = $class_id ");
      $stmt2->execute();
      $class_teacher = $stmt2->fetchAll();
    ?>
    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
      <h1 class="h3 mb-2 text-gray-800">classes/edit</h1>
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Edit Class Details</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-9">
              <div class="form-content">
                <form class="" action="classes.php?action=update" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="class_id" value="<?= $class_info['class_id']?>">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputUsername">Name</label>
                      <input type="text" name="class_name" class="form-control" id="inputUsername" value="<?= $class_info['name']?>">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputEmail4">Division</label>
                      <input type="text" name="division" class="form-control" id="inputEmail4" value="<?= $class_info['division']?>">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="inputStatus">Material</label>
                      <select class="form-control"  id="inputMaterial">
                        <option value="active" selected>Choose Material</option>
                        <?php foreach ($all_material as $info): ?>
                          <option value="<?=$info['material_id']?>"><?=$info['material']?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputStatus">Teachers</label>
                      <select class="form-control"  id="inputTeacher">
                        <option value="active" selected>Choose Teacher</option>
                        <?php foreach ($teachers as $info): ?>
                          <option value="<?=$info['user_id']?>"><?=$info['first_name']?> <?=$info['last_name']?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group col-md-1">
                      <label for="inputStatus">Add</label>
                      <button class="btn btn-primary form-control" type="button" id="material_teacher">Add</button>
                    </div>
                  </div>
                  <div class="form-row">
                    <div id="class_info">
                       <?php foreach ($class_teacher as $info): ?>
                         <div class="item_list">
                           <input type="checkbox" checked  name="class_info[]" value="<?=$info['material_id']?>,<?=$info['user_id']?>">
                           <label> The Material: <?= $info['material']?> The Teacher: <?=$info['first_name']?> <?=$info['last_name']?></label>
                         </div>
                       <?php endforeach; ?>

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
        redirect('classes.php');

        }
 }elseif ($action == 'update') {
   hasAccess();

   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     $name     = $_POST['class_name'];
     $division = $_POST['division'];
     $class_id = $_POST['class_id'];
     $class_info = $_POST['class_info'];


     // update The data in database
     $stmt = $con->prepare("UPDATE app_classes SET name = ?, division = ?  WHERE class_id = ?");
     $stmt->execute(array($name, $division, $class_id));

     // IF $stmt True Will Be Continue The Block of Code
     if ($stmt) {
       $stmt1 = $con->prepare("DELETE FROM app_classes_material WHERE class_id = :pid");
       $stmt1->bindParam(":pid",$class_id );
       $stmt1->execute();
       if ($stmt1) {
         foreach ($class_info as $info) {
          $item = explode(',', $info);
          // insrt The data in database
          $stmt2 = $con->prepare(" INSERT INTO
                              app_classes_material(class_id, material_id, user_id)
                              VALUES (:class, :material, :user) ");
          $stmt2->execute(array(
            'class'    => $class_id,
            'material' =>  $item[0],
            'user'     =>  $item[1]
          ));
         }
         messagesPut('success', 'Class updated successfuly');
         redirect('classes.php');
      }
     }else {
       messagesPut('danger', 'Something went wrong! Please try again');
       redirect('back');
     }

   }else {
     redirect('classes.php');
   }
 } elseif ($action == 'delete') {
   hasAccess();
   $class_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']): 0;
   $check = check('class_id', 'app_classes', $class_id);
   if ($check > 0) {
     $stmt = $con->prepare("DELETE FROM app_classes WHERE class_id = :pid");
     $stmt->bindParam(":pid",$class_id );
     $stmt->execute();
     if ($stmt) {
       $stmt1 = $con->prepare("DELETE FROM app_classes_material WHERE class_id = :pid");
       $stmt1->bindParam(":pid",$class_id );
       $stmt1->execute();
       messagesPut('success', 'Class deleted successfuly');
       redirect('classes.php');
     }else {
       messagesPut('danger', 'Something went wrong! Please try again');
       redirect('classes.php');
     }
   }else {
     redirect('classes.php');
   }
 }else {
    redirect('notfound.php');
  }

  require_once(ADMIN_TEMPLATE_PATH . 'footer.php');
ob_end_flush();
