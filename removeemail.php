<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Me Elvis - remove Email</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

<img src="blankface.jpg" width="161" height="350" alt="" style="float:right" />
  <img name="elvislogo" src="elvislogo.gif" width="229" height="32" border="0" alt="Make Me Elvis" />
  <p>Choose people to remove them from list</p>

  <form method="post" action="<?php echo $SERVER['PHP_SELF']; ?>">

<?php

    $dbc = mysqli_connect('127.0.0.1', 'root', 'root', 'elvis_store')
        or die ('Ошибка соединения с MySQL-сервером'); 
        
    if(isset($_POST['submit'])) {
        foreach($_POST['todelete'] as $delete_id) {
            $query = "DELETE FROM email_list WHERE id = $delete_id";
            mysqli_query($dbc, $query)
                or die ('Ошибка при выполнении запроса к базе данных');
        }

        echo 'Покупатель(ли) удален(ы).<br/>';
    }   

    $query = "SELECT * FROM email_list";
    $result = mysqli_query($dbc, $query)
        or die ('Ошибка при выполнении запроса к базе данных');

    while ( $row = mysqli_fetch_array($result) ) {
        echo '<input type="checkbox" value="'. $row['id'] .'" name="todelete[]" />';
        echo $row['first_name'] . ' ' . $row['last_name'] . ' ' . $row['email'] . '<br/><br/>';
    }
    mysqli_close($dbc);

?>
    <input type="submit" name="submit" value="Remove" />
</form>
    
</body>
</html>
