<?php
include __DIR__.'/includes/libraries/vendor/autoload.php';

$info = Embed\Embed::create('https://twitter.com/Alaa_Najmi/status/1304871255947063296');

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