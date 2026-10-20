<?php
// Radio del área máximo, que queremos ver dentro del mapa 
$radio = 4000;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mapa a 4 km de mi ubicación</title>


    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        #mapa { height: 500px; width: 100%; background: white; }
    </style>
</head>
<body>

    <h1>Mi ubicación (área de <?php echo $radio / 1000; ?> km)</h1>

    <div id="mapa"></div>

    <script>
        var radio = <?php echo $radio; ?>;

        // Variable donde tenemos guardada y creada el mapa 
        var mapa = L.map('mapa').setView([40.4168, -3.7038], 5);

        // Cargamos imagen del mapa 
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(mapa);

        //Obtenemos nuestra ubicación
        navigator.geolocation.getCurrentPosition(
            function (posicion) {
                var lat = posicion.coords.latitude;
                var lng = posicion.coords.longitude;
                var centro = [lat, lng];

                // Marcador a mi ubicación
                L.marker(centro).addTo(mapa)
                    .bindPopup('Estás aquí')
                    .openPopup();

                // Dibujar el círculo del radio
                var circulo = L.circle(centro, {
                    radius: 50,
                    fill: false
                }).addTo(mapa);

                
                //Ajustar el zoom al círculo de mi ubicación y no permitir salir de esa zona
                var limites = circulo.getBounds();
                mapa.fitBounds(limites);
                mapa.setMaxBounds(limites);
                mapa.setMinZoom(mapa.getZoom());
            },
            function () {
                alert('No se pudo obtener tu ubicación. Revisa los permisos del navegador.');
            }
        );
    </script>

</body>
</html>