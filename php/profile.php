<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Kezdőlap | iWiW</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="../css/profile.css"/>
    <link rel="stylesheet" type="text/css" href="../css/header.css"/>
    <link rel="stylesheet" type="text/css" href="../css/print/profile.css"/>
    <link rel="icon" type="image/x-icon" href="../img/iwiw-logo-16x16.png"/>
</head>
<body>
<header>
    <div class="logo">
        <a href="../pages/home.html"><img src="../img/iwiw-logo-512x512.png" alt="iwiw logó"></a>
    </div>
    <div class="search-container">
        <input type="text" name="searchbar" size="30" placeholder="Keresés az iWiW-en.."/>
        <img src="../img/icons/search-icon.png" alt="kereső ikon"/>
    </div>
    <nav class="main-menu">
        <ul>
            <li><img class="icon menu" src="../img/icons/event-icon.png" alt="események menüpont"></li>
            <li><img class="icon menu" src="../img/icons/friends-icon.png" alt="ismerősök menüpont"></li>
            <li><img class="icon menu" src="../img/icons/groups-icon.png" alt="csoportok menüpont"></li>
            <li><img class="icon menu" src="../img/icons/forum-icon.png" alt="fórum menüpont"></li>
            <li><img class="icon menu" src="../img/icons/apps-icon.png" alt="alkalmazások menüpont"></li>
            <li><img class="icon menu" src="../img/icons/market-icon.png" alt="apró menüpont"></li>
        </ul>
    </nav>
    <nav class="side-menu">
        <ul>
            <li><img class="icon profile" src="../img/icons/added-icon.png" alt="új ismerősök menüpont"></li>
            <li><img class="icon profile" src="../img/icons/message-icon.png" alt="üzenetek menüpont"></li>
            <li><img class="icon profile pic" src="../img/static/profile-pic.jpg" alt="profilkép menüpont"></li>
        </ul>
    </nav>
</header>
<main>


<?php
function get_profile_picture($user_dir) {
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    foreach ($allowed_extensions as $ext) {
        $profile_picture_path = $user_dir . '/profile.' . $ext;
        if(file_exists($profile_picture_path)) {
            return $profile_picture_path;
        }
    }
    return '../img/static/profile-pic.jpg';
}

$users_dir = '../users/';
$userid = '643a710a5a5b41.52901773';

$user_data = unserialize(file_get_contents($users_dir.$userid."/data.txt"));
?>

    <div>
        <a href="home.html"><img src="../img/iwiw-logo.png" class="iwiw-logo" alt="iwiw logó"></a>
    </div>
    <div class="profile-info">
        <img src="<?php echo get_profile_picture($users_dir.$userid);?>" class="user-img" alt="profilkép">
        <div class="profile-details">
            <div>
                <span class="user-fullname"><?php echo $user_data['username'];?></span>
                <img src="../img/iwiw-plus-logo.png" class="iwiw-plus-logo" title="iWiW+ Tagság" alt="iWiW Plus Tagság"
                     style="visibility: <?php echo $user_data['iwiwplus']==1?"visible":"hidden";?>">
                <span class="iwiw-plus-label" style="visibility: <?php echo $user_data['iwiwplus']==1?"visible":"hidden";?>">>tag</span>
            </div>
            <p class="user-introduction"><?php echo $user_data['introduction'];?></p>
            <span class="user-birthdate">Születési idő: <?php echo $user_data['year_of_birth'];?></span>
        </div>
    </div>
    <div class="profile-interactions">
        <button type="submit" class="add-button">Jelölés</button>
        <button type="submit" class="message-button">Üzenet küldése</button>
    </div>
    <hr id="profile-separator">
    <span class="other-information-label">Egyéb információ</span>
    <div class="other-information">
        <span class="user-location">Lakhely: <?php echo $user_data['residence'];?></span>
        <span class="user-workplace">Munkahely: <?php echo $user_data['workplace'];?></span>
        <span class="user-email">E-mail cím: <?php echo $user_data['email'];?></span>
        <span class="user-registered">Regisztráció ideje: <?php echo $user_data['year_of_registration'];?></span>
        <span class="user-height">Magasság: <?php echo $user_data['height']==''?"(nem adta meg)":$user_data['height'];?></span>
        <span class="user-weight">Súly: <?php echo $user_data['weight']==''?"(nem adta meg)":user_data['weight'];?></span>
        <span class="user-plus">iWiW Plus: <?php echo $user_data['iwiwplus']==1?"igen":"nem";?></span>
    </div>
    <span class="user-friends">Ismerősök (<?php echo rand(0,300) ?>)</span>
</main>
</body>
</html>