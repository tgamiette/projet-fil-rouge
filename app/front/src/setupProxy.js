const express = require('express');
const { createProxyMiddleware } = require('http-proxy-middleware');
const cors = require("cors");
const app = express();


app.use(
  cors({
    origin: 'http://localhost:3001',
    method: ["GET", "POST"]
  })
);

app.use('/api/products', createProxyMiddleware(
  {
    target: 'http://localhost:8000',
    changeOrigin: true
  }
));

app.listen(3001);
