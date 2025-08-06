const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');
const settingsRouter = require('./routes/settings');

const app = express();
const PORT = 4000;

app.use(cors());
app.use(bodyParser.json());

app.use('/api/settings', settingsRouter);

app.listen(PORT, () => {
  console.log(`Backend server running on http://localhost:${PORT}`);
});
