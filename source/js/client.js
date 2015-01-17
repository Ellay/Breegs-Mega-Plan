var socket = io('http://46.249.16.151:3003');
var NODE_CONNECT = new function(){
}
$(document).ready(function(){
	NODE_CONNECT.user = {
		id : SYS.USER.id
	};
	socket.emit('connect_user',NODE_CONNECT);
});