<div id="app-sidepanel" class="app-sidepanel">
    <div id="sidepanel-drop" class="sidepanel-drop"></div>
    <div class="sidepanel-inner d-flex flex-column">
        <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
        <div class="app-branding">
            <a class="app-logo" href="<?= base_url('admin/dashboard') ?>"></a>
            <h1 class="m-0 display-6 text-white font-weight-normal">Beauty Of Indonesia</h1>
            </a>
        </div><!--//app-branding-->

        <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
            <ul class="app-menu list-unstyled accordion" id="menu-accordion">

                <li class="nav-item">
                    <!-- //Bootstrap Icons: https://icons.getbootstrap.com/ -->
                    <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-speedometer2" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z" />
                                <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z" />
                            </svg>
                        </span>
                        <span class="nav-link-text">Dashboard</span>
                    </a><!--//nav-link-->
                </li><!--//nav-item-->

                <li class="nav-item">
                    <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                    <a class="nav-link" href="<?= base_url('admin/kategori/index') ?>">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
                            </svg>
                        </span>
                        <span class="nav-link-text">Kategori</span>
                    </a><!--//nav-link-->
                </li><!--//nav-item-->

                <li class="nav-item">
                    <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                    <a class="nav-link" href="<?= base_url('admin/meta/index') ?>">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
                            </svg>
                        </span>
                        <span class="nav-link-text">Meta</span>
                    </a><!--//nav-link-->
                </li><!--//nav-item-->

                <li class="nav-item">
                    <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                    <a class="nav-link" href="<?= base_url('admin/artikel/index') ?>">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-image" viewBox="0 0 16 16">
                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13zm13 1a.5.5 0 0 1 .5.5v6l-3.775-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12v.54A.505.505 0 0 1 1 12.5v-9a.5.5 0 0 1 .5-.5h13z" />
                            </svg>
                        </span>
                        <span class="nav-link-text">Artikel</span>
                    </a><!--//nav-link-->
                </li><!--//nav-item-->

                <!--<li class="nav-item">-->
                <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                <!--<a class="nav-link" href="<?= base_url('admin/penulis/index') ?>">-->
                <!--    <span class="nav-icon">-->
                <!--        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-activity" viewBox="0 0 16 16">-->
                <!--            <path fill-rule="evenodd" d="M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2Z" />-->
                <!--        </svg>-->
                <!--    </span>-->
                <!--    <span class="nav-link-text">Penulis</span>-->
                <!--</a>-->
                <!--//nav-link-->
                <!--</li>-->
                <!--//nav-item-->

                <li class="nav-item">
                    <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                    <a class="nav-link" href="<?= base_url("admin/tentang/edit"); ?>">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                            </svg>
                        </span>
                        <span class="nav-link-text">Tentang</span>
                    </a><!--//nav-link-->
                </li><!--//nav-item-->

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="<?= base_url("admin/provinsi/index"); ?>">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-map" viewBox="0 0 16 16">
                                <path d="M15.817.113A.5.5 0 0 0 15.5 0a.49.49 0 0 0-.192.041L10 2.243 5.692.041A.497.497 0 0 0 5.5 0a.5.5 0 0 0-.183.037L.683 1.634a.5.5 0 0 0-.183.363v13.305a.5.5 0 0 0 .683.471l4.5-1.8 4.308 2.202a.497.497 0 0 0 .442 0l4.5-2.25a.5.5 0 0 0 .275-.447V.5a.5.5 0 0 0-.391-.487ZM5 1.058l4 2v11.884l-4-2V1.058ZM1 2.02l3-1.2v11.884l-3 1.2V2.02ZM15 13.98l-3 1.5V3.595l3-1.5V13.98Z" />
                            </svg>
                        </span>
                        <span class="nav-link-text">Provinsi</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="<?= base_url("admin/kabupaten/index"); ?>">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-map-fill" viewBox="0 0 16 16">
                                <path d="M15.817.113A.5.5 0 0 0 15.5 0a.49.49 0 0 0-.192.041L10 2.243 5.692.041A.497.497 0 0 0 5.5 0a.5.5 0 0 0-.183.037L.683 1.634a.5.5 0 0 0-.183.363v13.305a.5.5 0 0 0 .683.471l4.5-1.8 4.308 2.202a.497.497 0 0 0 .442 0l4.5-2.25a.5.5 0 0 0 .275-.447V.5a.5.5 0 0 0-.391-.487ZM5 1.058l4 2v11.884l-4-2V1.058ZM1 2.02l3-1.2v11.884l-3 1.2V2.02ZM15 13.98l-3 1.5V3.595l3-1.5V13.98Z" />
                            </svg>
                        </span>
                        <span class="nav-link-text">Kabupaten</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="<?= base_url("admin/kategori_wisata/index"); ?>">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe" viewBox="0 0 16 16">
                                <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8Zm1.94 3.783a6.96 6.96 0 0 0 1.29 1.373 13.077 13.077 0 0 1-1.167-3.27A6.963 6.963 0 0 0 1.94 11.783ZM8 15.25c.276 0 .553-.72.74-1.708a13.07 13.07 0 0 1-1.48 0C7.447 14.53 7.724 15.25 8 15.25ZM5.925 11.917c.54.095 1.105.154 1.575.173v-3.08H5.172v2.646c.23.086.473.167.754.261Zm4.293 0c.281-.094.524-.175.754-.26V8.083H8.5v3.08c.47-.019 1.035-.078 1.575-.173ZM4.287 6.5h2.213V3.417a12.5 12.5 0 0 0-1.171.2c-.32.076-.63.168-.925.274a6.2 6.2 0 0 0-.525 2.608Zm5.213 0h2.213a6.2 6.2 0 0 0-.525-2.608 12.5 12.5 0 0 0-1.171-.2V6.5ZM7.705 6.5h.59V3.353a11.057 11.057 0 0 0-.59 0V6.5ZM2.272 10.34a7.076 7.076 0 0 1-.1-4.1 13.306 13.306 0 0 1 1.16-3.122 6.96 6.96 0 0 0-1.09 7.223ZM13.828 10.34a6.96 6.96 0 0 0 1.09-7.223 13.306 13.306 0 0 1 1.16 3.122 7.076 7.076 0 0 1-.1 4.1ZM10.612 1.74c.32.076.63.168.925.274a6.2 6.2 0 0 1 .525 2.608H9.85V3.417a12.5 12.5 0 0 1 1.171-.2ZM2.882 2.014c.295-.106.605-.198.925-.274a12.5 12.5 0 0 1 1.17-.2V6.5H2.765a6.2 6.2 0 0 1 .525-2.608ZM14.06 11.783a6.963 6.963 0 0 0-.123-2.896 13.077 13.077 0 0 1-1.167 3.27 6.96 6.96 0 0 0 1.29-1.373ZM2.333 12.56a6.94 6.94 0 0 0 3.46 2.268 12.95 12.95 0 0 1-.885-2.56 13.077 13.077 0 0 1-2.575-.96Zm9.427 0a13.078 13.078 0 0 1-2.575.96c-.194.823-.48 1.765-.885 2.56a6.94 6.94 0 0 0 3.46-2.268Z" />
                            </svg>
                        </span>
                        <span class="nav-link-text">Kategori Wisata</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="<?= base_url("admin/kategori_oleholeh/index"); ?>">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gift-fill" viewBox="0 0 16 16">
                                <path d="M8 1.5a2.5 2.5 0 0 1 2 4.001V6h4v6a2 2 0 0 1-2 2h-3v-5H7v5H4a2 2 0 0 1-2-2V6h4v-.499A2.5 2.5 0 1 1 8 1.5Zm0 1A1.5 1.5 0 0 0 6.5 4H7V3a1 1 0 0 1 1-1Zm2.5 0A1 1 0 0 0 9 3v1h.5A1.5 1.5 0 1 0 10.5 2.5Z" />
                            </svg>
                        </span>
                        <span class="nav-link-text">Kategori Oleh-Oleh</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="<?= base_url("admin/tempat_wisata/index"); ?>">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-map-fill" viewBox="0 0 16 16">
                                <path d="M15.817.113A.5.5 0 0 1 16 .5v13.961a.5.5 0 0 1-.683.472l-4.634-1.617-4.366 1.746a.5.5 0 0 1-.334 0L.183 14.113A.5.5 0 0 1 0 13.64V.5a.5.5 0 0 1 .683-.472L5.317 1.645l4.366-1.746a.5.5 0 0 1 .334 0l5.8 2.186ZM10 1.82l-4 1.6v11.76l4-1.6V1.82Zm1 0v11.76l3-.944V2.266l-3-.446ZM5 2.18l-4-.944v11.31l4 .944V2.18Z" />
                            </svg>
                        </span>
                        <span class="nav-link-text">Tempat Wisata</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="<?= base_url("admin/oleh_oleh/index"); ?>">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-basket-fill" viewBox="0 0 16 16">
                                <path d="M8 1a2 2 0 0 1 2 2v1h3.5a.5.5 0 0 1 .48.637l-1.5 6A.5.5 0 0 1 12 11H4a.5.5 0 0 1-.48-.363l-1.5-6A.5.5 0 0 1 2.5 4H6V3a2 2 0 0 1 2-2Zm-3.44 8h6.88L12.62 5H3.38l1.18 4ZM8 12a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                            </svg>
                        </span>
                        <span class="nav-link-text">Oleh - Oleh</span>
                    </a>
                </li>



            </ul><!--//app-menu-->
        </nav><!--//app-nav-->

    </div><!--//sidepanel-inner-->
</div><!--//app-sidepanel-->