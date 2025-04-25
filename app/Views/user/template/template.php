<!DOCTYPE html>
<?php $lang = session()->get('lang') ?? 'en'; ?>
<html lang="<?= $lang ?>">

<head>
    <meta charset="utf-8">
    <title>
        <?=
        session()->get('lang') == 'id'
            ? ($wisata['meta_title_id'] ?? $oleh['meta_title_id'] ?? $artikel['meta_title_id'] ?? $meta->meta_title_id ?? 'Judul Standar Bahasa Indonesia')
            : ($wisata['meta_title_en'] ?? $oleh['meta_title_en'] ?? $artikel['meta_title_en'] ?? $meta->meta_title_en ?? 'Default English Title');
        ?>
    </title>

    <!-- Meta Tags -->

    <meta name="description" content="<?=
                                        session()->get('lang') == 'id'
                                            ? ($wisata['meta_description_id'] ?? $oleh['meta_description_id'] ?? $artikel['meta_description_id'] ??   $meta->meta_description_id ??  'Deskripsi Standar Bahasa Indonesia')
                                            : ($wisata['meta_description_en'] ?? $oleh['meta_description_en'] ?? $artikel['meta_description_en'] ??   $meta->meta_description_en ??  'Default English Description');
                                        ?>">

    <!-- Canonical Tag -->
    <link rel="canonical" href="<?= isset($canonical) && !empty($canonical) ? $canonical : base_url() ?>">

    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="Cache-Control" content="max-age=604800, must-revalidate">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="<?= isset($metaOG['title']) ? esc($metaOG['title']) : 'Default OG Title' ?>" />
    <meta property="og:description" content="<?= isset($metaOG['description']) ? esc($metaOG['description']) : 'Default OG Description' ?>" />
    <meta property="og:image" content="<?= isset($metaOG['image']) ? base_url($metaOG['image']) : base_url('uploads/default-image.jpg') ?>" />
    <meta property="og:url" content="<?= isset($metaOG['url']) ? esc($metaOG['url']) : base_url() ?>" />
    <meta property="og:type" content="<?= isset($metaOG['type']) ? esc($metaOG['type']) : 'website' ?>" />

    <!-- Favicon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="icon" href="<?= base_url() ?>favicon.png" type="image/png">

    <!-- Google Web Fonts -->

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?= base_url('assets-baru') ?>/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?= base_url('assets-baru') ?>/css/style.css" rel="stylesheet">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>

</head>

<body>
    <!-- Topbar Start -->
    <?= $this->include('user/layout/header'); ?>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <?= $this->include('user/layout/nav'); ?>
    <!-- Navbar End -->



    <?= $this->renderSection('content'); ?>
    <!-- Main News Slider Start -->

    <!-- Main News Slider End -->


    <!-- Breaking News Start -->

    <!-- Breaking News End -->


    <!-- Featured News Slider Start -->

    <!-- Featured News Slider End -->


    <!-- News With Sidebar Start -->

    <!-- News With Sidebar End -->

    <?= $this->include('user/layout/popup');  ?>


    <!-- Footer Start -->
    <?= $this->include('user/layout/footer');  ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-square back-to-top"><i class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script src="<?= base_url('assets-baru') ?>/lib/easing/easing.min.js"></script>
    <script src="<?= base_url('assets-baru') ?>/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->

    <script src="<?= base_url('assets-baru') ?>/js/main.js"></script>



</body>

</html>