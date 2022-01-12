<?php
ob_start();
  session_start();
  $app  = 'app-admin';
  $page = 'users';
  require_once('../config.php');
  if (null == authorized()) {
    redirect('login.php');
  }
  $page_title = $lang['page_users'];
  // Start Content View
  require_once(ADMIN_TEMPLATE_PATH . 'header.php');
  require_once(ADMIN_TEMPLATE_PATH . 'sidebar.php');
  require_once(ADMIN_TEMPLATE_PATH . 'navbar.php');

  $action = isset($_GET['action']) ? $_GET['action'] : 'index';

  if ($action == 'index') {
    hasAccess();
    //$usersinfo = getAll("*", "app_users");
    $stmt = $con->prepare("SELECT au.*, aug.group_title_en FROM app_users au INNER JOIN app_users_groups aug ON aug.group_id = au.group_id");
    $stmt->execute();
    $usersinfo = $stmt->fetchAll();
?>
      <!-- Begin Page Content -->
      <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">users</h1>
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
            <h6 class="m-0 font-weight-bold text-primary">Users Manage</h6>
            <a class="action-item reload btn btn-primary btn-sm"href="users.php?action=create" > <i class="fas fa-user-plus fa-fw"></i></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th>Group Name</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th>Last Update</th>
                    <th>Actions</th>
                  </tr>
                </thead>

                <tbody>
                  <?php if ($usersinfo !== false): foreach ($usersinfo as $info): ?>
                    <tr>
                      <td><?= $info['user_id']?></td>
                      <td><?= $info['username']?></td>
                      <td><?= $info['first_name']?></td>
                      <td><?= $info['last_name']?></td>
                      <td><?= $info['email']?></td>
                      <td><?= $info['group_title_en']?></td>
                      <td><?= $info['status']?></td>
                      <td><?= $info['created_at']?></td>
                      <td><?= $info['updated_at']?></td>
                      <td>

                         <a class="btn btn-info bt-sm" href="users.php?action=show&id=<?=$info['user_id']?>"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-success bt-sm" href="users.php?action=edit&id=<?=$info['user_id']?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger bt-sm" href="users.php?action=delete&id=<?=$info['user_id']?>"><i class="fa fa-trash"></i></a>
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
    $users_groups_info = getAll("*", "app_users_groups");
  ?>
    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
      <h1 class="h3 mb-2 text-gray-800">users/create</h1>
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">New User Details</h6>
          <a class="action-item reload btn btn-primary btn-sm"href="users.php?action=create" > <i class="fas fa-user-plus fa-fw"></i></a>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-9">
              <div class="form-content">
                <form class="" action="users.php?action=insert" method="post" enctype="multipart/form-data">
                  <div class="form-row">
                    <div class=" username-field form-group col-md-3">
                      <label for="inputUsername">Username</label>
                      <input type="text" name="username" class="form-control" id="inputUsername">
                    </div>
                    <div class=" email-field form-group col-md-3">
                      <label for="inputEmail4">Email</label>
                      <input type="email" name="email" class="form-control" id="inputEmail4">
                    </div>
                    <div class="form-group col-md-3">
                      <label for="inputFirst_Name">Firstname</label>
                      <input type="text" name="firstname" class="form-control" id="inputFirst_Name" >
                    </div>
                    <div class="form-group col-md-3">
                      <label for="inputLanst_name">Lastname</label>
                      <input type="text" name="lastname" class="form-control" id="inputLanst_name" >
                    </div>
                  </div>
                  <div class="form-row">
                    <div class=" username-field form-group col-md-3">
                      <label for="inputPasssword">Password</label>
                      <input type="password" name="password" class="form-control" id="inputPasssword">
                    </div>
                    <div class=" email-field form-group col-md-3">
                      <label for="inputREPassword">RE-Password</label>
                      <input type="password" name="re_password" class="form-control" id="inputREPassword">
                    </div>
                    <div class="form-group col-md-3">
                      <label for="inputStatus">Status</label>
                      <select class="form-control" name="status" id="inputStatus">
                        <option value="active" selected>Active</option>
                        <option value="pending">Pending</option>
                        <option value="disabled">Disabled</option>
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="inputStatus">Users groups</label>
                      <select class="form-control" name="users_group" id="inputStatus">
                        <option value="">Choose Group</option>
                        <?php foreach ($users_groups_info as $info): ?>
                          <option value="<?=$info['group_id']?>"><?=$info['group_title_en']?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class=" username-field form-group col-md-3">
                      <label for="inputSpecialty">Specialty</label>
                      <input type="text" name="specialty" class="form-control" id="inputSpecialty">
                    </div>
                    <div class=" email-field form-group col-md-3">
                      <label for="inputCity">City</label>
                      <input type="text" name="city" class="form-control" id="inputCity">
                    </div>
                    <div class="form-group col-md-3">
                      <label for="inputAddress">Address</label>
                      <input type="text" name="address" class="form-control" id="inputAddress" >
                    </div>
                    <div class="form-group col-md-3">
                      <label for="inputPhone">Phone</label>
                      <input type="text" name="phone" class="form-control" id="phone">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class=" username-field form-group col-md-3">
                      <label for="inputDOB">Data of Birth</label>
                      <input type="date" name="dob" class="form-control" id="inputDOB">
                    </div>
                    <div class=" email-field form-group col-md-3">
                      <label for="inputImage">Image</label>
                      <input type="file" name="image" class="form-control" id="inputImage">
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
      $username     = $_POST['username'];
      $email        = $_POST['email'];
      $firstname    = $_POST['firstname'];
      $lastname     = $_POST["lastname"];
      $password     = $_POST["password"];
      $repass       = $_POST["re_password"];
      $status       = $_POST["status"];
      $user_group   = $_POST["users_group"];
      // Profile Variables
      $specialty    = $_POST["specialty"];
      $city         = $_POST["city"];
      $address      = $_POST["address"];
      $phone        = $_POST["phone"];
      $dob          = $_POST["dob"];
      $about        = $_POST["about"];
      $date = date('Y-m-d');
      // insrt The data in database
      $stmt = $con->prepare(" INSERT INTO
                          app_users(username, email, password, first_name, last_name, group_id, status, created_at)
                          VALUES (:username, :email, :password, :first_name, :last_name, :group_id, :status, :created_at) ");
      $stmt->execute(array(
        'username'    => $username,
        'email'       => $email,
        'password'    => crypt_pass($password),
        'first_name'  => $firstname,
        'last_name'   => $lastname,
        'group_id'    => $user_group,
        'status'      => $status,
        'created_at'  => $date
      ));
      // Register Tha Last Id
      $last_id = $con->lastInsertId();
      // IF $stmt True Will Be Continue The Block of Code
      if ($stmt) {
        // insrt The data in database
        $stmt1 = $con->prepare(" INSERT INTO
                            app_users_profiles(user_id, specialty, city, address, phone, dob, about)
                            VALUES (:user_id, :specialty, :city, :address, :phone, :dob, :about) ");
        $stmt1->execute(array(
          'user_id'   => $last_id,
          'specialty' => $specialty,
          'city'      => $city,
          'address'   => $address,
          'phone'     => $phone,
          'dob'       => $dob,
          'about'     => $about,
        ));
        if ($stmt1) {
          messagesPut('success', 'User added successfuly');
          redirect('users.php');
        }
      }else {
        messagesPut('danger', 'Something went wrong! Please try again');
        redirect('back');
      }

    }else {
      redirect('users.php');
    }
  }elseif ($action == 'edit') {
    hasAccess();

    //display id in the title of current page
    $user_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']): 0;
    $check = check('user_id', 'app_users', $user_id);
    if ($check > 0) {
      // get the user info
      $stmt = $con->prepare("SELECT * FROM app_users WHERE user_id = ? ");
      $stmt->execute(array($user_id));
      $userinfo = $stmt->fetch();
      // get the user profile
      $stmt1 = $con->prepare("SELECT * FROM app_users_profiles WHERE user_id = ? ");
      $stmt1->execute(array($user_id));
      $userprofile = $stmt1->fetch();
      // get all users groups
      $users_groups_info = getAll("*", "app_users_groups");
    ?>
    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
      <h1 class="h3 mb-2 text-gray-800">users/edit</h1>
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Edit User Details</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-9">
              <div class="form-content">
                <form class="" action="users.php?action=update" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="user_id" value="<?= $userinfo['user_id']?>">
                  <div class="form-row"><!--for each attribute assigend values -->
                    <div class=" username-field form-group col-md-3">
                      <label for="inputUsername">Username</label>
                      <input type="text" name="username" class="form-control" id="inputUsername" value="<?=$userinfo['username']?>">
                    </div>
                    <div class=" email-field form-group col-md-3">
                      <label for="inputEmail4">Email</label>
                      <input type="email" name="email" class="form-control" id="inputEmail4" value="<?=$userinfo['email']?>">
                    </div>
                    <div class="form-group col-md-3">
                      <label for="inputFirst_Name">Firstname</label>
                      <input type="text" name="firstname" class="form-control" id="inputFirst_Name" value="<?=$userinfo['first_name']?>" >
                    </div>
                    <div class="form-group col-md-3">
                      <label for="inputLanst_name">Lastname</label>
                      <input type="text" name="lastname" class="form-control" id="inputLanst_name" value="<?=$userinfo['last_name']?>" >
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="inputStatus">Status</label>
                      <select class="form-control" name="status" id="inputStatus">
                        <!--if the option is chosen...then chosen the new option from a list-->
                        <option value="active" <?php if($userinfo['status'] == 'active'){echo ' selected';}?>>Active</option>
                        <option value="pending"<?php if($userinfo['status'] == 'pending'){echo ' selected';}?>>Pending</option>
                        <option value="disabled"<?php if($userinfo['status'] == 'disabled'){echo ' selected';}?>>Disabled</option>
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="inputStatus">Users groups</label>
                      <select class="form-control" name="users_group" id="inputStatus">
                        <option value="">Choose Group</option>
                        <?php foreach ($users_groups_info as $info): ?>
                          <option value="<?=$info['group_id']?>" <?php if($userinfo['group_id'] == $info['group_id']){echo ' selected';}?>><?=$info['group_title_en']?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class=" username-field form-group col-md-3">
                      <label for="inputSpecialty">Specialty</label>
                      <input type="text" name="specialty" class="form-control" id="inputSpecialty" value="<?= $userprofile['specialty']?>">
                    </div>
                    <div class=" email-field form-group col-md-3">
                      <label for="inputCity">City</label>
                      <input type="text" name="city" class="form-control" id="inputCity" value="<?= $userprofile['city']?>">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="inputAddress">Address</label>
                      <input type="text" name="address" class="form-control" id="inputAddress" value="<?= $userprofile['address']?>" >
                    </div>
                    <div class="form-group col-md-3">
                      <label for="inputPhone">Phone</label>
                      <input type="text" name="phone" class="form-control" id="phone" value="<?= $userprofile['phone']?>">
                    </div>
                    <div class=" username-field form-group col-md-3">
                      <label for="inputDOB">Data of Birth</label>
                      <input type="date" name="dob" class="form-control" id="inputDOB" value="<?= $userprofile['dob']?>">
                    </div>
                    <div class=" email-field form-group col-md-3">
                      <label for="inputImage">Image</label>
                      <input type="file" name="image" class="form-control" id="inputImage">
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="about">About</label>
                      <textarea name="about" rows="8" cols="80" class="form-control"><?= $userprofile['about']?></textarea>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <button class="btn btn-success" type="submit" name="group_create"><i class="fas fa-plus fa-fw"></i> Update</button>
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
        redirect('users.php');

        }
 }elseif ($action == 'update') {
   hasAccess();

   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     $user_id      = $_POST['user_id'];
     $username     = $_POST['username'];
     $email        = $_POST['email'];
     $firstname    = $_POST['firstname'];
     $lastname     = $_POST["lastname"];
     $status       = $_POST["status"];
     $user_group   = $_POST["users_group"];
     // Profile Variables
     $specialty    = $_POST["specialty"];
     $city         = $_POST["city"];
     $address      = $_POST["address"];
     $phone        = $_POST["phone"];
     $dob          = $_POST["dob"];
     $about        = $_POST["about"];
     $date = date('Y-m-d');
     // update The data in database
     $stmt = $con->prepare("UPDATE app_users SET username = ?, email = ? , first_name = ?, last_name = ?, group_id = ?, status = ?, updated_at = ? WHERE user_id = ?");
     $stmt->execute(array($username, $email, $firstname, $lastname, $user_group, $status, $date, $user_id   ));

     // IF $stmt True Will Be Continue The Block of Code
     if ($stmt) {
       // update user profile The data in database
       $stmt1 = $con->prepare("UPDATE app_users_profiles SET specialty = ?, city = ? , address = ?, phone = ?, dob = ?, about = ? WHERE user_id = ?");
       $stmt1->execute(array($specialty, $city, $address, $phone, $dob, $about, $user_id   ));
       if ($stmt1) {
         messagesPut('success', 'User updated successfuly');
         redirect('users.php');
       }
     }else {
       messagesPut('danger', 'Something went wrong! Please try again');
       redirect('back');
     }

   }else {
     redirect('users.php');
   }

   //Show profile of users
 }elseif ($action == 'show') {
  hasAccess();
  hasAccess();




  //display id in the title of current page
  $user_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']): 0;
  $check = check('user_id', 'app_users', $user_id);
  if ($check > 0) //featch data from two tables

  // get the user info
  $stmt = $con->prepare("SELECT * FROM app_users WHERE user_id = ? ");
  $stmt->execute(array($user_id));
  $userinfo = $stmt->fetch();
  // get the user profile
  $stmt1 = $con->prepare("SELECT * FROM app_users_profiles WHERE user_id = ? ");
  $stmt1->execute(array($user_id));
  $userprofile = $stmt1->fetch();
  // get all users groups
  $users_groups_info = getAll("*", "app_users_groups");
  ?>
  <!-- Begin Page Content -->
  <div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Users/profile</h1>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Show User Details</h6>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-9">
          <div class="form-content">
            <form class="" action="users.php?action=update" method="post" enctype="multipart/form-data">
              <input type="hidden" name="user_id" value="<?= $userinfo['user_id']?>">
              <div class="form-row"><!--for each attribute assigend values -->
                <div class=" username-field form-group col-md-3">
                  <label for="inputUsername">Username</label>
                  <input type="text" name="username" class="form-control" id="inputUsername" value="<?=$userinfo['username']?>">
                </div>
                <div class=" email-field form-group col-md-3">
                  <label for="inputEmail4">Email</label>
                  <input type="email" name="email" class="form-control" id="inputEmail4" value="<?=$userinfo['email']?>">
                </div>
                <div class="form-group col-md-3">
                  <label for="inputFirst_Name">Firstname</label>
                  <input type="text" name="firstname" class="form-control" id="inputFirst_Name" value="<?=$userinfo['first_name']?>" >
                </div>
                <div class="form-group col-md-3">
                  <label for="inputLanst_name">Lastname</label>
                  <input type="text" name="lastname" class="form-control" id="inputLanst_name" value="<?=$userinfo['last_name']?>" >
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="inputStatus">Status</label>
                  <select class="form-control" name="status" id="inputStatus">
                    <!--if the option is chosen...then chosen the new option from a list-->
                    <option value="active" <?php if($userinfo['status'] == 'active'){echo ' selected';}?>>Active</option>
                    <option value="pending"<?php if($userinfo['status'] == 'pending'){echo ' selected';}?>>Pending</option>
                    <option value="disabled"<?php if($userinfo['status'] == 'disabled'){echo ' selected';}?>>Disabled</option>
                  </select>
                </div>
                <div class="form-group col-md-3">
                  <label for="inputStatus">Users groups</label>
                  <select class="form-control" name="users_group" id="inputStatus">
                    <option value="">Choose Group</option>
                    <?php foreach ($users_groups_info as $info): ?>
                      <option value="<?=$info['group_id']?>" <?php if($userinfo['group_id'] == $info['group_id']){echo ' selected';}?>><?=$info['group_title_en']?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class=" username-field form-group col-md-3">
                  <label for="inputSpecialty">Specialty</label>
                  <input type="text" name="specialty" class="form-control" id="inputSpecialty" value="<?= $userprofile['specialty']?>">
                </div>
                <div class=" email-field form-group col-md-3">
                  <label for="inputCity">City</label>
                  <input type="text" name="city" class="form-control" id="inputCity" value="<?= $userprofile['city']?>">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="inputAddress">Address</label>
                  <input type="text" name="address" class="form-control" id="inputAddress" value="<?= $userprofile['address']?>" >
                </div>
                <div class="form-group col-md-3">
                  <label for="inputPhone">Phone</label>
                  <input type="text" name="phone" class="form-control" id="phone" value="<?= $userprofile['phone']?>">
                </div>
                <div class=" username-field form-group col-md-3">
                  <label for="inputDOB">Data of Birth</label>
                  <input type="date" name="dob" class="form-control" id="inputDOB" value="<?= $userprofile['dob']?>">
                </div>
                <div class=" email-field form-group col-md-3">
                  <label for="inputImage">Image</label>
                  <input type="file" name="image" class="form-control" id="inputImage">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="about">About</label>
                  <textarea name="about" rows="8" cols="80" class="form-control"><?= $userprofile['about']?></textarea>
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
  <?php



 } elseif ($action == 'delete') {
   hasAccess();
   $user_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']): 0;
   $check = check('user_id', 'app_users', $user_id);
   if ($check > 0) {
     $stmt = $con->prepare("DELETE FROM app_users WHERE user_id = :pid");
     $stmt->bindParam(":pid",$user_id );
     $stmt->execute();
     if ($stmt) {
       messagesPut('success', 'Users deleted successfuly');
       redirect('users.php');
     }else {
       messagesPut('danger', 'Something went wrong! Please try again');
       redirect('users.php');
     }
   }else {
     redirect('users.php');
   }
 }else {
    redirect('notfound.php');
  }

  require_once(ADMIN_TEMPLATE_PATH . 'footer.php');
ob_end_flush();
