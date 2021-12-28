<!DOCTYPE html>
<html lang='ru'>
<head>
    <title><?=$title?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Блог начинающего web-разработчика">
    <meta name="keywords" content="HTML, PHP, блог">     
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    
</head>
<body>
    <div class="container">
        <header>
            <a href="/"><img src="images/logo.png" /></a>                       
        </header>        
        
        <div class="content"><?=$content?></div>
        
        <footer>
        <!--
<pre>
            <?php
            print_r($_SESSION);
            ?>
        </pre>
-->
        
        <p>&copy; <?php echo date('Y'); ?> Ассиди Эльконнэри</p>
        </footer>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.2.0.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>