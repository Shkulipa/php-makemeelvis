<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Me Elvis - Add Email</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

<img src="blankface.jpg" width="161" height="350" alt="" style="float:right" />
<img name="elvislogo" src="elvislogo.gif" width="229" height="32" border="0" alt="Make Me Elvis" />
<p>Enter your first name, last name, and email to be added to the <strong>Make Me Elvis</strong> mailing list.</p>

<?php
    if (isset($_POST['submit'])) {
        $first_name = $_POST['firstname'];
        $last_name = $_POST['lastname'];
        $mail = $_POST['mail'];
        $output_form = true;

        if ( empty($first_name) || empty($last_name) || empty($mail) ) {
            echo 'Вы не заполнили какое-то из полей. Заполните пожалуйсте все поля.';
            $output_form = true;
        } else  {
            $dbc = mysqli_connect('127.0.0.1', 'root', 'root', 'elvis_store')
                or die ('Ошибка соединения с MySQL-сервером'); 

            $query = "INSERT INTO email_list (" .
                "first_name," .
                "last_name," .
                "email" .
            ")" .

            "VALUES (" .
                "'$first_name'," .
                "'$last_name'," .
                "'$mail'" .
            ")";

            mysqli_query($dbc, $query)
                or die('Ошибка при выполнении запроса к базе данных');

            echo 'Customer added' . '<br/><br/>';
            echo '<a href="addemail.html">Вернуться назда?</a>' . '<br/><br/>';
            
            mysqli_close($dbc);

            $output_form = false;
        }
    } else {
        $output_form = true;
    }

    if ($output_form) {
?>

<form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
    <label for="firstname">First name:</label>
    <input type="text" id="firstname" name="firstname" value="<?php echo  $first_name ?>" /><br />

    <label for="lastname">Last name:</label>
    <input type="text" id="lastname" name="lastname" value="<?php echo  $last_name ?>" /><br />

    <label for="mail">Email:</label>
    <input type="text" id="mail" name="mail" value="<?php echo  $mail ?>" /><br />

    <input type="submit" name="submit" value="Submit" />
</form>

<?php 
    };
?>
    
</body>
</html>
