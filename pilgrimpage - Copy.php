<?php
session_start();
require('inpro/db.php');
if(isset($_REQUEST["gate"])){
   
}

$query = "SELECT * FROM `gates_info` limit 1";
$stmt = $pdo->prepare($query);
$stmt->execute();
$gates_info = $stmt->fetch(PDO::FETCH_ASSOC);
//print ($gates_info["red"]); die;
if(!isset($_SESSION['red'])){
    $_SESSION['red'] = $gates_info["red"];
    $_SESSION['orange']= $gates_info["orange"];
    $_SESSION['green']= $gates_info["green"];
}

$show_notify = 0;
if($_SESSION['red']!=$gates_info["red"] || $_SESSION['orange']!=$gates_info["orange"] || $_SESSION['green']!=$gates_info["green"] ){
    $show_notify = "";
    if($_SESSION['red']!=$gates_info["red"]){
        $show_notify .= "Red gate has been ".$gates_info["red"].". ";
    }
    if($_SESSION['orange']!=$gates_info["orange"]){
        $show_notify .= "Orange gate has been ".$gates_info["orange"].". ";
    }
    if($_SESSION['green']!=$gates_info["green"]){
        $show_notify .= "Green gate has been".$gates_info["green"].". ";
    }
    
    $_SESSION['red'] = $gates_info["red"];
    $_SESSION['orange']= $gates_info["orange"];
    $_SESSION['green']= $gates_info["green"];
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
 
    /* CSS styles */
    .dot {
      width: 30px; /* Adjust the width as needed for the rectangle */
      height: 10px; /* Adjust the height as needed for the rectangle */
      position: absolute;
    }
    
    .map_icon{
        top: 30%; /* Adjust the top position for the red rectangle */
        left: 50%; /* Adjust the left position for the red rectangle */
        position: absolute;
    }
    
    .red {
      background-color: red;
     
      top: 30%; /* Adjust the top position for the red rectangle */
      left: 61%; /* Adjust the left position for the red rectangle */
      transform: rotate(180deg); /* Rotate the red rectangle 180 degrees */
    }
    
    .orange {
      background-color: rgb(255, 0, 0);
      top: 63%; /* Adjust the top position for the orange rectangle */
      left: 61%; /* Adjust the left position for the orange rectangle */
      transform: rotate(180deg)
    }
    
    .green {
      background-color: green;
      top: 80%; /* Adjust the top position for the green rectangle */
      left: 71%; /* Adjust the left position for the green rectangle */
    }
    /* ...Existing CSS code... */
    #map {
      height: 800px; /* Adjust the height as needed */
      width: 98%; /* Adjust the width as needed */
      margin: 0 auto;
      max-width: 1500px;
      text-align: center;
      position: relative;
      overflow: hidden; /* Ensure the image doesn't overflow */
    }
    
    .map img {
      width: 100%; /* Make the image take 100% of the container width */
      height: auto;
      object-fit: cover;
    }
    body, html {
      height: 100%;
      margin: 0;
      padding: 0;
    }

    header {
      height: 50px; /* Adjust the header height as needed */
    }

    footer {
      height: 50px; /* Adjust the footer height as needed */
    }

    .map .user-icon {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      position: absolute;
      background-color: #4285f4; /* Google Maps blue color */
      box-shadow: 0 0 6px rgba(66, 133, 244, 0.6); /* Optional: add a subtle shadow */
    }
    
    .map .user-icon::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 16px; /* Adjust the size of the inner circle */
      height: 16px;
      background-color: #fff; /* White color for the inner circle */
      border-radius: 50%;
    }
    

.help-button {
  display: flex;
  justify-content: center;
  align-items: center;
}

.help-button button {
  margin-top: 1px;
  background-color: red;
  color: #fff;
  outline: none;
  padding: 12px 24px; /* Adjust the padding values to make the button bigger */
  font-size: 16px; /* Adjust the font size to make the button text bigger */
  border-radius: 50px; /* Apply border-radius to make the button round */
  cursor: pointer;
  
}


.phone-dropdown {
  display: none;
  margin-top: 20px;
  justify-content: center;
}

.phone-dropdown select {
  padding: 5px;
}

          
body {
  margin: 0;
   padding: 0;
  font-family: Arial, sans-serif;
     }
    
        header {
          background-color: #0e5108;
          color: #070707;
          padding: 10px;
          display: flex;
          align-items: center;
          justify-content: space-between;
        }
        
        
        header .logo {
          display: flex;
          align-items: center;
        }
    
        header .logo img {
          width: 50px;
          height: 50px;
          margin-left: 10px;
        }
    
        header .menu-links {
          display: flex;
          align-items: center;
        }
    
        header .menu-links a {
          color: #fff;
          text-decoration: none;
          margin-right: 20px;
          position: relative;
        }
    
       
       
    
        .greeting {
          text-align: right;
          margin-top: 50px;
        }
    
    
        .gate-icons {
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          margin-top: 30px;
        }
    
       
       
        
    
        footer {
          background-color: #09600d;
          color: #fff;
          padding: 10px;
          text-align: center;
        }
       
          /* ... (existing styles) ... */
          .gate-icons {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
          }
      
          .gate-icon {
            position: absolute;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #4285f4; /* Google Maps blue color */
            box-shadow: 0 0 6px rgba(66, 133, 244, 0.6); /* Optional: add a subtle shadow */
            display: none; /* Hide the icons by default */
          }
      
          .gate-icon.open {
            background-color: green; /* Color for open gate */
          }
      
          .gate-icons .closed {
            top: 30%; /* Adjust the top position for the closed gate icon */
            left: 61%; /* Adjust the left position for the closed gate icon */
          }
      
          .gate-icons .open {
            top: 80%; /* Adjust the top position for the open gate icon */
            left: 71%; /* Adjust the left position for the open gate icon */
          }
          
          .notification {
/*            display: none;*/
            position: fixed;
            top: 90px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px;
            background-color: #333;
            color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            z-index: 999;
          }
      </style>
    </head>
    <body>
      <header>
        <nav class="menu-links">
          <a href="tt.html" >عن مسير </a>
          <a href="login.html" >الص�?حه الرئيسيه</a>
        </nav>
        <div class="logo">
          
          <img src="photo_2023-12-01 16.13.53.jpeg" alt="Logo">
        </div>
      </header>
    
      <div class="greeting">
        <h2  >مرحبا بك </h2>
      </div>
    
      <div id="map" class="mapx"></div>  
      <div id="map1" class="map">
       
          <!-- Placeholder for the image 
          <img src="Screenshot 2023-12-12 at 11.43.02 PM.png" alt="Custom Map Image">-->
          
          <div class="dot red" style="background-color:<?php if($gates_info["red"]=="closed"){print "red";}else{print "green";} ?> "></div>
          <div class="dot orange" style="background-color:<?php if($gates_info["orange"]=="closed"){print "red";}else{print "green";} ?> "></div>
          <div class="dot green" style="background-color:<?php if($gates_info["green"]=="closed"){print "red";}else{print "green";} ?> "></div>
      
         <!--<div class="map_icon"><img src="map_icon.png" style="width:100px" /></div>-->
        <!-- Placeholder for Google Map -->
        
      </div>
      <div class="gate-icons">
        <div class="gate-icon closed"></div>
        <div class="gate-icon open"></div>
      </div>

      <!-- <div class="gate-icons">
        <div class="icon"></div>
        <div class="icon open"></div>
      </div>
     -->
    
    <div>
      <div class="help-button">
        <button onclick="showPhoneDropdown()">المساعدة</button>
        <div id="phone-dropdown" class="phone-dropdown">
          <select>
            <option>Telephone: 8004304444</option>
            <option>Mobile: 00966920002814</option>
          </select>
        </div>
      </div>
    
     
    
      
      <!-- <div class="help-button">
        <button onclick="showPhoneDropdown()">المساعدة</button>
        <div id="phone-dropdown" class="phone-dropdown">
          <select>
            <option>Telephone: 8004304444</option>
            <option>Mobile: 00966920002814</option>
          </select>
        </div>
      </div> -->
    </div>
     
     <?php if($show_notify!="0"){ ?>
      <div class="notification" id="notification">
        <?php print $show_notify; ?>
      </div>
     <?php } ?>
     
      <footer>
        &copy; 2023 F27. All rights reserved.
      </footer>
    
      <script>
        
       
          // Function to handle incoming gate status updates
          function handleGateStatusUpdate(event) {
            const { gate, status } = event.data;
            console.log(`Received gate status update: ${gate} is ${status}`);
            // Perform actions on the user page based on the gate status update
          }
        
          // Listen for updates from the admin page
          const channel = new BroadcastChannel('gateStatusChannel');
          channel.addEventListener('message', handleGateStatusUpdate);
       
          function showPhoneDropdown() {
            const phoneDropdown = document.getElementById("phone-dropdown");
            phoneDropdown.style.display = phoneDropdown.style.display === "block" ? "none" : "block";
          }
      
  
        
         // JavaScript code
         function initMap() {
            // Create a map object
            const map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 21.41567896777339, lng: 39.89298060890521 },
                zoom: 12,
                zoomControl: false, // Disable the default zoom control
                gestureHandling: "none", // Disable all map gestures, including zooming
                disableDoubleClickZoom: true, // Disable zooming on double click
                scrollwheel: false // Disable zooming on scroll
            });
          
      
            // Call your deep learning model to determine the gate status
            const gateStatus = callDeepLearningModel(); // Replace with your deep learning model logic
      
            // Display the appropriate gate icon based on gate status
            const gateIcon = document.querySelector(".gate-icon");
            const closedIcon = gateIcon.querySelector(".closed");
            const openIcon = gateIcon.querySelector(".open");
      
            if (gateStatus === "closed") {
              closedIcon.style.display = "block";
              openIcon.style.display = "none";
            } else {
              closedIcon.style.display = "none";
              openIcon.style.display = "block";
            }
          }
      
          function callDeepLearningModel() {
            // Implement your deep learning model logic here
            // Return gate status: "closed" or "open"
          }
         
          function dialPhoneNumber() {
            const phoneDropdown = document.querySelector(".phone-dropdown select");
            const phoneNumber = phoneDropdown.value;
            const formattedPhoneNumber = phoneNumber.split(":")[1].trim();
            const dialLink = "tel:" + formattedPhoneNumber;
            window.location.href = dialLink;
          }
        // Add your Google Maps API implementation here
        
        
        setTimeout(function(){
            //window.location.reload(1);
        }, 10000);
      </script>
      <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d59424.80608093475!2d39.85899165577134!3d21.42726467337449!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15c2040f36853503%3A0xd6a3cb46f2b797b4!2sMina%2C%20Al%20Mashair%2C%20Makkah!5e0!3m2!1sen!2ssa!4v1701720967861!5m2!1sen!2ssa&zoom=12" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->

      
      
      <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNZluJtOoU34fHOh_ECxIoNJnEnlOba0E&callback=initMap&v=weekly"
      defer
    ></script>  
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script>
    function initMap() {
      const center = new google.maps.LatLng(21.413056, 39.892222);
      const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: center,
      });
      const svgMarker = {
        path: "M-1.547 12l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM0 0q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
        fillColor: "blue",
        fillOpacity: 0.6,
        strokeWeight: 0,
        rotation: 0,
        scale: 2,
        anchor: new google.maps.Point(0, 20),
      };

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