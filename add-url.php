<?php
session_start();

if (!isset($_SESSION['user_name'])){
    header('location:index.php');
    die();
}

require_once 'includes/config/database.php';
$userId = $_SESSION['user_id'];

include __DIR__.'/includes/libraries/vendor/autoload.php';

if (isset($_POST['url'])){

    $url =  $_POST['url'];

    if (filter_var($url, FILTER_VALIDATE_URL)){

        $info = Embed\Embed::create($url);

        if (!empty($info->image)){
            $urlImage = $info->image;
        }else{
            $urlImage = 'layout/images/default-url-img.png';
        }

        $urlTitle = $info->title;
        if (mb_strlen($info->title) > 59){
            $urlTitle  = mb_substr($info->title, 0, 59);
            $urlTitle .= '...';
        }
        if (empty($info->title)){
            $urlTitle = 'العنوان غير متاح';
        }

        $urlDesc = $info->description;
        if (mb_strlen($info->description) > 115){
            $urlDesc  = mb_substr($info->description, 0, 115);
            $urlDesc .= '...';
        }
        if (empty($info->description)){
            $urlDesc = 'الوصف غير متاح<i class="far fa-frown fa-fw"></i>';
        }


        $output = '';
        $output .= '<div class="col-12 col-md-6 col-lg-4 mt-5 mx-auto mx-lg-0">';
        $output .= '<div class="card border-top-0 border-right-0 border-left-0 mx-auto">';
        $output .= '<img class="card-img-top" src="';
        $output .= "$urlImage";
        $output .= '" alt="Card image cap">';
        $output .= '<div class="card-body px-0 pb-3">';
        $output .= '<h5 class="card-title">';
        $output .= "$urlTitle";
        $output .= '</h5>';
        $output .= '<p class="provider-name  mb-2">';
        $output .= '<a href="';
        $output .= "$info->providerUrl";
        $output .= '" target="_blank">';
        $output .= "$info->providerName";
        $output .= '</a>';
        $output .= '</p>';
        $output .= '<p class="card-text">';
        $output .= "$urlDesc";
        $output .= '</p>';
        $output .= '<img class="rounded-circle header-profile-img float-right"  src="';
        $output .= "$info->providerIcon";
        $output .= '" alt="Card image cap">';
        $output .= '<div class="action-btn float-left">';
        $output .= '<i class="far fa-heart">
                        <span class="badge">إضافة الى المفضلة</span>
                    </i>
                    <i class="fas fa-file-archive pl-1">
                        <span class="badge">إضافة الى الإرشيف</span>
                    </i>
                    <i class="text-danger fas fa-trash-alt pl-1">
                        <span class="badge badge-pill">حذف</span>
                    </i>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';


        $dbUrl                      = mysqli_real_escape_string($mysqli, $url);
        $dbUrlTitle                 = mysqli_real_escape_string($mysqli, $urlTitle );
        $dbUrlImage                 = mysqli_real_escape_string($mysqli, $urlImage);
        $dbUrlDesc                  = mysqli_real_escape_string($mysqli, $urlDesc);
        $dbUrlProviderIcon          = mysqli_real_escape_string($mysqli, $info->providerIcon);
        $dbUrlProviderIconName      = mysqli_real_escape_string($mysqli, $info->providerName);
        $dbUrlProviderIconNameUrl   = mysqli_real_escape_string($mysqli, $info->providerUrl);


        $query = "INSERT INTO 
                            urls
                            (
                            user_id,
                            url_name,
                            url_title,
                            url_image,
                            url_description,
                            url_providerIcon,
                            url_providerName,
                            url_providerUrl
                            )
                        VALUES 
                            (
                            '$userId',
                            '$dbUrl',
                            '$dbUrlTitle',
                            '$dbUrlImage',
                            '$dbUrlDesc',
                            '$dbUrlProviderIcon',
                            '$dbUrlProviderIconName',
                            '$dbUrlProviderIconNameUrl'
                            )";

        $mysqli->query($query);

        echo $output;

    }else{

        echo '<div class="alert alert-danger alert-ajax">
                <p class="m-0">'.'الرابط المدخل غير صالح'.'</p>
              </div>';
    }



}