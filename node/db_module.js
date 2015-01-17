var Db = require('mysql-activerecord');
var db = new Db.Adapter({
	server: 'localhost',
	username: 'Anton_breegsplan',
	password: 'breegsplan',
	database: 'Anton_breegsplan',
	reconnectTimeout: 2000
});

function insert_calendar_event(event){
	//console.log(event);
}
module.exports.mainsert_calendar_eventke = insert_calendar_event;