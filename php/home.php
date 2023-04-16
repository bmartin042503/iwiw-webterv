<?php
require('autocookielogin.php');

session_start();

if(!isset($_SESSION['bejelentkezve']) || !$_SESSION['bejelentkezve']) {
    header('Location: ../index.php');
    exit;
}
require('getpfp.php');
require('find_user_by_id.php');

function display_posts() {
    $post_directories = glob('../db/posts/*', GLOB_ONLYDIR);

    foreach($post_directories as $post_directory) {
        $data_file = $post_directory . '/data.txt';
        $comments_file = $post_directory . '/comments.txt';
        $post_data = null;
        $post_image = null;

        if(file_exists($data_file)) {
            $post_data = unserialize(file_get_contents($data_file));
            $image_extensions = ['png', 'jpg', 'jpeg', 'gif'];

            foreach($image_extensions as $ext) {
                if(file_exists($post_directory . '/post-img.' . $ext)) {
                    $post_image = $post_directory . '/post-img.' . $ext;
                    break;
                }
            }
        }

        $post_user_data = find_user_by_id($post_data['user_id']);
        $profile_picture = get_profile_picture($post_user_data);

        echo '<div class="post">';
        echo '<div class="post-details">';
        echo '<img class="post-user-img" src="' . $profile_picture . '" alt="profilkép" title="' . $post_user_data['username'] . '">';
        echo '<div class="post-details-info">';
        echo '<span class="post-user-name" title="' . $post_user_data['username'] . '">' . $post_user_data['username'] . '</span>';
        echo '<span class="post-date">' . $post_data['date'] . '</span>';
        echo '</div>';
        echo '</div>';
        echo '<p class="post-description">' . nl2br($post_data['description']) . '</p>';
    
        if($post_image) {
            echo '<img class="post-img" src="' . $post_image . '" alt="bejegyzés képe">';
        }

        echo '<hr class="post-top-separator">';
        echo '<div class="post-interactions">';
        echo '<div class="interaction">';
        echo '<img class="like-button" src="../img/icons/like-icon.png" alt="like">';
        echo '<span class="like-count i-label">' . $post_data['likes'] . ' ember kedveli</span>';
        echo '</div>';

        $comments = null;
        $comment_count = 0;
        if(file_exists($comments_file)) {
            $comments = unserialize(file_get_contents($comments_file));
            $comment_count = count($comments);
        }

        echo '<div class="interaction">';
        echo '<img class="comment-button" src="../img/icons/comment-icon.png" alt="komment">';
        echo '<span class="comment-count i-label">' . $comment_count . ' hozzászólás</span>';
        echo '</div>';
        echo '<div class="interaction">';
        echo '<img class="share-button" src="../img/icons/share-icon.png" alt="megosztás">';
        echo '<span class="share-count i-label">' . $post_data['shares'] . ' megosztás</span>';
        echo '</div>';
        echo '</div>';
        echo '<hr class="post-bottom-separator">';

        if($comment_count > 0) {
            echo '<div class="post-comments">';

            $visible_comments = 0;
            foreach($comments as $comment) {
                if($visible_comments >= 2) {
                    echo '<div class="comment comment-hidden">';
                } else {
                    echo '<div class="comment">';
                }
                $comment_user_data = find_user_by_id($comment['user_id']);
                $profile_picture = get_profile_picture($comment_user_data);

                //  echo '<div class="comment">';
                echo '<div class="comment-details">';
                echo '<img class="comment-user-img" src="' . $profile_picture . '" alt="profilkép" title="' . $comment_user_data['username'] . '">';
                echo '<div class="comment-details-info">';
                echo '<span class="comment-user-name" title="' . $comment_user_data['username'] . '">' . $comment_user_data['username'] . '</span>';
                echo '<span class="comment-date">' . $comment['date'] . '</span>';
                echo '</div>';
                echo '</div>';
                echo '<p class="comment-description">' . nl2br($comment['description']) . '</p>';
                echo '</div>';
                $visible_comments++;
            }

            if($comment_count > 2) {
                echo '<span class="post-comments-expand" onclick="toggleComments(this)">További hozzászólások megtekintése..</span>';
            }
            echo '</div>';
        }
        echo '<form method="post" action="add_comment.php"">';
        echo '<input type="hidden" name="post_id" value="' . $post_data['id'] . '">';
        echo '<div class="comment-create">';
        echo '<img class="comment-create-user-profile" src="' . get_profile_picture($_SESSION['user_data']) . '" alt="profilkép" title="' . $_SESSION['user_data']['username'] . '">';
        echo '<textarea name="comment-create-description" id="comment-create-input" placeholder="Szólj hozzá.." maxlength="600" rows="1"></textarea>';
        echo '<button class="send-message-button" type="submit" name="submit-comment">';
        echo '<img class="comment-send-img" src="../img/icons/comment-send.png" alt="Komment elküldése">';
        echo '</button>';
        echo '</div>';
        echo '</form>';
        echo '</div>';
    }
}

?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <title>Kezdőlap | iWiW</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="../css/home.css"/>
        <link rel="stylesheet" type="text/css" href="../css/header.css"/>
        <link rel="stylesheet" type="text/css" href="../css/scrollbar.css"/>
        <link rel="stylesheet" type="text/css" href="../css/print/home.css"/>
        <link rel="icon" type="image/x-icon" href="../img/iwiw-logo-16x16.png"/>
        <script src="../js/user.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                //var profileLink = document.getElementById('ddm-profile');
                //profileLink.innerHTML = '<a href="profile.php">Profilom' + ' ' + "(" + "<?php echo $_SESSION['user_data']['username']; ?>" + ")" + '</a>';
                document.getElementById('profilkep').addEventListener('click', function() {
                    var dropdownMenu = document.getElementById('legordulomenu');
                    if (getComputedStyle(dropdownMenu).display === 'none') {
                        dropdownMenu.style.display = 'block';
                    } else {
                        dropdownMenu.style.display = 'none';
                    }
                });

                document.addEventListener('click', function(event) {
                    var dropdownMenu = document.getElementById('legordulomenu');
                    var profilKep = document.getElementById('profilkep');
                    if(!profilKep.contains(event.target)) {
                        dropdownMenu.style.display = 'none';
                    }
                });

                const brdayItems = document.querySelectorAll(".brday-item");

                for(let i = 0; i < brdayItems.length; i++) {
                    const img = brdayItems[i].querySelector(".brday-profile");
                    img.setAttribute("src", users[i].profilkepUrl);

                    const name = brdayItems[i].querySelector(".brday-name");
                    name.textContent = users[i].nev;

                    /*const date = brdayItems[i].querySelector(".brday-date");
                    date.textContent = users[i].szulDatum;*/

                    const age = brdayItems[i].querySelector(".brday-age");
                    const currentYear = new Date().getFullYear();
                    let ageCalc = currentYear - parseInt(users[i].szulDatum.split('/')[0]);
                    age.textContent = ageCalc + " éves";
                }
                handleInteractionLabel();
            });

            function toggleComments(element) {
                const comments = element.parentNode.querySelectorAll('.comment-hidden');
                const expandText = 'További hozzászólások megtekintése..';
                const collapseText = 'Hozzászólások elrejtése';

                for (let i = 0; i < comments.length; i++) {
                    const comment = comments[i];

                    if (comment.style.display === 'none' || !comment.style.display) {
                        comment.style.display = 'block';
                        element.textContent = collapseText;
                    } else {
                        comment.style.display = 'none';
                        element.textContent = expandText;
                    }
                }
            }

            function redirect(obj) {
                var title = obj.title;
                if(obj.title == "") {
                    title = obj.textContent;
                }
                window.location.href = "profile.php?user=" + encodeURIComponent(title);
            }

            let modified = false;

            function handleInteractionLabel() {
                const screenWidth = window.innerWidth; 

                if(screenWidth < 800 && modified == false) {
                    const spanElements = document.querySelectorAll('.i-label');
                    spanElements.forEach(spanElement => {
                        let spanContent = spanElement.textContent;
                        
                        if(spanContent.includes('ember kedveli')) {
                            spanContent = spanContent.replace('ember kedveli', '');
                        } else if(spanContent.includes('hozzászólás')) {
                            spanContent = spanContent.replace('hozzászólás','');
                        } else if(spanContent.includes('megosztás')) {
                            spanContent = spanContent.replace('megosztás', '');
                        }
                        spanElement.textContent = spanContent;
                        modified = true;
                    });
                } else if(screenWidth > 800 && modified == true) {
                    const likeSpanElements = document.querySelectorAll('.like-count.i-label');
                    likeSpanElements.forEach(likeSpan => {
                        let spanContent = likeSpan.textContent;
                        likeSpan.textContent = spanContent + ' ember kedveli';
                    });

                    const commentSpanElements = document.querySelectorAll('.comment-count.i-label');
                    commentSpanElements.forEach(commentSpan => {
                        let spanContent = commentSpan.textContent;
                        commentSpan.textContent = spanContent + ' hozzászólás';
                    });

                    const shareSpanElements = document.querySelectorAll('.share-count.i-label');
                    shareSpanElements.forEach(shareSpan => {
                        let spanContent = shareSpan.textContent;
                        shareSpan.textContent = spanContent + ' megosztás';
                    });
                    modified = false;
                }
            }

            window.addEventListener('resize', () => {
                handleInteractionLabel();
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
            <div class="side-notifications">
                <div class="reminders-container">
                    <span class="label-container">Friss hírek</span>
                    <div class="news-container">
                        <div class="news-item">
                            <img src="../img/static/news/news-img-1.png" class="news-img" alt="hír kép">
                            <div>
                                <a href="https://444.hu/2023/03/18/hogyan-lehet-egy-videojatekbol-ennyire-jo-sorozatot-kesziteni" target="_blank" class="news-title">Hogy lehet egy videójátékból ennyire jó sorozatot készíteni?</a>
                                <p class="news-description">Véget ért a Last of Us első évada. Ez lett a valaha készült egyik legjobb videójáték-adaptáció, amit epizódról epizódra egyre többen néztek...</p>
                            </div>
                        </div>
                        <div class="news-item">
                            <img src="../img/static/news/news-img-2.png" class="news-img" alt="hír kép">
                            <div>
                                <a href="https://444.hu/2023/03/18/joe-biden-szerint-megalapozott-a-putyin-elleni-elfogatoparancs" target="_blank" class="news-title">Joe Biden szerint megalapozott a Putyin elleni elfogatóparancs</a>
                                <p class="news-description">Ugyan az Egyesült Államok nem ismeri el a hágai Nemzetközi Büntetőbíróságot...</p>
                            </div>
                        </div>
                        <div class="news-item">
                            <img src="../img/static/news/news-img-3.png" class="news-img" alt="hír kép">
                            <div>
                                <a href="https://24.hu/belfold/2023/03/19/idojaras-jovo-het-8/" target="_blank" class="news-title">22 fok is lehet a jövő héten</a>
                                <p class="news-description">Napos, tavaszias idő várható a jövő héten: folytatódik a felmelegedés, megszűnnek a hajnali fagyok és pénteken akár 22 Celsius-fok is lehet a legmelegebb órákban...</p>
                            </div>
                        </div>
                    </div>
                    <span class="label-container">Emlékeztetők</span>
                    <span class="brday-label">Születésnapok</span>
                    <div class="birthday-container">
                        <div class="brday-item">
                            <img src="../img/static/default-profile.png" class="brday-profile" alt="profilkép">
                            <div>
                                <span class="brday-name" onclick="redirect(this)"></span>
                                <span class="brday-date">ma</span>
                                <span class="brday-age"></span>
                            </div>
                        </div>
                        <div class="brday-item">
                            <img src="../img/static/default-profile.png" class="brday-profile" alt="profilkép">
                            <div>
                                <span class="brday-name" onclick="redirect(this)"></span>
                                <span class="brday-date">ma</span>
                                <span class="brday-age"></span>
                            </div>
                        </div>
                        <div class="brday-item">
                            <img src="../img/static/default-profile.png" class="brday-profile" alt="profilkép">
                            <div>
                                <span class="brday-name" onclick="redirect(this)"></span>
                                <span class="brday-date">holnap</span>
                                <span class="brday-age"></span>
                            </div>
                        </div>
                        <div class="brday-item">
                            <img src="../img/static/default-profile.png" class="brday-profile" alt="profilkép">
                            <div>
                                <span class="brday-name" onclick="redirect(this)"></span>
                                <span class="brday-date">holnap után</span>
                                <span class="brday-age"></span>
                            </div>
                        </div>
                    </div>
                    <span class="label-container">Online ismerősök (10)</span>
                    <div class="friends-container">
                        <table class="friends-table">
                            <tr>
                                <td><img src="../img/static/users/user-1.png" alt="profilkép" title="Nagy Béla" onclick="redirect(this)"></td>
                                <td><img src="../img/static/users/user-2.png" alt="profilkép" title="Szabó Peti" onclick="redirect(this)"></td>
                                <td><img src="../img/static/default-profile.png" alt="profilkép" title="Balázs Judit" onclick="redirect(this)"></td>
                                <td><img src="../img/static/users/user-4.png" alt="profilkép" title="Arató András" onclick="redirect(this)"></td>
                                <td><img src="../img/static/users/user-9.png" alt="profilkép" title="Kovács József" onclick="redirect(this)"></td>
                            </tr>
                            <tr>
                                <td><img src="../img/static/users/user-5.png" alt="profilkép" title="Kovács Gábor" onclick="redirect(this)"></td>
                                <td><img src="../img/static/users/user-6.png" alt="profilkép" title="Kertész Kolompár" onclick="redirect(this)"></td>
                                <td><img src="../img/static/default-profile.png" alt="profilkép" title="Kovács Anna" onclick="redirect(this)"></td>
                                <td><img src="../img/static/default-profile.png" alt="profilkép" title="Varga Boglárka" onclick="redirect(this)"></td>
                                <td><img src="../img/static/users/user-10.png" alt="profilkép" title="Juhász Erzsébet" onclick="redirect(this)"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="posts">
                <div class="post-create">
                    <form action="post-add.php" method="POST" enctype="multipart/form-data">
                        <div class="post-details">
                            <img class="post-user-img" alt="profilkép" src="<?php echo get_profile_picture($_SESSION['user_data']); ?>" onclick="redirect(this)">
                            <textarea name="post-create-description" id="post-create-input" placeholder="Mi jár a fejedben?" maxlength="600" rows="2"></textarea>
                        </div>
                        <div class="post-create-buttons">
                            <label for="photo-add-post" id="photo-add-label">Fénykép hozzáadása</label>
                            <input type="file" name="photoadd" accept=".png, .jpg, .jpeg, .gif" id="photo-add-post">
                            <input type="submit" name="submitpost"  id="submit-post" value="Bejegyzés létrehozása">
                        </div>
                    </form>
                    <?php if(isset($_SESSION['post-error'])): ?>
                        <div class="post-error-msg">
                            <?php echo $_SESSION['post-error']; unset($_SESSION['post-error']); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php display_posts(); ?>
            </div>
            <div class="ad-container">
                <h1>Hirdetés</h1>
                <img class="ad-img" src="../img/static/ads/ad-1.png" alt="hirdetés"/>
            </div>  
        </main>
    </body>
</html>