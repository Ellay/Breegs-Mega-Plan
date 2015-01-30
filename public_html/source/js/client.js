
var socket = new function(){
	this.emit = function(f,d){}
	this.on = function(f,d){}
}
if(typeof io!='undefined') socket = io('http://46.249.16.151:3003');

var NODE_CONNECT = new function(){
}
var Client = new Client;

$(document).ready(function(){
	NODE_CONNECT.user = {
		id : SYS.USER.id
	};
	socket.emit('connect',NODE_CONNECT);
	console.log(NODE_CONNECT)
});

socket.io('echo',function(data){
	console.log(data)
});
socket.io('notice',function(data){
	
});




function Client(){
	
}

