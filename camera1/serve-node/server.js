var express = require('express');
var app = express();

var server = require('http').Server(app);
var port = (process.env.OPENSHIFT_NODEJS_PORT || process.env.PORT || 8000);
var io = require('socket.io')(server);
server.listen(port, () => console.log('Server running in port ' + port));

io.on('connection', function (socket) {
    console.log(socket.id + ': connected');
    socket.emit('id', socket.id);

    socket.on('disconnect', function () {
        console.log(socket.id + ': disconnected')
    })

    // socket.on('pingServer', data => {
    //     socket.emit('pingServer', { data: data, id: socket.id }); //only user
    //     // io.sockets.emit(); multil user
    // })

});
