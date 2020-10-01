<?php
$pageTitle = "| الرئيسية";
require_once 'includes/templates/admin-header.php'
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">الرئيسية</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                  <?php
                  $stUsersNum = $mysqli->query('SELECT * FROM users');
                  $UsersNum = $stUsersNum->num_rows;
                  ?>
                <h3><?php echo $UsersNum ?></h3>
                <p class="font-head">الأعضاء</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                  <?php
                  $stUrlNum = $mysqli->query('SELECT * FROM urls');
                  $urlNum = $stUrlNum->num_rows;
                  ?>
                <h3><?php echo $urlNum ?></h3>
                <p class="font-head">الروابط</p>
              </div>
              <div class="icon">
                <i class="fas fa-globe"></i>
              </div>
              <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                  <?php
                  $stSectionsNum = $mysqli->query('SELECT * FROM sections');
                  $sectionsNum = $stSectionsNum->num_rows;
                  ?>
                <h3><?php echo $sectionsNum?></h3>
                <p class="font-head">القوائم</p>
              </div>
              <div class="icon">
                <i class="fas fa-th-list"></i>
              </div>
              <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                    <?php
                    $stMsgUum = $mysqli->query('SELECT * FROM messages');
                    $msgUum = $stMsgUum->num_rows;
                    ?>
                <h3><?php echo $msgUum?></h3>
                <p class="font-head">الرسائل</p>
              </div>
              <div class="icon">
                <i class="fas fa-envelope"></i>
              </div>
              <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- .row -->
          <div class="row">

              <div class="col-12 col-md-6">
                  <!-- latest users -->
                  <div class="card">
                      <div class="card-header">
                          <h3 class="card-title">
                              <i class="fas fa-users"></i>
                              آخرالأعضاء المسجلين
                          </h3>

                          <div class="card-tools">
                              <span data-toggle="tooltip" class="badge badge-info">5</span>
                              <button type="button" class="btn btn-tool" data-widget="collapse">
                                  <i class="fa fa-minus"></i>
                              </button>
                          </div>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body" style="padding: 10px !important;">
                          <ul class="todo-list">
                                <?php

                                $stUsers = $mysqli->query('SELECT * FROM users ORDER BY user_id DESC LIMIT 5');
                                $users = $stUsers->fetch_all(MYSQLI_ASSOC);

                                foreach ($users as $user):?>
                              <li>
                                  <!-- user name -->
                                  <span class="text"><?php echo $user['user_name']?></span>
                                  <!-- General tools such as edit or delete-->
                                  <div class="tools float-right">
                                      <a href="users/edit.php?userId=<?php echo $user['user_id']?>"><button class="btn btn-sm btn-info px-2 pt-0 pb-1"><i style="font-size: 12px" class="fa fa-edit fa-fw p-0 pr-1"></i></button></a>
                                      <form style="display: inline-block" action="" method="post" class="mx-1">
                                          <input type="hidden" name="userId" value="<?php echo $user['user_id']?>">
                                          <button type="submit" name="delete_user" class="btn btn-sm btn-danger px-2 pt-0 pb-1" onclick="return confirm('هل تريد الحذف؟')"><i style="font-size: 12px" class="fas fa-backspace fa-fw"></i></button>
                                      </form>
                                  </div>
                              </li>
                               <?php endforeach;?>
                          </ul>
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer clearfix">
                          <a href="users/add_user.php"><button type="button" class="btn btn-info float-left"><i class="fa fa-plus"></i> إضافة عضو</button></a>
                      </div>
                  </div>
              </div>

              <div class="col-12 col-md-6">
                  <!-- latest messages  -->
                  <div class="card direct-chat direct-chat-primary">
                      <div class="card-header">
                          <h3 class="card-title">
                              <i class="fas fa-envelope"></i>
                              آخر الرسائل المرسلة
                          </h3>

                          <div class="card-tools">
                              <span data-toggle="tooltip" class="badge badge-primary">5</span>
                              <button type="button" class="btn btn-tool" data-widget="collapse">
                                  <i class="fa fa-minus"></i>
                              </button>

                          </div>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                          <!-- Message -->
                          <div class="direct-chat-messages">
                              <?php

                              $stMsg = $mysqli->query('SELECT * FROM messages ORDER BY message_id DESC LIMIT 5');
                              $msgs = $stMsg->fetch_all(MYSQLI_ASSOC);

                              foreach ($msgs as $msg):
                              ?>
                              <div class="direct-chat-msg">
                                  <div class="direct-chat-info clearfix">
                                      <span class="direct-chat-name float-left"><?php echo $msg['name']?></span>
                                      <span class="direct-chat-timestamp float-right"><?php echo $msg['date_time']?></span>
                                  </div>
                                  <!-- /.Message-info -->
                                  <img class="direct-chat-img" src="<?php echo $config['app_url']?>uploads/avatars/default.png" alt="message user image">
                                  <!-- /.Message-img -->
                                  <div class="direct-chat-text">
                                      <?php echo $msg['message']?>
                                  </div>
                                  <!-- /.Message-text -->
                              </div>
                              <?php endforeach; ?>

                          </div>
                          <!-- /Message-->
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer">
                          <button type="button" class="btn btn-primary float-left"><i class="far fa-envelope"></i> الرسائل</button>

                      </div>
                      <!-- /.card-footer-->
                  </div>
                  <!--/.direct-chat -->
              </div>

          </div>
          <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php

if (isset($_POST['delete_user'])){

    $userId = mysqli_real_escape_string($mysqli, $_POST['userId']);

    $query = "DELETE FROM users WHERE user_id=$userId";
    $mysqli->query($query);

    if ($mysqli->error){
        echo "<script>alert('".$mysqli->error."')</script>";
    }else{
        $_SESSION['error_message'] = 'تم الحذف';
        header('location:index.php');
        die();
    }

}
require_once 'includes/templates/admin-footer.php'?>