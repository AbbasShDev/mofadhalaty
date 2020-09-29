<?php
session_start();

if (!isset($_SESSION['user_name'])){
    header('location:index.php');
    die();
}

require_once 'includes/config/database.php';
require_once 'includes/config/app.php';
$userId = $_SESSION['user_id'];

include __DIR__.'/includes/libraries/vendor/autoload.php';

if (isset($_POST['url'])){

    $url =  $_POST['url'];

    try {
        $info = Embed\Embed::create($url);

        if (filter_var($url, FILTER_VALIDATE_URL)){



            if (!empty($info->image)){
                $urlImage = $info->image;
            }else{
                $urlImage = "$config[app_url]layout/images/default-url-img.png";
            }

            if (!empty($info->providerIcon)){
                $urlProviderIcon = $info->providerIcon;
            }else{
                $urlProviderIcon = "$config[app_url]layout/images/default-url-img.png";
            }

            if (filter_var($info->title, FILTER_VALIDATE_URL)){
                $urlTitle = $info->authorName;
            }else{
                $urlTitle = $info->title;
            }
            if (mb_strlen( $urlTitle) > 59){
                $urlTitle  = mb_substr( $urlTitle, 0, 59);
                $urlTitle .= '...';
            }
            if (empty($info->title)){
                $urlTitle = 'لا يوجد عنوان';
            }

            $urlDesc = $info->description;
            if (mb_strlen($info->description) > 115){
                $urlDesc  = mb_substr($info->description, 0, 115);
                $urlDesc .= '...';
            }
            if (empty($info->description)){
                $urlDesc = 'لا يوجد وصف';
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
            $dbUrlProviderIcon          = filter_var($urlProviderIcon, FILTER_SANITIZE_URL);
            $dbUrlProviderName          = filter_var($urlProviderName, FILTER_SANITIZE_STRING);
            $dbUrlProviderUrl           = filter_var($info->providerUrl, FILTER_SANITIZE_URL);

            if ($stat->execute()){

                $dbUrlId =$mysqli->insert_id;

                $output = '';
                $output .= '<div class="col-12 col-md-6 col-lg-4 mb-5 mx-auto mx-lg-0">';
                $output .= '<div class="card border-top-0 border-right-0 border-left-0 mx-auto">';
                $output .= '<a href="read.php?url_id=';
                $output .= "$dbUrlId";
                $output .= '" >';
                $output .= '<img class="card-img-top" src="';
                $output .= "$dbUrlImage";
                $output .= '" alt="url_image"></a>';
                $output .= '<div class="card-body px-0 pb-3">';
                $output .= '<a href="read.php?url_id=';
                $output .= "$dbUrlId";
                $output .= '" >';
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
                $output .= '<div class="fav-icon mr-2 float-right"></div>';
                $output .= '<div class="action-btn float-left">';
                $output .= '<div class="dropup">';
                $output .= '<div class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $output .= '<i class="fas fa-ellipsis-h fa-lg"></i>';
                $output .= '</div>';
                $output .= '<div class="dropdown-menu">';
                $output .= '<div class="dropdown-item px-0">';
                $output .= '<form action="" class="favourite" method="post" data-fav="0" data-urlid="';
                $output .= "$dbUrlId";
                $output .= '">';
                $output .= '<button>';
                $output .= '<i class="far fa-star fa-lg fa-fw mx-2"></i><span class="">إضافة الى المفضلة</span>';
                $output .= '</button></form></div>';
                $output .= '<div class="dropdown-item px-0">';
                $output .= '<form action="" class="archive" method="post" data-archive="0" data-urlid="';
                $output .= "$dbUrlId";
                $output .= '">';
                $output .= '<button><i class="fas fa-archive fa-lg fa-fw mx-2"></i><span class="">إضافة الى الإرشيف</span></button>';
                $output .= '</form></div>';
                $output .= '<div class="dropdown-item px-0">';
                $output .= '<form action="app.php" method="post">';
                $output .= '<input type="hidden" name="urlid" value="';
                $output .= "$dbUrlId";
                $output .= '">';
                $output .= '<button button type="submit" name="delete_url" onclick="return confirm(';
                $output .= "'هل تريد الحذف؟'";
                $output .= ')">';
                $output .= '<i class="fas fa-trash-alt fa-lg fa-fw mx-2"></i><span class="">حذف</span></button>';
                $output .= '</form></div>';
                $output .= '<div class="dropdown-item px-0">';
                $output .= '<div class="add-section-toggler" data-toggle="modal" data-target="#add-url-to-section" data-urlid="';
                $output .= "$dbUrlId";
                $output .= '">';
                $output .= '<i class="fas fa-th-list fa-lg fa-fw mx-2"></i><span class="">إضافة الى قائمة</span></div>';
                $output .= '</div></div></div></div></div></div></div>';

                echo $output;

            }else{
                echo '<div class="alert alert-danger alert-ajax">
                <p class="m-0">'.'حدث خطأ'.'</p>
              </div>';
            }



        }else{
            echo '<div class="alert alert-danger alert-ajax">
                <p class="m-0">'.'الرابط المدخل غير صالح'.'</p>
              </div>';
        }

    } catch (Embed\Exceptions\InvalidUrlException $exception) {
        $response = $exception->getResponse();
        $statusCode = $response->getStatusCode();

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