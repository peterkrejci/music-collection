<?php

if (!isset($_SERVER['argv'][2])) {
	echo '
Add new user to database.

Usage: create-user.php <name> <password>
';
	exit(1);
}

list(, $name, $password, $fullname) = $_SERVER['argv'];

$container = require __DIR__ . '/../app/bootstrap.php';
$manager = $container->getByType('App\Models\UserModel');

$manager->add($name, $password, $fullname);
echo "User $name was added.\n";
