var Ws = new require('ws');
var webSocketServer = new Ws.Server({port: 3002});
var Db = require('mysql-activerecord');
var db = new Db.Adapter({
	server: 'localhost',
	username: 'Anton_breegsplan',
	password: 'breegsplan',
	database: 'Anton_breegsplan',
	reconnectTimeout: 2000
});

var express = require('express')();
var http = require('http').createServer(handler);
var io = require('socket.io')(http);
function handler(req, res){
	//console.log(req);
	console.log(req.headers);
	res.writeHead(200);
	if(req.headers.end) res.end(req);
	if(req.headers.action){
		Act.headers_action(req.headers.action);
	}
}

http.listen(3003);
io.on('connection', function ( socket ) {
	Act.parse_header(socket);
	Act.socket = socket;
	socket.on('connect_user', function (data) {
		Act.log("START SERVER",socket.id)
	});
});

  
var Act = new function(){
	this.socket;
	this.get_time = function(){
		return Math.floor(D.getTime()/1000);
	}
	this.b_url = function(url){
		return 'web/sk.ru/public_html/'+url;	
	}
	//	Запрос метода через заголовок
	this.headers_action = function(h){
		var data = JSON.parse(h);
		switch (data.method) {
			case "order_complete":
				var d = data.value;
				var type = (type==='sk')? 'пересчета координат': 'пост обработки';
				Act.notice(d.user,{
					from : 'Успех',	
					text : 'Заказ '+type+' выполнен успешно <a href="/order/'+d.type+'/'+d.order+'">открыть</a>'	
				})
				break
			case "test":
				console.log(data);
				break
			case "notice":
				console.log(data);
				break
			case 5:
				alert('Перебор')
				break
			default:
				alert('Я таких значений не знаю')
		}

	}
	//	Отправка и запись уведомлений
	this.notice = function(id_user, data){
		Sql.insert('notice',{user:id_user,text:data.text,date:data_time},function(e,r){
			data.id = r.insertId;
			Act.emit(id_user,'notice',data);
		});
	}
	//	Отправка сообщения на все сокеты пользователя по флагу
	this.emit = function( id_user, flags, data ){
		io.emit( flags+'-'+id_user , data );
		Act.log( 'Emit '+flags+'-'+id_user,data,'emit' );
	}
	//	Отправка сообщения на все сокеты для модеаторов
	this.emit_admin = function( flags, data ){
		io.emit( flags+'-admin' , data );
		Act.log( 'Emit_admin '+flags,data,'emit_admin' );
	}
	//	Связка сокетов с пользователями
	this.push_socket = function( user_id ){
		session[Act.socket.id] = user_id;
	}
	//	Удаление сокета
	this.delit_socket = function(){
		Admin.disconnect(Act.current_user())
		delete session[Act.socket.id];
	}
	this.current_user = function(){
		return session[Act.socket.id];
	}
	this.parse_header = function( socket ){
		//	Заголовок 
		header = socket.handshake.headers;
		//	Текущая страница
		var parser = header.origin
		uri = header.referer.replace( parser, '')
		//	END
		var address = socket.handshake.address;
		ip = address.address;
	}
	this.log = function(tags,value,type){
		if(type!=undefined){
			if(SERVER.console[type]===undefined){
				this.log("ERROR CONSOLE",type+'='+SERVER.console[type]);
				return false;
			}
			if(SERVER.console[type]==false) return false;
		}
		console.log()
		console.log()
		console.log('--------------------------- START => '+tags );
		console.log(value);
		console.log('--------------------------- END   => '+tags);
		console.log()
		console.log()
	}
}

Act.log("START SERVER",'')





var user_id;
//var db_tools=require('./node/db_module.js');
//var db= new db_tools();
//console.log(db);
var clients=[];
webSocketServer.on('connection', function(ws) {
	user_id=ws.upgradeReq.url;
	//user_id="sdsdsd";
	user_id=user_id.slice(1);
	var id = Math.random();
	clients[user_id+"_"+id] = ws;
	console.log("новое соединение " + user_id);
	ws.on('message', function(data) {
		var data=JSON.parse(data);
		//console.log(data.method);
		var marker=data.method
		

		
		
		//console.log(data);
		
		
		
		for(var key in clients) {
			//clients[key].send(data);
		}
	});
	ws.on('close', function() {
		console.log('соединение закрыто ' + id);
		delete clients[id];
	});

});
console.log("Start.....");

/////// PART
function insert_calendar_event(event){
	console.log(event);
	var dateParts = event.todo_date_start.split('-');
	var timeParts = event.todo_time_start.split(':');
	var year=parseInt(dateParts[0]);
	var month=parseInt(dateParts[1]);
	var day=parseInt(dateParts[2]);
	var hour=parseInt(timeParts[0]);
	var minutes=parseInt(timeParts[1]);
	var date=new Date(year, month-1, day, hour, minutes);
	var timestamp_start=date.getTime()/1000;
	//console.log(timestamp_start);
	var data = {
		todo_housmen: user_id,
		todo_time_start: timestamp_start,
		todo_time_real: timestamp_start,
		todo_tite: event.todo_title,
		todo_body: event.todo_description,
		todo_short_cut: event.todo_short_cut
		
	};
	console.log(data);
	db.insert('todo', data, function(err, info) {
		console.log('New row ID is ' + info.insertId);
	});

}
