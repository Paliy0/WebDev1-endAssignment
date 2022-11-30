<?php
//echo "Requested URL: " . $_SERVER['REQUEST_URI'];

/*
First Assignment
$name = $_GET['name'];
$birthDate = $_GET['birthdate'];

$age = date_diff(date_create($birthDate), date_create('now'))->y;

echo "your name is $name and your date of birth is $age";
*/
?>

<form action="response.php" method="POST">
    <label for="firstname">First name:</label><br>
    <input type="text" id="firstname" name="firstname" value="John"><br>

    <label for="lastname">Last name:</label><br>
    <input type="text" id="lastname" name="lastname" value="Doe"><br><br>

    <label for="dateofbirth">Birth date:</label><br>
    <input type="date" id="dateofbirth" name="dateofbirth" value="1999-02-23"><br><br>

    <input type="submit" value="Submit">
</form>