<?php
require('autocookielogin.php');

session_start();

if(!isset($_SESSION['bejelentkezve']) || !$_SESSION['bejelentkezve']) {
    header('Location: ../index.php');
    exit;
}

require('getpfp.php');

function get_uid($username)
{
    $users_dir = '../db/users/';
    if (!file_exists($users_dir)) {
        mkdir($users_dir, 0777, true);
    }

    $users_directory = new DirectoryIterator($users_dir);
    foreach($users_directory as $user_directory) {
        if($user_directory->isDir()) {
            $data_file = $user_directory->getPathname() . '/data.txt';
            if(file_exists($data_file)) {
                $user_data = unserialize(file_get_contents($data_file));
                if($user_data['username'] == $username) {
                    return $user_data['id'];
                }
            }
        }
    }
    return "";
}

$users_dir = '../db/users/';
$userid = "";
$notfound = false;

if(isset($_GET['user'])) {
    $userid = get_uid($_GET['user']);
}
else{
    $notfound = true; //user not found
}
if($userid==''){
    $notfound = true;//user not found
}

$user_data = unserialize(file_get_contents($users_dir.$userid."/data.txt"));
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <title><?php echo $user_data['username']; ?> | iWiW</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="../css/profile.css"/>
        <link rel="stylesheet" type="text/css" href="../css/header.css"/>
        <link rel="stylesheet" type="text/css" href="../css/print/profile.css"/>
        <link rel="icon" type="image/x-icon" href="../img/iwiw-logo-16x16.png"/>
        <script>
            function redirect(obj) {
                var title = obj.title;
                if(obj.title == "") {
                    title = obj.textContent;
                }
                window.location.href = "profile.php?user=" + encodeURIComponent(title);
            }

            document.addEventListener('DOMContentLoaded', () => {
                document.getElementById('profilkep').addEventListener('click', function () {
                    var dropdownMenu = document.getElementById('legordulomenu');
                    if (getComputedStyle(dropdownMenu).display === 'none') {
                        dropdownMenu.style.display = 'block';
                    } else {
                        dropdownMenu.style.display = 'none';
                    }
                });

                document.addEventListener('click', function (event) {
                    var dropdownMenu = document.getElementById('legordulomenu');
                    var profilKep = document.getElementById('profilkep');
                    if (!profilKep.contains(event.target)) {
                        dropdownMenu.style.display = 'none';
                    }
                });

                if(<?php echo (bool)$notfound==0?"false":(bool)$notfound; ?>)
                {
                    let profileInfo = document.getElementsByClassName('profile-info');
                    for (let i = 0; i < profileInfo.length; i++) profileInfo[i].innerHTML='<span id=missing-user>Nem létező vagy törölt felhasználó</span>';

                    profileInfo = document.getElementsByClassName('profile-interactions');
                    for (let i = 0; i < profileInfo.length; i++) profileInfo[i].innerHTML='';

                    profileInfo = document.getElementById('profile-separator');
                    profileInfo.style="visibility: hidden;"

                    profileInfo = document.getElementsByClassName('other-information-label');
                    for (let i = 0; i < profileInfo.length; i++) profileInfo[i].innerHTML='';

                    profileInfo = document.getElementsByClassName('other-information');
                    for (let i = 0; i < profileInfo.length; i++) profileInfo[i].innerHTML='';

                    profileInfo = document.getElementsByClassName('user-friends');
                    for (let i = 0; i < profileInfo.length; i++) profileInfo[i].innerHTML='';

                }

                if(<?php echo ($user_data['username']==$_SESSION['user_data']['username'])?"true":"false"; ?>){
                    let btn = document.getElementById("add-button");
                    btn.textContent="Profil szerkesztése";
                    btn.onclick = function() {
                        window.location.href = "profile-edit.php";
                    }

                    btn=document.getElementById("message-button");
                    btn.style="visibility:hidden;";
                }
            });
        </script>
    </head>
    <body>
        <header>
            <div class="logo">
                <a href="home.php"><img src="../img/iwiw-logo-512x512.png" alt="iwiw logó"></a>
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
                    <li><img class="icon profile pic" id="profilkep" src="<?php echo get_profile_picture($_SESSION['user_data']); ?>" alt="profilkép menüpont"></li>
                </ul>
            </nav>
        </header>
        <nav class="dropdown-menu" id="legordulomenu">
            <ul>
                <li><span onclick="redirect(this)" title="<?php echo $_SESSION['user_data']['username'] ?>" id="ddm-profile">Profilom (<?php echo $_SESSION['user_data']['username']; ?>)</span></li>
                <li><a href="#">Beállítások és adatvédelem</a></li>
                <li><a href="../pages/footer/contact.html">Kapcsolatfelvétel</a></li>
                <li><a href="logout.php" id="logout-text">Kijelentkezés</a></li>
            </ul>
        </nav>
        <main>
            <div>
                <a href="home.php"><img src="../img/iwiw-logo.png" class="iwiw-logo" alt="iwiw logó"></a>
            </div>
            <div class="profile-info">
                <img src="<?php echo get_profile_picture_userdir($users_dir.$userid);?>" class="user-img" alt="profilkép">
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
                <button type="submit" id="add-button" onclick="">Jelölés</button>
                <button type="submit" id="message-button">Üzenet küldése</button>
            </div>
            <hr id="profile-separator">
            <span class="other-information-label">Egyéb információ</span>
            <div class="other-information">
                <span class="user-location">Lakhely: <?php echo $user_data['residence'];?></span>
                <span class="user-workplace">Munkahely: <?php echo $user_data['workplace'];?></span>
                <span class="user-email">E-mail cím: <?php echo $user_data['email'];?></span>
                <span class="user-registered">Regisztráció ideje: <?php echo $user_data['year_of_registration'];?></span>
                <span class="user-height">Magasság: <?php echo $user_data['height']==''?"(nem adta meg)":$user_data['height'];?></span>
                <span class="user-weight">Súly: <?php echo $user_data['weight']==''?"(nem adta meg)":$user_data['weight'];?></span>
                <span class="user-plus">iWiW Plus: <?php echo $user_data['iwiwplus']==1?"igen":"nem";?></span>
            </div>
            <span class="user-friends">Ismerősök (<?php echo $user_data['acquaintances'];?>)</span>
        </main>
    </body>
</html>