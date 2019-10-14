var socket  = require( 'socket.io' );
var express = require('express');
var app     = express();
var server = require('http').createServer(app);
var io      = socket.listen( server );
var port    = process.env.PORT || 3000;

server.listen(port, function () {
  console.log('Server listening at port %d', port);
});
// handle incoming connections from clients
io.on('connection', function (socket) {
    // once a client has connected, we expect to get a ping from them saying what room they want to join
    socket.on('subscribe', function (room) {
        socket.join(room);
    });
    socket.on('unsubscribe', function (room) {
        socket.leave(room);
    });
    socket.on('refresh_page', function (data) {
        io.sockets.in(data.room).emit('reload', data.pageId);
    });
    socket.on('redirect_page', function (data) {
        io.sockets.in(data.room).emit('redirect', data.pageURL);
    });
    socket.on('user_logout', function (data) {
        io.sockets.in(data.room).emit('logout', "");
    });
});
//Error handler
process.on('uncaughtException', function (exception) {
    console.log(exception); // handle or ignore error
});
