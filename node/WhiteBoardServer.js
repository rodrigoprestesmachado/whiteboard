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

//Including the data layer file
var dataLayer = require('./DataLayer.js');

"use strict";

// Process name
process.title = 'WhiteBoardServer';

// Port where we'll run the websocket server
var webSocketsServerPort = 9090;

// WebSocket and HTTP servers
var webSocketServer = require('websocket').server;
var http = require('http');

/**
 * Global variables
 */
// list of currently connected clients (users)
var clients = new Array();

var production = 0;

/**
 * HTTP server
 */
var server = http.createServer(function(request, response) {
    // Not important for WebSocketServer only
});

server.listen(webSocketsServerPort, function() {
    console.log((new Date()) + " Server is listening on port " + webSocketsServerPort);
});

/**
 * WebSocket server
 */
var wsServer = new webSocketServer({
    httpServer: server
});

/**
 *  This function is called every time someone tries to connect to the WebSocket server
 */
wsServer.on('request', function(request) {
	
    console.log((new Date()) + ' Connection from origin ' + request.origin + '.');

    try{
    	// accept connection
        var connection = request.accept(null, request.origin); 

        // Creating the connection object
        objConnection = new Object();
        objConnection.connection = connection;
        objConnection.production = 0;
        objConnection.idUser = 0;
        // Needed on disconnect event
        objConnection.onClose = false;
        
        // we need to know client index to remove them on close event
        var index = clients.push(objConnection) - 1;
      
        console.log((new Date()) + ' Connection accepted.');
    }catch(err){
    	console.log('Erro na conexao ao websocket server, verifique os parametros');
    }
    
    
    
    /**
     * User send a message
     */
    connection.on('message', function(message) {
    	
    	// accept only text messsage
        if (message.type === 'utf8') { 
            
        	 // Debug
        	 console.log((new Date()) + ' Received Message from ' + message.utf8Data);
        	 
        	 try{
        	 	// parsing the message
        	 	var msg = JSON.parse(message.utf8Data);
        	 	// Getting the production
        	 	production = msg.idProduction;
        	 	try{
        		 	// Establishing a relationship between production and connection
        	 		if(msg.op == "reCalculateIndex"){
        				var objConnection = clients[index-1];
        	 		}else{
        				var objConnection = clients[index];
        	 		}
        	 
	        		if (objConnection.production != production) {
        		 		objConnection.production = production;
        	 		}
        	 
        	 		// Establishing a relationship between user id and a connection
        	 		if (objConnection.idUser == 0) {
        				objConnection.idUser = msg.idUser;
        				
        				// Turn the user to online
        				dataLayer.database(objConnection, index, 'insertUser', msg);
        	 		}
        	 		
        	 	}catch(err){
        			var error=true;
        			console.log('Erro no objConection, verifique o array');
        	 	}
        	 }catch(err){
        	 	var error=true;
        		console.log('Erro no JSON.parse, verifique a mensagem JSON');
        		
        	 }
        	 
        	 
        	
        	 if(!error){
        	 	// Applications Operations
        	 	if (msg.op == "saveOrUpdate"){
        			console.log('Entrando no saveOrUpdate...');
        		 	dataLayer.database(objConnection, index, 'saveOrUpdate', msg);
				 
				 	msg.op = "updateElement";
				 	msg = "[" + JSON.stringify(msg) + "]"; 
				 
				 	exports.sendToOthers(index, msg);
				 	console.log(msg);
			 	}else if(msg.op == "productionHistory"){
        		 	console.log('Entrando no productionHistory...');
        			dataLayer.database(objConnection, index, 'productionHistory', msg);
        	 	}
			 	else if(msg.op == "loadProduction"){
        		 	console.log('Entrando no loadProduction...');
        			dataLayer.database(objConnection, index, 'loadProduction', msg);
        			dataLayer.database(objConnection, index, 'loadProductionHistory', msg);
        	 	}
			 	else if(msg.op == "updateTableOnline"){
        		 	console.log('Entrando no updateTableOnline...');
        			dataLayer.database(objConnection, index, 'updateTableOnline', msg);
        			
        			msg.op = "loadPreviusProduction";
        			msg = "[" + JSON.stringify(msg) + "]";
        			exports.sendToOthers(index, msg);
        			console.log(msg);
        	 	}
        	 	else if(msg.op == "loadUsers"){
        		 console.log('Entrando no loadUsers');
        		 dataLayer.database(objConnection, index, 'loadUsers', msg);
        	 	}
        	 	else if(msg.op == "sendText"){
        			console.log('Entrando no sendText...');
        			dataLayer.database(objConnection, index, 'saveText', msg);
        			msg = "[" + JSON.stringify(msg) + "]"; 
        			exports.sendToOthers(index, msg);
        			console.log(msg);
        	 	}
        	 	else if(msg.op == "loadTexts"){
        			console.log('Entrando no loadTexts...');
        			dataLayer.database(objConnection, index, 'loadTexts', msg);
        	 	}
        	 	else if(msg.op == "reCalculateIndex"){
        			console.log('Entrando no reCalculateIndex...');
        			index = index - 1;
        			//console.log("O index numero "+(index+1)+" tornou-se o numero "+index);
        	 	}
        	 	else if(msg.op == "removeElement"){
        	 		dataLayer.database(objConnection, index, 'deleteElement', msg)
        	 		msg = "[" + JSON.stringify(msg) + "]"; 
        			exports.sendToOthers(index, msg);
        			console.log(msg);
        	 	}
        	 	else if(msg.op == "enablePublishStreaming" || "disablePublishStreaming" || "enablePlayStreaming" || "disablePlayStreaming"){
        	 		if(msg.op=="enablePublishStreaming" || msg.op== "disablePublishStreaming"){
        	 			dataLayer.database(objConnection, index, 'clearUserTransmit', msg);
        	 			dataLayer.database(objConnection, index, 'setUserTransmit', msg);
        	 		}
        	 		msg = "[" + JSON.stringify(msg) + "]"; 
        			exports.sendToOthers(index, msg);
        			console.log(msg);
        	 	}
        	 	else{
        			console.log("Undefined operation ...");
        	 	}
        	 }
        }
    });

    /**
     * User disconnect
     */
    connection.on('close', function(connection) {
            
           
            try{
            	
	            var objConnection = clients[index];
	            var idUser = objConnection.idUser;
	            var idProduction = objConnection.production;
	            
	            //When this function is over the connection will not exist anymore, so we need somehow comunicate 
	            //the other connection child that there was a disconnection
	            clients[index].onClose = true;
	            
	            dataLayer.database(objConnection, index, 'deleteUser');
	
	            dataLayer.database(objConnection, index, 'loadUsers');
	            
	            console.log((new Date()) + " Peer " + connection.remoteAddress + " disconnected.");
	            
            }catch(err){
            	console.log('Erro no onClose');
            	console.log(err);
            }
    });
    
    
    /**
     * Sends a messages to others clients in the same room or production
     */
    exports.sendToOthers = function (myIndex, msg) {
    	console.log('Funcao sendToOthers: ');
    	
    	for (var i = 0; i < clients.length; i++) {
    		if (i != myIndex){
    			try{
    				// Sends the message to all users in the same room or production
	    			var objConnection = clients[i];
	    			var msgObject = JSON.parse(msg);
	    			
	    			//if there was a disconnection, the indexes need to be recalculated
	    			if(clients[myIndex].onClose && i > myIndex){
	    				var connection = objConnection.connection;
	    				connection.sendUTF('[{"op":"reCalculateIndex"}]');
	    				//console.log('[{"op":"reCalculateIndex"}] foi enviado para o index '+ i);
	    			}
	    			
	    			if ((objConnection.production == production) || (objConnection.production == msgObject[0].oldProduction)) {
    					
	    				var connection = objConnection.connection;
	    				
	    				if(msgObject.op == "enablePublishStreaming"){ 
	    					
	    					if(msgObject.idUser!=i){
	    						
	    						msgObject.op = "disablePublishStreaming";
	    						msg="[" + JSON.stringify(msgObject) + "]";
	    					
	    					}
	    				}
	    				
	    				connection.sendUTF(msg);
	    				console.log("A mensagem foi enviada para id: "+objConnection.idUser+" que está na producao "+objConnection.production);
	    			 }
    			}catch(err){
    				var error = true;
    				console.log('Erro ao recalcular indice');
    			}
    			
    		}
    		
    	}
    	if(!error){
	    	// if there was a disconnection the object need to be removed from the array
	    	if(clients[myIndex].onClose){
	    	// remove user from the list of connected clients
	        clients.splice(myIndex, 1);
	    	}
    	}
    }    
});