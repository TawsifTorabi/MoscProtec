    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <!-- Total Revenue -->
                <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                    <div class="card">
                        <div class="row row-bordered g-0">
                            <div class="col-md-8">
                                <h5 class="card-header m-0 me-2 pb-3">Report Risk Zones</h5>
                                <div class="search-container">
                                    <input type="text" id="location-input" placeholder="Search for locations...">
                                    <div id="suggestions">
                                        <ul id="suggestion-list"></ul>
                                    </div>
                                </div>
                            </div>
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
                <!--/ Total Revenue -->
                <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                        <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                            <div class="card-title">
                                                <h5 class="text-nowrap mb-2">Report Form</h5>
                                            </div>
                                            <div class="mt-sm-auto">
                                                <!-- Form for submitting picked coordinates -->
                                                <form id="location-form" enctype="multipart/form-data" method="post" target="<?= base_url("/user/heatmap/reportLocation") ?>">
                                                    <div class="form-group mt-3">
                                                        <label for="description">Description:</label>
                                                        <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
                                                    </div>

                                                    <div class="form-group mt-3">
                                                        <label for="image">Upload Image:</label>
                                                        <input
                                                            name="images[]"
                                                            type="file"
                                                            id="basic-icon-default-images"
                                                            class="form-control"
                                                            accept="image/*"
                                                            multiple
                                                            onchange="previewMultipleImages(event)" />
                                                    </div>

                                                    <div class="form-group mt-3">
                                                        <button type="button" class="btn btn-primary" id="use-current-location">Get Current Location</button>
                                                    </div>

                                                    <input type="hidden" id="latitude" name="latitude">
                                                    <input type="hidden" id="longitude" name="longitude">
                                                    <button type="submit" class="btn btn-success mt-3">Submit</button>
                                                    <div id="progress-container" style="display: none; width: 100%; background-color: #f3f3f3; margin-top: 10px;">
                                                        <div id="progress-bar" style="width: 0%; height: 30px; background-color: #696cff; text-align: center; line-height: 30px; color: white;">
                                                            0%
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 row flex-wrap align-items-center" id="image-preview-container"></div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var isSubmitting = true;
            // Javascript to Submit form via XHR
            document.getElementById('location-form').addEventListener('submit', function(e) {
                e.preventDefault();

                if (isSubmitting) return; // Prevent multiple submissions
                isSubmitting = true;
                //validateForm();

                if (markerLat && markerLng) {
                    document.getElementById('latitude').value = markerLat;
                    document.getElementById('longitude').value = markerLng;
                } else if (userLat && userLng) {
                    document.getElementById('latitude').value = userLat;
                    document.getElementById('longitude').value = userLng;
                }

                
                // Show the progress bar when the form is submitted
                progressContainer.style.display = 'block';
                progressBar.style.width = '0%'; // Reset progress bar width
                progressBar.innerHTML = '0%';
                
                const xhr = new XMLHttpRequest();
                const formData = new FormData(form);

                xhr.open('POST', '<?= base_url("/user/heatmap/reportLocation") ?>', true);
               
                // Progress event to update progress bar
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const percentComplete = (e.loaded / e.total) * 100;
                        progressBar.style.width = percentComplete + '%';
                        progressBar.innerHTML = Math.round(percentComplete) + '%';
                    }
                });

                xhr.onload = function() {
                    isSubmitting = false;
                    validateForm();

                    // Hide the progress bar once the upload is complete
                    progressContainer.style.display = 'none';

                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        handleSubmissionResponse(response); // Call function on response
                    } else {
                        console.error('Error in form submission');
                        console.error(xhr.responseText); // Log the error response
                    }
                };

                xhr.onerror = function() {
                    console.error('Request failed');
                    isSubmitting = false;
                    //validateForm();
                    progressContainer.style.display = 'none'; // Hide progress bar on error
                };

                xhr.send(formData);
            });
        </script>

        <!-- JavaScript to handle multiple image previews with remove button -->
        <script>
            const imageInput = document.getElementById('basic-icon-default-images');
            const imagePreviewContainer = document.getElementById('image-preview-container');
            let selectedFiles = [];

            function previewMultipleImages(event) {
                const files = Array.from(event.target.files);

                // Clear previous previews
                imagePreviewContainer.innerHTML = '';
                selectedFiles = [...files]; // Update selected files

                files.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.readAsDataURL(file);

                    reader.onload = function(e) {
                        const imagePreviewDiv = document.createElement('div');
                        imagePreviewDiv.classList.add('col-3', 'col-sm-2', 'col-md-2', 'mb-3', 'image-card');

                        const cardDiv = document.createElement('div');
                        cardDiv.classList.add('imagecont', 'card', 'overflow-hidden');

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('imgview', 'img-fluid');

                        const removeButton = document.createElement('button');
                        removeButton.classList.add('remove-image');
                        removeButton.innerHTML = '&times;';
                        removeButton.onclick = () => removeImage(index);

                        cardDiv.appendChild(img);
                        cardDiv.appendChild(removeButton);
                        imagePreviewDiv.appendChild(cardDiv);
                        imagePreviewContainer.appendChild(imagePreviewDiv);
                    };
                });
            }


            function removeImage(index) {
                // Remove the image from the selected files array
                selectedFiles.splice(index, 1);

                // Create a new FileList object from the updated array
                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => dataTransfer.items.add(file));

                // Update the input's files to reflect the removed image
                imageInput.files = dataTransfer.files;

                // Re-trigger the image preview generation
                const event = new Event('change');
                imageInput.dispatchEvent(event);
            }
        </script>
        <script>
            let map, heatmapLayer, marker;
            let debounceTimeout;
            let markerLat, markerLng; // Store picked coordinates
            let userLat, userLng; // Store user's location

            async function initMap() {
                // Initialize the map
                map = L.map('map').setView([0, 0], 2);

                // Add OpenStreetMap tile layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 18,
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                // Request user's location and center the map
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(position => {
                        userLat = position.coords.latitude;
                        userLng = position.coords.longitude;
                        map.setView([userLat, userLng], 13);
                    }, () => {
                        console.log("Location access denied.");
                    });
                } else {
                    console.log("Geolocation is not supported by this browser.");
                }

                heatmapLayer = L.heatLayer([], {
                    radius: 20,
                    blur: 15,
                    maxZoom: 17
                }).addTo(map);
                //await loadHeatmapData();

                // Add click event listener to pick a location
                map.on('click', function(e) {
                    const lat = e.latlng.lat;
                    const lng = e.latlng.lng;

                    if (marker) {
                        map.removeLayer(marker); // Remove previous marker if any
                    }

                    // Set the new marker and show the location
                    marker = L.marker([lat, lng]).addTo(map)
                        .bindPopup(`Picked Location: ${lat}, ${lng}`)
                        .openPopup();

                    // Store the clicked coordinates
                    markerLat = lat;
                    markerLng = lng;

                    // Optionally, automatically fill the hidden inputs if you want to update them immediately
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                });
            }


            async function loadHeatmapData() {
                const response = await fetch("<?= site_url('user/heatmap/getLocations'); ?>");
                const data = await response.json();
                const heatmapData = data.map(loc => [loc.latitude, loc.longitude, 0.5]);
                heatmapLayer.setLatLngs(heatmapData);

                if (heatmapData.length > 0) {
                    const bounds = L.latLngBounds(heatmapData.map(loc => [loc[0], loc[1]]));
                    map.fitBounds(bounds);
                }
            }

            function debounce(func, delay) {
                return function() {
                    const context = this;
                    const args = arguments;
                    clearTimeout(debounceTimeout);
                    debounceTimeout = setTimeout(() => func.apply(context, args), delay);
                };
            }

            async function fetchSuggestions() {
                const query = document.getElementById('location-input').value;
                if (query.length < 2) {
                    document.getElementById('suggestions').style.display = 'none';
                    return;
                }

                const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`);
                const suggestions = await response.json();
                const suggestionList = document.getElementById('suggestion-list');
                suggestionList.innerHTML = '';

                suggestions.forEach(suggestion => {
                    const li = document.createElement('li');
                    li.textContent = `${suggestion.display_name}`;
                    li.onclick = () => moveToLocation(suggestion.lat, suggestion.lon, suggestion.display_name);
                    suggestionList.appendChild(li);
                });

                document.getElementById('suggestions').style.display = 'block';
            }

            function moveToLocation(lat, lng, name) {
                if (marker) {
                    map.removeLayer(marker);
                }
                markerLat = lat;
                markerLng = lng;
                map.setView([lat, lng], 14);
                document.getElementById('location-input').value = name;
                document.getElementById('suggestions').style.display = 'none';

                marker = L.marker([lat, lng]).addTo(map)
                    .bindPopup(name)
                    .openPopup();
            }

            // Use the current location when the button is clicked
            document.getElementById('use-current-location').addEventListener('click', () => {
                if (userLat && userLng) {
                    moveToLocation(userLat, userLng, 'Current Location');
                } else {
                    alert('Could not fetch your current location.');
                }
            });

            window.onload = initMap;
            document.getElementById('location-input').addEventListener('input', debounce(fetchSuggestions, 400));
        </script>
        <style>
            .image-card {
                position: relative;
                width: 100px;
                height: 100px;
                padding: 0;
                margin-right: 10px;
                margin-bottom: 10px;
            }

            .image-card img {
                object-fit: cover;
                height: 100%;
                width: 100%;
                border-radius: 13px;
            }

            .image-card .remove-image {
                position: absolute;
                top: 5px;
                right: 5px;
                background-color: rgba(255, 255, 255, 0.7);
                border: none;
                color: #696cff;
                font-weight: bold;
                border-radius: 50%;
                width: 20px;
                height: 20px;
                cursor: pointer;
            }

            .image-card .remove-image:hover {
                background-color: rgba(255, 0, 0, 0.7);
                color: white;
                border-radius: 13px;
            }

            .imagecont {
                height: 7em;
                box-shadow: 1px 1px 7px 0px #00000061;
                border-radius: 13px;
            }

            .imgview {
                border: 3px solid #696cff;
                border-radius: 13px;
            }
        </style>

        <!-- / Content -->