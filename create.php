<?php
include 'auth.php';
include 'config.php';
$majors = mysqli_query(
    $conn,
    "SELECT id, name FROM majors ORDER BY name"
);
if (isset($_POST['submit'])) {
    $nim = $_POST['nim'];
    $name = $_POST['name'];
    $major_id = $_POST['major_id'];
    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO students (nim, name, major_id)
         VALUES (?, ?, ?)"
    );
    mysqli_stmt_bind_param(
        $stmt,
        "ssi",
        $nim,
        $name,
        $major_id
    );
    mysqli_stmt_execute($stmt);
    header("Location: index.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Student</title>
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">
</head>
<body class="bg-light">
<?php include 'navbar.php'; ?>
<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-6">
<div class="card shadow-sm">
<div class="card-header bg-success text-white">
<h5 class="mb-0">Add New Student</h5>
</div>
<div class="card-body">
<form name="studentForm" method="POST" action="" onsubmit="return
validateForm()">
<div class="mb-3">
<label for="nim" class="form-label">NIM</label>
<input type="text" class="form-control" id="nim" name="nim" required>
<!-- Pesan error JS disembunyikan secara default -->
<div id="nimError" class="text-danger mt-1" style="display: none;
font-size: 0.875em;">NIM harus berupa angka yang valid!</div>
</div>
<div class="mb-3">
<label for="name" class="form-label">Name</label>
<input type="text" class="form-control" id="name" name="name"
required>
</div>
<div class="mb-3">
    <label for="major_id" class="form-label">
        Prodi
    </label>
    <select class="form-select"
            id="major_id"
            name="major_id"
            required>
        <option value="" disabled selected>
            Pilih Prodi...
        </option>
        <?php while ($m = mysqli_fetch_assoc($majors)): ?>
            <option value="<?= $m['id'] ?>">
                <?= htmlspecialchars($m['name']) ?>
            </option>
        <?php endwhile; ?>
    </select>
</div>
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
<a href="index.php" class="btn btn-secondary">Cancel</a>
<button type="submit" name="submit" class="btn btn-success">Save
Data</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
<!-- JavaScript untuk Form Validation -->
<script>
function validateForm() {
    let nim = document.forms["studentForm"]["nim"].value;
    let nimError = document.getElementById("nimError");
    let nimInput = document.getElementById("nim");
    if (!/^[0-9]+$/.test(nim)) {
        nimError.style.display = "block";
        nimInput.classList.add("is-invalid");
        return false;
    }
    nimError.style.display = "none";
    nimInput.classList.remove("is-invalid");
    return true;
}
</script>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>