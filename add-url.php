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

        $urlProviderName = $info->providerName;
        if (mb_strlen($info->providerName) > 32){
            $urlProviderName  = mb_substr($info->providerName, 0, 32);
            $urlProviderName .= '...';
        }

        $stat = $mysqli->prepare("INSERT INTO
                            urls
                            ( user_id, url_name, url_title, url_image, url_description, url_type, url_providerIcon, url_providerName, url_providerUrl)
                        VALUES
                            (?,?,?,?,?,?,?,?,?)");
        $stat->bind_param('issssssss', $dbUserId, $dbUrl, $dbUrlTitle, $dbUrlImage, $dbUrlDesc, $dbUrlType, $dbUrlProviderIcon, $dbUrlProviderName, $dbUrlProviderUrl);

        $dbUserId                   = $_SESSION['user_id'];
        $dbUrl                      = $url;
        $dbUrlTitle                 = filter_var($urlTitle, FILTER_SANITIZE_STRING);
        $dbUrlImage                 = filter_var($urlImage, FILTER_SANITIZE_URL);
        $dbUrlDesc                  = filter_var($urlDesc, FILTER_SANITIZE_STRING);
        $dbUrlType                  = filter_var($info->type, FILTER_SANITIZE_STRING);
        $dbUrlProviderIcon          = filter_var($info->providerIcon, FILTER_SANITIZE_URL);
        $dbUrlProviderName          = filter_var($urlProviderName, FILTER_SANITIZE_STRING);
        $dbUrlProviderUrl           = filter_var($info->providerUrl, FILTER_SANITIZE_URL);

        $stat->execute();

        $dbUrlId =$mysqli->insert_id;

            $output = '';
            $output .= '<div class="col-12 col-md-6 col-lg-4 mt-5 mx-auto mx-lg-0">';
            $output .= '<div class="card border-top-0 border-right-0 border-left-0 mx-auto">';
            $output .= '<a href="url.php?url_id=';
            $output .= "$dbUrlId";
            $output .= '">';
            $output .= '<img class="card-img-top" src="';
            $output .= "$dbUrlImage";
            $output .= '" alt="url_image"></a>';
            $output .= '<div class="card-body px-0 pb-3">';
            $output .= '<a href="url.php?url_id=';
            $output .= "$dbUrlId";
            $output .= '">';
            $output .= '<h5 class="card-title">';
            $output .= "$dbUrlTitle";
            $output .= '</h5></a>';
            $output .= '<p class="provider-name  mb-2">';
            $output .= '<a href="';
            $output .= "$dbUrlProviderUrl";
            $output .= '" target="_blank">';
            $output .= "$dbUrlProviderName";
            $output .= '</a>';
            $output .= '</p>';
            $output .= '<p class="card-text">';
            $output .= "$dbUrlDesc";
            $output .= '</p>';
            $output .= '<img class="rounded-circle header-profile-img float-right"  src="';
            $output .= "$dbUrlProviderIcon";
            $output .= '" alt="">';
            $output .= '<div class="action-btn float-left">';
            $output .= '<form action="" class="favourite" method="post" data-fav="0" data-urlid="';
            $output .= "$dbUrlId";
            $output .= '">';
            $output .= '<button><i class="far fa-star"><span class="badge">إضافة الى المفضلة</span></i></button>';
            $output .= '</form>';
            $output .= '<form action="" class="archive" method="post" data-archive="0" data-urlid="';
            $output .= "$dbUrlId";
            $output .= '">';
            $output .= '<button><i class="fas fa-minus-circle pl-1"><span class="badge">إضافة الى الإرشيف</span></i></button>';
            $output .= '</form>';
            $output .= '<form action="app.php" class="" method="post">';
            $output .= '<input type="hidden" name="urlid" value="';
            $output .= "$dbUrlId";
            $output .= '">';
            $output .= '<button button type="submit" name="delete_url" onclick="return confirm(';
            $output .= "'هل تريد الحذف؟'";
            $output .= ')">';
            $output .= '<i class="text-danger fas fa-trash-alt pl-1"><span class="badge badge-pill">حذف</span></i></button>';
            $output .= '</form>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';

            echo $output;

    }else{
        echo '<div class="alert alert-danger alert-ajax">
                <p class="m-0">'.'الرابط المدخل غير صالح'.'</p>
              </div>';
    }


}
//
//
//The MIT License (MIT)
//
//Copyright (c) 2017 Oscar Otero Marzoa
//
//Permission is hereby granted, free of charge, to any person obtaining a copy
//of this software and associated documentation files (the "Software"), to deal
//in the Software without restriction, including without limitation the rights
//to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
//copies of the Software, and to permit persons to whom the Software is
//furnished to do so, subject to the following conditions:
//
//The above copyright notice and this permission notice shall be included in all
//copies or substantial portions of the Software.
//
//THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
//IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
//FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
//AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
//                                           LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
//OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
//SOFTWARE.