
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
	socket.emit('connect_user',NODE_CONNECT);
	if(typeof io!='function'){
		$.gritter.add({
	        title: '',
	        text: 'Соединение отсутствует',
	        time: 3000
	    });
	}
});

socket.on('message',function(data){
	$.gritter.add({
        title: data.title,
        text: data.text,
        time: 3000
    });
});
socket.on('user_connected',function(data){
	$.gritter.add({
        title: '',
        text: data.text,
        time: 3000
    });
});
socket.on('disconect',function(data){
	$.gritter.add({
        title: '',
        text: data.text,
        time: 3000
    });
});
socket.on('count_unread_email',function(data){
	$('.count_unread_email').html(data.count)
});

socket.on('notice',function(data){
	
});



function Client(){
	
}

