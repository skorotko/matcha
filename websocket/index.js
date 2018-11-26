var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http, {'pingInterval': 25000, 'pingTimeout': 600000});
// var io = require('socket.io')(http);
const path = require('path');
const axios = require('axios');
// const publicPath = path.join(__dirname, 'index.html');
// app.get('/', function(req, res){
//   res.sendFile(publicPath);
// });

io.on('connection', (socket) => {
  socket.on('disconnect', () => {
    socket.disconnect();
  });

    socket.on('chat message', (msg) => {
    io.emit('chat message', msg);
  });

    socket.on('like action', (msg) => {
    	axios.post('http://10.111.4.5:8080/Token/decodeToken', {
    		login: msg
    	}).then((response) => {
    		io.emit('like action', response.data);
    	}).catch(function(error) {
    		console.log(error);
    	})
  });

    socket.on('view profile action', (msg) => {
      axios.post('http://10.111.4.5:8080/ViewProfileNotification/viewProfileNotification', {
        login: msg
      }).then((response) => {
        io.emit('view profile action', response.data);
      }).catch(function(error) {
        console.log(error);
      })
  });

    socket.on('dislike action', (msg) => {
      axios.post('http://10.111.4.5:8080/Dislike/dislike', {
        login: msg
      }).then((response) => {
        io.emit('dislike action', response.data);
      }).catch(function(error) {
        console.log(error);
      })
  });

    socket.on('message send', (msg) => {
      axios.post('http://10.111.4.5:8080/SaveSendMessage/saveSendMessage', {
        login: msg
      }).then((response) => {
        io.emit('message send', response.data);
      }).catch(function(error) {
        console.log(error);
      })
  });

     socket.on('is typing', (msg) => {
      axios.post('http://10.111.4.5:8080/MessageTyping/isTyping', {
        login: msg
      }).then((response) => {
        io.emit('is typing', response.data);
      }).catch(function(error) {
        console.log(error);
      })
  });

     socket.on('reading chat', (msg) => {
        io.emit('reading chat', msg);
  });

      socket.on('is reading', (msg) => {
        io.emit('is reading', msg);
  });

      socket.on('block action', (msg) => {
        io.emit('block action', msg);
  });
});

http.listen(8083, () => {
  console.log('listening on *:8083');
});
// var express = require('express');
// var app = express();
// var path = require('path');
// var server = require('http').createServer(app);
// var io = require('socket.io')(server);
// var port = process.env.PORT || 8083;

// server.listen(port, () => {
//   console.log('Server listening at port %d', port);
// });

// // Routing
// app.use(express.static(path.join(__dirname, 'public')));

// // Chatroom

// var numUsers = 0;

// io.on('connection', (socket) => {
//   var addedUser = false;

//   // when the client emits 'new message', this listens and executes
//   socket.on('new message', (data) => {
//     // we tell the client to execute 'new message'
//     socket.broadcast.emit('new message', {
//       username: socket.username,
//       message: data
//     });
//   });

//   // when the client emits 'add user', this listens and executes
//   socket.on('add user', (username) => {
//     if (addedUser) return;

//     // we store the username in the socket session for this client
//     socket.username = username;
//     ++numUsers;
//     addedUser = true;
//     socket.emit('login', {
//       numUsers: numUsers
//     });
//     // echo globally (all clients) that a person has connected
//     socket.broadcast.emit('user joined', {
//       username: socket.username,
//       numUsers: numUsers
//     });
//   });

//   // when the client emits 'typing', we broadcast it to others
//   socket.on('typing', () => {
//     socket.broadcast.emit('typing', {
//       username: socket.username
//     });
//   });

//   // when the client emits 'stop typing', we broadcast it to others
//   socket.on('stop typing', () => {
//     socket.broadcast.emit('stop typing', {
//       username: socket.username
//     });
//   });

//   // when the user disconnects.. perform this
//   socket.on('disconnect', () => {
//     if (addedUser) {
//       --numUsers;

//       // echo globally that this client has left
//       socket.broadcast.emit('user left', {
//         username: socket.username,
//         numUsers: numUsers
//       });
//     }
//   });
// });