<?php
session_start();
require('inpro/db.php');
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
 
    /* CSS styles */
    header {
  background-color: #0e5108;
  color: #070707;
  padding: 2px; /* Adjust the padding value to make the header smaller */
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
}

header .logo img {
  width: 40px; /* Adjust the width of the logo image */
  height: 40px; /* Adjust the height of the logo image */
}
    .map_icon{
        top: 30%; /* Adjust the top position for the red rectangle */
        left: 50%; /* Adjust the left position for the red rectangle */
        position: absolute;
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
    #map {
      height: 550px; /*800px; /* Adjust the height as needed */ /* تغيير حجم الخريطه*/ 
      width: 98%; /* Adjust the width as needed */
      margin: 0 auto;
      max-width: 1500px;
      text-align: center;
      position: relative;
      overflow: hidden; /* Ensure the image doesn't overflow */
    }
    
    .map img {
      /* width: 100%; /* Make the image take 100% of the container width */
      /*height: auto;*/
      /*object-fit: cover; */

      width: 100%; /* Cover the entire width of the container */
      height: auto;
      display: block;
      margin: 0 auto; /* Center the image horizontally */
    }
    body, html {
      height: 100%;
      margin: 0;
      padding: 0;
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
  margin-top: 4px; /*1px;*/
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
  background-color:#faf8f6 
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
      
        .greeting {
          text-align: right;
          margin-right: 45px; 
          margin-top: 19px; /*50px;*/
        }
    
    
        .gate-icons {
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          margin-top: 30px;
        }
    
    
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
            display: none;  
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
        <!-- <a href="tt.html" >عن مسير </a> -->
         
        </nav>
        <div class="logo">
          
          <img src="maseer.jpeg" alt="Logo"> <!--add pic name  -->
        </div>
      </header>
    
      <div class="greeting">
        <h2  >مرحبا بك </h2>
      </div>
    
      <div id="map" class="mapx"></div>  
      <div id="map1" class="map">
       
          <!-- Placeholder for the image 
          <img src="Screenshot 2023-12-12 at 11.43.02 PM.png" alt="Custom Map Image">-->
          
      <?php
        $query = "SELECT * FROM `gates_info`";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $gates_info_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($gates_info_rows as $row):  ;?>
        <div class="dot <?php $gate = $row['gate']; $gate =str_replace(' ', '', $gate); echo $gate; ?>"><span><?php  echo $row['gate']; ?></span></div>
        <?php endforeach; ?>
      
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
    <div class="notification" id="notification">
      </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
$(document).ready(function () {
    $('#notification').hide();

    // Function to check for updates
    function checkForUpdates() {
        $.ajax({
            type: 'GET',
            url: 'check_updates.php',
            dataType: 'json',
            success: function (response) {
                console.log("AJAX Success. Response:", response);

                if (response.hasUpdates) {
                    // Update your page with the new value of show_notify
                    var showNotifyValue = response.show_notify;
                    // Update the necessary element on your page
                    $('#notification').show();
                    $('#notification').text(showNotifyValue);

                }else{
                  $('#notification').hide();
                }
                // Update dot colors based on gate status
                if (response.Gate1 == 'opened') {
                        // Use .css() to update the background color
                        $('.Gate1').css('background-color', 'green');
                    } else {
                        $('.Gate1').css('background-color', 'red');
                    }

                    if (response.Gate2 == 'opened') {
                        // Use .css() to update the background color
                        $('.Gate2').css('background-color', 'green');
                    } else {
                        $('.Gate2').css('background-color', 'red');
                    }

                    if (response.Gate3 == 'opened') {
                        // Use .css() to update the background color
                        $('.Gate3').css('background-color', 'green');
                    } else {
                        $('.Gate3').css('background-color', 'red');
                    }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
            },
            complete: function () {
                // Schedule the next check after a delay (e.g., 5 seconds)
                setTimeout(checkForUpdates, 5000);
            }
        });
    }

    // Start checking for updates when the document is ready
    checkForUpdates();
});

</script>


     
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
       
        
      
  
        
         // JavaScript code
        //  function initMap() {
        //     // Create a map object
        //     const map = new google.maps.Map(document.getElementById("map"), {
        //         center: { lat: 21.41567896777339, lng: 39.89298060890521 },
        //         zoom: 12,
        //         zoomControl: false, // Disable the default zoom control
        //         gestureHandling: "none", // Disable all map gestures, including zooming
        //         disableDoubleClickZoom: true, // Disable zooming on double click
        //         scrollwheel: false // Disable zooming on scroll
        //     });
          
      
           
      
          //   // Display the appropriate gate icon based on gate status
          //   const gateIcon = document.querySelector(".gate-icon");
          //   const closedIcon = gateIcon.querySelector(".closed");
          //   const openIcon = gateIcon.querySelector(".open");
      
          //   if (gateStatus === "closed") {
          //     closedIcon.style.display = "block";
          //     openIcon.style.display = "none";
          //   } else {
          //     closedIcon.style.display = "none";
          //     openIcon.style.display = "block";
          //   }
          // }
      
          
         
         
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
      zoomControl: false,
      center: center,
      gestureHandling: "none", 
    });

    const imageMarker1 = {
      url: 'icon1.png',
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 20), 
    };

    new google.maps.Marker({
      position: map.getCenter(),
      icon: imageMarker1,
      map: map,
    });

    // // Add a second marker with a different icon
    // const imageMarker2 = {
    //   url: 'icon-name',
    //   scaledSize: new google.maps.Size(40, 40),
    //   origin: new google.maps.Point(0, 0),
    //   anchor: new google.maps.Point(20, 20), 
    // };

    // new google.maps.Marker({
    //   position: { lat: 21.413056, lng: 39.892222 }, // Specify the position for the second marker
    //   icon: imageMarker2,
    //   map: map,
    // });

    window.initMap = initMap;
  }
</script>


    </body>
    </html>