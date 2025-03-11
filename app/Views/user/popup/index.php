<!-- popup_ad.php -->
<div id="popupAd" class="popup animate__animated animate__fadeInUp">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">&times;</span>

        <!-- Check if there is an image to display -->
        <?php if (isset($popup['foto_popup']) && !empty($popup['foto_popup'])): ?>
            <img src="<?= base_url('uploads/foto_oleholeh/example.png') ?>" alt="Popup Image" onerror="this.style.display='none';">

        <?php else: ?>
            <!-- Default message or image if foto_popup is empty -->
            <p class="popup-message">Diskon hingga 50% untuk produk tertentu. Kunjungi sekarang!</p>
        <?php endif; ?>

        <h2 class="popup-title"><?php echo isset($popup['nama_popup']) ? $popup['nama_popup'] : 'Promosi Spesial!'; ?></h2>

        <a href="<?php echo isset($popup['link_popup']) ? $popup['link_popup'] : 'https://example.com'; ?>"
            class="btn-popup">
            <?php echo isset($popup['nama_tombol']) && !empty($popup['nama_tombol']) ? $popup['nama_tombol'] : 'Lihat Selengkapnya'; ?>
        </a>

    </div>
</div>

<style>
    /* Style for the popup overlay */
    .popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        animation: fadeIn 0.5s ease-out, growShrink 3s infinite;
    }

    /* Centering the content in the popup */
    .popup-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 15px 25px rgba(0, 0, 0, 0.3);
        width: 80%;
        max-width: 500px;
        transition: all 0.3s ease-in-out;
    }

    /* Close button styling */
    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 28px;
        font-weight: bold;
        color: #4A4A4A;
        cursor: pointer;
        background: transparent;
        border: none;
    }


    /* Title styling */
    .popup-title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Image styling */
    .popup-image {
        max-width: 50%;
        height: auto;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* Message styling when no image is available */
    .popup-message {
        font-size: 18px;
        color: #555;
        margin-bottom: 25px;
        font-weight: bold;
    }

    /* Button styling */
    .btn-popup {
        display: inline-block;
        padding: 12px 30px;
        background: #007bff;
        color: #fff;
        font-size: 16px;
        text-decoration: none;
        border-radius: 5px;
        transition: background 0.3s ease;
    }



    /* Animation for fading in the popup */
    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    /* Animation for the grow and shrink effect */
    @keyframes growShrink {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }
</style>

<script>
    function showPopup() {
        document.getElementById("popupAd").style.display = "block";
    }

    function closePopup() {
        document.getElementById("popupAd").style.display = "none";
    }

    // Show popup after 3 seconds
    setTimeout(showPopup, 1000);
</script>