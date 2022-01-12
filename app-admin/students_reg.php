<?php
ob_start();
  session_start();
  $app  = 'app-admin';
  $page = 'students_reg';
  require_once('../config.php');
  if (null == authorized()) {
    redirect('login.php');
  }
  $page_title = $lang['page_classes'];
  // Start Content View
  require_once(ADMIN_TEMPLATE_PATH . 'header.php');
  require_once(ADMIN_TEMPLATE_PATH . 'sidebar.php');
  require_once(ADMIN_TEMPLATE_PATH . 'navbar.php');

  $action = isset($_GET['action']) ? $_GET['action'] : 'create';

 if ($action == 'create') {
    hasAccess();
    $all_users = getAll('*', 'app_users');
    $all_calsses = getAll('*', 'app_classes');

  ?>
    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
      <h1 class="h3 mb-2 text-gray-800">students/create</h1>
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
          <h6 class="m-0 font-weight-bold text-primary">New Students Details</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-9">
              <div class="form-content">
                <form class="" action="students_reg.php?action=insert" method="post" enctype="multipart/form-data" id="students_reg">
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="inputFirst_Name">Firstname</label>
                      <input type="text" name="firstname" class="form-control" id="inputFirst_Name" >
                    </div>
                    <div class="form-group col-md-3">
                      <label for="inputLanst_name">Lastname</label>
                      <input type="text" name="lastname" class="form-control" id="inputLanst_name">
                    </div>
                    <div class=" email-field form-group col-md-3">
                      <label for="inputEmail4">Email</label>
                      <input type="email" name="email" class="form-control" id="inputEmail4" >
                    </div>
                    <div class=" email-field form-group col-md-3">
                      <label for="inputnational_id">National ID</label>
                      <input type="text" name="national_id" class="form-control" id="inputnational_id" >
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="has_teacher">Has Teacher</label>
                      <select class="form-control" name="has_teacher" id="has_teacher">
                        <option selected value="no">NO</option>
                        <option value="yes">YES</option>
                      </select>
                    </div>
                    <div class="form-group col-md-3" id="students_users">
                      <label for="teacher">Teacher</label>
                      <select class="form-control" name="teacher" id="teacher">
                        <option  value="0">Choose Teacher</option>
                        <?php foreach ($all_users as $users): ?>
                          <option value="<?= $users['user_id']?>"><?= $users['first_name']?> <?= $users['last_name']?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group col-md-3" >
                      <label for="Class">Class</label>
                      <select class="form-control" name="class_id" id="Class">
                        <option selected value="0">Choose Class</option>
                        <?php foreach ($all_classes as $classes): ?>
                          <option value="<?= $classes['class_id']?>"><?= $classes['name']?> division <?= $classes['division']?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="inputaddress">Address</label>
                      <input type="text" name="addrees" class="form-control" id="inputaddress" >
                    </div>
                    <div class="form-group col-md-3">
                      <label for="inputPOB">Pleace of Birth</label>
                      <input type="date" name="pob" class="form-control" id="inputPOB">
                    </div>
                    <div class=" email-field form-group col-md-3">
                      <label for="inputDOB">Date of Birth</label>
                      <input type="date" name="dob" class="form-control" id="inputDOB" >
                    </div>
                    <div class=" email-field form-group col-md-3">
                      <label for="Gender">Gender</label>
                      <select class="form-control" name="gender" id="Gender">
                        <option selected value="0">Choose Gender</option>
                        <option  value="male">Male</option>
                        <option  value="female">Female</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="inputnationalty">Nationalty	</label>
                      <input type="text" name="nationalty" class="form-control" id="inputnationalty" >
                    </div>
                    <div class="form-group col-md-3">
                      <label for="inputresponsble">Responsble Name</label>
                      <input type="text" name="responsble" class="form-control" id="inputresponsble">
                    </div>
                    <div class=" email-field form-group col-md-3">
                      <label for="inputresponsible_phone">Responsible Phone</label>
                      <input type="text" name="responsible_phone" class="form-control" id="inputresponsible_phone" >
                    </div>
                    <div class=" email-field form-group col-md-3">
                      <label for="inputresponsible_job">Responsible Job</label>
                      <input type="text" name="responsible_job" class="form-control" id="inputresponsible_job" >
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <button class="btn btn-success" type="submit" name="students_create"><i class="fas fa-plus fa-fw"></i> Create</button>
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
      pre($_POST);
      $first_name = $_POST['firstname'];
      $last_name = $_POST['lastname'];
      $email = $_POST['email'];
      $class_id = $_POST['class_id'];
      $national_id = $_POST['national_id'];
      if ($_POST['has_teacher'] !== 'no') {
        $has_user = $_POST['teacher'];
      }
      // profile
      $addrees = $_POST['addrees'];
      $pob = $_POST['pob'];
      $dob = $_POST['dob'];
      $gender = $_POST['gender'];
      $nationalty = $_POST['nationalty'];
      $responsble = $_POST['responsble'];
      $responsible_phone = $_POST['responsible_phone'];
      $responsible_job = $_POST['responsible_job'];
      $date = date('Y-m-d');
      // insrt The data in database
      $stmt = $con->prepare(" INSERT INTO
                          app_students(first_name, last_name, national_id, email, class_id, has_users, created_at)
                          VALUES (:first_name, :last_name, :national_id, :email, :class_id, :has_users, :created_at) ");
      $stmt->execute(array(
        'first_name'  => $first_name,
        'last_name'   => $last_name,
        'national_id' => $national_id,
        'email'       => $email,
        'class_id'    => $class_id,
        'has_users'   => $has_user,
        'created_at'  => $date
      ));

      // Register Tha Last Id
      $last_id = $con->lastInsertId();
      // IF $stmt True Will Be Continue The Block of Code
      if ($stmt) {
        // insrt The data in database
        $stmt1 = $con->prepare(" INSERT INTO
                            app_students_profiles(student_id, address, pob, dob, gender, nationalty, responsble, responsible_phone, responsible_job)
                            VALUES (:student_id, :address, :pob, :dob, :gender, :nationalty, :responsble, :responsible_phone, :responsible_job) ");
        $stmt1->execute(array(
          'student_id'   => $last_id,
          'address' => $addrees,
          'pob'      => $pob,
          'dob'   =>   $dob,
          'gender'     => $gender,
          'nationalty'       => $nationalty,
          'responsble'     => $responsble,
          'responsible_phone' => $responsible_phone,
          'responsible_job' => $responsible_job
        ));
        if ($stmt1) {
          messagesPut('success', 'Student added successfuly');
          redirect('students_reg.php');
        }
      }else {
        messagesPut('danger', 'Something went wrong! Please try again');
        redirect('back');
      }

    }else {
      redirect('students_reg.php');
    }
  } elseif ($action == 'get_data') {
    $info = ['zeyad', 'hadeel'];
    echo json_encode($info);
  }else {
    redirect('notfound.php');
  }

  require_once(ADMIN_TEMPLATE_PATH . 'footer.php');
ob_end_flush();
