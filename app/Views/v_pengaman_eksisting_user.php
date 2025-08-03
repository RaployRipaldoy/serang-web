<div id="map" style="width: 100%; height: 100vh;"></div>

<script>
    const osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
	maxZoom: 19,
	attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });

	const openTopoMap = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
	maxZoom: 19,
	attribution: 'Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
    });

	const map = L.map('map', {
	center: [-6.0928869, 106.2070087],
	zoom: 13,
	layers: [osm, openTopoMap]
    });

	const baseLayers = {
	'Default': osm,
	'Topografi': openTopoMap
    };

	const layerControl = L.control.layers(baseLayers).addTo(map);
	
</script>