var Msql = require('mysql-activerecord');
var Db = new Msql.Adapter({
	server: 'localhost',
	username: 'Anton_breegsplan',
	password: 'breegsplan',
	database: 'Anton_breegsplan',
	reconnectTimeout: 2000
});
var Act = new Act;
var User = new User;

var express = require('express')();
var http = require('http').createServer(Act.handler);
var io = require('socket.io')(http);
http.listen(3003);

io.on('connection', function(socket){
	socket.on('connect_user', function(data){
		Act.socket=socket;
		User.connect(data,socket)
	});
	socket.on('open_email', function(data){
		User.checket_email(data.user_id);
	});
	socket.on('disconnect', function(data){
		User.disconnect(socket)
	});
});

  
function User(){
	this.socket = [];
	this.socket_id = [];
	this.waiting_disconect = [];
	
	this.connect = function(data,socket){
		var user_id = data.user.id;
		User.socket[user_id+'_'+socket.id] = socket;
		User.socket_id[socket.id] = user_id;
		
		User.checket_email(user_id);
		User.checket_alerts(user_id);
		var waiting = User.waiting_disconect[user_id];
		if(typeof waiting ==='undefined'){
			Act.emit('all','user_connected',{
				text:'ID-'+user_id+' в сети',	
			})
		}else{
			User.clear_waiting_disconect(user_id);
		}
	}
	this.checket_email = function(user_id){
		Db.select(['Id_mail_box']).where({mail_hosman:user_id,mail_status:0}).get("mail_box", function(e,r){
			Act.emit(user_id,'count_unread_email',{
				count:(r).length,	
			},true)
			
		});
	}
	this.checket_alerts = function(user_id){
		var line = {};
		var mail = {};
		Db.select(['*']).where({user_target:user_id,status:2}).get("alerts", function(e,r){
			for(var i in r){
				line = r[i];
				Act.log("ALERTS",line)
				if(line.relay==='mail_boxs'){
					Db.select(['*']).where({mail_hosman:line.user_target}).get("mail_box", function(e,r){
						mail=r[0];
						Act.emit(user_id,'message',{
							title: '<smal>Новое письмо от</smal> '+mail.mail_from_str,
							text: mail.mail_subject,	
						},true)
					});
				}
			}
		});
	}
	this.disconnect = function(socket){
		var user_id = User.socket_id[socket.id];
		if(user_id===undefined) return false;
		delete User.socket_id[socket.id]
		delete User.socket[user_id+'_'+socket.id]
		
		var waiting = true;
		for(var i in User.socket_id){
			if(User.socket_id[i]==user_id){
				waiting=false;
				break;
			}
		}
		if(waiting==false) return false;
		User.clear_waiting_disconect(user_id);
		User.waiting_disconect[user_id] = setInterval(function(){
			Act.emit('all','disconect',{
				text:'ID-'+user_id+' вышел',	
			})
			User.clear_waiting_disconect(user_id);
		}, 5000);
	}
	this.clear_waiting_disconect = function(user_id){
		clearInterval(User.waiting_disconect[user_id]);
		delete User.waiting_disconect[user_id];
	}
}

function Act(){
	this.socket;
	
	this.handler = function(req, res){
		console.log(req.headers);
		res.writeHead(200);
		if(req.headers.end) res.end(req);
		if(req.headers.action){
			Act.headers_action(req.headers.action);
		}
	}
	this.get_time = function(){
		return Math.floor(D.getTime()/1000);
	}
	this.b_url = function(url){
		return 'web/sk.ru/public_html/'+url;	
	}
	//	Запрос метода через заголовок
	this.headers_action = function(h){
		var d = JSON.parse(h);
		var method = d.method;
		var data = d.value;
		switch (method) {
			case "open_email":
				break
			default:
				console.log('Я таких значений не знаю')
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
	this.emit = function( id_user, flags, data, send_mi ){
		var socket = online = [];
		var pattern;
		for( var i in User.socket){
			pattern = new RegExp(id_user+'_');
			if(id_user!="all"){
				if( i.match(pattern) ){
					if(typeof User.socket[i]==='object')
					User.socket[i].emit( flags, data );
				}
			}else{
				if(typeof User.socket[i]==='object')
				User.socket[i].emit( flags, data );
			}
		}
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