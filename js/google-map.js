function initMap() {
    var myLatlng = new google.maps.LatLng(-8.182031997533857, 113.69144491600575);
    
    var mapOptions = {
        zoom: 7,
        center: myLatlng,
        scrollwheel: false,
        styles: [
            {
                "featureType": "administrative.country",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "hue": "#ff0000"
                    }
                ]
            }
        ]
    };

    var mapElement = document.getElementById('map');
    var map = new google.maps.Map(mapElement, mapOptions);
    
    var addresses = ['New York'];

    for (var x = 0; x < addresses.length; x++) {
        (function(address) {
            fetch('https://maps.googleapis.com/maps/api/geocode/json?address=' + address + '&sensor=false')
              .then(response => response.json())
              .then(data => {
                var p = data.results[0].geometry.location;
                var latlng = new google.maps.LatLng(p.lat, p.lng);
                new google.maps.Marker({
                  position: latlng,
                  map: map,
                  icon: 'images/loc.png'
                });
              })
              .catch(error => console.error('Error fetching geocode:', error));
          })(addresses[x]);
          
    }
}

// Memuat Google Maps API dengan async
var script = document.createElement('script');
script.src = 'https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap&loading=async';
script.defer = true;
script.async = true;
document.head.appendChild(script);
