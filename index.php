<!DOCTYPE html>
<html lang="en">
    <head>
        <title>TARSIP (TARUNA ARSIP)</title>
        <meta charset="UTF-8">
        <meta name="description" content="Route">
        <link rel="stylesheet" href="style.css" type="text/css">

    </head>
    <body>
        <header>
            <h1 class="title">ROUTE</h1>
            <h3 class="desc">ARSIP TARUNA</h3>
            <nav id="navigation">
                <ul>
                    <li><a href="index.php?page=login">Login</a></li>
                    <li><a href="index.php?page=register">Register</a></li>
                </ul>
            </nav>
        </header>
        <div id="contents">
            <?php
            if(isset($_GET["page"])){
                $page = $_GET["page"];

                switch ($page){
                    case "login":
                        include "login.php"; // Tambahkan file PHP untuk proses login
                        break;
                    case "register":
                        include "register.php"; // Tambahkan file PHP untuk proses registrasi
                        break;
            }
        }
else{
        }
        ?>    
        </div>
        <footer>
            &copy Copyright Kelompok 3
        </footer>
    </body>
</html>
