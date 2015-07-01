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

/**
 * Sends the chat message (text) to others
 */
function sendChatText(){
	// Get the text
	var text = document.getElementById('chatInput').value;
	
	if (text != ""){
		
		text = libReplaceAll(text, "\\", "");
		// Put the text in the chat content area
		appendText(userName, text);
		
		// Clean the input text field
		var chatInput = document.getElementById('chatInput');
		chatInput.value = "";
		
		// Saving into data base and sending the text to others
		var message = '{"op":"sendText","text":"'+text+'","lang":"'+lang+'",';
		message += '"idProduction":"'+idProduction+'","name":"'+userName+'","idUser":"'+idUser+'"}';;
		ws.send(message);
	}
}

/**
 * Sends the chat message (text) to others from keyboard
 * 
 * @param Javascript event
 */
function sendChatTextFromKeyboard(event){
	// Enter = 13
	if (event.keyCode == 13)
		sendChatText();
}

/**
 * Load the messages from the server
 */
function loadChatTexts(){
	var message = '{"op":"loadTexts","idProduction":"'+idProduction+'"}';
	ws.send(message);
}

//The appendText function is in jsLocalization.php for now on

/**
 * Remove all text from the chat content area
 */
function clearChat() {
	var chatContentDiv = document.getElementById("chatContent");
	if (chatContentDiv.hasChildNodes()){
	    while ( chatContentDiv.childNodes.length >= 1 )
	    	chatContentDiv.removeChild( chatContentDiv.firstChild );       
	}
}

function newMessage() {
	var title = document.getElementsByTagName("title")[0].innerHTML;
	
	if(title.indexOf('(') != -1){
		var number = title.substring(title.indexOf('(')+1,title.indexOf(')'));
		number = parseInt(number);
		number = number + 1;
		
		title = title.substring(0, title.indexOf('(')+1) +
				number +
				title.substring(title.indexOf(')'), title.length);
		document.getElementsByTagName("title")[0].innerHTML = title;
	}
	else{
		
		title = "(1) "+title;
		document.getElementsByTagName("title")[0].innerHTML = title;
	}
}

function alreadyRead(){
	var title = document.getElementsByTagName("title")[0].innerHTML;
	
	if(title.indexOf('(') != -1){
		title = title.substring(title.indexOf(')')+1, title.length);
		document.getElementsByTagName("title")[0].innerHTML = title;
	}
}