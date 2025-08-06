const express = require('express');
const fs = require('fs');
const path = require('path');
const router = express.Router();

const settingsPath = path.join(__dirname, '../settings.json');

// Get settings
router.get('/', (req, res) => {
  fs.readFile(settingsPath, 'utf8', (err, data) => {
    if (err) return res.status(500).json({ error: 'Failed to read settings.' });
    res.json(JSON.parse(data));
  });
});

// Update settings
router.post('/', (req, res) => {
  const newSettings = req.body;
  fs.writeFile(settingsPath, JSON.stringify(newSettings, null, 2), (err) => {
    if (err) return res.status(500).json({ error: 'Failed to save settings.' });
    res.json({ success: true, settings: newSettings });
  });
});

module.exports = router;
