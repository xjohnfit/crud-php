<?php

function getUser() {
    return json_decode(file_get_contents(__DIR__.'/users.json'), true);
    exit;
}

function getUserById($userId) {
    $users = getUser();
    foreach($users as $user){
        if($user['id'] == $userId){
            return $user;
        }
    }
    return null;
}

function createUser($data) {
    $users = getUser();

    $data['id'] = rand(1000000, 2000000);

    $users[] = $data;

    putJson($users);

    return $data;
}

function updateUser($data, $userId) {
    $updateUser = [];
    $users = getUser();
    foreach($users as $i => $user){
        if($user['id'] == $userId){
            $users[$i] = $updateUser = array_merge($user, $data);
        }
    }

    putJson($users);

    return $updateUser;
    // echo '<pre>';
    // var_dump($users);
    // echo '</pre>';
}

function deleteUser($id) {
    $users = getUser();
        foreach($users as $i => $user) {
            if ($user['id'] == $id) {
                array_splice($users, $i, 1);
            }
        }
        putJson($users);
}

function uploadImage($file, $user) 
{
    if (isset($_FILES['picture']) && $_FILES['picture']['name']) {
        if(!is_dir(__DIR__ . "/images")) {
            mkdir(__DIR__ . "/images");
        }

        //get the file extension
        $fileName = $file['name'];

        //search for the dot in the filename
        $dotPosition = strpos($fileName, '.');

        //take the substring from the dot position till the end of the string 
        $extension = substr($fileName, $dotPosition + 1);
        
        move_uploaded_file($file['tmp_name'], __DIR__ . "/images/${user['id']}.$extension");
        $user['extension'] = $extension;
        updateUser($user, $user['id']);
    }
}

function putJson($users) {
    file_put_contents(__DIR__.'/users.json', json_encode($users, JSON_PRETTY_PRINT));
}

function validateUser($user, &$errors){
    $isValid = true;

    if (!$user['name']) {
        $isValid = false;
        $errors['name'] = "Name is mandatory";
    }
    if (!$user['username'] || strlen($user['username']) < 6 || strlen($user['username']) > 16) {
        $isValid = false;
        $errors['username'] = "Username is mandatory and must be more than 6 and less than 16 characters";
    }
    if(!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
        $isValid = false;
        $errors['email'] = 'Must be a valid email address';
    }
    if (!filter_var($user['phone'], FILTER_VALIDATE_INT)) {
        $isValid = false;
        $errors['phone'] = 'Must be a valid phone number';
    }
    if (!filter_var($user['website'], FILTER_VALIDATE_DOMAIN)) {
        $isValid = false;
        $errors['website'] = 'Must be a valid website';
    }

    return $isValid;
}
?>