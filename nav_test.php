<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
<link href="bootstrap-3.3.7-dist/css/style.css" rel="stylesheet">
<title>Testseite der Navigation</title>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
            <ul class="nav navbar-nav">
                <?php
                include "navigation.php";
                ?>
            </ul>
</nav>



<script src="jquery/jquery-1.12.4.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</body>
</html>