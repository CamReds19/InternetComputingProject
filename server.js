const path = require('path');
const socketio = require('socket.io');
const http = require('http');
const express = require('express');
const moment = require('moment');

const users = [];

const app = express();
const server = http.createServer(app);
const io = socketio(server);

app.use(express.static(path.join(__dirname, 'public')));

// run when client connects
io.on('connection', socket => {
    socket.on('joinRoom', ({ user, room }) => {
        const u = userJoin(socket.id, user, room);

        console.log("joinROOM", u);

        socket.join(u.room);


        // welcome new user
        socket.emit('message', "Welcome " + u.username + ' @ ' + moment().format('h:mm:a'));

        socket.broadcast.to(u.room).emit('message', u.username + '  has joined the chat!');

        // Send users and room info
        io.to(u.room).emit('roomUsers', {
            room: u.room,
            users: getRoomUsers(u.room)
        });
    });

    // listen for messages
    socket.on('chatMessage', msg => {
        const user = getCurrentUser(socket.id);

        console.log(user, user.room);

        io.to(user.room).emit('message', user.username+ '   ' + msg);

        console.log("MSG:::", msg);
    });

    // runs when client disconnects
    socket.on('disconnect', () => {
        const user = userLeave(socket.id);
    
        if (user) {
          io.to(user.room).emit(
            'message',
            user.username + ' has left the chat'
          );
    
          // Send users and room info
          io.to(user.room).emit('roomUsers', {
            room: user.room,
            users: getRoomUsers(user.room)
          });
        }
      });
});

function userJoin(id, username, room) {
    const user = {id, username, room};
    users.push(user);

    return user
}

function getCurrentUser(id) {
    return users.find(user => user.id === id);
}
function userLeave(id) {
    const index = users.findIndex(user => user.id === id);

    if(index !== -1) {
        return users.splice(index,1)[0];
    }
}
function getRoomUsers(room) {
    return users.filter(user => user.room == room);
}

const PORT = process.env.PORT || 9999;

server.listen(PORT, () => console.log('server running on port ' + PORT));