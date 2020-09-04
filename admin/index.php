<?php
session_start();
$noNavbar = '';
$pageTitle = 'Login';

if (isset($_SESSION['username'])){
    header('location: dashboard.php');

}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $password = $_POST['pass'];
    $username =  $_POST['username'];

    $st = $con->prepare('SELECT Username, Password FROM users where Username=? AND GroupID=1');
    $st->execute(array($username));
    $result = $st->fetch(PDO::FETCH_ASSOC);

    if ($st->rowCount() > 0 && password_verify($password,$result['Password'])){
        $_SESSION['username'] = $username;
        header('location: dashboard.php');
        die();
    }
}

?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <h4 class="text-center">Admin Login</h4>
    <input type="text" name="username" class="form-control" autocomplete="off" placeholder="Username">
    <input type="password" name="pass" class="form-control" autocomplete="new-password" placeholder="Password">
    <input type="submit" class="btn btn-primary btn-block">

</form>

<?php include $config_dir['template'].'footer.php'?>
