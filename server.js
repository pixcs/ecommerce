const express = require('express');
const app = express();

const server = require('http').createServer(app);
const io = require('socket.io')(server, {
    cors: { origin: "http://127.0.0.1:8000" }
});

server.listen(3000, () => {
    console.log("Server is running on port 3000");
});

io.on('connection', (socket) => {
    console.log('Client connected', );

    // Receive the message from a client
    socket.on('sendChatToServer', (message) => {
        console.log(message);

        // Send the message to all clients, including the sender
        io.emit('sendChatToClient', message);
    });

    socket.on('disconnect', () => {
        console.log('Client disconnected');
    });
});