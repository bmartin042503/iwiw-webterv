<?php
require('autocookielogin.php');

session_start();

if(!isset($_SESSION['bejelentkezve']) || !$_SESSION['bejelentkezve']) {
    header('Location: ../index.php');
    exit;
}

require('getpfp.php');
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <title>Saját profil szerkesztése | iWiW</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="../css/profile.css"/>
        <link rel="stylesheet" type="text/css" href="../css/header.css"/>
        <link rel="stylesheet" type="text/css" href="../css/print/profile.css"/>
        <link rel="stylesheet" type="text/css" href="../css/print/profile-edit.css"/>
        <link rel="icon" type="image/x-icon" href="../img/iwiw-logo-16x16.png"/>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                var myFileInput = document.getElementById("myFileInput");
                var myForm = document.getElementById("myForm");

                myFileInput.addEventListener("change", function () {
                    if (myFileInput.files.length > 0) {
                        myForm.submit();
                    }
                });
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
<!--        <div>-->
<!--            <a href="home.php"><img src="../img/iwiw-logo.png" class="iwiw-logo" alt="iwiw logó"></a>-->
<!--        </div>-->
        <div class="profile-info">
            <div class="pfp-containter">
                <img src="<?php echo get_profile_picture($_SESSION['user_data']);?>" class="user-img" alt="profilkép">
                <form id="myForm" action="update-pfp.php" method="post" enctype="multipart/form-data">
                    <input type="file" id="myFileInput" name="profile-picture" style="display: none;">
                    <button id="myButton" onclick="document.getElementById('myFileInput').click(); return false;">Profilkép frissítése</button>
                    <button id="introButton" onclick="document.getElementById('introduction-form').submit(); return false;">Bemutatkozás frissítése</button>
                </form>
            </div>
            <div class="profile-details">
                <div>
                    <span class="user-fullname"><?php echo $_SESSION['user_data']['username'];?></span>
                    <img src="../img/iwiw-plus-logo.png" class="iwiw-plus-logo" title="iWiW+ Tagság" alt="iWiW Plus Tagság"
                         style="visibility: <?php echo $_SESSION['user_data']['iwiwplus']==1?"visible":"hidden";?>">
                    <span class="iwiw-plus-label" style="visibility: <?php echo $_SESSION['user_data']['iwiwplus']==1?"visible":"hidden";?>">>tag</span>
                </div>
                <div>
                    <form id="introduction-form" action="update-intro.php" method="post" enctype="multipart/form-data">
                        <label class="user-introduction" for="introduction-label">Bemutatkozás (max. 600 karakter):</label>
                        <textarea name="introduction" id="introduction-label" maxlength="600" rows="7"><?php echo $_SESSION['user_data']['introduction'];?></textarea>
                    </form>
                </div>
            </div>
        </div>
        <hr id="profile-separator">
        <span class="other-information-label">Egyéb információ</span>
        <div class="other-information">
            <span class="user-location">Lakhely: <?php echo $_SESSION['user_data']['residence'];?></span>
            <span class="user-workplace">Munkahely: <?php echo $_SESSION['user_data']['workplace'];?></span>
            <span class="user-email">E-mail cím: <?php echo $_SESSION['user_data']['email'];?></span>
            <span class="user-registered">Regisztráció ideje: <?php echo $_SESSION['user_data']['year_of_registration'];?></span>
            <span class="user-height">Magasság: <?php echo $_SESSION['user_data']['height']==''?"(nem adta meg)":$_SESSION['user_data']['height'];?></span>
            <span class="user-weight">Súly: <?php echo $_SESSION['user_data']['weight']==''?"(nem adta meg)":$_SESSION['user_data']['weight'];?></span>
            <span class="user-plus">iWiW Plus: <?php echo $_SESSION['user_data']['iwiwplus']==1?"igen":"nem";?></span>
        </div>
        <span class="user-friends">Ismerősök (<?php echo $_SESSION['user_data']['acquaintances'];?>)</span>
    </main>
    </body>
</html>