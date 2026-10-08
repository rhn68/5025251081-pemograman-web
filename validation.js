<script>
function validateForm(){
let nim = document.forms["studentForm"]["nim"].value;
let nimError = document.getElementById("nimError");
let nimInput = document.getElementById("nim");
// Validasi apakah NIM hanya berisi karakter angka
if (isNaN(nim)) {
nimError.style.display = "block"; // Tampilkan pesan error
nimInput.classList.add("is-invalid"); // Tambahkan border merah kustom
Bootstrap
return false; // Batalkan pengiriman form
}
nimError.style.display = "none";
nimInput.classList.remove("is-invalid");
return true;
}
</script>
<!-- Bootstrap 5 JS Bundle -->
<script>
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></scri
pt>
</body>
</html>
</script>