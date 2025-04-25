<?= $this->extend('user/template/template') ?>

<?= $this->section('content') ?>

<div class="sitemap-container" style="margin: 100px auto; padding: 20px; max-width: 800px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
    <div class="sitemap-section">
        <ul style="padding-left: 10;">
            <?php 
            $langSegment = service('uri')->getSegment(1); 
            foreach ($data['pages'] as $page): 
                if ($langSegment == 'id' && str_contains($page['url'], '/id')): ?>
                    <li style="margin-bottom: 10px;">
                        <a href="<?= $page['url'] ?>" style="color: #007;"><?= $page['name'] ?></a>
                    </li>
                <?php elseif ($langSegment == 'en' && str_contains($page['url'], '/en')): ?>
                    <li style="margin-bottom: 10px;">
                        <a href="<?= $page['url'] ?>" style="color: #007;"><?= $page['name'] ?></a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php foreach (['articles', 'wisata', 'souvenirs', 'kategori_wisata', 'kategori_oleh'] as $section): ?>
                <?php foreach ($data[$section] as $page): ?>
                    <?php if ($langSegment == 'id'): ?>
                        <li style="margin-bottom: 10px;">
                            <a href="<?= $page['url_id'] ?>" style="color: #007;"><?= $page['name'] ?></a>
                        </li>
                    <?php elseif ($langSegment == 'en'): ?>
                        <li style="margin-bottom: 10px;">
                            <a href="<?= $page['url_en'] ?>" style="color: #007;"><?= $page['name'] ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<?= $this->endSection() ?>
