<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <title>View Records</title>
</head>
<body>
    <h1>View Records.</h1>
    <?php
    include('connect-db.php');

    if($result = $mysqli->query('SELECT * FROM players ORDER BY id'))
    {
        if($result->num_rows > 0)
        {
            echo "<table border='1px solid'>";
            echo "<tr><th>ID</th><th>FIRSTNAME</th><th>LASTNAME</th><th></th><th></th></tr>";

            while($row = $result->fetch_object())
            {
                echo "<tr>";
                echo "<td>" . $row->id . "</id>";
                echo "<td>" . $row->firstname . "</id>";
                echo "<td>" . $row->lastname . "</id>";
                echo "<td><a href='records.php?id=" . $row->id . "'>Edit</id>";
                echo "<td><a href='delete.php?id=" . $row->id . "'>Delete</id>";
                echo "</tr>";
            }

            echo "</table>";
        }
        else
        {
            echo 'No results to display.';
        }
    }
    else
    {
        echo 'Error: ' . $mysqli->error;
    }
    $mysqli->close();
    ?>

    <a href="records.php">Add new player.</a>
</body>
</html>