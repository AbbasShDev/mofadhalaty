<?php
session_start();

if (!isset($_SESSION['user_name'])){
    header('location:index.php');
    die();
}

require_once 'includes/config/database.php';
$userId = $_SESSION['user_id'];


if (isset($_POST['search'])){

        $searchValue = mysqli_real_escape_string($mysqli, $_POST['search']);

        $stat = $mysqli->query("SELECT * FROM 
                                                    urls 
                                                WHERE 
                                                    (
                                                    url_title LIKE '%$searchValue%' 
                                                OR  url_description LIKE '%$searchValue%'
                                                    )
                                                AND user_id=$userId 
                                                ORDER
                                                BY
                                                    url_id
                                                DESC");

        if ($stat->num_rows > 0){



        $urls = $stat->fetch_all(MYSQLI_ASSOC);

        $output = '';
        foreach ($urls as $url){

            $output .= '<div class="col-12 col-md-6 col-lg-4 mb-5 mx-auto mx-lg-0">';
            $output .= '<div class="card border-top-0 border-right-0 border-left-0 mx-auto">';
            $output .= '<a href="read.php?url_id=';
            $output .= "$url[url_id]";
            $output .= '" >';
            $output .= '<img class="card-img-top" src="';
            $output .= "$url[url_image]";
            $output .= '" alt="url_image"></a>';
            $output .= '<div class="card-body px-0 pb-3">';
            $output .= '<a href="read.php?url_id=';
            $output .= "$url[url_id]";
            $output .= '" >';
            $output .= '<h5 class="card-title">';
            $output .= "$url[url_title]";
            $output .= '</h5></a>';
            $output .= '<p class="provider-name  mb-2">';
            $output .= '<a href="';
            $output .= "$url[url_providerUrl]";
            $output .= '" target="_blank">';
            $output .= "$url[url_providerName]";
            $output .= '</a>';
            $output .= '</p>';
            $output .= '<p class="card-text">';
            $output .= "$url[url_description]";
            $output .= '</p>';
            $output .= '<img class="rounded-circle header-profile-img float-right"  src="';
            $output .= "$url[url_providerIcon]";
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
            $output .= "$url[url_id]";
            $output .= '">';
            $output .= '<button>';
            $output .= '<i class="far fa-star fa-lg fa-fw mx-2"></i><span class="">إضافة الى المفضلة</span>';
            $output .= '</button></form></div>';
            $output .= '<div class="dropdown-item px-0">';
            $output .= '<form action="" class="archive" method="post" data-archive="0" data-urlid="';
            $output .= "$url[url_id]";
            $output .= '">';
            $output .= '<button><i class="fas fa-archive fa-lg fa-fw mx-2"></i><span class="">إضافة الى الإرشيف</span></button>';
            $output .= '</form></div>';
            $output .= '<div class="dropdown-item px-0">';
            $output .= '<form action="app.php" method="post">';
            $output .= '<input type="hidden" name="urlid" value="';
            $output .= "$url[url_id]";
            $output .= '">';
            $output .= '<button button type="submit" name="delete_url" onclick="return confirm(';
            $output .= "'هل تريد الحذف؟'";
            $output .= ')">';
            $output .= '<i class="fas fa-trash-alt fa-lg fa-fw mx-2"></i><span class="">حذف</span></button>';
            $output .= '</form></div>';
            $output .= '<div class="dropdown-item px-0">';
            $output .= '<div class="add-section-toggler" data-toggle="modal" data-target="#add-url-to-section" data-urlid="';
            $output .= "$url[url_id]";
            $output .= '">';
            $output .= '<i class="fas fa-th-list fa-lg fa-fw mx-2"></i><span class="">إضافة الى قائمة</span></div>';
            $output .= '</div></div></div></div></div></div></div>';
        }

        echo $output;

        }else{

            echo '<div class="empty-result mx-auto">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg"  width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#3f64b5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z"/>
                            <circle cx="10" cy="10" r="7" />
                            <line x1="21" y1="21" x2="15" y2="15" />
                            </svg>
                            <p>لاتوجد نتائج مطابقة</p>
                        </div>
                  </di>';
        }

}