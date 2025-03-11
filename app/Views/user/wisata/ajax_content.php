<!-- app/Views/user/home/ajax_content.php -->
<div class="ajax-content">
    
<!-- CSS untuk styling map dan autocomplete -->







<script>
    // Inisialisasi peta
    var map = L.map('map').setView([-2.5489, 118.0149], 5); // Koordinat Indonesia

    // Layer peta dasar
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Ikon untuk tempat wisata
    var wisataIcon = L.icon({
        iconUrl: '/assets-baru/img/icon_wisata.png',
        iconSize: [32, 42],
        iconAnchor: [20, 50],
        popupAnchor: [0, -42]
    });

    // Ikon untuk oleh-oleh
    var olehOlehIcon = L.icon({
        iconUrl: '/assets-baru/img/icon_oleholeh.png',
        iconSize: [32, 42],
        iconAnchor: [20, 50],
        popupAnchor: [0, -42]
    });


    // Tambahkan MarkerClusterGroup untuk tempat wisata dan oleh-oleh
    var wisataCluster = L.markerClusterGroup();
    var olehOlehCluster = L.markerClusterGroup();

    // Data dari PHP
    var wisataData = <?= json_encode($tempatWisata); ?>;
    var olehOlehData = <?= json_encode($olehOleh); ?>;

    // Variabel untuk menyimpan marker pencarian
    var currentSearchMarker = null;

    // Fungsi untuk memperbarui jumlah
    function updateCount() {
        document.getElementById("wisata-count").textContent = wisataData.length;
        document.getElementById("oleh-oleh-count").textContent = olehOlehData.length;
    }

    // Kontrol kustom untuk menampilkan jumlah tempat wisata dan oleh-oleh dengan checkbox
    var InfoPanelControl = L.Control.extend({
        onAdd: function(map) {
            var div = L.DomUtil.create('div', 'info-panel leaflet-control-info-panel');
            div.style.marginRight = '30px'; // Tambahkan margin-right di sini
            div.innerHTML = `
            <div>
    <label>
        <input type="checkbox" id="toggle-wisata" checked> 
        <img src='/assets-baru/img/icon_wisata.png' alt="Ikon Wisata" style='width:20px;height:25px;'/> 
        <?php echo lang('Blog.btnWisata'); ?> : 
        <span id="wisata-count" style='color: blue;'>0</span>
    </label>
</div>
<div>
    <label>
        <input type="checkbox" id="toggle-oleh-oleh" checked> 
        <img src='/assets-baru/img/icon_oleholeh.png' alt="Ikon Oleh-Oleh" style='width:20px;height:25px;'/> 
        <?php echo lang('Blog.btnOleholeh'); ?> : 
        <span id="oleh-oleh-count" style='color: blue;'>0</span>
    </label>
</div>

        `;

            // Event listener untuk checkbox
            L.DomEvent.on(div.querySelector('#toggle-wisata'), 'change', function(e) {
                if (e.target.checked) {
                    map.addLayer(wisataCluster);
                } else {
                    map.removeLayer(wisataCluster);
                }
            });

            L.DomEvent.on(div.querySelector('#toggle-oleh-oleh'), 'change', function(e) {
                if (e.target.checked) {
                    map.addLayer(olehOlehCluster);
                } else {
                    map.removeLayer(olehOlehCluster);
                }
            });

            return div;
        },
        onRemove: function(map) {
            // Do nothing
        }
    });

    L.control.infoPanel = function(opts) {
        return new InfoPanelControl(opts);
    };

    L.control.infoPanel({
        position: 'topright' // Posisikan di kanan atas
    }).addTo(map);

    // Tambahkan marker untuk setiap tempat wisata ke cluster
    // Fungsi untuk menghapus tag HTML
    function stripHtmlTags(text) {
        const div = document.createElement('div');
        div.innerHTML = text;
        return div.textContent || div.innerText || "";
    }

    // Tambahkan marker untuk setiap tempat wisata ke cluster
    // Assuming you have a `lang` variable or session that stores the current language, e.g., 'en' for English, 'id' for Indonesian
    // Retrieve the current language from the PHP session and store it in a JavaScript variable
    var lang = '<?= session('lang') ?>'; // This gets the current language from the PHP session

    // Iterate through each 'wisata' data
    wisataData.forEach(function(wisata) {
        // Limit description based on the selected language


        var marker = L.marker([wisata.wisata_latitude, wisata.wisata_longitude], {
                icon: wisataIcon
            })
            .bindPopup(
                `<div style="text-align: center;"> <!-- Centering div -->
                <img 
    src="/asset-user/uploads/foto_wisata/${wisata.foto_wisata}" 
    alt="${lang === 'en' ? wisata.nama_wisata_eng : wisata.nama_wisata_ind}" 
    style="width:200px; height:200px; margin-bottom: 5px; object-fit: cover;" 
    onerror="this.onerror=null; this.src='/assets-baru/img/error_logo1.png';"
/>

            </div>
            <strong>${lang === 'en' ? wisata.nama_wisata_eng : wisata.nama_wisata_ind}</strong><br>
            ${wisata.nama_kotakabupaten}, ${wisata.nama_provinsi}
            
            <a href="<?= base_url() ?>${lang === 'en' ? 'en' : 'id'}/${lang === 'en' ? 'destination' : 'wisata'}/detail/${lang === 'en' ? wisata.slug_wisata_eng : wisata.slug_wisata_ind}" class="popup-button" target="_blank">
        ${lang === 'en' ? 'Learn More' : 'Selengkapnya'}
            </a>
            <a href="https://www.google.com/maps/dir/?api=1&destination=${wisata.wisata_latitude},${wisata.wisata_longitude}" target="_blank" class="popup-button">${lang === 'en' ? 'Get Directions' : 'Petunjuk Arah'}</a>`
            )
            .on('click', function() {
                map.setView(this.getLatLng(), 15, {
                    animate: true,
                    duration: 1
                });

                // Offset to ensure the popup is centered when zoomed
                var popup = this.getPopup();
                var offset = map.getSize().y * 0.5; // Add 50% offset from the top of the screen
                map.panBy([0, -offset], {
                    animate: true,
                    duration: 1
                });

                this.openPopup();
            });

        wisataCluster.addLayer(marker); // Add marker to cluster
    });

    // Function to remove HTML tags
    function stripHtmlTags(text) {
        const div = document.createElement('div');
        div.innerHTML = text;
        return div.textContent || div.innerText || "";
    }



    // Tambahkan marker untuk setiap oleh-oleh ke cluster
    // Assuming you have a session or variable to detect the current language
    var lang = '<?= session('lang') ?>'; // This retrieves the current language

    olehOlehData.forEach(function(olehOleh) {


        var marker = L.marker([olehOleh.oleholeh_latitude, olehOleh.oleholeh_longitude], {
                icon: olehOlehIcon
            })
            .bindPopup(
                `<div style="text-align: center;"> <!-- Centering div -->
                <img 
    src="/asset-user/uploads/foto_wisata/${olehOleh.foto_oleholeh}" 
    alt="${lang === 'en' ? olehOleh.nama_oleholeh_eng : olehOleh.nama_oleholeh}" 
    style="width:200px; height:200px; margin-bottom: 5px; object-fit: cover;" 
    onerror="this.onerror=null; this.src='/assets-baru/img/error_logo1.png';"
/>

            </div>
            <strong>${lang === 'en' ? olehOleh.nama_oleholeh_eng : olehOleh.nama_oleholeh}</strong><br>
            ${olehOleh.nama_kotakabupaten}, ${olehOleh.nama_provinsi}<br>
            
            <a href="<?= base_url() ?>${lang === 'en' ? 'en' : 'id'}/${lang === 'en' ? 'souvenirs' : 'oleh-oleh'}/${lang === 'en' ? olehOleh.slug_en : olehOleh.slug_oleholeh}" class="popup-button" target="_blank">
        ${lang === 'en' ? 'Learn More' : 'Selengkapnya'}
            </a>
            <a href="https://www.google.com/maps/dir/?api=1&destination=${olehOleh.oleholeh_latitude},${olehOleh.oleholeh_longitude}" target="_blank" class="popup-button">${lang === 'en' ? 'Get Directions' : 'Petunjuk Arah'}</a>`
            )
            .on('click', function() {
                map.setView(this.getLatLng(), 15, {
                    animate: true,
                    duration: 1
                });

                // Offset untuk memastikan popup berada di tengah saat di-zoom
                var popup = this.getPopup();
                var offset = map.getSize().y * 0.5; // Menambahkan offset 25% dari atas layar
                map.panBy([0, -offset], {
                    animate: true,
                    duration: 1
                });

                this.openPopup();
            });

        olehOlehCluster.addLayer(marker); // Tambahkan ke cluster
    });


    // Tambahkan layer cluster ke peta
    map.addLayer(wisataCluster);
    map.addLayer(olehOlehCluster);

    // Perbarui jumlah tempat wisata dan oleh-oleh
    updateCount();

    function searchLocation() {
        var input = document.getElementById("searchInput").value.trim();
        var location = [...wisataData, ...olehOlehData].find(w =>
            (w.nama_wisata_ind && w.nama_wisata_ind.toLowerCase() === input.toLowerCase()) ||
            (w.nama_oleholeh && w.nama_oleholeh.toLowerCase() === input.toLowerCase())
        );

        if (location) {
            var lat = location.wisata_latitude || location.oleholeh_latitude;
            var lng = location.wisata_longitude || location.oleholeh_longitude;

            // Zoom ke lokasi pencarian
            map.flyTo([lat, lng], 15, {
                animate: true,
                duration: 1
            });

            // Hapus marker pencarian lama jika ada
            if (currentSearchMarker) {
                map.removeLayer(currentSearchMarker);
            }

            // Buat marker baru
            currentSearchMarker = L.marker([lat, lng]).addTo(map);

            // Buat konten untuk popup
            var content = '';
            var descriptionLimited = '';

            // Assuming you have a session or variable to detect the current language
            var lang = '<?= session('lang') ?>'; // This retrieves the current language

            // If the location is a wisata, display the wisata details in the desired format
            if (location.nama_wisata_ind) {


                // Set the default image URL
                var defaultImage = '/assets-baru/img/error_logo1.png';
                // Check if the wisata image exists, use the default image if it doesn't
                var imageUrl = location.foto_wisata ? `/asset-user/uploads/foto_wisata/${location.foto_wisata}` : defaultImage;

                var content = `
        <div style="text-align: center;"> <!-- Centering div -->
            <img 
    src="${imageUrl}" 
    alt="${lang === 'en' ? location.nama_wisata_eng : location.nama_wisata_ind}" 
    style="width:200px; height:200px; margin-bottom: 5px; object-fit: cover;" 
    onerror="this.onerror=null; this.src='/assets-baru/img/error_logo1.png';"
/><br>

        </div>
        <strong>${lang === 'en' ? location.nama_wisata_eng : location.nama_wisata_ind}</strong><br>
        ${location.nama_kotakabupaten}, ${location.nama_provinsi}<br>
        
        <a href="<?= base_url() ?>${lang === 'en' ? 'en' : 'id'}/${lang === 'en' ? 'destination' : 'wisata'}/detail/${lang === 'en' ? location.slug_wisata_eng : location.slug_wisata_ind}" class="popup-button" target="_blank">
            ${lang === 'en' ? 'Learn More' : 'Selengkapnya'}
        </a>
        <a href="https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}" target="_blank" class="popup-button">${lang === 'en' ? 'Get Directions' : 'Petunjuk Arah'}</a>
    `;
            }


            // Jika lokasi adalah oleh-oleh, tampilkan detail oleh-oleh dengan format yang diinginkan
            else if (location.nama_oleholeh) {
                // Determine the description and title based on the selected language

                var title = lang === 'en' ? location.nama_oleholeh_eng : location.nama_oleholeh;

                content = `
    <div style="text-align: center;"> <!-- Centering div -->
        <img 
    src="/asset-user/uploads/foto_wisata/${location.foto_oleholeh}" 
    alt="${title}" 
    style="width:200px; height:200px; margin-bottom: 5px; object-fit: cover;" 
    onerror="this.onerror=null; this.src='/assets-baru/img/error_logo1.png';"
/><br>

    </div>
    <strong>${title}</strong><br>
    ${location.nama_kotakabupaten}, ${location.nama_provinsi}<br>
    
    <a href="<?= base_url() ?>${lang === 'en' ? 'en' : 'id'}/${lang === 'en' ? 'souvenirs' : 'oleh-oleh'}/${lang === 'en' ? location.slug_en : location.slug_oleholeh}" class="popup-button" target="_blank">
            ${lang === 'en' ? 'Learn More' : 'Selengkapnya'}
        </a>
    <a href="https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}" target="_blank" class="popup-button">${lang === 'en' ? 'Get Directions' : 'Petunjuk Arah'}</a>
    `;
            }


            // Tambahkan konten ke marker dan buka popup
            currentSearchMarker.bindPopup(content).openPopup();

            // Menambahkan offset untuk memastikan popup berada di tengah saat di-zoom
            var offset = map.getSize().y * 0.5; // Menambahkan offset 5% dari atas layar
            map.panBy([0, -offset], {
                animate: true,
                duration: 1
            });
        } else {
            // Menangani situasi ketika tidak ada lokasi yang ditemukan
            alert("Lokasi tidak ditemukan. Silakan coba lagi.");
        }
    }

    // Fungsi autocomplete
    function showAutocomplete(value) {
        var autocompleteList = document.getElementById("autocomplete-list");
        autocompleteList.innerHTML = '';
        var searchString = value.toLowerCase();

        if (searchString.length > 0) {
            var filteredData = [...wisataData, ...olehOlehData].filter(function(item) {
                return (item.nama_wisata_ind && item.nama_wisata_ind.toLowerCase().includes(searchString)) ||
                    (item.nama_oleholeh && item.nama_oleholeh.toLowerCase().includes(searchString));
            });

            filteredData.forEach(function(item) {
                var div = document.createElement("div");
                var name = item.nama_wisata_ind || item.nama_oleholeh;
                div.innerHTML = name;
                div.addEventListener("click", function() {
                    document.getElementById("searchInput").value = name;
                    autocompleteList.innerHTML = '';
                    searchLocation();
                });
                autocompleteList.appendChild(div);
            });
        }
    }

    document.addEventListener('click', function(e) {
        if (!document.querySelector('.search-container').contains(e.target)) {
            document.getElementById("autocomplete-list").innerHTML = '';
        }
    });
</script>
</div>
