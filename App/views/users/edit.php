<h2>Edit User</h2>

<form action="<?= url("users/update/{$user['id']}") ?>" method="POST">

    <div>
        <label>Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>">
    </div>
    <div>
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
    </div>

    <div>
        <label>Room ID</label>
        <input type="number" name="room_id" value="<?= htmlspecialchars($user['room_id']) ?>">
    </div>

    <div>
        <label>Extension</label>
        <input type="text" name="ext" value="<?= htmlspecialchars($user['ext']) ?>">
    </div>

    <div>
        <label>Role</label>
        <select name="role">
            <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
    </div>

    <button type="submit">Update User</button>

</form>