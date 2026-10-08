<?php
include 'auth.php';
include 'config.php';
require_admin();
$message = "";
if (isset($_POST['add_user'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    if (strlen($password) < 6) {
        $message = "<div class='alert alert-danger'>
            Password must be at least 6 characters.
        </div>";
    } elseif (!in_array($role, ['admin', 'staff'])) {
        $message = "<div class='alert alert-danger'>
            Invalid role.
        </div>";
    } else {
        $hash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );
        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO users (username, password, role)
             VALUES (?, ?, ?)"
        );
        mysqli_stmt_bind_param(
            $stmt,
            "sss",
            $username,
            $hash,
            $role
        );
        try {
            mysqli_stmt_execute($stmt);
            $message = "<div class='alert alert-success'>
                User added successfully.
            </div>";
        } catch (mysqli_sql_exception $e) {
            $message = "<div class='alert alert-danger'>
                Username is already taken.
            </div>";
        }
    }
}
$users = mysqli_query(
    $conn,
    "SELECT id, username, role
     FROM users ORDER BY id"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <?= $message ?>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5>Add User</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text"
                                   name="username"
                                   class="form-control"
                                   required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   minlength="6"
                                   required>
                        </div>
                        <div class="mb-3">
                            <label>Role</label>
                            <select name="role"
                                    class="form-select">
                                <option value="staff">Staff</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <button type="submit"
                                name="add_user"
                                class="btn btn-success w-100">
                            Save User
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5>User List</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php while ($u = mysqli_fetch_assoc($users)): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <?= htmlspecialchars($u['username']) ?>
                                        <?php if ($u['id'] == $_SESSION['user_id']): ?>
                                            <span class="badge bg-info">
                                                you
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge <?= $u['role'] === 'admin' ? 'bg-danger' : 'bg-secondary' ?>">
                                            <?= htmlspecialchars($u['role']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>