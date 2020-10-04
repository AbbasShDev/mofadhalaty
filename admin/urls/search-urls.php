<?php
ob_start();
session_start();
require_once __DIR__.'/../includes/config/database.php';

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 'admin'){
    die('غير مصرح به');
}

if (!isset($_SESSION['user_name'])){
    die('غير مصرح به');
}

if (!isset($_SESSION['admin']['name'])){
    header("location:$config[app_url]admin/login.php");
    die();
}

$output = '';

if (isset($_POST['search'])){

    $stat = $mysqli->prepare("SELECT urls.*, users.user_name FROM urls INNER JOIN users ON urls.user_id = users.user_id WHERE users.user_name LIKE CONCAT('%',?, '%') ORDER BY url_id DESC");
    $stat->bind_param('s', $search);
    $search = $_POST['search'];

}else {
    $stat = $mysqli->prepare('SELECT urls.*, users.user_name FROM urls INNER JOIN users ON urls.user_id = users.user_id ORDER BY url_id DESC');
}
$stat->execute();
$result = $stat->get_result();

if ($result->num_rows > 0){
    $urls = $result->fetch_all(MYSQLI_ASSOC);


    $output = "<tr>
                            <th style=\"text-align: center;\" >حذف</th>
                            <th>#</th>
                            <th style=\"min-width: 95px;\" >اسم المستخدم</th>
                            <th style=\"min-width: 95px;\" >العنوان</th>
                            <th >الرابط</th>
                        </tr>";

    foreach ($urls as $url):
        $output .= '<tr>';
        $output .= '
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <form style="display: inline-block" action="" method="post" class="mx-1">
                                            <input type="hidden" name="url_id" value="'. $url['url_id'].'">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'هل تريد الحذف؟\')"><i class="fas fa-backspace fa-fw"></i></button>
                                        </form>
                                    </div>
                                </td>';
        $output .= '<td>';
        $output .= $url['url_id'];
        $output .= '</td>';
        $output .= '<td><u><a class="text-info text-" href="user_urls.php?userId='.$url['user_id'].'">';
        $output .= $url['user_name'];
        $output .= '</a></u></td>';
        $output .= '<td>';
        $output .= $url['url_title'];
        $output .= '</td>';
        $output .= '<td><a style=" text-decoration: underline;color: var(--darker-main-color);" href="'.$url['url_name'].'" target="_blank">';
        $output .= $url['url_name'];
        $output .= '</a></td>';
        $output .= '</tr>';
    endforeach;

    echo $output;
}else{
    echo '<div class="error-page">
                <div class="error-content text-center m-0">
                    <h1 class="headline text-warning"><i class="fas fa-search"></i></h1>
                    <h3>لايوجد نتائج مطابقة</h3>
                </div>
            </div>';
}

ob_end_flush();