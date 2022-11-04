<?php
    require __DIR__.'/users/users.php';
    $users = getUser();
    include 'partials/header.php';
?>
    <div class="container">
        <div class="card m-2">
            <p>
                <a class="btn btn-outline-success m-2" href="create.php">Create new User</a>
            </p>
            <table class="table" style="width: 100%">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Website</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user):?>
                    <tr>
                        <td>
                            <?php if(isset($user['extension'])): ?>
                                <img style="width: 60px" src="<?php echo "users/images/${user['id']}.${user['extension']}"; ?>" alt="">
                            <?php endif; ?>
                        </td>
                        <td><?php echo $user['name']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['phone']; ?></td>
                        <td>
                            <a href="http://<?php echo $user['website']; ?>" target="_blank"><?php echo $user['website']; ?></a>
                        </td>
                        <td>
                            <a href="view.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-outline-info">View</a>
                            <a href="update.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-outline-secondary">Update</a>
                            <form style="display: inline-block" action="delete.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php include 'partials/footer.php'; ?>