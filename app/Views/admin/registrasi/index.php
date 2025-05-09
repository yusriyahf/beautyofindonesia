<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - BeautyofIndonesia</title>
    <script src="https://cdn.tiny.cloud/1/sxxy60vycziwn57rquoz0cvjdvgfutm9pk6h9uhil105r02a/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container">
    <div class="form-container">

    <!-- <div class="back-button">
        <a href="<?= base_url('/'); ?>" class="btn-back"> < Back</a>
    </div> -->

    <a href="<?= base_url('/'); ?>" class="btn-back">
    <svg width="20" height="18" fill="currentColor" style="margin-right:0px" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>Back</a>


        <div class="logo-container">
            <img class="logo-icon" src="<?= base_url('assets-baru/img/icon_logo1.png'); ?>" alt="logo">
            <h2 class="form-heading">Registrasi BeautyofIndonesia</h2>
        </div>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('registrasi/process'); ?>" onsubmit="return syncEditor();">
            <?= csrf_field(); ?>
            
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input id="full_name" name="full_name" type="text" placeholder="Enter Full Name" required>
            </div>
            
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" placeholder="Enter Username" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" placeholder="Enter Email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" placeholder="Enter Password" required>
            </div>

            <div class="form-group">
                <label for="kontak">Contact</label>
                <input id="kontak" name="kontak" type="text" placeholder="Enter Kontak" required>
            </div>

            <div class="form-group">
                <label for="bank_account_number">Bank Account Number</label>
                <input id="bank_account_number" name="bank_account_number" type="text" placeholder="Enter Bank Account Number" required>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required onchange="toggleArtikelField()">
                    <option value="" disabled selected>Select Role</option>
                    <option value="penulis">Writer</option>
                    <option value="marketing">Marketing</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="form-group" id="artikel-group" style="display: none;">
                <label for="article">Article</label>
                <textarea id="article" name="artikel">Enter your first article here!</textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="btn-register">Registration</button>
            </div>
        </form>

        <p class="text-center">Already have an account? <a href="/login" style="color: #d32f2f; text-decoration: underline;">Login</a></p>
    </div>
</div>

<!-- Styles -->
<style>
   body {
    background-color: #f0f4f8;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}
.container {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    display: flex;
    width: 90%;
    max-width: 1000px;
    overflow: hidden;
}
.form-container {
    flex: 1;
    padding: 2rem;
}
.form-heading {
    text-align: center;
    margin: 1rem 0;
    color: rgb(0, 0, 0);
}
.logo-container {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}
.logo-icon {
    width: 50px;
    margin-right: 10px;
}
.form-group {
    display: flex;
    margin-bottom: 1rem;
}
.form-group label {
    width: 30%;
    font-weight: bold;
}
.form-group input, .form-group select, .form-group textarea {
    width: 70%;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.btn-register {
    background-color: #2196F3; /* Ganti warna merah menjadi biru */
    color: white;
    width: 100%;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 1rem;
    transition: background 0.3s;
}
.btn-register:hover {
    background-color: #1976D2; /* Warna biru lebih gelap saat hover */
}
.alert {
    background-color: #ffeeba;
    color: #856404;
    padding: 10px;
    margin-bottom: 1rem;
    border: 1px solid #ffeeba;
    border-radius: 5px;
}
.text-center {
    text-align: center;
    margin-top: 1rem;
}

/* button back */
.back-button {
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background-color: #e3f2fd; /* Warna latar belakang biru muda */
    color: #1976D2; /* Warna teks biru */
    padding: 10px 18px;
    border: 1.5px solid #1976D2; /* Warna border biru */
    border-radius: 10px;
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    font-family: 'Poppins', sans-serif;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 2px 5px rgba(25, 118, 210, 0.1); /* Bayangan biru */
}

.btn-back:hover {
    background-color: #1976D2; /* Warna latar belakang biru saat hover */
    color: #ffffff; /* Warna teks putih saat hover */
    border-color: #0d47a1; /* Warna border biru gelap saat hover */
    box-shadow: 0 4px 10px rgba(25, 118, 210, 0.2); /* Bayangan biru lebih gelap */
    transform: translateY(-1px);
}

</style>

<!-- Scripts -->
<script>
    // Inisialisasi TinyMCE
    tinymce.init({
        selector: 'textarea#article',
        menubar: false,
        plugins: 'lists link image table code',
        toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image table | code',
        height: 300
    });

    // Sync TinyMCE
    function syncEditor() {
        tinymce.triggerSave();
        return true;
    }

    // Tampilkan artikel jika role penulis
    function toggleArtikelField() {
        const role = document.getElementById('role').value;
        const artikelGroup = document.getElementById('artikel-group');
        const artikelInput = document.getElementById('article');

        if (role === 'penulis') {
            artikelGroup.style.display = 'block';
            artikelInput.setAttribute('required', 'required');
        } else {
            artikelGroup.style.display = 'none';
            artikelInput.removeAttribute('required');
        }
    }

    // Tampilkan SweetAlert jika registrasi sukses
    document.addEventListener("DOMContentLoaded", function () {
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Registrasi Berhasil!',
                text: 'Silakan tunggu info melalui email.',
                confirmButtonColor: '#4CAF50'
            });
        <?php endif; ?>
    });
</script>

</body>
</html>
