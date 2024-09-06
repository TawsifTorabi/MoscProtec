<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpenStreetMap Heatmap</title>
    <!-- Include Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Include Leaflet Heatmap Plugin -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>
    <style>
        #map {
            height: 100vh;
            width: 100%;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <script>
        async function initMap() {
            // Initialize the map
            const map = L.map('map').setView([0, 0], 2); // Set default center (customize as needed)

            // Add OpenStreetMap tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Fetch location data from the server
            const response = await fetch("<?= site_url('/user/heatmap/getLocations'); ?>");
            const data = await response.json();

            // Convert data to heatmap format
            const heatmapData = data.map(loc => [loc.latitude, loc.longitude, 0.5]); // Third value is intensity (0.0 to 1.0)

            // Create a heatmap layer
            L.heatLayer(heatmapData, {
                radius: 20,    // Adjust the radius
                blur: 15,      // Adjust the blur
                maxZoom: 17,   // Adjust the max zoom
            }).addTo(map);
        }

        // Initialize the map
        window.onload = initMap;
    </script>
</body>
</html>
