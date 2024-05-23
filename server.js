const express = require('express');
const { exec } = require('child_process');
const app = express();
const port = 3000;

app.use(express.static('public'));

app.get('/start-app', (req, res) => {
  const appPath = 'C:\\Users\\Hp\\AppData\\Local\\Programs\\BurpSuiteCommunity\\BurpSuiteCommunity.exe'; // Replace with the path to your .exe file

  exec(appPath, (error, stdout, stderr) => {
    if (error) {
      console.error(`Error: ${error.message}`);
      res.status(500).send('Error launching application');
      return;
    }

    if (stderr) {
      console.error(`Stderr: ${stderr}`);
      res.status(500).send('Error launching application');
      return;
    }

    console.log(`Stdout: ${stdout}`);
    res.send('Application started successfully');
  });
});

app.listen(port, () => {
  console.log(`Server is running at http://localhost:${port}`);
});
