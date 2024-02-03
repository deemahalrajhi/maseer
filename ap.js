
const express = require('express');
const fs = require('fs');
const app = express();

app.get('/read-file', (req, res) => {
  fs.readFile('results/Cam1.txt', 'utf8', (err, data) => {
    if (err) {
      console.log("Error occurred while reading the file");
      res.status(500).send("Error occurred while reading the file");
      return;
    }
    res.send(data);
  });
});

app.listen(3000, () => {
  console.log('Server is running on port 3000');
});



// const fs = require('fs'); // Use require instead of requires

// fs.readFile('results/crowded_areas.txt', 'utf8', (err, data) => {
//   if (err) {
//     console.log("Error occurred while reading file");
//     return;
//   }
//   console.log(data);
// });

