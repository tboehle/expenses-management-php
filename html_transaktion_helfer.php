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
                <meta name="viewport" content="width=device-width, initial scale=1">
                <title><?php echo $title; ?></title>
                <link rel="stylesheet" href="Transaktion_neu/layout.css">
                <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                <link rel="stylesheet" href="/resources/demos/style.css">
                <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                <script>
                    $( function() {
                        $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
                    } );
                </script>
            </head>
            <body>
        <?php
}



function htmlende()
{
    ?>
            </body>
        </html>
<?php
}
?>