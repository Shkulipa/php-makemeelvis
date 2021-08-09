<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Me Elvis - send Email</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

<img src="blankface.jpg" width="161" height="350" alt="" style="float:right" />
<img name="elvislogo" src="elvislogo.gif" width="229" height="32" border="0" alt="Make Me Elvis" />
<p><strong>Private:</strong> For Elmer's use ONLY<br />
Write and send an email to mailing list members.</p>

<?php
    if(isset($_POST['submit'])) {
        $from = 'elmer@makeelvis.com';
        $subject = $_POST['subject'];
        $text = $_POST['elvismail'];
        $output_form = false;


        if ( (empty($subject)) && (empty($text)) ) {
            echo "Вы забыли ввести тему и содержимое письма<br>";
            $output_form = true;
            echo '<a href="sendemail.html">Вернуться назда?</a>' . '<br/><br/>';
        } else if ( (empty($subject)) && (!empty($text)) ) {
            echo "Вы забыли ввести тему письма<br>";
            $output_form = true;
            echo '<a href="sendemail.html">Вернуться назда?</a>' . '<br/><br/>';
        } else if ( (!empty($subject)) && (empty($text))) {
            echo "Вы забыли ввести содержимое письма<br>";
            $output_form = true;
            echo '<a href="sendemail.html">Вернуться назда?</a>' . '<br/><br/>';
        } else if ( (!empty($subject)) && (!empty($text))) {
            $dbc = mysqli_connect('127.0.0.1', 'root', 'root', 'elvis_store')
                or die ('Ошибка соединения с MySQL-сервером'); 
                
            $query = "SELECT * FROM email_list";
            $result = mysqli_query($dbc, $query)
                or die ('Ошибка при выполнении запроса к базе данных');

            while ($row = mysqli_fetch_array($result)) {
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];

                $msg = "Уважаемый  $first_name $last_name, \n $text";

                $to =  $row['email'];

                echo $row['first_name'] . ' ' . $row['last_name'] . ' ' . ': ' . $row['email'] . '<br />';

                mail($to, $subject, $msg, 'From: ' . $from);

                echo 'Электронное письмо отправленно: ' . $to . '<br/>';

            }

            echo '<a href="sendemail.html">Вернуться назда?</a>' . '<br/><br/>';
            
            mysqli_close($dbc);

            $output_form = false;
        };
    } else {
        $output_form = true;
    };


    if ($output_form) {
    ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="subject">Subject of email:</label><br />
            <input id="subject" name="subject" type="text" size="30" value="<?php echo $subject; ?>"/><br />

            <label for="elvismail">Body of email:</label><br />

            <textarea id="elvismail" name="elvismail" rows="8" cols="40"><?php echo $text; ?></textarea><br />
            <input type="submit" name="submit" value="Submit" />
        </form>
    <?php
    };
?>
    
</body>
</html>
