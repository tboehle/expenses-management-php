<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 18.04.2017
 * Time: 15:46
 */

function htmlanfang ($title = "PHP")
{
?>
    <!DOCTYPE html>
        <html>
            <head>
                <meta charset=\"UTF-8\">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title><?php echo $title; ?></title>
                <link rel="stylesheet" href="layout.css">
                <link href="bootstrap-3.3.7-dist/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
                <script type="text/javascript" src="https://www.google.com/jsapi"></script>
                <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
                <link href="bootstrap-3.3.7-dist/css/style.css" rel="stylesheet">
            </head>
            <body class="Transaktionsseite">
            <div class="container">
        <?php
}



function htmlende()
{
    ?>
    </div>
    <script src="jquery/jquery-1.12.4.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

<!--    <footer style="position: absolute ;bottom: 0 ;width: 100%; height: 50px; background-color: #f5f5f5;">-->
    <footer class="modal-footer">
        <p class="container text-muted">&copy; by Team Overkill (auch bekannt als Teaminator)</p>
      </div>
    </footer>
        </body>
    </html>
<?php
}
?>