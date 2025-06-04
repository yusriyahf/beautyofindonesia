<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?= base_url() ?>favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - BeautyofIndonesia</title>
    <script src="https://cdn.tiny.cloud/1/sxxy60vycziwn57rquoz0cvjdvgfutm9pk6h9uhil105r02a/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <?php $role = session()->get('role'); ?>
</head>

<body>

    <div class="main-container">
        <div class="form-wrapper">
            <!-- Decorative background elements -->
            <div class="bg-decoration">
                <div class="circle circle-1"></div>
                <div class="circle circle-2"></div>
                <div class="circle circle-3"></div>
            </div>

            <div class="form-container">
                <!-- Back Button -->
                <a href="<?= base_url(esc($role . '/')) ?>" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>


                <!-- Logo and Header -->
                <div class="header-section">
                    <div class="logo-container">
                        <div class="logo-placeholder">
                            <!-- <img src="/favicon.png" alt="Logo" style="width: 100%;"> -->
                        </div>
                        <h1 class="form-title">Beauty<span>of</span>Indonesia</h1>
                    </div>
                    <p class="form-subtitle">Daftarkan akun Anda dan bergabung dengan komunitas kami</p>
                </div>

                <!-- Alert Section -->
                <div class="alert alert-error" style="display: none;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Error message will appear here</span>
                </div>

                <!-- Registration Form -->
                <form method="post" action="<?= base_url('registrasi/process'); ?>" class="registration-form" onsubmit="return syncEditor();">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="full_name">
                                <i class="fas fa-user"></i>
                                Nama Lengkap
                            </label>
                            <input id="full_name" name="full_name" type="text" placeholder="Masukkan nama lengkap Anda" required>
                        </div>

                        <div class="form-group">
                            <label for="username">
                                <i class="fas fa-at"></i>
                                Username
                            </label>
                            <input id="username" name="username" type="text" placeholder="Masukkan username unik" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">
                                <i class="fas fa-envelope"></i>
                                Email
                            </label>
                            <input id="email" name="email" type="email" placeholder="contoh@email.com" required>
                        </div>

                        <div class="form-group">
                            <label for="password">
                                <i class="fas fa-lock"></i>
                                Password
                            </label>
                            <div class="password-input">
                                <input id="password" name="password" type="password" placeholder="Masukkan password yang kuat" required>
                                <button type="button" class="toggle-password" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="password-icon"></i>
                                </button>
                            </div>
                            <div class="password-strength">
                                <div class="strength-bar">
                                    <div class="strength-fill" id="strength-fill"></div>
                                </div>
                                <span class="strength-text" id="strength-text">Masukkan password</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="kontak">
                                <i class="fas fa-phone"></i>
                                Nomor Telepon
                            </label>
                            <input id="kontak" name="kontak" type="tel" placeholder="08xxxxxxxxxx" required pattern="[0-9]+" title="Hanya boleh berisi angka">
                        </div>

                        <div class="form-group">
                            <label for="bank_account_number">
                                <i class="fas fa-credit-card"></i>
                                Nomor Rekening Bank
                            </label>
                            <input id="bank_account_number" name="bank_account_number" type="text" placeholder="1234567890" required pattern="[0-9]+" title="Hanya boleh berisi angka">
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="role">
                            <i class="fas fa-user-tag"></i>
                            Peran
                        </label>
                        <select id="role" name="role" required onchange="toggleArtikelField()">
                            <option value="" disabled selected>Pilih peran Anda</option>
                            <option value="penulis">Penulis</option>
                            <option value="marketing">Marketing</option>
                        </select>
                    </div>

                    <div class="form-group full-width" id="artikel-group" style="display: none;">
                        <label for="article">
                            <i class="fas fa-pen-fancy"></i>
                            Artikel Pertama
                        </label>
                        <div class="editor-container">
                            <textarea id="article" name="artikel" placeholder="Tulis artikel pertama Anda di sini untuk menunjukkan kemampuan menulis..."></textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-register">
                            <i class="fas fa-user-plus"></i>
                            <span>Daftar Sekarang</span>
                            <div class="btn-loading" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </button>
                    </div>
                </form>

                <!-- Footer -->
                <div class="form-footer">
                    <p>Sudah memiliki akun? <a href="/login">Masuk di sini</a></p>
                </div>
            </div>
        </div>
        <!-- Tambahkan kode ini di bagian bawah body, sebelum penutup </body> -->
        <div id="successModal" class="modal-success" style="display: none;">
            <div class="modal-content">
                <div class="modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#4CAF50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <h2 class="modal-title">Registrasi Berhasil!</h2>
                <div class="modal-body">
                    <p>Terima kasih telah mendaftar di <strong>BeautyofIndonesia</strong>.</p>
                    <p>Registrasi Anda sedang menunggu persetujuan dari Admin. Kami akan mengirimkan notifikasi melalui email setelah akun Anda diaktivasi.</p>
                    <p>Proses verifikasi biasanya memakan waktu 1x24 jam pada hari kerja.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?= base_url() ?>" class="btn-home">
                        <i class="fas fa-home"></i> Kembali ke Halaman Utama
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            /* background: linear-gradient(135deg, #ff8c00 0%, #ffd700 50%, #32cd32 100%); */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .main-container {
            width: 100%;
            max-width: 1200px;
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .form-wrapper {
            position: relative;
            overflow: hidden;
        }

        .bg-decoration {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .circle-1 {
            width: 100px;
            height: 100px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .circle-2 {
            width: 150px;
            height: 150px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .circle-3 {
            width: 80px;
            height: 80px;
            top: 30%;
            right: 20%;
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #ff8c00, #ffd700);
            color: white;
            padding: 12px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 140, 0, 0.3);
            margin-bottom: 30px;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 140, 0, 0.4);
        }

        .header-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            gap: 15px;
        }

        .logo-placeholder {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            box-shadow: 0 10px 25px rgba(255, 140, 0, 0.3);
            background-image: url('favicon.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }


        .form-title {
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(135deg, #ff8c00, #ffd700, #32cd32);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .form-title span {
            font-weight: 300;
        }

        .form-subtitle {
            color: #666;
            font-size: 16px;
            font-weight: 400;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }

        .alert-error {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }

        .registration-form {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-group label i {
            color: #ff8c00;
            width: 16px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 15px 18px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 15px;
            font-family: inherit;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #ff8c00;
            box-shadow: 0 0 0 3px rgba(255, 140, 0, 0.1);
            background: white;
        }

        .password-input {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            padding: 5px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .toggle-password:hover {
            background: rgba(255, 140, 0, 0.1);
            color: #ff8c00;
        }

        .password-strength {
            margin-top: 8px;
        }

        .strength-bar {
            height: 4px;
            background: #e1e5e9;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 5px;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-text {
            font-size: 12px;
            color: #666;
            font-weight: 500;
        }

        .editor-container {
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .editor-container:focus-within {
            border-color: #ff8c00;
            box-shadow: 0 0 0 3px rgba(255, 140, 0, 0.1);
        }

        .form-actions {
            margin-top: 15px;
        }

        .btn-register {
            width: 100%;
            padding: 18px 30px;
            background: linear-gradient(135deg, #ff8c00, #ffd700);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(255, 140, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(255, 140, 0, 0.4);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .btn-register.loading .btn-loading {
            display: block !important;
        }

        .btn-register.loading span {
            display: none;
        }

        .form-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid #e1e5e9;
        }

        .form-footer p {
            color: #666;
            font-size: 15px;
        }

        .form-footer a {
            color: #ff8c00;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .form-footer a:hover {
            color: #ffd700;
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-container {
                padding: 25px;
                margin: 10px;
                border-radius: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .form-title {
                font-size: 24px;
            }

            .logo-placeholder {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
        }

        /* Input validation styles */
        .form-group input:invalid:not(:placeholder-shown) {
            border-color: #ff6b6b;
        }

        .form-group input:valid:not(:placeholder-shown) {
            border-color: #51cf66;
        }

        /* Custom select styling */
        .form-group select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 40px;
        }

        /* Modal Success Styles */
        .modal-success {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal-success.active {
            opacity: 1;
        }

        .modal-content {
            background-color: white;
            border-radius: 16px;
            padding: 40px;
            max-width: 500px;
            width: 90%;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transform: translateY(-20px);
            transition: transform 0.3s ease;
        }

        .modal-success.active .modal-content {
            transform: translateY(0);
        }

        .modal-icon {
            margin-bottom: 20px;
            animation: bounce 1s ease;
        }

        .modal-title {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
        }

        .modal-body {
            margin-bottom: 25px;
            color: #555;
            line-height: 1.6;
        }

        .modal-body p {
            margin-bottom: 10px;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #ff8c00, #ffd700);
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 140, 0, 0.3);
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 140, 0, 0.4);
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-20px);
            }

            60% {
                transform: translateY(-10px);
            }
        }
    </style>

    <script>
        // TinyMCE initialization
        tinymce.init({
            selector: 'textarea#article',
            menubar: false,
            plugins: 'lists link image table code wordcount',
            toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image table | code | wordcount',
            height: 300,
            skin: 'oxide',
            content_css: 'default',
            branding: false,
            setup: function(editor) {
                editor.on('focus', function() {
                    document.querySelector('.editor-container').style.borderColor = '#ff8c00';
                    document.querySelector('.editor-container').style.boxShadow = '0 0 0 3px rgba(255, 140, 0, 0.1)';
                });
                editor.on('blur', function() {
                    document.querySelector('.editor-container').style.borderColor = '#e1e5e9';
                    document.querySelector('.editor-container').style.boxShadow = 'none';
                });
            }
        });

        // Sync TinyMCE content
        function syncEditor() {
            tinymce.triggerSave();

            // Add loading state to button
            const submitBtn = document.querySelector('.btn-register');
            submitBtn.classList.add('loading');

            return true;
        }

        // Toggle article field based on role selection
        function toggleArtikelField() {
            const role = document.getElementById('role').value;
            const artikelGroup = document.getElementById('artikel-group');
            const artikelInput = document.getElementById('article');

            if (role === 'penulis') {
                artikelGroup.style.display = 'block';
                artikelInput.setAttribute('required', 'required');

                // Smooth animation
                artikelGroup.style.opacity = '0';
                artikelGroup.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    artikelGroup.style.opacity = '1';
                    artikelGroup.style.transform = 'translateY(0)';
                    artikelGroup.style.transition = 'all 0.3s ease';
                }, 50);
            } else {
                artikelGroup.style.display = 'none';
                artikelInput.removeAttribute('required');
            }
        }

        // Password toggle functionality
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        // Password strength checker
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthFill = document.getElementById('strength-fill');
            const strengthText = document.getElementById('strength-text');

            let strength = 0;
            let feedback = '';

            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;

            const strengthPercentage = (strength / 5) * 100;
            strengthFill.style.width = strengthPercentage + '%';

            if (strength <= 2) {
                strengthFill.style.background = 'linear-gradient(135deg, #ff6b6b, #ee5a52)';
                feedback = 'Password lemah';
            } else if (strength <= 3) {
                strengthFill.style.background = 'linear-gradient(135deg, #ffd93d, #ff9500)';
                feedback = 'Password sedang';
            } else {
                strengthFill.style.background = 'linear-gradient(135deg, #51cf66, #40c057)';
                feedback = 'Password kuat';
            }

            strengthText.textContent = password.length > 0 ? feedback : 'Masukkan password';
        });

        // Number only input for phone and bank account
        document.getElementById('kontak').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        document.getElementById('bank_account_number').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Form validation
        document.querySelector('.registration-form').addEventListener('submit', function(e) {
            const inputs = this.querySelectorAll('input[required], select[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = '#ff6b6b';
                    input.style.animation = 'shake 0.5s ease-in-out';
                } else {
                    input.style.borderColor = '#51cf66';
                    input.style.animation = '';
                }
            });

            if (!isValid) {
                e.preventDefault();
                // Show error alert
                const alert = document.querySelector('.alert');
                alert.style.display = 'flex';
                alert.querySelector('span').textContent = 'Mohon lengkapi semua field yang diperlukan';
                alert.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });

        // Add shake animation
        const style = document.createElement('style');
        style.textContent = `
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}
`;
        document.head.appendChild(style);

        // Success notification (simulation)
        document.addEventListener("DOMContentLoaded", function() {
            // Simulate success message (replace with actual PHP condition)
            // if (session()->getFlashdata('success')) {
            //     Swal.fire({
            //         icon: 'success',
            //         title: 'Registrasi Berhasil!',
            //         text: 'Silakan tunggu konfirmasi melalui email.',
            //         confirmButtonColor: '#ff8c00',
            //         background: 'rgba(255, 255, 255, 0.95)',
            //         backdrop: `rgba(255, 140, 0, 0.2)`
            //     });
            // }
        });

        // Tampilkan modal jika registrasi berhasil
        document.addEventListener("DOMContentLoaded", function() {
            // Ini adalah contoh, sesuaikan dengan kondisi aktual dari backend
            <?php if (session()->getFlashdata('success')): ?>
                showSuccessModal();
            <?php endif; ?>
        });

        function showSuccessModal() {
            const modal = document.getElementById('successModal');
            modal.style.display = 'flex';

            // Trigger animation
            setTimeout(() => {
                modal.classList.add('active');
            }, 10);

            // Scroll ke atas halaman
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

            // Blokir scroll body saat modal terbuka
            document.body.style.overflow = 'hidden';
        }

        // Fungsi untuk menutup modal (jika diperlukan)
        function closeSuccessModal() {
            const modal = document.getElementById('successModal');
            modal.classList.remove('active');

            setTimeout(() => {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }, 300);
        }
    </script>

</body>

</html>