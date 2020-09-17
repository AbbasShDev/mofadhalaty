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
                                                AND user_id=$userId");

        if ($stat->num_rows > 0){



        $urls = $stat->fetch_all(MYSQLI_ASSOC);

        $output = '';
        foreach ($urls as $url){

        $output .= '<div class="col-12 col-md-6 col-lg-4 mt-5 mx-auto mx-lg-0">';
        $output .= '<div class="card border-top-0 border-right-0 border-left-0 mx-auto">';
        $output .= '<img class="card-img-top" src="';
        $output .= "$url[url_image]";
        $output .= '" alt="">';
        $output .= '<div class="card-body px-0 pb-3">';
        $output .= '<h5 class="card-title">';
        $output .= "$url[url_title]";
        $output .= '</h5>';
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
        }

        echo $output;

        }else{

            echo '<div class="empty-search-result mx-auto">
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