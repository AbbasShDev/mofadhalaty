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

    $stat = $mysqli->prepare("SELECT sections.*, users.user_name FROM sections INNER JOIN users ON sections.user_id = users.user_id WHERE users.user_name LIKE CONCAT('%',?, '%') ORDER BY section_id DESC");
    $stat->bind_param('s', $search);
    $search = $_POST['search'];

}else {
    $stat = $mysqli->prepare('SELECT sections.*, users.user_name FROM sections INNER JOIN users ON sections.user_id = users.user_id ORDER BY section_id DESC');
}
$stat->execute();
$result = $stat->get_result();

if ($result->num_rows > 0){
    $sections = $result->fetch_all(MYSQLI_ASSOC);


    $output = '<tr>
                            <th>#</th>
                            <th>اسم المستخدم</th>
                            <th>اسم القائمة</th>
                            <th style="text-align: center;" >حذف</th>
                        </tr>';

    foreach ($sections as $section):
        $output .= '<tr>';
        $output .= '<td>';
        $output .= $section['section_id'];
        $output .= '</td>';
        $output .= ' <td><u><a class="text-info text-" href="user_sections.php?userId='.$section['user_id'].'">';
        $output .= $section['user_name'];
        $output .= '</a></u></td>';
        $output .= '<td>';
        $output .= $section['section_name'];
        $output .= '</td>';
        $output .= '<td>
                        <div class="d-flex justify-content-center">
                            <form style="display: inline-block" action="" method="post" class="mx-1">
                                <input type="hidden" name="section_id" value="'.$section['section_id'].'">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'هل تريد الحذف؟\')"><i class="fas fa-backspace fa-fw"></i></button>
                            </form>
                        </div>
                    </td>';
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