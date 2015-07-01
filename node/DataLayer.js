/**
 * Copyright 2011 - Nucleo de Informatica na Educacao Especial (NIEE) 
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

var WhiteBoardServer = require('./WhiteBoardServer.js');

// Connection parameters
var Client = require('mysql').Client,
client = new Client();
client.port = '3306';  
client.user = 'wb';
client.password = 'wb';
client.useDatabase('whiteboard');

/**
 * @param objConnection : User's connection object
 * @param index         : User's current index
 * @param action        : Name of the action that will be executed in database
 * @param msg           : String message
 * 
 * -- Unique function accessible from outside of datalayer.
 * -- This new structure keep the state from the current user because its a new variable scope.
 * -- When a connection with the user close and there was a callback function, the server still do the right job, because
 * the state of connection remains.
 * -- There was no changes in any function, just the structure.
 */
exports.database = function (objConnection, index, action, msg) {
	console.log('Funcao database do DataLayer: ');
	client.useDatabase('whiteboard');
	

deleteElement = function(msg) {
	console.log('Utilizando a funcao deleteElement..');
	
	if(msg.idNode.indexOf('div') != -1){
		msg.idNode = msg.idNode.replace("div", "");
		
	}
	
	var query = "delete from element ";
	query = query + "where id='"+ msg.idNode +"' and production_id='"+ msg.idProduction +"'";
	
	client.query(query,
		function selectCb(err, results, fields) {
			if (err) {
				//throw err;
				console.log('Erro DATALAYER - Delete Element');
				console.log(err);
			}		   
 		});
};
	
saveOrUpdate = function (msg) {
	console.log('Utilizando a funcao saveOrUpdate..');
	var query = "select element_id from element ";
	query = query + "where id='"+ msg.id +"' and production_id='"+ msg.idProduction +"'";
	
	client.query(query,
			function selectCb(err, results, fields) {
				if (!err) {
					var queryType;
					if (results.length > 0){
						query = mountUpdateQuery(msg, results[0].element_id);
						queryType = "update"
					}
					else{
						query = mountSaveQuery(msg);
						queryType = "insert"
					}
						
					client.query(query,
						function selectCb(err, results, fields) {
							if (err) {
								//throw err;
								console.log('Erro DATALAYER - '+queryType);
					    		console.log(err);
							}
					 	});
			    }else{
			    	//throw err;
			    	console.log('Erro DATALAYER - saver or update');
			    	console.log(err);
				}					
			});
};

productionHistory = function (msg) {
	console.log('Utilizando a funcao productionHistory...');
	
	var today = new Date();
	var today = today.getFullYear()+"-"+(today.getMonth()+1)+"-"+today.getDate()+" "+today.getHours()+":"+today.getMinutes()+":"+today.getSeconds();
	console.log(today);
	
	var query = "insert into production_history "
	 + "(user_id, "
	 + "action, "
	 + "date, "
	 + "production_id, "
	 + "type, "
	 + "user_name, "
	 + "value) "
	 + "values "
	 + "('" + msg.idUser + "', "
	 + "'" + msg.action + "', "
	 + "'" + today + "', "
	 + "'" + msg.idProduction + "',"
	 + "'" + msg.type + "',"
	 + "'" + msg.nameUser + "',"
	 + "'" + msg.value + "')";
	
	client.query(query,
			function selectCb(err, results, fields) {
				if (err) {
					//throw err;
					console.log('Erro DATALAYER - productionHistory');
					console.log(err);
				}		   
			});

};

loadProduction = function (idProduction, callBackFunction) {
	console.log('Utilizando a funcao loadProduction...');
	var query = "select * from element where production_id="+idProduction;
	
	client.query(query,callBackFunction);
};

loadProductionHistory = function (idProduction, callBackFunction) {
	console.log('Utilizando a funcao loadProductionHistory...');
	var query = "select * from production_history where production_id="+idProduction;
	
	client.query(query,callBackFunction);
};

updateTableOnline = function (idProduction, msg) {
	console.log('Utilizando a funcao updateTableOnline...');
	
	console.log('Prestes a colocar usuarios da producao '+msg.oldProduction+' para '+idProduction);
	var query = "update online set production_id = "+idProduction+" where production_id = "+msg.oldProduction;
	
	client.query(query,
		function selectCb(err, results, fields) {
			if (err) {
				//throw err;
				console.log('Erro DATALAYER - updateTableOnline');
				console.log(err);
			}	
 		});
	
	var query = "update room set active_production = "+idProduction+" where active_production = "+msg.oldProduction;
	
	client.query(query,
		function selectCb(err, results, fields) {
			if (err) {
				//throw err;
				console.log('Erro DATALAYER - updateTableOnline');
				console.log(err);
			}	
 		});
	
	console.log('updateTableOnline executado');
};

loadUsers = function (idProduction, callBackFunction) {
	console.log('Utilizando a funcao loadUsers...');
	var query = "select user.user_id, user.name, online.transmit from online ";
	query = query + "left join user on user.user_id = online.user_id where production_id="+idProduction;
	
	client.query(query,callBackFunction);
};

insertUser = function (idUser, idProduction){
	console.log('Utilizando a funcao insertUser...');
	var query = "insert into online (user_id, production_id) values ("+idUser+","+idProduction+")";
	
	client.query(query, 
		function selectCb(err, results, fields) {
			if (err) {
				//throw err;
				console.log('Erro DATALAYER - insert User');
		    	console.log(err);
			}		   
		 });
};


deleteUser = function (idUser, idProduction) {
	console.log('Utilizando a funcao deleteUser...');
	var query = "delete from online where user_id="+idUser+" and production_id="+idProduction;
	
	client.query(query,
		function selectCb(err, results, fields) {
			if (err) {
				//throw err;
				console.log('Erro DATALAYER - Delete User');
				console.log(err);
			}		   
 		});
};


saveText = function (msg) {
	console.log('Utilizando a funcao saveText...');
	
	
	msg.text = replaceAll(msg.text, "'", "&quot;");

	
	var query = "insert into message "
	 + "(text, "
	 + "lang, "
	 + "user_id, "
	 + "production_id) "
	 + "values "
	 + "('" + msg.text + "', "
	 + "'" + msg.lang + "', "
	 + "'" + msg.idUser + "', "
	 + "'" + msg.idProduction + "')";
	
	client.query(query,
		function selectCb(err, results, fields) {
			if (err) {
				//throw err;
				console.log('Erro DATALAYER - Save Text');
				console.log(err);
			}		   
		});
	
	msg.text = replaceAll(msg.text, "&quot;", "'");

};
	
loadTexts = function (idProduction, callBackFunction) {
	console.log('Utilizando a funcao loadTexts...');
		var query = "select user.name, message.text " +
			    	"from message " + 
				    "left join user on " +
				    "user.user_id = message.user_id " +
				    "where production_id="+idProduction;
		
		client.query(query, callBackFunction);
	};

clearUserTransmit = function (idProduction) {
	console.log('Utilizando a funcao clearUserTransmit...');
	var query = "update online set transmit = null where production_id = "+idProduction;
	
	client.query(query,
		function selectCb(err, results, fields) {
			if (err) {
				//throw err;
				console.log('Erro DATALAYER - clearUserTransmit');
				console.log(err);
			}		   
 		});
	
	};
	
setUserTransmit = function (idProduction, msg) {
	console.log('Utilizando a funcao setUserTransmit...');
	var query = "update online set transmit = 1 where production_id = " + idProduction + " AND user_id = " + msg.idUser;
	
	client.query(query,
		function selectCb(err, results, fields) {
			if (err) {
				//throw err;
				console.log('Erro DATALAYER - setUserTransmit');
		    	console.log(err);
			}		   
	 	});
	};
	
function mountSaveQuery(msg){
	
	msg.value = replaceAll(msg.value, "'", "&quot;");

	
	var query = "insert into element "
	+ "(id, "
	+ "value, "
	+ "tabIndex, "
	+ "css_left, "
	+ "css_top, "
	+ "css_width, "
	+ "css_height, "
	+ "rotation, "
	+ "production_id, "
	+ "last_change_by)"
	+ " values "
	+ "('" + msg.id + "', "
	+ "'" + msg.value + "', "
	+ "'" + msg.tabIndex + "', "
	+ "'" + toInt(msg.left) + "', "
	+ "'" + toInt(msg.top) + "', "
	+ "'" + toInt(msg.width) + "', "
	+ "'" + toInt(msg.height) + "', "
	+ "'" + parseInt(msg.rotation) + "', "
	+ "'" + msg.idProduction + "', "
	+ "'" + msg.idUser + "')";
	
	return query;
}

function mountUpdateQuery(msg, idElement){
	
	msg.value = replaceAll(msg.value, "'", "&quot;");

	
	var query = "update element set "
	+ "id='" + msg.id + "', "
	+ "value='" + msg.value + "', "
	+ "tabIndex='" + msg.tabIndex + "', "
	+ "css_left='" + toInt(msg.left) + "', "
	+ "css_top='" + toInt(msg.top) + "', "
	+ "css_width='" + toInt(msg.width) + "', "
	+ "css_height='" + toInt(msg.height) + "', "
	+ "rotation='" + parseInt(msg.rotation) + "', "
	+ "production_id='" + msg.idProduction + "', "
	+ "last_change_by='" + msg.idUser + "' "
	+ "where element_id='"+ idElement +"'";
	
	return query;
}

function toInt(str){
	var length = str.length;
	if (length == 0)
		return 0;
	else
		return str.substring(0, length - 2);
}

function replaceAll(string, token, newtoken){
	while(string.indexOf(token) != -1){
		string = string.replace(token, newtoken);
	}
	return string;
}


/**
 * Load Production call back function
 */
loadProductionCallBack = function selectCb(err, results, fields) {
	console.log('Utilizando a loadProductionCallBack...');
	if (!err){
		var resultMsg = JSON.stringify(results);
		// Adding the operation to the client
		
		var subMsg = resultMsg.substring(1, resultMsg.length);
		subMsg = replaceAll(subMsg, "&quot;", "'");

		
		resultMsg = '[{"op":"loadProduction"}, ' + resultMsg.substring(1, resultMsg.length);
		
		// Changing the columns names
		resultMsg = replaceAll(resultMsg, "css_top", "top");
		resultMsg = replaceAll(resultMsg, "css_left", "left");
		resultMsg = replaceAll(resultMsg, "css_width", "width");
		resultMsg = replaceAll(resultMsg, "css_height", "height");

		
		connection.sendUTF(resultMsg);
		console.log(resultMsg);
	}else{
		//throw err;
		console.log('nao foi possivel a execucao de loadProductionCallBack()');
		console.log(err);
	}
	
}

/**
 * Load ProductionHistory call back function
 */
loadProductionHistoryCallBack = function selectCb(err, results, fields) {
	console.log('Utilizando a loadProductionCallBack...');
	if (!err){
		var resultMsg = JSON.stringify(results);
		// Adding the operation to the client
		
		var subMsg = resultMsg.substring(1, resultMsg.length);
		subMsg = replaceAll(subMsg, "&quot;", "'");

		resultMsg = '[{"op":"loadProductionHistory"}, ' + resultMsg.substring(1, resultMsg.length);
		
		connection.sendUTF(resultMsg);
		console.log(resultMsg);
	}else{
		//throw err;
		console.log('nao foi possivel a execucao de loadProductionHistoryCallBack()');
		console.log(err);
	}
	
}

/**
 * Load Users call back function
 */
loadUsersCallBack = function selectCb(err, results, fields) {
	console.log('Utilizando a loadUsersCallBack...');
	if (!err){
	var resultMsg = JSON.stringify(results);
	
	// Adding the operation to the client
	resultMsg = '[{"op":"loadUsers"}, ' + resultMsg.substring(1, resultMsg.length);
	
	// Send to yourself
	connection.sendUTF(resultMsg);
	
	// Update the other clients
	WhiteBoardServer.sendToOthers(index, resultMsg);
	console.log(resultMsg);
	}else{
		//throw err;
		console.log('nao foi possivel a execucao de loadUsersCallBack()');
		console.log(err);
	}
}	

/**
 * Load Texts call back function
 */
loadTextsCallBack = function selectCb(err, results, fields) {
	console.log('Utilizando a funcao loadTextsCallBack...');
	if (!err){ 
	
	var resultMsg = JSON.stringify(results);
	
	var subMsg = resultMsg.substring(1, resultMsg.length);
	subMsg = replaceAll(subMsg, "&quot;", "'");

	
	// Adding the operation to the client
	resultMsg = '[{"op":"loadTexts"}, ' + subMsg;
	
	
	// Send to yourself
	connection.sendUTF(resultMsg);
	console.log(resultMsg);
	}else{
		//throw err;
		console.log('nao foi possivel a execucao de loadTextsCallBack()');
		console.log(err);
	}
}

//if msg is null
if(!msg){
	msg = "";
}

var connection = objConnection.connection;
var idProduction = objConnection.production;
var idUser = objConnection.idUser;

//DEBUG
console.log('O action recebido foi: '+action);
console.log('da producao: '+idProduction);
console.log('do usuario: '+idUser);

if(action == 'saveOrUpdate'){
	console.log('Prestes a executar o saveOrUpdate...');
saveOrUpdate(msg); 

}else if(action == 'loadProduction'){
	console.log('Prestes a executar o loadProduction...');
	loadProduction(idProduction, loadProductionCallBack	);

}else if(action == 'updateTableOnline'){
	console.log('Prestes a executar o updateTableOnline...');
	updateTableOnline(idProduction, msg);

}else if(action == 'loadUsers'){
	console.log('Prestes a executar o loadUsers...');
	loadUsers(idProduction, loadUsersCallBack);

}else if(action == 'insertUser'){
	console.log('Prestes a executar o insertUser...');
	insertUser(idUser, idProduction);

}else if(action == 'deleteUser'){
	console.log('Prestes a executar o deleteUser...');
	deleteUser(idUser, idProduction);

}else if(action == 'saveText'){
	console.log('Prestes a executar o saveText...');
	saveText(msg);

}else if(action == 'loadTexts'){
	console.log('Prestes a executar o loadTexts...');
	loadTexts(idProduction, loadTextsCallBack);

}else if(action == 'deleteElement'){
	console.log('Prestes a executar o deleteElement');
	deleteElement(msg);
	
}else if(action == 'productionHistory'){
	console.log('Prestes a executar o productionHistory');
	productionHistory(msg);
	
}else if(action == 'clearUserTransmit'){
	console.log('Prestes a executar o clearUserTransmit');
	clearUserTransmit(idProduction);
	
}else if(action == 'setUserTransmit'){
	console.log('Prestes a executar o setUserTransmit');
	setUserTransmit(idProduction, msg);
	
}else if(action == 'loadProductionHistory'){
	console.log('Prestes a executar o setUserTransmit');
	loadProductionHistory(idProduction, loadProductionHistoryCallBack);
	
}else{
	console.log('Acao nao reconhecida...');
}

};