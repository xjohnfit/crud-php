<?php

include 'partials/header.php';
require __DIR__.'/users/users.php';

$user = [
    'id' => '',
    'name' => '',
    'username' => '',
    'email' => '',
    'phone' => '',
    'website' => '',
];

$errors = [
    'name' => "",
    'username' => "",
    'email' => "",
    'phone' => "",
    'website' => ""
];

$isValid = true;

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $isValid = validateUser($user, $errors);

    if($isValid) {
        $user = array_merge($user, $_POST);
        $user = createUser($_POST);
        uploadImage($_FILES['picture'], $user);
        header('Location: index.php');
    }
}

?>

<?php include '_form.php'; ?>