<?php
$pageTitle = "| رد على رسالة";
require_once '../includes/templates/admin-header.php';

if (!isset($_GET['message_id']) || empty($_GET['message_id']) || !is_numeric($_GET['message_id'])){
    header('location:index.php');
    die();
}

$stat = $mysqli->prepare("SELECT * FROM messages WHERE message_id=? LIMIT 1");
$stat->bind_param('i', $messageId);
$messageId = intval($_GET['message_id']);
$stat->execute();
$result = $stat->get_result();

if ($result->num_rows > 0){
    $message = $result->fetch_assoc();
}else{
    header('location:index.php');
    die();
}


    $errors     = [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        $username            = mysqli_real_escape_string($mysqli, $_POST['name']);
        $email               = mysqli_real_escape_string($mysqli, $_POST['email']);
        $message             = mysqli_real_escape_string($mysqli, $_POST['message']);

        if (empty($username)){array_push($errors, 'يجب ادخال اسم مستخدم');}
        if (empty($email)){array_push($errors, 'يجب ادخال بريد الكتروني');}
        if (empty($message)){array_push($errors, 'يجب ادخال رسالة');}

        if (!count($errors)){
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=UFT-8' . "\r\n";
            $headers .= 'From: '.$config['admin_email']."\r\n".
                'Reply-To: '.$config['admin_email']."\r\n" .
                'X-Mailer: PHP/' . phpversion();

            $messageHtml = '<html><body></body></html>';
            $messageHtml .= "<h5>شكرا لتواصلكم معنا $username ،</h5>";
            $messageHtml .= "<div>$message</div>";
            $messageHtml .= '</body></html>';


            if (mail($email, 'رسالة من مفضلتي', $messageHtml, $headers)){
                $_SESSION['notify_message'] = 'تم ارسال الرسالة';
                header('location: index.php');
                die();
            }else{
                $_SESSION['error_message'] = 'لم يتم إرسالة البريد، حدثت مشكلة';
                header('location: index.php');
                die();
            }
        }

    }

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">رد على رسالة</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid pb-5">

                <div class="card">
                    <?php  include  '../includes/config/errorsMessages.php'; ?>
                    <div class="card-header">
                        <h3 class="card-title m-0">رسالة جديدة</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="" method="post">
                        <div class="form-group">
                            <label for="name">إرسال الى:</label>
                            <input class="form-control" name="name" placeholder="إرسال الى:" value="<?php echo $message['name']?>">
                        </div>
                        <div class="form-group">
                            <label for="email">البريد الإلكتروني:</label>
                            <input class="form-control" name="email" placeholder="البريد الإلكتروني:"  value="<?php echo $message['email']?>">
                        </div>
                        <div class="form-group">
                            <label for="message">الرسالة:</label>
                            <textarea id="compose-textarea" name="message" class="form-control" style="height: 300px"></textarea>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="float-left">
                            <button type="submit" class="btn my-btn-main"><i class="fa fa-envelope-o"></i> ارسال</button>
                        </div>
                        </form>
                    </div>
                    <!-- /.card-footer -->
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- ckeditor js -->
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <!-- Page Script (ckeditor) -->
    <script>
            //Add text editor
            ClassicEditor
                .create(document.querySelector('#compose-textarea'))
                .then(function (editor) {
                    // The editor instance
                })
                .catch(function (error) {
                    console.error(error)
                })

    </script>
<?php
require_once '../includes/templates/admin-footer.php';
?>