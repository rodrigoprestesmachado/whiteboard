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

// From Application.js
// Verifies if we can create the text area
var isTextArea = true;

// TODO ajust tab counter value
var tabCounter = 12;

// From Drag.js
/* This array controls the disable nodes dragging */
var arrayNodesStoppedDragging = new Array();

// current focused element
var focusedElementId = null;

//Drag

/**
 *  Enable only one text boxes to drag
 *  
 *  @param String : the id of node  
 */
function libStartElementDrag(idNode){	
	$(idNode).draggable({ 
		disabled: false, 
		cursor: 'crosshair', 
		scroll: false, 
		stop: function(event, ui) { 
			logArea("updatePosition", ui.helper[0].id, ui.helper[0].innerHTML);
			endDrag();
		},
		containment: "#writing"
	});
	
	removeStopedDragArray(idNode);
}

/**
 *  Disable all text boxes to drag  
 */
function libStopElementDrag(idNode){
	
	$(idNode).draggable({ 
		disabled: true 
		});
	
	arrayNodesStoppedDragging.push(idNode);
}

/**
 * Verifies if a node is enable do drag 
 * 
 * @param String : the id of node
 * @returns {Boolean}
 */
function libIsNodeStopedDrag(idNode){
	for (x in arrayNodesStoppedDragging) {
		if (arrayNodesStoppedDragging[x] == idNode)
			return true;
	}
	return false;
}

/**
 * Remove a node (text box) from the array of stoped drag elements
 * 
 * @param String : the id of node
 */
function libRemoveStopedDragArray(idNode){
	for (x in arrayNodesStoppedDragging) {
		if (arrayNodesStoppedDragging[x] == idNode)
			arrayNodesStoppedDragging.splice(x);
	}
}


//Accessibility

/**
 * Shows the tip of a div element
 *  
 * @param String idNode : The id of a div that contains the tip
 */
function libShowTip(idNode, focus) {
	var tips = new Array();
	tips = document.getElementsByClassName("tip");
	for (var i = 0; i < tips.length; i++) {
		tips[i].style.display = "none";
	}
	document.getElementById(idNode).style.display = "inline";
	if (focus != null)
		document.getElementById(focus).focus();
}

/**
 * Hides the tip of a div element
 * 
 * @param String idNode : The id of a div that contains the tip
 */
function libHideTip(idNode) {
	document.getElementById(idNode).style.display = "none";
}

//Application

/**
 * Method used to create the initial text area (empty)
 */
function libCreateInitialTextArea(){
	
	if (isTextArea){
	
		// We can't create a text area
		isTextArea = false;
		
		var textarea = document.createElement("textarea");
		
		textarea.id = "initialTextArea";
		
		
		textarea.style.left = "252px";
		textarea.style.top = "132px";
		textarea.style.position = "absolute";
		textarea.tabIndex = 1;
		textarea.style.width = "300px";
		textarea.style.height = "50px";
		
		textarea.setAttribute("onmouseover", "showTip('tipTextArea', 'initialTextArea' )");
		textarea.setAttribute("onmouseout", "hideTip('tipTextArea')");
		textarea.setAttribute("onblur", "createTextBox('initialTextArea', event)");
		textarea.setAttribute("onkeyup", "createTextBox('initialTextArea', event)");
		textarea.setAttribute("aria-describedby", "tipTextArea");
		
		document.getElementById('writing').appendChild(textarea);
		
		document.getElementById(textarea.id).focus();
	}
}


/**
 * Method used to create a text box area
 * 
 * @parem Id    : The id of the initial text area
 * @param Event : The JavaScript event
 */
function libCreateTextBox(idNode, event) {

	textArea = document.getElementById(idNode);
	
	// Enable to create the initial text area
	if (textArea.value != "")
		isTextArea = true;
	
	// Esc (27) = cancel the operation
	if (event.keyCode == 27){
		if (confirm(getLabelCancelInsertion())) {
			$("#initialTextArea").remove();
			
			isTextArea = true;
		}
	}
	else{
		
		var value = textArea.value;
		
		//Replace the enter "\n" for "<br>" in value
		var enterIndex;
		do{
			enterIndex = value.indexOf('\n');
			
			if (enterIndex != -1)
				value = libSetCharAt(value,enterIndex,"<br>");
			
		}while(enterIndex != -1);
		
		// ctrl + space(32) or onblur = create the text box area
		if ((((event.keyCode == 32) && (event.ctrlKey)) || (event.type == 'blur')) && value != "" ){
	    	
			tabCounter = tabCounter + 1;
			
			textBoxId = "box" + tabCounter;
			
			focusedElementId = '#'+textBoxId;
			
			var div = document.createElement("div");
			
			div.style.left = "252px";
			div.style.top = "132px";
			div.style.position = "absolute";
			
			div.style.width = textArea.style.width;
			div.style.height = textArea.style.height;
			
	        div.setAttribute("class", "box");
	        div.setAttribute("id", textBoxId);
	        div.setAttribute("tabindex", tabCounter);
	        div.setAttribute("onkeydown", "keyboardEvents(this, event)");
	        div.setAttribute("onmousedown", "mouseEvents(this, event)");
	        div.setAttribute("onmouseover", "changeColor(this)");
	        div.setAttribute("onmouseout", "returnColor(this)");
	        div.setAttribute("ondblclick", "libCreateTextArea(this)");
	        
	        div.innerHTML = value;
	        
	        // Removing the node
			$('#initialTextArea').remove();
	        
			document.getElementById("writing").insertBefore(div, document.getElementById('writing').firstChild);
			
	        // put the text box to drag
	    	startElementDrag("#" + textBoxId);
	    	
	    	//botar logArea aqui
	    	logArea("newElement",textBoxId, div.innerHTML);
	    	
	    	return div;
	    	
	    }
	}
	return 0;
}

/**
 * Method used to create a video box with de url of youtube video
 *
 * @parem no params
 * @returns the div with de youtube video
 */
function libCreateVideoBox(event) {
	
	var value = $('#inputYoutubeVideo').val();
	var idVideoYoutubeURL=libGetIdVidoYoutubeURL(value);
	if(idVideoYoutubeURL!=false){
		tabCounter = tabCounter + 1;
		videoId = "video" + tabCounter;
		
		focusedElementId = '#'+videoId;
		
		var div = document.createElement("div");
		
		div.style.left = "252px";
		div.style.top = "132px";
		div.style.position = "absolute";
		div.setAttribute("class", "youtubeVideo");
		div.setAttribute("id", videoId);
		div.setAttribute("tabindex", tabCounter);
		div.setAttribute("onkeydown", "keyboardEvents(this, event)");
		div.setAttribute("onmousedown", "mouseEvents(this, event)");

		var embed = document.createElement("embed");
		embed.setAttribute("src", "http://www.youtube.com/v/"+idVideoYoutubeURL+"?version=3&amp;hl=pt_BR");
		embed.setAttribute("type", "application/x-shockwave-flash");
		embed.setAttribute("width", "220");
		embed.setAttribute("height", "165");
		embed.setAttribute("allowscriptaccess", "always");
		embed.setAttribute("allowfullscreen", "true");
		embed.setAttribute("wmode", "transparent");
		
		var object = document.createElement("object");
		object.appendChild(embed);

		div.appendChild(object);

		document.getElementById("writing").insertBefore(div, document.getElementById('writing').firstChild);
       
		// put the text box to drag
		startElementDrag("#" + videoId);
		
		//botar logArea aqui
		logArea("newElement",videoId,embed.src);

		return div;
	}
	$('#inputYoutubeVideo').val('Insira uma URL de video do YOUTUBE valida');

	return 0;
}

/**
 * Controls the keyboard events over one text box.
 * 
 * Focus + Delete (46) = remove from white board
 * Focus + Space (32) = start / stop drag
 * Focus + M (77) = open a form to move de txt box
 * Focus + shift (16) = update text box
 * 
 * @param Node : The DOM node object
 * @param Event : The JavaScript event
 */
function libKeyboardEvents(node, event){
	
	// Gets the node id
	var idNode = "#" + getNodeId(node);
	// Gets the node class
	var classNode = libGetNodeClass(node);
	// The class youtubeVideo 
	var validClass=/youtubeVideo/g;
	
	if (event.keyCode == 46) {		
		removeFromWhiteBoard(idNode);		
	}
	else if(event.keyCode == 77)
		libOpenModalMvElement(node);
	else if (event.keyCode == 16){
		var resultado = validClass.test(classNode);
		if(resultado==false && classNode.indexOf('wrapper') == -1)
			createTextArea(node);
	}
	else if ((isNodeStopedDrag(idNode)) && (event.keyCode == 32)) {
		startElementDrag(idNode);
		// Handle ondragend event using jQuery
    	$(idNode).bind( "dragstop", function(event, ui) {
        	  endDrag();
        });
	}
	else {
		if(event.keyCode == 32)
			stopElementDrag(idNode);
	}
}

/**
 * Controls the mouse events over one text box 
 * 
 * alt + mouse = remove node from wite board
 * double click mouse = update the text box area
 * ctrl + mouse = start / stop drag
 * 
 * @param Node : The DOM node object
 * @param Event : The JavaScript event
 */
function libMouseEvents(node, event){
	
	focusedElementId = '#' + getNodeId(node);
	
	if (event.shiftKey){
		var idNode = '#' + getNodeId(node);
		removeFromWhiteBoard(idNode);
	}
	else{
		// Gets the nodes id
		var idNode = "#" + node.attributes["id"].value;
		
		if ((isNodeStopedDrag(idNode)) && (event.ctrlKey)) {
			startElementDrag(idNode);			
		}
		else{
			if(event.ctrlKey)
				stopElementDrag(idNode);
		}
	}
}

/**
 * Method used to create a text area with some content (text). It is used to 
 * update the text.
 * 
 * @param Node : The DOM node object
 */
function libCreateTextArea(node){
	
	if (isTextArea){
		
		isTextArea = false;
	
		var idNode = '#' + getNodeId(node);
		
		// Creating text area to edit the text
		var textarea = document.createElement("textarea");
		
		// Variables to help in the change of <br> for \n
		var value = node.innerHTML;
		var enterIndex;
		
		textarea.tabIndex = node.tabIndex;
		textarea.id = node.id;
		
		textarea.style.position = "absolute";
		textarea.style.left = node.style.left;
		textarea.style.top = node.style.top;
		
		textarea.style.width = $(idNode).width() + "px";
		textarea.style.height = $(idNode).height() + "px";
		
		textarea.setAttribute("onmouseover", "showTip('tipTextArea', '" + node.id + "')");
		textarea.setAttribute("onmouseout", "hideTip('tipTextArea')");
		textarea.setAttribute("onblur", "updateTextBox(this, event)");
		textarea.setAttribute("onkeyup", "updateTextBox(this, event)");		
		textarea.setAttribute("aria-describedby", "tipTextArea");
		
		//Replace the enter "<br>" for "\n" in value
		do{
			enterIndex = value.indexOf('<br>');
			
		if (enterIndex != -1)
			value = libSetCharAt(value,enterIndex,"\n");
			
		}while(enterIndex != -1);
		
		textarea.innerHTML = value;
		
		// Removing the old node
		$(idNode).empty();
		$(idNode).remove();
		
		document.getElementById('writing').insertBefore(textarea, document.getElementById('writing').firstChild);
	}
}

/**
 * The method is used to return to create an updated text box
 * 
 * @param Node : The DOM node object
 * @param Event : The JavaScript event
 */
function libUpdateTextBox(node, event){
	
	// Esc (27) = cancel the operation
	
		if (event.keyCode == 27 || event.keyCode == undefined){
		
		var value = node.innerHTML;
		
		// ctrl + space(32) or onblur = create the text box area
		if ((((event.keyCode == 32) && (event.ctrlKey)) || (event.type == 'blur')) && value != "" || event.keyCode == 27){
	    	isTextArea = true;
			var idNode = "#" + getNodeId(node);
			
			// Returning the updated text box
			var div = document.createElement("div");

			var textAreaValue = document.getElementById(node.id).value;
			var enterIndex;			
			
			div.tabIndex = node.tabIndex;
			div.id = node.id;
			
			div.style.position = "absolute";
			div.style.left = node.style.left;
			div.style.top = node.style.top;
			
			div.style.width = $(idNode).width() + "px";
			div.style.height = $(idNode).height() + "px";		
			
			div.setAttribute("class", "box");
			div.setAttribute("onkeydown", "keyboardEvents(this, event)");
			div.setAttribute("onmousedown", "mouseEvents(this, event)");
			div.setAttribute("onmouseover", "changeColor(this)");
			div.setAttribute("onmouseout", "returnColor(this)");
			div.setAttribute("ondblclick", "libCreateTextArea(this)");
			
			//Replace the enter "\n" for "<br>" in value
			do{
				enterIndex = textAreaValue.indexOf('\n');
				
			if (enterIndex != -1)
				textAreaValue = libSetCharAt(textAreaValue,enterIndex,"<br>");
			
			}while(enterIndex != -1);
			
			div.innerHTML = textAreaValue;
			
			if($(idNode).innerHTML != div.innerHTML){
				logArea("updateText", node.id, div.innerHTML);
			}
			
			// Removing the node
			$(idNode).empty();
			$(idNode).remove();
			
			document.getElementById('writing').insertBefore(div, document.getElementById('writing').firstChild);
			
			startElementDrag(idNode);
						
			return div;
			
	    }
	}
	return 0;
}

/**
 * Remove one text box from white board
 * 
 * @param String : the id of node
 */
function libRemoveFromWhiteBoard(idNode){
	if (confirm(getLabelDeleteElement())) {
		
		// This applies only for image removal task, because jQuery creates a
		// div and put the <img> element inside to enable drag operation.
		// When removing the div, jQuery returns the original <img> element to the DOM.
		// So we need to search for the <img> element inside the div and remove it before
		// removing the div itself.		
		$(idNode).find('img').remove();
		
		// Remove any element provided
		$(idNode).remove();
		return true;
	}
	return false;
}

/**
 * Change the color of a text box area 
 * 
 * @param node object
 */
function libChangeColor(node){
	node.style.background = "#FFFF66";
}

/**
 * Change the color of a text box area 
 * 
 * @param node object
 */
function libReturnColor(node){
	node.style.background = "#D8D8D8";
}

/**
 * Returns the id of a node
 * 
 * @param Node 	   : The DOM node object 
 * @returns String : The id of a node
 */
function libGetNodeId(node){
	return node.attributes["id"].value;
}

/** 
 * Returns the css class of a node 
 *  
 * @param Node     : The DOM node object  
 * @returns String : The css class of a node 
 */ 
function libGetNodeClass(node){ 
        return node.attributes["class"].value; 
}

/**
 * This method is used to organize the tab index in the white board
 */
function libTabIndexCalculation(){
	
	var div1, div2, x, y, temp;
	var divArray = new Array();
	var returnArray = new Array();
	
	var writingNode = document.getElementById('writing');
	var childrenList = writingNode.children;
	
	for ( var i = 0; i < childrenList.length; i++) {
		var div = childrenList[i];
		
		// Put the zero value if it doesn't
		if (div.style.top == "")
			div.style.top = "0px";
		
		divArray.push(div);
	}
	
	if (divArray.length > 1){	
		
		// Bubble Sort
		for(x = 0; x < divArray.length; x++) {
			for(y = 0; y < (divArray.length-1); y++) {
		      
				div1 = divArray[y];
				div2 = divArray[y+1];
				
				if(getTopValue(div1.style.top) < getTopValue(div2.style.top)) {
					temp = div2;
					divArray[y+1] = div1;
					divArray[y] = temp;
				}
			}
		}
		
	}
	
	// Organize the tab index after sort
	for ( var j = 0; j < divArray.length; j++) {
		
		var div = divArray[j];
		
		div.tabIndex = tabCounter - j;
	
		if(div.id.indexOf("image") != -1)
			div = div.firstChild;
		
		returnArray.push(div);
	}
	
	return returnArray;
}

/**
 * Returns the top value in number (integer) format  
 * 
 * @param String    : The top value in string format (ex.: 0px)
 * @returns Integer : The top value
 */
function libGetTopValue(strTop){
	return parseInt(strTop.substring(0, strTop.length - 2));
}

/**
 * Remove all users from user div space (div)
 */
function libRemoveUsers(){
	var divUsers = document.getElementById("users");
	if (divUsers.hasChildNodes()){
	    while ( divUsers.childNodes.length >= 1 )
	    	divUsers.removeChild( divUsers.firstChild );       
	}
}


/**
 * Remove all elements from witheboard
 */
function libClearBoard(){
	var divWriting = document.getElementById("writing");
	if (divWriting.hasChildNodes()){
	    while ( divWriting.childNodes.length >= 1 )
	    	divWriting.removeChild( divWriting.firstChild );       
	}
}

/**
 * Verifies if the position data are in the right format
 * 
 * @param Object obj   : The object element with the data
 * 
 * @returns Object obj : Element with the right data
 */
function libAjustElementPosition(obj){
	var str = '' + obj.left;
	if (str.search("px") ==  -1)
		obj.left = str + 'px';
	
	str = '' + obj.top;
	if (str.search("px") ==  -1)
		obj.top = str + 'px';
	
	str = '' + obj.width;
	if (str.search("px") ==  -1)
		obj.width = str + 'px';
	
	str = '' + obj.height;
	if (str.search("px") ==  -1)
		obj.height = str + 'px';
	
	return obj;
}

//TODO test method
function libEndDrag(){
	console.log("endDrag() called");
	
	tabIndexCalculation();
}

function libEndImageDragOrResize(imageId) {
	// Update image element
	console.log('imageId='+imageId);
	
	updateElement($(imageId)[0], 'saveOrUpdate');
}

function libCallMidiateca() {	
	$("#dialog-modal").dialog('open');
}

function libSetCharAt(str,index,chr) {
    if(index > str.length-1) return str;
    if(chr.length > 1)
    	return str.substr(0,index) + chr + str.substr(index+1);
    else
    	return str.substr(0,index) + chr + str.substr(index+4);
}

/**
 * Move a node by the modal window
 * 
 * @param no params
 */
function libMoveElement(){
	var idElement = $('#s-mvElement').val();
	
	var wElement = $(idElement).width(); 
	var hElement = $(idElement).height();
	
	var wWrtng = $('#writing').width();
	var hWrtng = $('#writing').height();
	
	var writingXYPosition = $('#writing').position();
	var writingXPosition = writingXYPosition.left;
	var writingYPosition = writingXYPosition.top;
	
	var elementXYPosition = $(idElement).position();
	var elementPosition = $(idElement).css('position');
	
	var xDisplacement = $('#x-mvElement').val();
	var yDisplacement = $('#y-mvElement').val();
	
	if($('input:radio[name=direction-x]:checked').val()=='l')
		xDisplacement=xDisplacement*(-1);
	else
		xDisplacement=xDisplacement*(1);
	
	if($('input:radio[name=direction-y]:checked').val()=='t')
		yDisplacement=yDisplacement*(-1);
	else
		yDisplacement=yDisplacement*(1);
	
	if(elementPosition=='relative'){
		var xMinPosition = 0;
		var yMinPosition = 0;
		var xMaxPosition = wWrtng-wElement-2;
		var yMaxPosition = hWrtng-hElement-2;
		
		var elementXPosition=elementXYPosition.left-1;
		var elementYPosition=elementXYPosition.top-68;
		
	}
	else if(elementPosition=='absolute'){
		var xMinPosition = writingXPosition;
		var yMinPosition = writingYPosition;
		var xMaxPosition = wWrtng-wElement-2+writingXPosition;
		var yMaxPosition = hWrtng-hElement-2+writingYPosition;
		
		var elementXPosition=elementXYPosition.left;
		var elementYPosition=elementXYPosition.top;
	}
	
	var newXPosition=elementXPosition+xDisplacement;
	var newYPosition=elementYPosition+yDisplacement;	
	
	if(newXPosition<xMinPosition)
		newXPosition=xMinPosition;
	else if(newXPosition>xMaxPosition)
		newXPosition=xMaxPosition;
	
	if(newYPosition<yMinPosition)
		newYPosition=yMinPosition;
	else if(newYPosition>yMaxPosition)
		newYPosition=yMaxPosition;
	
	$(idElement).css('left', newXPosition);
	$(idElement).css('top', newYPosition);
	
	tabIndexCalculation();
	
	$('#dialogMoveElement').dialog('close');
}

/**
 * Open modal to move the element
 * 
 * 
 * @param idNode
 */
function libOpenModalMvElement(idNode){
		if(typeof(idNode)=="string"){
			var idElement="#"+idNode;
		}else{
			var idElement="#"+getNodeId(idNode);
		}

		libClearValuesModalWindowMvElement();
		var divWriting = document.getElementById('writing');
		var elements = divWriting.getElementsByTagName('div');
		if(elements.length>=1){
			
			var currentPosition = $(idElement).css('position');
			var currentXYPosition = $(idElement).position(); 
			
			var currentXPosition=currentXYPosition.left;
			var currentYPosition=currentXYPosition.top;
			
			var wElement=parseInt($(idElement).width());
			var hElement=parseInt($(idElement).height());
			
			var writingPosition = $('#writing').css('position');
			var writingXYPosition = $('#writing').position();
			var writingXPosition = writingXYPosition.left;
			var writingYPosition = writingXYPosition.top;
			
			var wWriting = $('#writing').width();
			var hWriting = $('#writing').height();
			
			$('#s-mvElement').val(idElement);
			
			$('#i-mvElementWidth').val(wElement);
			$('#i-mvElementHeight').val(hElement);
			
			if(currentPosition=='relative'){
				currentXPosition=currentXPosition-1;
				currentYPosition=currentYPosition-71;
			
				$('#i-mvElementAPointsL').val(parseInt(currentXPosition));
				$('#i-mvElementAPointsR').val(parseInt($('#writing').width()-$(idElement).width()-currentXPosition));
				$('#i-mvElementAPointsT').val(parseInt(currentYPosition));
				$('#i-mvElementAPointsB').val(parseInt($('#writing').height()-$(idElement).height()-currentYPosition)+2);
				
			}else if(currentPosition=='absolute'){
				if(writingXPosition>currentXPosition){
					var aPointsL=0;
				}else{
					var aPointsL=parseInt(currentXPosition-writingXPosition);
				}
				var aPointsR = parseInt(wWriting-wElement-aPointsL);
				var aPointsT = parseInt(currentYPosition-writingYPosition);
				var aPointsB = parseInt(hWriting-hElement-aPointsT);
				
				$('#i-mvElementAPointsL').val(aPointsL);
				$('#i-mvElementAPointsT').val(aPointsT);
				$('#i-mvElementAPointsR').val(aPointsR-2);
				$('#i-mvElementAPointsB').val(aPointsB-2);
				
			}
			libOpenModalWindow('#dialogMoveElement');
		}
}

/**
 * Function to open modal window
 * 
 * 
 * @params: no params 
 */
function libOpenModalWindow(idModal){
	
	$(idModal).dialog('open');
}

/**
 * Function to open modal window
 * 
 * 
 * @params: no params 
 */
function libCloseModalWindow(idModal){
	
	$(idModal).dialog('close');
}

function libClearValuesModalWindowMvElement(){
	$('#s-mvElement').val(" ");
	
	$('#i-mvElementAPointsL').val(" ");
	$('#i-mvElementAPointsR').val(" ");
	$('#i-mvElementAPointsT').val(" ");
	$('#i-mvElementAPointsB').val(" ");
	
	$('#i-mvElementWidth').val(" ");
	$('#i-mvElementHeight').val(" ");
	
	$('#x-mvElement').val(" ");
	$('#y-mvElement').val(" ");
}

/** 
 * Function to get de id video of youtube url video paste 
 *  
 * @param url 
 * @returns the id or false case the url is not a valid youtube video 
 */ 
function libGetIdVidoYoutubeURL(url){
	
	var params=url.split('/'); 
	
	for ( var int = 0; int < params.length; int++) {
		
		if(params[int]=='www.youtube.com'||params[int]=='www.youtube.com.br'){ 
			var atribs = params[int+1]; 
			
			params.length=0; 
           	params=atribs.split('?') 
			
           	int=-1; 
		}
		else if(params[int]=='watch'){
			
			var atribs = params[int+1]; 
			var param=atribs.split('&');
			
			if(param.length>0){ 
                for ( var int2 = 0; int2 < param.length; int2++) { 
                    
                	var atrib=param[int2].split('='); 
               		
                	for ( var int3 = 0; int3 < atrib.length; int3++) { 
						if(atrib[int3]=='v'||atrib[int3]=='V') 
							return atrib[int3+1]; 
					}
                	
				} 
			} 
		}              
	} 
	return false; 
}

/**
 * Function to replace all characters of one string
 *
 * @params string, token, newtoken: The string with the character, the character and the New character
 * @returns string: The string replaced
 */
function libReplaceAll(string, token, newtoken) {
	while (string.indexOf(token) != -1) {
 		string = string.replace(token, newtoken);
	}
	return string;
}

/**
 * Controls the keyboard events on WhiteBoard.
 * 
 * On RoomTemplate:
 * Alt + T = Button to add Text;
 * Alt + V = Button to add Videos;
 * Alt + I = Button to add Images;
 * Alt + L = Button rolate image to Left;
 * Alt + R = Button rolate image to Right ;
 * Alt + O = Button to open a previus production;
 * Alt + E = Button Exit Room;
 * Alt + M = Input Message of chat;
 * Alt + S = Button Send message of chat;
 * Alt + F = Button invite Friends;
 * Alt + A = Button to open dialog modal of shortCuts;
 * Alt + H = Button to open dialog modal of Help;
 * Alt + P = Button Publish webCam;
 * Alt + Q = Button play/stop webcam;
 * 
 * On UserPage:
 * Alt + E = Button Logout;
 * Alt + U = Button Update account;
 * Alt + N = Button to create New room;
 * Alt + C = Input to Enter RoomCode;
 * Alt + R = Button enter RoomCode;
 * 
 * On LoginForm:
 * Alt + L = Input of e-mail (login);
 * Alt + P = Input of password;
 * Alt + S = Button Login;
 * Alt + R = Button Register;
 * 
 */
document.onkeydown = function(e){ 
	var keychar; 
	
	// Internet Explorer 
	try { 
	keychar = String.fromCharCode(event.keyCode); 
	e = event; 
	} 
	
	// Firefox, Opera, Chrome e outros 
	catch(err) { 
	keychar = String.fromCharCode(e.keyCode); 
	} 
		
	if (e.altKey && keychar == 'T') { 
		document.getElementById('btnText').focus();
		return false; 
	} 
	
	if (e.altKey && keychar == 'V') { 
		document.getElementById('btnVideo').focus();
		return false; 
	} 
	
	if (e.altKey && keychar == 'I') { 
		document.getElementById('btnImage').focus();
		return false; 
	} 
	
	if (e.altKey && keychar == 'L') { 
		if (document.getElementById('btnRolateLeft'))
			document.getElementById('btnRolateLeft').focus();
		else
			document.getElementById('textEmail').focus();
		return false; 
	} 
	
	if (e.altKey && keychar == 'R') { 
		if (document.getElementById('btnRolateRight'))
			document.getElementById('btnRolateRight').focus();
		else {
			if (document.getElementById('btnEnterRoomCode'))
				document.getElementById('btnEnterRoomCode').focus();
			else
				document.getElementById('textbtnRegister').focus();
		}
		return false; 
	} 
	
	if (e.altKey && keychar == 'O') { 
		document.getElementById('btnOpenProduction').focus();
		return false; 
	} 
	
	if (e.altKey && keychar == 'E') { 
		if (document.getElementById('btnExitRoom'))
			document.getElementById('btnExitRoom').focus();
		else
			document.getElementById('btnLogoutUserPage').focus();
		return false; 
	}
	
	if (e.altKey && keychar == 'M') { 
		document.getElementById('chatInput').focus();
		return false; 
	}
	
	if (e.altKey && keychar == 'S') { 
		if (document.getElementById('btnSendMsg'))
			document.getElementById('btnSendMsg').focus();
		else
			document.getElementById('textSubmit').focus();
		return false; 
	}
	
	if (e.altKey && keychar == 'F') { 
		document.getElementById('btnInviteFriend').focus();
		return false; 
	}
	
	if (e.altKey && keychar == 'A') { 
		document.getElementById('btn1').focus();
		return false; 
	}
	
	if (e.altKey && keychar == 'H') { 
		document.getElementById('btn7').focus();
		return false; 
	}
	
	if (e.altKey && keychar == 'P') { 
		if (document.getElementById('btnPublishStream'))
			document.getElementById('btnPublishStream').focus();
		else
			document.getElementById('textPassword').focus();
		return false; 
	}
	
	if (e.altKey && keychar == 'Q') { 
		document.getElementById('btnPlayStopStream').focus();
		return false; 
	}
	
	// User Page
	
	if (e.altKey && keychar == 'U') { 
		document.getElementById('btnUpdateAccount').focus();
		return false; 
	}
	
	if (e.altKey && keychar == 'N') { 
		document.getElementById('btnOpenNewRoomForm').focus();
		return false; 
	}
	
	if (e.altKey && keychar == 'C') { 
		document.getElementById('textRoomCode').focus();
		return false; 
	}
	
} 