<script>
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
 
logArea = function(action, id, value, obj){
	var type;
		
	if(value == undefined)
		value = "";
	
	var div = document.getElementById("logArea");
	if(obj == undefined)
		person = '<?php  echo $msgs->getText('logArea.owner'); ?>';
	else
		person = users[obj.idUser];
	
	
	//POSITION
	if(action == "updatePosition"){
		if(id.indexOf('box') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.updateTextPosition'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'box';
		}
		else if(id.indexOf('video') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.updateVideoPosition'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'video';
		}
		else if(id.indexOf('image') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.updateImagePosition'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'image';
		}
	} //DIMENSION
	else if(action == "updateDimension"){
		if(id.indexOf('box') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.updateTextDimension'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'box';
		}
		else if(id.indexOf('video') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.updateVideoDimension'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'video';
		}
		else if(id.indexOf('image') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.updateImageDimension'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'image';
		}
	} //UPDATE CONTENT
	else if(action == "updateText"){
		if(id.indexOf('box') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.updateTextContent'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'box';
		}
		else if(id.indexOf('video') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.updateVideoContent'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'video';
		}
		else if(id.indexOf('image') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.updateImageContent'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'image';
		}
	} //NEW ELEMENT
	else if(action == "newElement"){
		if(id.indexOf('box') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.newText'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'box';
		}
		else if(id.indexOf('video') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.newVideo'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'video';
		}
		else if(id.indexOf('image') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.newImage'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'image';
		}
	}
	else if(action == "removeElement"){
		if(id.indexOf('box') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.rmvText'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'box';
		}
		else if(id.indexOf('video') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.rmvVideo'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'video';
		}
		else if(id.indexOf('image') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.rmvImage'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'image';
		}
	}
	value = libReplaceAll(value,'"','&quot;');
	
	if(person == '<?php  echo $msgs->getText('logArea.owner'); ?>'){
	var message = '{"op":"productionHistory",'
				  +'"action":"'+action+'", '
				  +'"idProduction":"'+idProduction+'",'
				  +'"idUser":"'+idUser+'",'
				  +'"type":"'+type+'",'
				  +'"nameUser":"'+users[idUser]+'",'
				  +'"value":"'+value+'"}';
	ws.send(message);
	}

	// Put the content to bottom
	var divLogContent = document.getElementById("logArea");
	divLogContent.scrollTop = divLogContent.scrollHeight;
}

reloadLogArea = function(action, id, value, name){
	var type;
		
	if(value == undefined)
		value = "";
	
	var div = document.getElementById("logArea");
	if(name == users[idUser])
		person = '<?php  echo $msgs->getText('logArea.owner'); ?>';
	else
		person = name;
	
	
	//POSITION
	if(action == "updatePosition"){
		if(id.indexOf('box') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.updateTextPosition'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'box';
		}
		else if(id.indexOf('video') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.updateVideoPosition'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'video';
		}
		else if(id.indexOf('image') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.updateImagePosition'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'image';
		}
	} //DIMENSION
	else if(action == "updateDimension"){
		if(id.indexOf('box') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.updateTextDimension'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'box';
		}
		else if(id.indexOf('video') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.updateVideoDimension'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'video';
		}
		else if(id.indexOf('image') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.updateImageDimension'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'image';
		}
	} //UPDATE CONTENT
	else if(action == "updateText"){
		if(id.indexOf('box') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.updateTextContent'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'box';
		}
		else if(id.indexOf('video') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.updateVideoContent'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'video';
		}
		else if(id.indexOf('image') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.updateImageContent'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'image';
		}
	} //NEW ELEMENT
	else if(action == "newElement"){
		if(id.indexOf('box') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.newText'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'box';
		}
		else if(id.indexOf('video') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.newVideo'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'video';
		}
		else if(id.indexOf('image') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.newImage'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'image';
		}
	}
	else if(action == "removeElement"){
		if(id.indexOf('box') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.rmvText'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'box';
		}
		else if(id.indexOf('video') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.rmvVideo'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'video';
		}
		else if(id.indexOf('image') != -1){
			div.appendChild(document.createTextNode(" <?php  echo $msgs->getText('logArea.rmvImage'); ?> "+person));
			div.appendChild(document.createElement("br"));
			type = 'image';
		}
	}

	// Put the content to bottom
	var divLogContent = document.getElementById("logArea");
	divLogContent.scrollTop = divLogContent.scrollHeight;
}

/**
 * Appending the text into the chat content area
 * 
 * @param String : A text to be appending
 */
function appendText(user, text){
	var bold = document.createElement("B");
	var br = document.createElement("br");
	bold.appendChild(document.createTextNode(user+" <?php  echo $msgs->getText('chat.Say'); ?>"));
	var txtNode = document.createTextNode(": " +  text); 
	var divChatContent = document.getElementById("chatContent");
	divChatContent.appendChild(bold);
	divChatContent.appendChild(txtNode);
	divChatContent.appendChild(br);
	
	// Put the content to bottom
	var divChatContent = document.getElementById("chatContent");
	divChatContent.scrollTop = divChatContent.scrollHeight;
}

function getLabelDeleteElement() {
	var label = '<?php echo $msgs->getText('delete.label'); ?>';
	return label;
}

function getLabelCancelInsertion() {
	var label = '<?php echo $msgs->getText('cancel.label'); ?>';
	return label;
}
</script>