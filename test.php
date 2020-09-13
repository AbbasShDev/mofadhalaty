<?php
include __DIR__.'/includes/libraries/vendor/autoload.php';

$info = Embed\Embed::create('https://www.youtube.com/watch?v=RyBC-Bu872Y&ab_channel=BasimKarbalaei%2F%D8%A8%D8%A7%D8%B3%D9%85%D8%A7%D9%84%D9%83%D8%B1%D8%A8%D9%84%D8%A7%D8%A6%D9%8A');

echo '<strong>title: </strong>'.$info->title;
echo '<br>';
echo '<strong>type: </strong>'.$info->type;
echo '<br>';
echo '<strong>code: </strong>'.$info->code;
echo '<br>';
echo '<strong>description: </strong>'.$info->description;
echo '<br>';
echo '<strong>authorName: </strong>'.$info->authorName;
echo '<br>';
echo '<strong>providerName: </strong>'.$info->providerName;
echo '<br>';
echo '<strong>image: </strong>'.$info->image;
echo '<br>';
echo '<strong>authorUrl: </strong>'.$info->authorUrl;
echo '<br>';
echo '<strong>providerIcon: </strong>'.$info->providerIcon;
echo '<br>';
echo '<strong>tags: </strong>';
print_r($info->tags) ;
echo '<br>';
echo '<strong>publishedTime: </strong>'.$info->publishedTime;
echo '<br>';
echo '<br>';