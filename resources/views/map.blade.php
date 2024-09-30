<!DOCTYPE html>
<html>

<head>
  <title>Clickable Markers with InfoWindows</title>
  <script src="https://maps.gomaps.pro/maps/api/js?key=AlzaSyWk97E2xHYkzIutsmGvUloBZQPC7Eqpw7b&callback=initMap" async
    defer></script>
  <style>
    #map {
      height: 400px;
      width: 100%;
    }
  </style>
</head>

<body>
  <h3>Google Map with Clickable Markers</h3>
  <div id="map"></div>

  <script>
    var map;
    var markers = [];
    var infoWindow;

    function initMap() {
      // Khởi tạo bản đồ với vị trí trung tâm
      var centerLocation = { lat: 21.00758683685569, lng: 105.8426435956797 }; // Vị trí Hồ Chí Minh
      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: centerLocation
      });

      // Tạo InfoWindow (cửa sổ thông tin) rỗng
      infoWindow = new google.maps.InfoWindow();

      // Danh sách các điểm đánh dấu 21.00758683685569, 105.8426435956797 21.007446616682614, 105.84446749779723
      var locations = [
        {
          position: { lat: 21.00758683685569, lng: 105.8426435956797 },
          title: "Đại học bách khoa",
          content: "1 đại cồ việt",
          openingHours: "08:00",
          closingHours: "17:00",
          imageUrl: "https://lh5.googleusercontent.com/p/AF1QipPZ_V3wEYFSRRO92G21nRcaH3znFLvAeyiy2N8T=w328-h130-p-k-no"
        },
        {
          position: { lat: 21.007446616682614, lng: 105.84446749779723 },
          title: "Mộc mobile",
          content: "Thủ đô Hà Nội.",
          openingHours: "08:00",
          closingHours: "17:00",
          imageUrl: "https://lh5.googleusercontent.com/p/AF1QipPZ_V3wEYFSRRO92G21nRcaH3znFLvAeyiy2N8T=w328-h130-p-k-no"
        }
      ];

      // Tạo các điểm đánh dấu và làm cho chúng có thể nhấp được
      locations.forEach(function (location) {
        var marker = new google.maps.Marker({
          position: location.position,
          map: map,
          title: location.title
        });

        // Lắng nghe sự kiện 'click' vào từng điểm đánh dấu
        marker.addListener('click', function () {
          infoWindow.close();

          // Nội dung cửa sổ thông tin, bao gồm giờ mở cửa và đóng cửa
          var contentString =
          '<img src="' + location.imageUrl + '" alt="' + location.title + '" style="width:100%; height:auto;">'+
            '<h3>' + location.title + '</h3>' +
            '<p>' + location.content + '</p>' +
            '<p><strong>Giờ mở cửa:</strong> ' + location.openingHours + '</p>' +
            '<p><strong>Giờ đóng cửa:</strong> ' + location.closingHours + '</p>' ;
          infoWindow.setContent(contentString);
          infoWindow.open(map, marker);
        });

        markers.push(marker);
      });
    }

  </script>
</body>

</html>
