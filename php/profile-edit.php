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
            function redirect(obj) {
                var title = obj.title;
                if(obj.title == "") {
                    title = obj.textContent;
                }
                window.location.href = "profile.php?user=" + encodeURIComponent(title);
            }
            document.addEventListener('DOMContentLoaded', () => {
                var myFileInput = document.getElementById("myFileInput");
                var myForm = document.getElementById("myForm");

                myFileInput.addEventListener("change", function () {
                    if (myFileInput.files.length > 0) {
                        myForm.submit();
                    }
                });
            });

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
            });

            function validateAndSubmit() {
                document.getElementById('otherform').submit();
            }

            function passcheckAndSubmit(){
                const pass1 = document.getElementById("newpswd");
                const pass2 = document.getElementById("newpswdre");

                if(pass1.value==pass2.value){
                    document.getElementById("passform").submit();
                }
                else{
                    alert("Nem egyezik meg a két új jelszó!")
                }
            }

            function confirmdel(){
                if (confirm("Biztosan törölni szeretnéd a fiokodat?")) {
                    document.getElementById("delete").submit();
                }
            }
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
                         style="visibility: <?php echo $_SESSION['user_data']['iwiwplus']=="true"?"visible":"hidden";?>">
                    <span class="iwiw-plus-label" style="visibility: <?php echo $_SESSION['user_data']['iwiwplus']=="true"?"visible":"hidden";?>">>tag</span>
                </div>
                <div>
                    <form id="introduction-form" action="update-intro.php" method="post" enctype="multipart/form-data">
                        <label class="user-introduction" for="introduction-label">Bemutatkozás (max. 600 karakter):</label>
                        <textarea name="introduction" id="introduction-label" maxlength="600" rows="7"><?php echo $_SESSION['user_data']['introduction'];?></textarea>
                    </form>
                </div>
            </div>
        </div>
        <hr class="profile-separator">
        <span class="other-information-label">Egyéb információ</span>
        <div class="other-information">
            <form id="otherform" action="update-otherinfo.php" method="post" enctype="multipart/form-data">
                <table>
                    <tr><td>Lakhely:</td><td><input type="text" name="residence"  value="<?php echo $_SESSION['user_data']['residence'];?>"></td></tr>
                    <tr><td>Munkahely:</td><td><input type="text" name="workplace" value="<?php echo $_SESSION['user_data']['workplace'];?>"></td></tr>
                    <tr><td>E-mail cím:</td><td><input type="email" name="email" value="<?php echo $_SESSION['user_data']['email'];?>"></td></tr>
                    <tr><td>Magasság:</td><td><input type="number" name="height" id="height" min="1" max="300" value="<?php echo $_SESSION['user_data']['height'];?>"></td></tr>
                    <tr><td>Súly:</td><td><input type="number" name="weight" id="weight" min="1" max="300" value="<?php echo $_SESSION['user_data']['weight'];?>"></td></tr>
                    <tr><td>iWiW Plus: </td><td>
                            <input type="radio" <?php echo $_SESSION['user_data']['iwiwplus']=="true"?"checked":"";?> name="iwiwplus" value="igen">igen</input>
                            <input type="radio" <?php echo $_SESSION['user_data']['iwiwplus']=="true"?"":"checked";?> name="iwiwplus" value="nem">nem</input>
                    </td></tr>
                    <tr><td>Ismerősök:</td><td><input type="number" name="acquaintances" id="acquaintances" min="0" max="10000" value="<?php echo $_SESSION['user_data']['acquaintances'];?>" /></td></tr>
                    <tr><td>Admin:</td><td>
                            <input type="radio" <?php echo $_SESSION['user_data']['admin']=="true"?"checked":"";?> name="admin" value="igen">igen
                            <input type="radio" <?php echo $_SESSION['user_data']['admin']=="true"?"":"checked";?> name="admin" value="nem">nem
                     </td></tr>
                </table>
                <button id="otherBtn" onclick="validateAndSubmit();">Egyéb információk frissítése</button>
            </form>
        </div>
        <hr class="profile-separator">
        <span class="other-information-label">Jelszó módosítás</span>
        <p id="pass-info">A jelszónak legalább 8 karakter hosszúnak kell lennie, tartalmaznia kell legalább egy nagybetűt és egy számot.</p>
        <table>
            <form id="passform" action="update-password.php" method="post" enctype="multipart/form-data">
                <tr><td>régi jelszó:</td><td><input typea="password" name="oldpswd" id="oldpswd" required pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[a-z]).{8,}$"></td></tr>
                <tr><td>új jelszó:</td><td><input typea="password" name="newpswd" id="newpswd" required pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[a-z]).{8,}$"></td></tr>
                <tr><td>új jelszó ismét:</td><td><input typea="password" name="newpswdre" id="newpswdre" required pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[a-z]).{8,}$"></td></tr>
            </form>
            <tr><td colspan="2"><button id="up-pass-btn" onclick="passcheckAndSubmit()">Jelszó frissítése</button></td> </tr>
        </table>

        <hr class="profile-separator">
        <button id="deluser" onclick="confirmdel()">Felhasználói fiok törlése</button>
        <form id="delete" action="delete-account.php" method="post" enctype="multipart/form-data" style="display: none">
            <input type="text" name="uid" value="<?php echo $_SESSION['user_data']['id'];?>">
        </form>

    </main>
    </body>
</html>