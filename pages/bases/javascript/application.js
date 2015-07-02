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

// URL of red5 server
var red5Server = "rtmp://localhost/fitcDemo";

// WebSocket Client
var ws = "";

var lastTabIndex = 5006;

/**
 * Starts the WebSocket Client
 */
function startSocket(){
	
	if (window.MozWebSocket)
		ws = new MozWebSocket("ws://localhost:9090/");
	else
		ws = new WebSocket("ws://localhost:9090/");
		
	ws.onopen = function(){
		
		// Sending the production id to the WebSocketServer
		var message = '{"op":"loadUsers", "idProduction":"'+ idProduction +'", "idUser":"'+ idUser +'"}';
		ws.send(message);
		
		// Load messages from the chat 
		loadChatTexts();
		
		// Load the production
		loadProduction();
    };

    ws.onclose = function(evt){
    	// Remove All users
    	removeUsers();
    	
    	// Clear the chat area
    	clearChat();
    	
    	// Clear the withe board elements
    	clearBoard();
    };
    
    ws.onmessage = function(evt){
    	// receiving the data (elements) in json format
    	console.log(evt.data);
    	var elements = JSON.parse(evt.data);
    	var value;
    	
    	if(elements[0].op == 'loadProduction') {
    		for ( var i = 1; i < elements.length; i++) {
        		var element = elements[i];
        		// loading an element in white board
        		loadElement(element);
        	}
    	}else if(elements[0].op == 'loadProductionHistory') {
    		for ( var i = 1; i < elements.length; i++) {
        		var element = elements[i];
        		// loading an element in white board
        		loadLog(element);
        		
        		//element = JSON.stringify(element);
        		//alert(element);
        	}
    	}
    	else if (elements[0].op == 'loadPreviusProduction') {
    		idProduction = elements[0].idProduction;
    		
    		var newTitle = elements[0].title;
    		document.getElementsByTagName("title")[0].innerHTML = newTitle;
    		
    		// Remove All users
        	removeUsers();
        	
        	// Clear the chat area
        	clearChat();
        	
        	// Clear the withe board elements
        	clearBoard();
    		
    		// Sending the production id to the WebSocketServer
    		var message = '{"op":"loadUsers", "idProduction":"'+ idProduction +'", "idUser":"'+ idUser +'"}';
    		ws.send(message);
    		
    		// Load messages from the chat 
    		loadChatTexts();
    		
    		// Load the production
    		loadProduction();

    		setCookie("alteredProduction", idProduction, 1);
    	}
    	else if (elements[0].op == 'updateElement') {
    		
    		logArea(checkElement(elements[0]), elements[0].id, value, elements[0]);
    		loadElement(elements[0]); 	
    	}
    	else if (elements[0].op == 'loadUsers') {
    		var idTransmit = null;
    		removeUsers();
    		for ( var i = 1; i < elements.length; i++) {
        		var element = elements[i];
        		// loading an user in the white board
        		loadUser(element);
        		if(element.transmit!=null)
        			idTransmit=element.user_id;
        	}
    		if(idTransmit!=null){
    			setCamTransmit(idTransmit);
    			enablePlayStreaming();
    		}
    	}
    	else if (elements[0].op == 'sendText') {
    		appendText(elements[0].name, elements[0].text);
    		newMessage();
    	}
    	else if (elements[0].op == 'loadTexts') {
			for ( var i = 1; i < elements.length; i++) {
	    		var element = elements[i];
	    		appendText(elements[i].name, elements[i].text);
	    	}
    	}
    	else if (elements[0].op == 'reCalculateIndex'){
    		ws.send('{"op":"reCalculateIndex"}');
    		
    	}
    	else if(elements[0].op == 'removeElement'){
    		
    		// This applies only for image removal task, because jQuery creates a
    		// div and put the <img> element inside to enable drag operation.
    		// When removing the div, jQuery returns the original <img> element to the DOM.
    		// So we need to search for the <img> element inside the div and remove it before
    		// removing the div itself.	
    		logArea("removeElement", elements[0].idNode, value, elements[0]);
    		var element = document.getElementById(elements[0].idNode);
    		
    		$(element).find('img').remove();
    		
    		// Remove any element provided
    		$(element).remove();
    	}
    	else if(elements[0].op == 'enablePublishStreaming'){ 
    		enablePublishStreaming(elements[0].idUser); 
	    } 
	    else if(elements[0].op == 'disablePublishStreaming'){ 
            disablePublishStreaming(elements[0].idUser); 
	    } 
	    else if(elements[0].op == 'enablePlayStreaming'){ 
            enablePlayStreaming(); 
	    } 
	    else if(elements[0].op == 'disablePlayStreaming'){ 
            disablePlayStreaming(); 
	    }
    };
}

/**
 * Method used to create the initial text area (empty)
 */
function createInitialTextArea(){
	
	libCreateInitialTextArea();
	
}


/**
 * Method used to create a text box area
 * 
 * @parem Id    : The id of the initial text area
 * @param Event : The JavaScript event
 */
function createTextBox(idNode, event) {

var div = libCreateTextBox(idNode, event);
	
	if(div != 0)
	updateElement(div, 'saveOrUpdate');
	
}

/** 
 * Method used to create a video in writing div by the youtube url 
 *  
 * @param Event : The JavaScript event 
 */ 
function createVideoBox(event) { 

	var div = libCreateVideoBox(event);
	
	if(div != 0) 
		updateElement(div, 'saveOrUpdate'); 

}

/**
 * Controls the keyboard events over one text box.
 * 
 * Focus + ESC (46) = remove from white board
 * Focus + Space (32) = start / stop drag
 * Focus + shift (16) = update text box
 * 
 * @param Node : The DOM node object
 * @param Event : The JavaScript event
 */
function keyboardEvents(node, event){
	
	libKeyboardEvents(node, event);
	
}

/**
 * Controls the mouse events over one text box 
 * 
 * alt + mouse = remove node from wite board
 * shift + mouse = update the text box area
 * ctrl + mouse = start / stop drag
 * 
 * @param Node : The DOM node object
 * @param Event : The JavaScript event
 */
function mouseEvents(node, event){
	
	libMouseEvents(node, event);
	
}

/**
 * Method used to create a text area with some content (text). It is used to 
 * update the text.
 * 
 * @param Node : The DOM node object
 */
function createTextArea(node){
	
	libCreateTextArea(node);
	
}

/**
 * The method is used to return to create an updated text box
 * 
 * @param Node : The DOM node object
 * @param Event : The JavaScript event
 */
function updateTextBox(node, event){
	
	var div = libUpdateTextBox(node, event);
	
	if(div != 0)
		updateElement(div, 'saveOrUpdate');
	
}

/**
 * Change the color of a text box area 
 * 
 * @param node object
 */
function changeColor(node){
	libChangeColor(node);
}

/**
 * Change the color of a text box area 
 * 
 * @param node object
 */
function returnColor(node){
	libReturnColor(node);
}

/**
 * Returns the id of a node
 * 
 * @param Node 	   : The DOM node object 
 * @returns String : The id of a node
 */
function getNodeId(node){
	return libGetNodeId(node);
}

/**
 * This method is used to organize the tab index in the white board
 */
function tabIndexCalculation(){
	
	var divArray = libTabIndexCalculation();
	
	for ( var j = 0; j < divArray.length; j++){
		var div = divArray[j];
		updateElement(div, 'saveOrUpdate');
	}
	
}

/**
 * Returns the top value in number (integer) format  
 * 
 * @param String    : The top value in string format (ex.: 0px)
 * @returns Integer : The top value
 */
function getTopValue(strTop){
	return libGetTopValue(strTop);
}

/**
 * Update the element in WebSocket server.
 * 
 * @param Node : The DOM node object 
 */
function updateElement(node, operation){
	console.log('updateElement function -> node='+node);
	// Retrieving the elements values
	var id = node.id;
	var tabIndex = node.tabIndex;
	
	var value = node.innerHTML;
	
	//Replace the enter "\n" for "<br>" in value
	var enterIndex;
	do{
		enterIndex = value.indexOf('\n');
		
	if (enterIndex != -1)
		value = libSetCharAt(value,enterIndex,"<br>");
		
	}while(enterIndex != -1);
		
	var left = node.style.left;
	var top = node.style.top;
	
	var idNode = "#" + getNodeId(node);
	var width = $(idNode).width() + "px";
	var height = $(idNode).height() + "px";		
	var rotation = 0;
	
	// If the element is an image
	if (node.id.indexOf('image') != -1) {
		tabIndex = node.parentNode.tabIndex;
		left = node.parentNode.style.left;
		top = node.parentNode.style.top;
		value = node.src;
		rotation = getRotateValue(node.parentNode);
	}

	if (node.id.indexOf('video') != -1) {
		value = libReplaceAll(value,'"','&quot;');
	}
	
	// Creating the JSON message in array format
	var message = '{"op":"'+operation+'",'
		+ '"id":"'+id+'",' 
		+ '"tabIndex":"'+tabIndex+'",'
		+ '"value":"'+value+'",'
		+ '"rotation":"'+rotation+'",'
		+ '"left":"'+left+'",'
		+ '"top":"'+top+'",'
		+ '"width":"'+width+'",'
		+ '"height":"'+height+'",'
		+ '"idProduction":"'+idProduction+'",'
		+ '"idUser":"'+idUser+'"}';
	
	console.log(message);
	// Sending the JSON message through WebSocket		
	ws.send(message);
}

/**
 * Loads a production from Server
 */
function loadProduction(){	
	var message = '{"op":"loadProduction","idProduction":"'+idProduction+'"}';
	ws.send(message);
}


function loadLog(element){
	
	reloadLogArea(element.action, element.type, element.value, element.user_name);
	
}
/**
 * Method used to load an element from WebSocket Server
 * 
 * @param JSON object : An object with elements values
 * @param string : Type of object (image or box)
 */
function loadElement(obj){
	// Ensuring the data is in the correct format
	obj = ajustElementPosition(obj);
	
	// Handle if element is equal box (text) or a youtubevideo
	if ((obj.id.indexOf('box') != -1)||(obj.id.indexOf('video') != -1)) {
				
		var div = document.createElement("div");
		
		// Remove an element to update with data 
		$('#' + obj.id).remove();
		
		div.id = obj.id;
		
		div.tabIndex = obj.tabindex;
		
		div.style.left = obj.left;
		div.style.top = obj.top;
		div.style.position = "absolute";
		
		div.style.width = obj.width;
		div.style.height = obj.height;
		
		div.setAttribute("onkeyup", "keyboardEvents(this, event)");
	    div.setAttribute("onmouseup", "mouseEvents(this, event)");
	    
		if(obj.id.indexOf('box') != -1){
			div.setAttribute("class", "box");
			div.setAttribute("onmouseover", "showTip('tipTextArea', '" + obj.id + "' )");
			div.setAttribute("onmouseout", "hideTip('tipTextArea')");
	    	div.setAttribute("onmouseover", "changeColor(this)");
	    	div.setAttribute("onmouseout", "returnColor(this)");
		    div.setAttribute("ondblclick", "libCreateTextArea(this)");
	    	div.innerHTML = obj.value;
		}else if(obj.id.indexOf('video') != -1){
	    	div.setAttribute("class", "youtubeVideo");
	    	div.innerHTML = libReplaceAll(obj.value, '&quot;', '"');
	    }

		if (tabCounter < parseInt(div.tabIndex))
			tabCounter = parseInt(div.tabIndex);
		
		document.getElementById('writing').appendChild(div);
		
		startElementDrag("#" + obj.id);
	} 
	// Handle if element is an image
	else {
		if (tabCounter < parseInt(obj.tabIndex))
			tabCounter = parseInt(obj.tabIndex);

		if(document.getElementById(obj.id) == null)
			initiateImage(obj);
		else{
			loadImage(obj.value, obj.top, obj.left, obj.width, obj.height, obj.id, obj.rotation, obj.tabIndex);		
		}
	}
}

/**
 * Add a user in the users div space
 * 
 * @param JSON object : An object with user name
 */
function loadUser(obj){
	var br = document.createElement("br");
	
	users[obj.user_id] = obj.name;
	
	var txtNode = document.createTextNode(obj.name); 
	
	var webCam = document.createElement("input"); 
	webCam.setAttribute("type", "image");
 	webCam.setAttribute("id", "imgSndEnblPblshStrmUser"+obj.user_id);
 	webCam.setAttribute("class", "imgSndEnblPblshStrmUser");
    if(ownerRoom){ 
        webCam.setAttribute("src", "pages/images/webcam.png"); 
        webCam.setAttribute("onclick", 'sendEnablePublishStreaming('+obj.user_id+')'); 
    }else{ 
        webCam.setAttribute("src", "pages/images/webcamDisable.png"); 
    }

	var divUsers = document.getElementById("users");
	divUsers.appendChild(webCam);
	divUsers.appendChild(txtNode);
	divUsers.appendChild(br);
	
}

function checkElement(obj){
	// Ensuring the data is in the correct format
	obj = ajustElementPosition(obj);
	
	// Handle if element is equal box (text)
	if (obj.id.indexOf('box') != -1) {
				
		var div = document.getElementById(obj.id);
		if(div != null){
			
			if(div.style.left != obj.left){
				//compare left
				return "updatePosition";
			}
			else if(div.style.top != obj.top){
				//compare top
				return "updatePosition";
			}
			else if(div.style.width != obj.width){
				//compare width
				return "updateDimension";
			}
			else if(div.style.height != obj.height){
				//compare height
				return "updateDimension";
			}
			else if(div.innerHTML != obj.value){
				//compare value
				return "updateText";
			}
		}else{
			return "newElement";
		}
	// Handle if element is equal an youtubevideo
	}else if(obj.id.indexOf('video') != -1){

		var div = document.getElementById(obj.id);
		if(div != null){
			if(div.style.left != obj.left){
				//compare left
				return "updatePosition";
			}
			else if(div.style.top != obj.top){
				//compare top
				return "updatePosition";
			}
		}else{
			return "newElement";
		}
	}
	// Handle if element is an image
	else {
		var div = document.getElementById(obj.id);
		if(div != null){
			if(div.style.left != obj.left){
				//compare left
				return "updatePosition";
			}
			else if(div.style.top != obj.top){
				//compare top
				return "updatePosition";
			}
		}else{
			return "newElement";
		}
	}
}

/**
 * Remove all users from user div space (div)
 */
function removeUsers(){
	
	libRemoveUsers();
	
}


/**
 * Remove all elements from witheboard
 */
function clearBoard(){
	
	libClearBoard();
	
}

/**
 * Verifies if the position data are in the right format
 * 
 * @param Object obj   : The object element with the data
 * 
 * @returns Object obj : Element with the right data
 */
function ajustElementPosition(obj){
	return libAjustElementPosition(obj);
}

//TODO test method
function endDrag(){	
	
	libEndDrag();
	
}

//TODO put into libWhiteBoard when midiateca is available
function endImageDragOrResize(imageId) {
	// Update image element
	console.log('imageId='+imageId);
	//libEndImageDragOrResize(imageId);
	//updateElement($(imageId)[0], 'saveOrUpdate');
	logArea("updatePosition", "image");
	tabIndexCalculation();
}

function callMidiateca() {	
	libCallMidiateca();	
}

/**
 * Remove one text box from white board
 * 
 * @param String : the id of node
 */
function removeFromWhiteBoard(idNode){
	var value = idNode[0].innerHTML;
	if(libRemoveFromWhiteBoard(idNode)){
		if(idNode[0].id != undefined){
			idNode = idNode[0].id;
		}else{
			idNode = idNode.replace("#", "");
		}
		var message = '{"op":"removeElement","idNode":"'+idNode+'", "idProduction":"'+idProduction+'", "idUser":"'+idUser+'"}';
		ws.send(message);
		logArea("removeElement", idNode, value);
	}
}

/**
 * Function to send of all users to enable button publish
 * 
 * @param	id of user
 **/
function sendEnablePublishStreaming(id) { 
    
    if(id==idUser){ 
        
    	enablePublishStreaming(id);

    	//Setting the message will send if the user is yourself
        var message = '{"op":"disablePublishStreaming", "idProduction":"'+idProduction+'", "idUser":"'+id+'"}';
        
    }else{ 
        
    	disablePublishStreaming(id);
    	
    	//Setting the message will send if the user isn't yourself
        var message = '{"op":"enablePublishStreaming", "idProduction":"'+idProduction+'", "idUser":"'+id+'"}';
        
    } 

    //Sending message
    ws.send(message); 

} 

/**
 * Function to send of all users to disable button publish
 * 
 * @param	id of user
 **/
function sendDisablePublishStreaming(id) { 
	         
        //Disable publish to me
		disablePublishStreaming(id);
	         
        //Sending message to all users
        var message = '{"op":"disablePublishStreaming", "idProduction":"'+idProduction+'", "idUser":"'+id+'"}';  
        ws.send(message); 

} 

/**
 * Function to enable of users the button publish
 * 
 * @param	id of user
 **/
function enablePublishStreaming(id){ 
 
	//Setting propertis of button publish
	$("#btnPublishStream").unbind("click"); 
	$("#btnPublishStream").bind("click", function(){ 
		publishStreaming(id) 
    }); 
	$("#btnPublishStream").attr("style", "background-image: url(pages/images/buttonPublish.png)"); 
	
	//Stopping the transmission and setting the image of webcam
    getPlayer().stopPublishStreaming();
    setCamTransmit(id); 
         
} 

/**
 * Function to disable of users the button publish
 * 
 * @param	id of user
 **/
function disablePublishStreaming(id){ 

    //Setting propertis of button publish
    $("#btnPublishStream").unbind("click"); 

    if(id==idUser){ 

    	$("#btnPublishStream").bind("click", function(){ 
    		publishStreaming(id) 
        }); 
        $("#btnPublishStream").attr("style", "background-image: url(pages/images/buttonPublish.png)"); 
        
    }else{ 

    	$("#btnPublishStream").attr("style", "background-image: url(pages/images/buttonPublishDisable.png)");
    	
    }
    
    //Stopping the transmission and setting the image of webcam
    getPlayer().stopPublishStreaming();
    setCamTransmit(id);

} 

/** 
* Function that publish one transmission
* 
*  @param	id of user
*/
function publishStreaming(id){ 

    //Send enable play/stop button to others users
	sendEnablePlayStreaming();
	
    //Setting the properties of button publish
    $("#btnPublishStream").unbind("click"); 
    $("#btnPublishStream").bind("click", function(){ 
        sendDisablePublishStreaming(id) 
    });  

    //Starting the transmission
	getPlayer().publishStreaming();
	getPlayer().stopStreaming();
    getPlayer().playStreaming();
} 

/** 
* Function that stop publish one transmission
* 
*  
*/
function stopPublishStreaming(){ 
	
	//Send disable play/stop button to others users
	sendDisablePlayStreaming();
	
	//Stopping the transmission
	getPlayer().stopPublishStreaming();

} 

/** 
* Function that send one message to others to enable buttons of play, stop and mute when transmit
* 
*  
*/
function sendEnablePlayStreaming(){
	
	//Enable play/stop button to me
	enablePlayStreaming();

	//Sending message to all users 
    var message = '{"op":"enablePlayStreaming", "idProduction":"'+idProduction+'"}'; 
    ws.send(message); 

}

/** 
* Function that send one message to others to disable buttons of play, stop and mute when no transmission
* 
*  
*/
function sendDisablePlayStreaming(){ 
	
	//Disable play/stop button to me
	disablePlayStreaming();

	//Sending message to all users
    var message = '{"op":"disablePlayStreaming", "idProduction":"'+idProduction+'"}'; 
    ws.send(message); 

} 

/** 
* Function that enable buttons of play, stop and mute when transmit
* 
*  
*/
function enablePlayStreaming(){ 

    //Setting properties of play/stop button
	$("#btnPlayStopStream").attr("style", "background-image: url(pages/images/buttonStop.png)"); 
    $("#btnPlayStopStream").unbind("click"); 
    $("#btnPlayStopStream").bind("click", function(){ 
    	stopStreaming()
    }); 
    
    //First call stop funtion and second call play function in swf 
    getPlayer().stopStreaming();
    getPlayer().playStreaming();
} 

/** 
* Function that disable buttons of play, stop and mute when no transmission
* 
*  
*/ 
function disablePlayStreaming(){ 
    
	//Settin properties of play/stop button
    $("#btnPlayStopStream").attr("style", "background-image: url(pages/images/buttonPlayDisable.png)"); 
    $("#btnPlayStopStream").unbind("click");

} 

/** 
* Function that call de method play() in FLEX (swf) archive
* 
*  
*/ 
function playStreaming(){ 

	//Setting properties of play/stop button
	$("#btnPlayStopStream").unbind("click"); 
	$("#btnPlayStopStream").bind("click", function(){ 
		stopStreaming()
	}); 
    $("#btnPlayStopStream").attr("style", "background-image: url(pages/images/buttonStop.png)"); 

    //Call function play in swf
    getPlayer().playStreaming();
    
} 

/** 
* Function that call de method stop() in FLEX (swf) archive
* 
*  
*/ 
function stopStreaming(){ 
	
	//Setting properties of play/stop button
    $("#btnPlayStopStream").unbind("click"); 
    $("#btnPlayStopStream").bind("click", function(){ 
        playStreaming() 
    }); 
    $("#btnPlayStopStream").attr("style", "background-image: url(pages/images/buttonPlay.png)"); 
    
    //Call function stop in swf
    getPlayer().stopStreaming();
    
}

/**
 * Function to get the first player in page
 * 
 * 
 **/
function getPlayer() {
    var o = document.getElementsByTagName("object");
    var e = document.getElementsByTagName("embed");
    if (e.length > 0 && typeof e[0].SetVariable != "undefined") {
        //window.alert('01')
        //window.alert( e[0].name )
        return e[0];
    }
    if (o.length > 0 && typeof o[0].SetVariable != "undefined") {
        //window.alert('02')
        if (navigator.appName.indexOf("Microsoft") != -1) {
            return window[ o[0].id ];
        } else {
            return document[ o[0].id ];
        }
    }
    if (o.length > 1 && typeof o[1].SetVariable != "undefined") {
        //window.alert('03')
        //window.alert( o[1].id )
        return o[1];
    }
    return undefined;
}

/**
 * Function to set the image of webcam that transmit
 * 
 * @param	id of user transmit
 **/
function setCamTransmit(id) {
	
	//Settin imagem of webcam of user transmit
	if(ownerRoom)
		$("#users").children(".imgSndEnblPblshStrmUser").attr("src", "pages/images/webcam.png");
	else
		$("#users").children(".imgSndEnblPblshStrmUser").attr("src", "pages/images/webcamDisable.png");
	
	$("#imgSndEnblPblshStrmUser"+id).attr("src", "pages/images/webcamTransmit.png");
	
}

/**
 * Function to get the url of red5 server
 * 
 * @return url of red5 server
 **/
function getRed5Server(){
	return red5Server;
}

/**
 * Função para carregar uma produção anterior dentro do roomTemplate
 */
function loadPreviusProduction() {
	var newIdProduction = document.getElementById('listProductions').options[document.getElementById('listProductions').selectedIndex].value; 
	var newProductionTitle = document.getElementById('listProductions').options[document.getElementById('listProductions').selectedIndex].innerHTML;
	
	document.getElementsByTagName("title")[0].innerHTML = newProductionTitle;
	
	oldProduction = idProduction;
	idProduction = parseInt(newIdProduction);
	
	// Remove All users
	removeUsers();
	
	// Clear the chat area
	clearChat();
	
	// Clear the withe board elements
	clearBoard();
	
	// Update table Online
	var message = '{"op":"updateTableOnline","idProduction":"'+idProduction+'","oldProduction":"'+oldProduction+'", "title":"'+newProductionTitle+'"}';
	ws.send(message);
	
	// Sending the production id to the WebSocketServer
	var message = '{"op":"loadUsers", "idProduction":"'+ idProduction +'", "idUser":"'+ idUser +'"}';
	ws.send(message);
	
	// Load messages from the chat 
	loadChatTexts();
	
	// Load the production
	loadProduction();
	
	setCookie("alteredProduction", idProduction, 1);
	
	libCloseModalWindow('#dialogLoadProduction');
	
}