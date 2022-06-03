<!DOCTYPE html>
<html class="h-100">
    <head>
        <!-- Bootsrtap required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <title>Port.hu</title>
        <style>
            #header-div {
                background-color: red;
                color: white;
                margin-bottom: 50px;
            }
        </style>
    </head>
    <body class="d-flex flex-column h-100">
        <header>
            <div id="header-div"class="d-flex justify-content-center">
                <h1>Port.hu</h1>
            </div>
        </header>
        <main class="container d-flex justify-content-center">
            <?php if(file_exists('Views/HomeView.php')):
                include_once('Views/HomeView.php'); endif; ?>
        </main>
        <footer>

        </footer>
    </body>
</html>
