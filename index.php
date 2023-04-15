<?php
    function find_user_by_email($email) {
        $users_dir = 'users/';
        $users_directory = new DirectoryIterator($users_dir);
        foreach($users_directory as $user_directory) {
            if($user_directory->isDir()) {
                $data_file = $user_directory->getPathname() . '/data.txt';
                if(file_exists($data_file)) {
                    $user_data = unserialize(file_get_contents($data_file)); {
                        if($user_data['email'] == $email) {
                            $user_data['id'] = basename($user_directory->getPathname());
                            return $user_data;
                        }
                    }
                }
            }
        }
        return null;
    }

    if(isset($_COOKIE['email'])){
        $email = $_COOKIE['email'];
        $password = $_COOKIE['password'];
        $user_data = find_user_by_email($email);

        if($user_data) {
            if (password_verify($password, $user_data['password'])) {
                session_start();
                $_SESSION['user_data'] = $user_data;
                $_SESSION['bejelentkezve'] = true;

                header('Location: php/home.php');
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="hu">
    <head>
        <title>Bejelentkezés | iWiW</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
        <link rel="stylesheet" type="text/css" href="css/index.css"/>
        <link rel="stylesheet" type="text/css" href="css/print/login.css"/>
        <link rel="icon" type="image/x-icon" href="img/iwiw-logo-16x16.png"/>
    </head>
    <body>
        <div class="main">
            <div class="logo">
                <img src="img/iwiw-logo.png" alt="iWiW logó"/>
            </div>
            <div class="login">
                <form action="php/login.php" method="POST">
                    <input type="email" class="loginput email" name="email" placeholder="E-mail cím" required/>
                    <input type="password" class="loginput password" name="password" placeholder="Jelszó" required/>
                    <input type="submit" name="login_submit" value="Bejelentkezés"/> 
                    <div class="logunder">
                        <div>
                            <input type="checkbox" id="remember-cbox" name="remember"/>
                            <label for="remember-cbox" id="remember-label" name="remember">Emlékezz rám</label>
                        </div>
                        <a href="" id="pswdreset">Elfelejtetted a jelszavad?</a>
                    </div>
                    <a href="pages/register.html" id="register">Nincs iWiW fiókod?</a>
                </form>
            </div>
        </div>
        <footer>
            <ul>
                <li><a href="pages/footer/tos.html">Felhasználási feltételek</a></li>
                <li><a href="pages/footer/dmp.html">Adatkezelési szabályzat</a></li>
                <li><a href="pages/footer/contact.html">Elérhetőség</a></li>
                <li><a href="pages/footer/security.html">Biztonság</a></li>
                <li><a href="pages/footer/support.html">Segítség</a></li>
                <li>—</li>
                <li>Nem hivatalos iWiW &copy; 2023</li>
            </ul>
        </footer>
    </body>
</html>