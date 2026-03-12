<h2>Create User</h2>

<form action="<?= url('users') ?>" method="POST">

<div>
<label>Name</label>
<input type="text" name="name" required>
</div>

<div>
<label>Email</label>
<input type="email" name="email" required>
</div>

<div>
<label>Password</label>
<input type="password" name="password" required>
</div>

<div>
<label>Room ID</label>
<input type="number" name="room_id">
</div>

<div>
<label>Extension</label>
<input type="text" name="ext">
</div>

<div>
<label>Role</label>
<select name="role">
<option value="user">User</option>
<option value="admin">Admin</option>
</select>
</div>

<button type="submit">Create User</button>

</form>