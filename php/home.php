<?php
session_start();

function get_profile_picture($user_data) {
    $user_dir = '../users/' . $user_data['id'];
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    foreach ($allowed_extensions as $ext) {
        $profile_picture_path = $user_dir . '/profile.' . $ext;
        if(file_exists($profile_picture_path)) {
            return $profile_picture_path;
        }
    }
    return '../img/static/profile-pic.jpg';
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
                    <li><img class="icon profile pic" src="<?php echo get_profile_picture($_SESSION['user_data']); ?>" alt="profilkép menüpont"></li>
                </ul>
            </nav>
        </header>
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
                <div class="post">
                    <div class="post-details">
                        <img class="post-user-img" src="../img/static/users/user-10.png" alt="profilkép" title="Juhász Erzsébet" onclick="redirect(this)">
                        <div class="post-details-info">
                            <span class="post-user-name" title="Juhász Erzsébet" onclick="redirect(this)">Juhász Erzsébet</span>
                            <span class="post-date">8 perce</span>
                        </div>
                    </div>
                    <p class="post-description">SZÉP JÓ REGGELT !</p>
                    <img class="post-img" src="../img/static/posts/post-4.jpg" alt="bejegyzés képe">
                    <hr class="post-top-separator">
                    <div class="post-interactions">
                        <div class="interaction">
                            <img class="like-button" src="../img/icons/like-icon.png" alt="like">
                            <span class="like-count i-label">26 ember kedveli</span>
                        </div>
                        <div class="interaction">
                            <img class="comment-button" src="../img/icons/comment-icon.png" alt="komment">
                            <span class="comment-count i-label">14 hozzászólás</span>
                        </div>
                        <div class="interaction">
                            <img class="share-button" src="../img/icons/share-icon.png" alt="megosztás">
                            <span class="share-count i-label">2 megosztás</span>
                        </div>
                    </div>
                    <hr class="post-bottom-separator">
                    <div class="post-comments">
                        <div class="comment">
                            <div class="comment-details">
                                <img class="comment-user-img" src="../img/static/users/user-9.png" alt="profilkép" title="Kovács József" onclick="redirect(this)">
                                <div class="comment-details-info">
                                    <span class="comment-user-name" title="Kovács József" onclick="redirect(this)">Kovács József</span>
                                    <span class="comment-date">5 perce</span>
                                </div>
                            </div>
                            <p class="comment-description">Viszont kívánom!</p>
                        </div>
                    </div>
                    <span class="post-comments-expand">További hozzászólások megtekintése..</span>
                </div>

                <div class="post">
                    <div class="post-details">
                        <img class="post-user-img" src="../img/static/users/user-6.png" alt="profilkép" title="Kertész Kolompár" onclick="redirect(this)">
                        <div class="post-details-info">
                            <span class="post-user-name" title="Kertész Kolompár" onclick="redirect(this)">Kertész Kolompár</span>
                            <span class="post-date">tegnap</span>
                        </div>
                    </div>
                    <p class="post-description">kedvenc zeném</p>
                    <audio class="post-sound" controls>
                        <source src="../media/rick-roll-music.mp3" type="audio/mpeg">
                        A böngésződ nem támogatja az audio lejátszást.
                    </audio>
                    <hr class="post-top-separator">
                    <div class="post-interactions">
                        <div class="interaction">
                            <img class="like-button" src="../img/icons/like-icon.png" alt="like">
                            <span class="like-count i-label">4 ember kedveli</span>
                        </div>
                        <div class="interaction">
                            <img class="comment-button" src="../img/icons/comment-icon.png" alt="komment">
                            <span class="comment-count i-label">0 hozzászólás</span>
                        </div>
                        <div class="interaction">
                            <img class="share-button" src="../img/icons/share-icon.png" alt="megosztás">
                            <span class="share-count i-label">1 megosztás</span>
                        </div>
                    </div>
                </div>

                <div class="post">
                    <div class="post-details">
                        <img class="post-user-img" src="../img/static/default-profile.png" alt="profilkép" title="Balázs Judit" onclick="redirect(this)">
                        <div class="post-details-info">
                            <span class="post-user-name" title="Balázs Judit" onclick="redirect(this)">Balázs Judit</span>
                            <span class="post-date">2 órája</span>
                        </div>
                    </div>
                    <p class="post-description">Kedvenc emlékem az elmúlt nyárból, amikor a Tátrában túráztunk. Az élmény egyszerűen fantasztikus volt! Életem legjobb kirándulásának tartom és alig várom, hogy újra visszatérjek oda!</p>
                    <img class="post-img" src="../img/static/posts/post-2.jpg" alt="bejegyzés képe">
                    <hr class="post-top-separator">
                    <div class="post-interactions">
                        <div class="interaction">
                            <img class="like-button" src="../img/icons/like-icon.png" alt="like">
                            <span class="like-count i-label">49 ember kedveli</span>
                        </div>
                        <div class="interaction">
                            <img class="comment-button" src="../img/icons/comment-icon.png" alt="komment">
                            <span class="comment-count i-label">5 hozzászólás</span>
                        </div>
                        <div class="interaction">
                            <img class="share-button" src="../img/icons/share-icon.png" alt="megosztás">
                            <span class="share-count i-label">1 megosztás</span>
                        </div>
                    </div>
                    <hr class="post-bottom-separator">
                    <div class="post-comments">
                        <div class="comment">
                            <div class="comment-details">
                                <img class="comment-user-img" src="../img/static/users/user-6.png" alt="profilkép" title="Kertész Kolompár" onclick="redirect(this)">
                                <div class="comment-details-info">
                                    <span class="comment-user-name" title="Kertész Kolompár" onclick="redirect(this)">Kertész Kolompár</span>
                                    <span class="comment-date">1 órája</span>
                                </div>
                            </div>
                            <p class="comment-description">nagyon szep</p>
                        </div>
                    </div>
                    <span class="post-comments-expand">További hozzászólások megtekintése..</span>
                </div>

                <div class="post">
                    <div class="post-details">
                        <img class="post-user-img" src="../img/static/users/user-6.png" alt="profilkép" title="Kertész Kolompár" onclick="redirect(this)">
                        <div class="post-details-info">
                            <span class="post-user-name" title="Kertész Kolompár" onclick="redirect(this)">Kertész Kolompár</span>
                            <span class="post-date">4 órája</span>
                        </div>
                    </div>
                    <p class="post-description">sziasztok xd</p>
                    <hr class="post-top-separator">
                    <div class="post-interactions">
                        <div class="interaction">
                            <img class="like-button" src="../img/icons/like-icon.png" alt="like">
                            <span class="like-count i-label">2 ember kedveli</span>
                        </div>
                        <div class="interaction">
                            <img class="comment-button" src="../img/icons/comment-icon.png" alt="komment">
                            <span class="comment-count i-label">0 hozzászólás</span>
                        </div>
                        <div class="interaction">
                            <img class="share-button" src="../img/icons/share-icon.png" alt="megosztás">
                            <span class="share-count i-label">0 megosztás</span>
                        </div>
                    </div>
                </div>

                <div class="post">
                    <div class="post-details">
                        <img class="post-user-img" src="../img/static/users/user-4.png" alt="profilkép" title="Arató András" onclick="redirect(this)">
                        <div class="post-details-info">
                            <span class="post-user-name" title="Arató András" onclick="redirect(this)">Arató András</span>
                            <span class="post-date">február 27. 17:37</span>
                        </div>
                    </div>
                    <p class="post-description">Harci bevetésre készen</p>
                    <img class="post-img" src="../img/static/posts/post-1.jpg" alt="bejegyzés képe">
                    <hr class="post-top-separator">
                    <div class="post-interactions">
                        <div class="interaction">
                            <img class="like-button" src="../img/icons/like-icon.png" alt="like">
                            <span class="like-count i-label">591 ember kedveli</span>
                        </div>
                        <div class="interaction">
                            <img class="comment-button" src="../img/icons/comment-icon.png" alt="komment">
                            <span class="comment-count i-label">126 hozzászólás</span>
                        </div>
                        <div class="interaction">
                            <img class="share-button" src="../img/icons/share-icon.png" alt="megosztás">
                            <span class="share-count i-label">9 megosztás</span>
                        </div>
                    </div>
                    <hr class="post-bottom-separator">
                    <div class="post-comments">
                        <div class="comment">
                            <div class="comment-details">
                                <img class="comment-user-img" src="../img/static/default-profile.png" alt="profilkép" title="Balázs Judit" onclick="redirect(this)">
                                <div class="comment-details-info">
                                    <span class="comment-user-name" title="Balázs Judit" onclick="redirect(this)">Balázs Judit</span>
                                    <span class="comment-date">február 28. 20:11</span>
                                </div>
                            </div>
                            <p class="comment-description">Jó utat:))</p>
                        </div>
                        <div class="comment">
                            <div class="comment-details">
                                <img class="comment-user-img" src="../img/static/users/user-5.png" alt="profilkép" title="Kovács Gábor" onclick="redirect(this)">
                                <div class="comment-details-info">
                                    <span class="comment-user-name" title="Kovács Gábor" onclick="redirect(this)">Kovács Gábor</span>
                                    <span class="comment-date">február 28. 20:11</span>
                                </div>
                            </div>
                            <p class="comment-description">Vigyázz magadra!</p>
                        </div>
                    </div>
                    <span class="post-comments-expand">További hozzászólások megtekintése..</span>
                </div>

                <div class="post">
                    <div class="post-details">
                        <img class="post-user-img" src="../img/static/users/user-1.png" alt="profilkép" title="Nagy Béla" onclick="redirect(this)">
                        <div class="post-details-info">
                            <span class="post-user-name" title="Nagy Béla" onclick="redirect(this)">Nagy Béla</span>
                            <span class="post-date">március 14. 10:21</span>
                        </div>
                    </div>
                    <p class="post-description">Sokan értékelik a pénzt és a vagyonukat, de az igazi boldogság nem ott van. Az én boldogságom a kertemben van, ahol az összes növény és állat az én életem része. Boldog vagyok, hogy van időm ápolni őket és egy kicsit lelassulni a rohanó világunkban.</p>
                    <img class="post-img" src="../img/static/posts/post-3.jpg" alt="bejegyzés képe">
                    <hr class="post-top-separator">
                    <div class="post-interactions">
                        <div class="interaction">
                            <img class="like-button" src="../img/icons/like-icon.png" alt="like">
                            <span class="like-count i-label">29 ember kedveli</span>
                        </div>
                        <div class="interaction">
                            <img class="comment-button" src="../img/icons/comment-icon.png" alt="komment">
                            <span class="comment-count i-label">0 hozzászólás</span>
                        </div>
                        <div class="interaction">
                            <img class="share-button" src="../img/icons/share-icon.png" alt="megosztás">
                            <span class="share-count i-label">1 megosztás</span>
                        </div>
                    </div>
                </div>
                <div class="post">
                    <div class="post-details">
                        <img class="post-user-img" src="../img/static/users/user-2.png" alt="profilkép" title="Szabó Peti" onclick="redirect(this)">
                        <div class="post-details-info">
                            <span class="post-user-name" title="Szabó Peti" onclick="redirect(this)">Szabó Peti</span>
                            <span class="post-date">2 napja</span>
                        </div>
                    </div>
                    <p class="post-description">Sosem láttam még ilyen tűéles videót a Mars fedélzetéről.</p>
                    <video class="post-video" controls>
                        <source src="../media/rick-roll-video.mp4" type="video/mp4">
                        A böngésződ nem támogatja a videókat.
                    </video>
                    <hr class="post-top-separator">
                    <div class="post-interactions">
                        <div class="interaction">
                            <img class="like-button" src="../img/icons/like-icon.png" alt="like">
                            <span class="like-count i-label">11 ember kedveli</span>
                        </div>
                        <div class="interaction">
                            <img class="comment-button" src="../img/icons/comment-icon.png" alt="komment">
                            <span class="comment-count i-label">1 hozzászólás</span>
                        </div>
                        <div class="interaction">
                            <img class="share-button" src="../img/icons/share-icon.png" alt="megosztás">
                            <span class="share-count i-label">0 megosztás</span>
                        </div>
                    </div>
                    <hr class="post-bottom-separator">
                    <div class="post-comments">
                        <div class="comment">
                            <div class="comment-details">
                                <img class="comment-user-img" src="../img/static/users/user-10.png" alt="profilkép" title="Juhász Erzsébet" onclick="redirect(this)">
                                <div class="comment-details-info">
                                    <span class="comment-user-name" title="Juhász Erzsébet" onclick="redirect(this)">Juhász Erzsébet</span>
                                    <span class="comment-date">38 perce</span>
                                </div>
                            </div>
                            <p class="comment-description">MII EZ ????</p>
                        </div>
                    </div>
                    <span class="post-comments-expand">További hozzászólások megtekintése..</span>
                </div>
            </div>
            <div class="ad-container">
                <h1>Hirdetés</h1>
                <img class="ad-img" src="../img/static/ads/ad-1.png" alt="hirdetés"/>
            </div>  
        </main>
    </body>
</html>