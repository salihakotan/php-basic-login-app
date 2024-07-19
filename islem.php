<?php

include 'fonksiyon/helper.php';
session_start();

$user = [
    'sahinersever'=> [
        'password' =>'123456',
        'eposta' =>'sahinersever@gmail.com',
    ],
    'fatmaersever' => [
        'password' =>'654321',
        'eposta' =>'farmaersever@gmail.com',
    ],
    'salihakotan' => [
        'password' =>'123',
        'eposta' =>'salihakotan77@gmail.com',
    ]
];

if (get('islem') == 'giris'){

    $_SESSION['username']= post('username');
    $_SESSION['password']= post('password');

    if (!post('username')){
        $_SESSION['error'] = 'Lütfen kullanıcı adınızı giriniz!';
        header('location: login.php');
        exit();
    }else if (!post('password')){
        $_SESSION['error'] = 'Lütfen kullanıcı şifrenizi giriniz!';
        header('location: login.php');
        exit();
    }else {
        if (array_key_exists(post('username'), $user)){

            if ($user[post('username')]['password'] == post('password')){

                $_SESSION['login'] = true;
                $_SESSION['kullanici_adi'] = post('username');
                $_SESSION['eposta'] = $user[post('username')]['eposta'];

                header('location: index.php');
                exit();

            }else {
                $_SESSION['error'] = 'Kayıtlı kullanıcı bulunamadı!';
                header('location: login.php');
                exit();
            }

        }else {
            $_SESSION['error'] = 'Kayıtlı kullanıcı bulunamadı!';
            header('location: login.php');
            exit();
        }
    }
}

if (get('islem') == 'hakkimda'){

    $hakkimda = post('hakkimda');

    $islem = file_put_contents('db/'.session('kullanici_adi').'.txt', htmlspecialchars($hakkimda));

    if ($islem){
        header('location: index.php?islem=true');
    }else{
        header('location: index.php?islem=false');
    }



}

if (get('islem') == 'cikis'){
    session_destroy();
    session_start();
    $_SESSION['error'] = 'Oturum sonlandırıldı';
    header('Location: login.php');
}

if (get('islem') == 'renk'){
    setcookie('color',get('color'),time() + (86400 * 365));
    header('Location:'.$_SERVER['HTTP_REFERER'] ? 'Location:'.$_SERVER['HTTP_REFERER']: 'index.php');
}


?>