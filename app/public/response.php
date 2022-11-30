<?php
$age = date_diff(date_create($_POST['dateofbirth']), date_create('now'))->y;

echo "Your name is " . $_POST['firstname'] . " " . $_POST['lastname'] . " and you are $age years old";
