<h2>Users</h2>

<table border="1" cellpadding="10">

    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>email</th>
        <th>Room Id</th>
        <th>Role</th>
        <th>Ext</th>
        <th>View</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>

    <?php foreach ($users as $user): ?>

        <tr>
            <td><?= $user["id"] ?></td>
            <td> <?= $user["name"] ?></td>
            <td><?= $user["email"] ?></td>
            <td> <?= $user["room_id"] ?></td>
            <td><?= $user["role"] ?></td>
            <td><?= $user["ext"] ?></td>

            <td>
                <a href="<?= url("users/show/{$user["id"]}")  ?>">View</a>
            </td>
            <td>
                <a href="<?= url("users/edit/{$user['id']}") ?>">Edit</a>
            </td>
            <td>
                <form action="<?= url("users/delete/{$user['id']}") ?>" method="POST" style="display:inline;">
                    <button type="submit">Delete</button>
                </form>
            </td>


        </tr>


    <?php endforeach; ?>


</table>
<a href="<?= url('users/create') ?>">Add User</a>