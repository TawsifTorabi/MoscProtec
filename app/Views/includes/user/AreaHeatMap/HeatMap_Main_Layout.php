    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <!-- <div class="col-lg-13 mb-4 order-0">
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-4">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">Congratulations John! 🎉</h5>
                                    <p class="mb-4">
                                        You have done <span class="fw-bold">72%</span> more sales today. Check your new badge in
                                        your profile.
                                    </p>

                                    <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- Total Revenue -->
                <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                    <div class="card">
                        <div class="row row-bordered g-0">
                            <div class="col-md-8">
                                <h5 class="card-header m-0 me-2 pb-3">Mosquito Risk Zones</h5>
                                <div class="search-container">
                                    <input type="text" id="location-input" placeholder="Search for locations...">
                                    <div id="suggestions">
                                        <ul id="suggestion-list"></ul>
                                    </div>
                                </div>
                            </div>

                            <div id="map"></div>
                            <script>
                                let map, heatmapLayer, marker;
                                let debounceTimeout; // Global variable to handle the debounce timer

                                async function initMap() {
                                    // Initialize the map
                                    map = L.map('map').setView([0, 0], 2); // Default center

                                    // Add OpenStreetMap tile layer
                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        maxZoom: 18,
                                        attribution: '&copy; OpenStreetMap contributors'
                                    }).addTo(map);

                                    // Request user's location and center the map
                                    if (navigator.geolocation) {
                                        navigator.geolocation.getCurrentPosition(position => {
                                            const userLat = position.coords.latitude;
                                            const userLng = position.coords.longitude;
                                            map.setView([userLat, userLng], 13); // Center map on user's location
                                        }, () => {
                                            console.log("Location access denied.");
                                        });
                                    } else {
                                        console.log("Geolocation is not supported by this browser.");
                                    }

                                    let markerLat, markerLng;

                                    // Create a heatmap layer
                                    heatmapLayer = L.heatLayer([], {
                                        radius: 20,
                                        blur: 15,
                                        maxZoom: 17
                                    }).addTo(map);

                                    await loadHeatmapData();
                                }

                                async function loadHeatmapData() {
                                    const response = await fetch("<?= site_url('user/heatmap/getLocations'); ?>");
                                    const data = await response.json();

                                    // Convert data to heatmap format
                                    const heatmapData = data.map(loc => [loc.latitude, loc.longitude, 0.5]); // Adjust intensity

                                    // Update heatmap layer
                                    heatmapLayer.setLatLngs(heatmapData);

                                    // Adjust the map bounds to fit the heatmap data
                                    if (heatmapData.length > 0) {
                                        const bounds = L.latLngBounds(heatmapData.map(loc => [loc[0], loc[1]]));
                                        map.fitBounds(bounds);
                                    }
                                }

                                // Debounce function to delay the execution of the search
                                function debounce(func, delay) {
                                    return function() {
                                        const context = this;
                                        const args = arguments;
                                        clearTimeout(debounceTimeout);
                                        debounceTimeout = setTimeout(() => func.apply(context, args), delay);
                                    };
                                }

                                // Function to fetch suggestions from OpenStreetMap API
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
                                    map.setView([lat, lng], 14); // Move to selected location
                                    document.getElementById('location-input').value = name;
                                    document.getElementById('suggestions').style.display = 'none';
                                    marker = new L.marker([lat, lng]).addTo(map)
                                        .bindPopup(name)
                                        .openPopup();
                                }

                                // Initialize the map
                                window.onload = initMap;

                                // Attach the debounce function to the search input, delaying the fetch by 300 milliseconds
                                document.getElementById('location-input').addEventListener('input', debounce(fetchSuggestions, 400));
                            </script>

                            <!-- <div class="col-md-4">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                type="button"
                                                id="growthReportId"
                                                data-bs-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false">
                                                2022
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                                                <a class="dropdown-item" href="javascript:void(0);">2021</a>
                                                <a class="dropdown-item" href="javascript:void(0);">2020</a>
                                                <a class="dropdown-item" href="javascript:void(0);">2019</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="growthChart"></div>
                                <div class="text-center fw-semibold pt-3 mb-2">62% Company Growth</div>

                                <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                                    <div class="d-flex">
                                        <div class="me-2">
                                            <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <small>2022</small>
                                            <h6 class="mb-0">$32.5k</h6>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="me-2">
                                            <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <small>2021</small>
                                            <h6 class="mb-0">$41.2k</h6>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <!--/ Total Revenue -->
                <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                    <div class="row">
                        <div class="col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="../assets/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded" />
                                        </div>
                                        <div class="dropdown">
                                            <button
                                                class="btn p-0"
                                                type="button"
                                                id="cardOpt4"
                                                data-bs-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="d-block mb-1">Nearby Report</span>
                                    <h3 class="card-title text-nowrap mb-2">15</h3>
                                    <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -14.82%</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="../assets/img/icons/unicons/cc-primary.png" alt="Credit Card" class="rounded" />
                                        </div>
                                        <div class="dropdown">
                                            <button
                                                class="btn p-0"
                                                type="button"
                                                id="cardOpt1"
                                                data-bs-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1">Total Report</span>
                                    <h3 class="card-title mb-2">150</h3>
                                    <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.14%</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                        <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                            <div class="card-title">
                                                <h5 class="text-nowrap mb-2">Heatzone Report Stat</h5>
                                                <span class="badge bg-label-warning rounded-pill">Year 2024</span>
                                            </div>
                                            <div class="mt-sm-auto">
                                                <small class="text-success text-nowrap fw-semibold"><i class="bx bx-chevron-up"></i> 68.2%</small>
                                                <h3 class="mb-0">240</h3>
                                            </div>
                                        </div>
                                        <div id="profileReportChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-5 col-xl-12">
                                <div class="card h-100">
                                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                                        <div class="card-title mb-0">
                                            <h5 class="m-0 me-2">Heatzone Statistics</h5>
                                            <small class="text-muted">42k Total Pointer</small>
                                        </div>
                                        <div class="dropdown">
                                            <button
                                                class="btn p-0"
                                                type="button"
                                                id="orederStatistics"
                                                data-bs-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                                                <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Share</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--  -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <!-- Order Statistics -->
                >
                <!--/ Order Statistics -->

                <!-- Expense Overview -->
                <!-- <div class="col-md-6 col-lg-4 order-1 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <ul class="nav nav-pills" role="tablist">
                                <li class="nav-item">
                                    <button
                                        type="button"
                                        class="nav-link active"
                                        role="tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#navs-tabs-line-card-income"
                                        aria-controls="navs-tabs-line-card-income"
                                        aria-selected="true">
                                        Income
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab">Expenses</button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab">Profit</button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body px-0">
                            <div class="tab-content p-0">
                                <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                                    <div class="d-flex p-4 pt-3">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <img src="../assets/img/icons/unicons/wallet.png" alt="User" />
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Total Balance</small>
                                            <div class="d-flex align-items-center">
                                                <h6 class="mb-0 me-1">$459.10</h6>
                                                <small class="text-success fw-semibold">
                                                    <i class="bx bx-chevron-up"></i>
                                                    42.9%
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="incomeChart"></div>
                                    <div class="d-flex justify-content-center pt-4 gap-2">
                                        <div class="flex-shrink-0">
                                            <div id="expensesOfWeek"></div>
                                        </div>
                                        <div>
                                            <p class="mb-n1 mt-1">Expenses This Week</p>
                                            <small class="text-muted">$39 less than last week</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!--/ Expense Overview -->

                <!-- Transactions -->
                <!-- <div class="col-md-6 col-lg-4 order-2 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Transactions</h5>
                            <div class="dropdown">
                                <button
                                    class="btn p-0"
                                    type="button"
                                    id="transactionID"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                                    <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="p-0 m-0">
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <img src="../assets/img/icons/unicons/paypal.png" alt="User" class="rounded" />
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <small class="text-muted d-block mb-1">Paypal</small>
                                            <h6 class="mb-0">Send money</h6>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <h6 class="mb-0">+82.6</h6>
                                            <span class="text-muted">USD</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <img src="../assets/img/icons/unicons/wallet.png" alt="User" class="rounded" />
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <small class="text-muted d-block mb-1">Wallet</small>
                                            <h6 class="mb-0">Mac'D</h6>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <h6 class="mb-0">+270.69</h6>
                                            <span class="text-muted">USD</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <img src="../assets/img/icons/unicons/chart.png" alt="User" class="rounded" />
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <small class="text-muted d-block mb-1">Transfer</small>
                                            <h6 class="mb-0">Refund</h6>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <h6 class="mb-0">+637.91</h6>
                                            <span class="text-muted">USD</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <img src="../assets/img/icons/unicons/cc-success.png" alt="User" class="rounded" />
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <small class="text-muted d-block mb-1">Credit Card</small>
                                            <h6 class="mb-0">Ordered Food</h6>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <h6 class="mb-0">-838.71</h6>
                                            <span class="text-muted">USD</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <img src="../assets/img/icons/unicons/wallet.png" alt="User" class="rounded" />
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <small class="text-muted d-block mb-1">Wallet</small>
                                            <h6 class="mb-0">Starbucks</h6>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <h6 class="mb-0">+203.33</h6>
                                            <span class="text-muted">USD</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <img src="../assets/img/icons/unicons/cc-warning.png" alt="User" class="rounded" />
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <small class="text-muted d-block mb-1">Mastercard</small>
                                            <h6 class="mb-0">Ordered Food</h6>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <h6 class="mb-0">-92.45</h6>
                                            <span class="text-muted">USD</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> -->
                <!--/ Transactions -->
            </div>
        </div>
        <!-- / Content -->