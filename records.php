<?php
include('connect-db.php');

function renderForm($first = "", $last = "", $error = "", $id = "")
{ ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
        <title><?php if($id != ''){echo 'Edit Record.';}else{echo 'New Record.';} ?></title>
    </head>
    <body>
        <h1><?php if($id != ''){echo 'Edit Record.';}else{echo 'New Record.';} ?></h1>
        <?php 
        if($error != '')
        {
            echo "<div style='padding: 4px; color:red;'>" . $error . "</div>";
        }
        ?>
        <form action="" method="POST">
            <div>
                <?php if($id != '') { ?>
                    <input type="hidden" name="id" value="<?php echo $id?>">
                    <p>ID: <?php echo $id;?></p>
                <?php } ?>
                <strong>First</strong>
                <input type="text" name="firstname" value="<?php echo $first;?>">
                <br>
                <strong>Last</strong> 
                <input type="text" name="lastname" value="<?php echo $last;?>">
                <br>
                <input type="submit" name="submit" value="Submit">
            </div>
        </form>
    </body>
    </html>
<?php 
}

//Add new players and edit existing players data.

if(isset($_GET['id']))
{
    //edit form.
    if(isset($_POST['submit']))
    {
        $id = $_POST['id'];
        $firstname = htmlentities($_POST['firstname'], ENT_QUOTES);
        $lastname = htmlentities($_POST['lastname'], ENT_QUOTES);

        if($lastname == '' || $firstname == '')
        {
            $error = 'Error: please fill in all fields.';
            renderForm($firstname, $lastname, $error, $id);
        }
        else
        {
            if($stmt = $mysqli->prepare("UPDATE players SET firstname = ?, lastname = ? WHERE id = ?"))
            {
                $stmt->bind_param('ssi', $firstname, $lastname, $id);
                $stmt->execute();
                $stmt->close();
            }
            else
            {
                echo 'Error: could not prepare SQL statement.';
            }
        }
        header('Location: view.php');
    }
    if(is_numeric($_GET['id']) && $_GET['id'] > 0)
    {
        $id = $_GET['id'];
        //query database
        if($stmt = $mysqli->prepare("SELECT * FROM players WHERE id=?"))
        {
            $stmt->bind_param('i', $id);
            $stmt->execute();

            $stmt->bind_result($id, $firstname, $lastname);
            $stmt->fetch();

            renderForm($firstname, $lastname, null, $id);
        }
        
    }
}
else
{   
    //add new player.
    if(isset($_POST['submit']))
    {   
        $firstname = htmlentities($_POST['firstname'], ENT_QUOTES);
        $lastname = htmlentities($_POST['lastname'], ENT_QUOTES);

        if($firstname == '' || $lastname == '')
        {
            $error = "ERROR: Please fill in all fields.";
            renderForm($firstname,$lastname,$error);
        }
        else
        {
            if($stmt = $mysqli->prepare("INSERT players (firstname, lastname) VALUES (?, ?)"))
            {
                $stmt->bind_param("ss", $firstname, $lastname);
                $stmt->execute();
                $stmt->close();
            }
            else
            {
                echo 'ERROR: could not prepare sql statement.';
            }
            header('Location: view.php');
        }
    }
    else
    {
        renderForm();
    }
}

$mysqli->close();
?>