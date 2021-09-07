<?php

return [
    // 'no_img' => img(),
    'no_img' => 'https://via.placeholder.com/400x300.png/0'.rand(73944, 79999).'?text=contact',
];


function img(){
    $photos = array(
        'photo-1597586124394-fbd6ef244026',
        // 'photo-1585612935006-3868737d43e6',
        // 'photo-1524502397800-2eeaad7c3fe5',
    );
    $url = 'https://images.unsplash.com/'.$photos[array_rand($photos)].'?auto=format&fit=crop&w=400&h=300&q=70';
    return $url;
}