<?php
session_start();
require('inpro/db.php');
if (isset($_REQUEST["gate"])) {
  $timestamp = time();
  $_SESSION['lastModified'] = date('Y-m-d H:i', $timestamp);

  $query = "UPDATE gates_info SET status = :status, last_modified = :timestamp WHERE gate = :gate";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':status', $_REQUEST["status"]);
  $stmt->bindParam(':timestamp', $_SESSION['lastModified']);
  $stmt->bindParam(':gate', $_REQUEST["gate"]);

  $stmt->execute();
}
?>
<html>
<head>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <style>
    header {
  background-color: #0e5108;
  color: #070707;
  padding: 4px; /* Adjust the padding value to make the header smaller */
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
}

header .logo img {
  width: 40px; /* Adjust the width of the logo image */
  height: 40px; /* Adjust the height of the logo image */
}
/* الخط لملف txt*/
    .small-text {
      font-size: 12px; /* Adjust the font size as desired */
    }
    #map {
     /*width: 94vw;  100% of the viewport width 
      margin: 20px auto 0;  Add margin at the top to create space below the header 
      background-color: #f2f2f2;
      position: relative;
      overflow: hidden;*/
      /*height: 550px; */

      height: 550px; /*800px; /* Adjust the height as needed */ /* تغيير حجم الخريطه*/ 
      width: 98%; /* Adjust the width as needed */
      margin: 0 auto;
      max-width: 1500px;
      text-align: center;
      position: relative;
      overflow: hidden;

    }

    #map img {
      width: 100%; /* Cover the entire width of the container */
      height: auto;
      display: block;
      margin: 0 auto; /* Center the image horizontally */
    }

  
  
    footer {
  position: relative;
  bottom: 0;
  width: 100%;
  background-color: #0e5108;
  color: #fff;
  padding: 5px;
  text-align: center;
  z-index: 1;
}
  
    
    .notification {
      display: none;
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      padding: 10px;
      background-color: #333;
      color: #fff;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      z-index: 999;
    }

    .b {
      display: block;
      width: 100%;
      padding: 10px;
      font-size: 16px;
      color: #fff;
      background-color: darkgreen;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-color:#faf8f6 ;
    }

    .dot {
      width: 40px; /* Adjust the width as needed for the rectangle */
      height: 10px; /* Adjust the height as needed for the rectangle */
      position: absolute;
    }
    .dot span{
      position: relative;
      top: -20px;
      font-size: 0.75em;
    }

    .Gate1 {
      top: 30%; /* Adjust the top position for the red rectangle */
      left: 58%; /* Adjust the left position for the red rectangle */
    }

    .Gate2 {
      top:  59%; /* Adjust the top position for the orange rectangle */
      left: 49%; /* Adjust the left position for the orange rectangle */
    }

    .Gate3 {
      top: 73%; /* Adjust the top position for the green rectangle */
      left: 58%; /* Adjust the left position for the green rectangle */
    }

    .button-container {
  display: flex;
  gap: 10px;
  flex-direction: row;
}

.button-row {
  display: flex;
  justify-content: center;
  gap: 10px;
 
}

.button {
  padding: 10px 20px;
  color: #fff;
  font-weight: bold;
  cursor: pointer;
  border-radius: 49pt;
  text-align: center;
  margin: 0 auto;
  display: inline-block;
  width: 70px;
  margin-top: 10px; /* Adjust this value to move the buttons lower */

}

.close-gate {
  background-color: red;
  text-align: center;
  align-items: center;
}

.open-gate {
  background-color: green;
  text-align: center;
  align-items: center;
}
.areas_text{
  display: flex;
  flex-direction: row;
  margin-bottom: 20px;
  grid-column-gap: 10px; /* Adjust this value as needed for the desired space between columns */
  grid-row-gap: 10px;
}
/* .region_status_text{
  display: grid;
  grid-template-columns: auto auto ;
  width: 30%;
  border-radius: 5px;
  border: 2px solid black;
  padding: 0.25em;
  overflow: scroll;
  align-items: center;
  height: 3.5em;
  font-size: 0.75em;
} */
.region_status_text {
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* Three equal columns */
  width: 5%; /* Adjust width as needed */
  border-radius: 5px;
  border: 2px solid black;
  padding: 0.25em;
  overflow: scroll;
  align-items: center;
  font-size: 0.75em;
  margin-bottom: 10px;
}

.region_status_text > * {
  aspect-ratio: 1/1; /* Ensures square shape */
  width: 15px; /* Adjust width as needed for smaller boxes */
  height: 15px; /* Adjust height to maintain square shape */
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
}

.region_status_text::before {
  content: "";
  display: block;
  padding-top: 100%;
}

.region_status_text p {
  margin: 0;
}
.ar
.areas_text h2{
  margin-block-start: 0.3em;
    margin-block-end: 0.3em;
    /* margin-top: 1.5em; */
    margin-right: 1em;
    }
    
  </style>
  <header>
    <nav class="menu-links">
      <!-- <a href="tt.html" data-hover-text="Services">Ø§Ù„ØµÙ�Ø­Ù‡ Ø§Ù„Ø±Ø¦ÙŠØ³ÙŠÙ‡</a> -->
      <!-- <a href="tt.html">عن مسير</a>-->
    </nav>
    <div class="logo">
      <img src="maseer.jpeg" alt="Logo">
    </div>
  </header>
      <meta http-equiv="refresh" content="1800"> 

      <div class="areas_text">
  <h4>Region Status:</h4>

  <div class="region_status_text ">
    <?php
    $filename = '/Applications/XAMPP/xamppfiles/htdocs/inpro/results/Cam1.txt';
    if (file_exists($filename)) {
        $lines = file($filename);
        foreach ($lines as $line) {
            echo '<div class="box">' . $line . '</div>';
        }
    } else {
        echo "The file '$filename' does not exist.";
    }
    ?>
  </div>
  <div class="region_status_text">
    <?php
    $filename = '/Applications/XAMPP/xamppfiles/htdocs/inpro/results/Cam2.txt';
    if (file_exists($filename)) {
        $lines = file($filename);
        foreach ($lines as $line) {
            echo '<div class="box">' . $line  . '</span> '.'</div>';
        }
    } else {
        echo "The file '$filename' does not exist.";
    }
    ?>
    
  </div>
  <div class="region_status_text">
    <?php
    $filename = '/Applications/XAMPP/xamppfiles/htdocs/inpro/results/Cam3.txt';
    if (file_exists($filename)) {
        $lines = file($filename);
        foreach ($lines as $line) {
            echo '<div class="box">' . $line . '</div>';
        }
    } else {
        echo "The file '$filename' does not exist.";
    }
    ?>
    
  </div>
</div>
  <div id="map" class="mapx"></div> 

  <div id="map1" class="map">
    <!--<img src="Screenshot 2023-12-12 at 11.43.02 PM.png" alt="Custom Map Image" style="width: 100%; display: block; margin: 0 auto;">-->
    <?php
      $query = "SELECT * FROM `gates_info`";
      $stmt = $pdo->prepare($query);
      $stmt->execute();
      $gates_info_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($gates_info_rows as $row):  ;?>
        <div class="dot <?php $gate = $row['gate']; $gate =str_replace(' ', '', $gate); echo $gate; ?>" style="background-color:<?php echo ($row["status"] == 'closed') ? "red" : "green"; ?>"><span><?php  echo $row['gate']; ?></span></div>
      <?php endforeach; ?>
  </div>

  <div class="button-container">
    <div class="button close-gate" onclick="showGateMenu('closed')">إغلاق البوابة</div>
    <div class="button open-gate" onclick="showGateMenu('opened')">فتح البوابة</div>
  </div> 
  <div class="notification" id="notification">
   تم <span id="notification-status"></span>.
  </div>

  <footer>
    &copy; 2023 F27. All rights reserved.
  </footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
  // <script src="inpro/Adminpage.php/crowded_areas.js">
  axios.get('/read-file')
      .then(function(response) {
        alert(response.data);
      })
      .catch(function(error) {
        console.log(error);
      });



  
  function save_gates(gate, status){
        var chrURL = "save_gates.php";
        var params = {"gate":gate, "status":status };
        $.post(chrURL, params, function(chrResponse){
            location.reload();
       });
  }
    
 // Function to get the gate status from localStorage
function getGateStatus() {
  const storedStatus = localStorage.getItem('gateStatus');

  try {
    // Try to parse the stored data as JSON
    const parsedStatus = JSON.parse(storedStatus);

    // Check if the parsed data is an object with the expected properties
    if (
      parsedStatus &&
      typeof parsedStatus === 'object' &&
      'Gate 1' in parsedStatus &&
      'Gate 2' in parsedStatus &&
      'Gate 3' in parsedStatus
    ) {
      return parsedStatus;
    }
  } catch (error) {
    // If there's an error parsing or the data is not valid, remove the local storage entry
    localStorage.removeItem('gateStatus');
  }

  // If the data is not valid or there's an error, return a default status
  return {
    'Gate 1': 'closed',
    'Gate 2': 'closed',
    'Gate 3': 'closed'
  };
}

  // Function to set the gate status to localStorage
  function setGateStatus(status) {
    localStorage.setItem('gateStatus', JSON.stringify(status));
  }

  // Initialize gateStatus from localStorage
  let gateStatus = getGateStatus();

  function showGateMenu(action) {
  const gateToToggle = prompt('Choose a gate to ' + action + ': Gate 1, Gate 2, Gate 3');
  console.log('Selected Gate:', gateToToggle);
  console.log('Current Gate Status:', gateStatus);

  if (gateToToggle && gateStatus.hasOwnProperty(gateToToggle)) {
    const confirmation = window.confirm(`Are you sure you want to ${action} the ${gateToToggle} gate?`);
    if (confirmation) {
      gateStatus[gateToToggle] = action;
      setGateStatus(gateStatus); // Save to localStorage
      notifyUser(gateToToggle, gateStatus[gateToToggle]);
    } else {
      alert('Invalid gate choice. Please choose from Gate 1, Gate 2, or Gate 3.');
    }
  } 
}


  function notifyUser(gate, status) {
    save_gates(gate, status);
    console.log(gate);// Gate 1, Gate 2, Gate 3
    console.log(status);//opened,closed
        
    const notification = document.getElementById('notification');
    const notificationStatus = document.getElementById('notification-status');

    if (status === 'closed') {
      notificationStatus.textContent = ' اغلاق البوابة';
      notification.style.backgroundColor = 'red';
      updateDotColor(gate, 'red');
    } else if (status === 'opened') {
      notificationStatus.textContent = ' فتح البوابة';
      notification.style.backgroundColor = 'green';
      updateDotColor(gate, 'green');
    }

    notification.style.display = 'block';

    setTimeout(() => {
      notification.style.display = 'none';
    }, 3000); // Hide the notification after 3 seconds
  }

  function updateDotColor(gate, color) {
    const dot = document.querySelector(`.${gate}`);
    dot.style.backgroundColor = color;
  }
</script>



<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNZluJtOoU34fHOh_ECxIoNJnEnlOba0E&callback=initMap&v=weekly"
      defer
    ></script>  
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script>
    // function initMap() {
    //   const center = new google.maps.LatLng(21.413056, 39.892222);
    //   const map = new google.maps.Map(document.getElementById("map"), {
    //     zoom: 15,
    //     zoomControl: false,
    //     center: center,
    //     gestureHandling: "none", 
    //   });
      // const svgMarker = {
      //   path: "M-1.547 12l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM0 0q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
      //   fillColor: "blue",
      //   fillOpacity: 0.6,
      //   strokeWeight: 0,
      //   rotation: 0,
      //   scale: 2,
      //   anchor: new google.maps.Point(0, 20),
      // };

      new google.maps.Marker({
        position: map.getCenter(),
        icon: svgMarker,
        map: map,
      });
    }

    window.initMap = initMap;
    </script>
</body>

</html>