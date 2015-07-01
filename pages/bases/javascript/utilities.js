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
 * Moves the selected item from one list to another list
 * 
 * @param MenuOrigem 	   : List of selected Item
 * @param MenuDestino 	   : List which the item will be moved
 */
function move(MenuOrigem, MenuDestino){
    var arrMenuOrigem = new Array();
    var arrMenuDestino = new Array();
    var arrLookup = new Array();
    
    for (var i = 0; i < MenuDestino.options.length; i++){
        arrLookup[MenuDestino.options[i].text] = MenuDestino.options[i].value;
        
        arrMenuDestino[i] = MenuDestino.options[i].text;
        
        for(var k = 0; k < MenuOrigem.options.length; k++){
        	if (MenuOrigem.options[k].selected)
        		if ("Selecionado "+MenuOrigem.options[k].text == MenuDestino.options[i].text)
        			arrMenuDestino.splice(i, 1);
        }
    }
    
    var fLength = 0;
    var tLength = arrMenuDestino.length;
    for(var i = 0; i < MenuOrigem.options.length; i++){
        arrLookup[MenuOrigem.options[i].text] = MenuOrigem.options[i].value;
        
        var control = true;
        for(var k = 0; k < MenuDestino.options.length; k++){
        	if ("Selecionado "+MenuDestino.options[k].text == MenuOrigem.options[i].text)
    			control = false;
        }
        
        if (control){
	        if (MenuOrigem.options[i].selected && MenuOrigem.options[i].value != ""){
	        	if (typeof arrLookup["Selecionado "+MenuOrigem.options[i].text] == "undefined") {
		            arrLookup["Selecionado "+MenuOrigem.options[i].text] = MenuOrigem.options[i].value;
		            arrMenuOrigem[fLength++] = "Selecionado "+MenuOrigem.options[i].text;
	        	}
	        	arrMenuDestino[tLength++] = MenuOrigem.options[i].text;
	        }
	        else{
	            arrMenuOrigem[fLength++] = MenuOrigem.options[i].text;
	        }
        } else {
        	if (MenuOrigem.options[i].selected && MenuOrigem.options[i].value != ""){
        		arrMenuOrigem[fLength++] = MenuOrigem.options[i].text.replace("Selecionado ", "");
        		
        		for(var l = 0; l < arrMenuDestino.length; l++){
        			if (arrMenuDestino[l] == MenuOrigem.options[i].text.replace("Selecionado ", ""))
            			arrMenuDestino.splice(l, 1);
                }
        	} else {
        		arrMenuOrigem[fLength++] = MenuOrigem.options[i].text;
        	}        	
        }
    }
    arrMenuOrigem.sort();
    arrMenuDestino.sort();
    MenuOrigem.length = 0;
    MenuDestino.length = 0;
    
    for(var c = 0; c < arrMenuOrigem.length; c++){
        var no = new Option();
        no.value = arrLookup[arrMenuOrigem[c]];
        no.text = arrMenuOrigem[c];
        MenuOrigem[c] = no;
    }

    for(var c = 0; c < arrMenuDestino.length; c++){
    	if (typeof arrLookup[arrMenuDestino[c]] != "undefined") {
	        var no = new Option();
	        no.value = arrLookup[arrMenuDestino[c]];
	        no.text = arrMenuDestino[c];
	        MenuDestino[c] = no;
        }
   }
}

/**
 * Selects all items in a list and moves them to a string that will later be sent by php - of newRoomForm
 * 
 * @param Menu 	   : listBox
 */
function selectListBoxAllOptions(Menu){
var i;
var selectedList = new Array();

document.newRoomForm.idsSelecteds.value = "";

for (i = 0; i < Menu.options.length; i++){
    Menu.options[i].selected = true;
    selectedList[i] = Menu.options[i].value; 
}
for (i = 0; i < selectedList.length; i++){
    document.newRoomForm.idsSelecteds.value += "-" + selectedList[i];
}
}

/**
 * Selects all items in a list and moves them to a string that will later be sent by php - of uptRoomForm
 * 
 * @param Menu 	   : listBox
 */
function selectListBoxAllOptions2(Menu, id){
	var i;
	var selectedList = new Array();

	document.uptRoomForm.idsSelecteds.value = "";

	for (i = 0; i < Menu.options.length; i++){
	    Menu.options[i].selected = true;
	    selectedList[i] = Menu.options[i].value; 
	}
	for (i = 0; i < selectedList.length; i++){
	    document.uptRoomForm.idsSelecteds.value += "-" + selectedList[i];
	}
	document.uptRoomForm.idsSelecteds.value += "-" + id;
}

/**
 * Selects all items in a list and moves them to a string that will later be sent by php - of inviteFriendForm
 * 
 * @param Menu 	   : listBox
 */
function selectListBoxAllOptions3(Menu){
	var i;
	var selectedList = new Array();

	document.inviteFriendForm.emailsSelecteds.value = "";

	for (i = 0; i < Menu.options.length; i++){
	    Menu.options[i].selected = true;
	    selectedList[i] = Menu.options[i].value; 
	}
	for (i = 0; i < selectedList.length; i++){
	    document.inviteFriendForm.emailsSelecteds.value += "-" + selectedList[i];
	}
}

/**
 * Function that validates email.
 * If the email is invalid then be shown an error message
 * and the focus goes to the input of the email.
 * 
 * @param form 	  	: Form of input email
 * @param idInput 	: id of input email
 * @param mail 	  	: name of input email
 * 
 * @return boolean	: true if email is valid
 */
function isEmail(form, idInput, mail){

	var email = document.forms[form].elements[mail].value;
	
    var exclude=/[^@\-\.\w]|^[_@\.\-]|[\._\-]{2}|[@\.]{2}|(@)[^@]*\1/;
    var check=/@[\w\-]+\./;
    var checkend=/\.[a-zA-Z]{2,3}$/;
    if(((email.search(exclude) != -1)||(email.search(check)) == -1)||(email.search(checkend) == -1))
    {
    	document.forms[form].elements[mail].focus();
    	showTip('tipInvalidEmail', idInput);
        return false;
    }
    else 
    {
    	hideTip('tipInvalidEmail');
        return true;
    }
}

/**
 * Show and hide div off checkboxs
 * 
 * @param id				: id of div
 * @param nameCheckBox 	    : name of div
 */
function showContent(id, nameCheckBox) {  

	checkbox = document.forms['uptUserForm'].elements[nameCheckBox];
	
	   if(document.getElementById(id).style.display=="none") {  
	        document.getElementById(id).style.display = "inline"; 
	        checkbox.checked = true; 
	    }    
	    else {  
	        document.getElementById(id).style.display = "none";  
	        checkbox.checked = false; 
	    }     
	}

function testBackspace(){
	if(event.keyCode == 8){

		var lang = navigator.language;
		if(lang == "en-US" || lang == "en"){
			var decision = confirm("Do you really want quit the page?");
		}else{
			var decision = confirm("Voce realmente deseja sair da sala?");
		}
		
		if(decision){
			window.history.back();
		}
	}
}

/**
 * Increases or decreases the font size,
 * the inputs and the modal windows
 * 
 * @param par				: Operation (more / less)
 */
function resizeFont(par){

	//Get all input elements
	var myInputObjs = new Array();
	myInputObjs = document.getElementsByTagName("input");
	
	//Get all select elements
	var mySelectObjs = new Array();
	mySelectObjs = document.getElementsByTagName("select");

	// Retrieves the previous size of the elements
	textSize = getCookie("textSize");
	inputSize = getCookie("inputSize");
				
	// If a size is not set, they go for the standard
	if(!textSize || !inputSize){
		textSize = 16;
		if (document.getElementById("writing")) // If is the roomTemplate, the input is less
			inputSize = 11;
		else
			inputSize = 13;
	}else{
		// Recover the true values
		textSize = parseInt(textSize.substring(0,2));
		inputSize = parseInt(inputSize.substring(0,2));
	}
		
	//Increases until it reaches a maximum of 20
	if(par == 'more' && textSize < 19){
		
		//Increments and sets the new sizes
		textSize = textSize + 1;
		inputSize = inputSize + 1;
		
	//Decreases until it reaches a maximum of 12
	} else {
		if(par == 'less' && textSize > 13){
			//Decrements and sets the new sizes
			textSize = textSize - 1;
			inputSize = inputSize - 1;
		}
	}
	
	document.body.style.fontSize = textSize + "px";
	
	for (var i = 0; i < myInputObjs.length; i++) {
		myInputObjs[i].style.fontSize = inputSize + "px";
	}
	
	for (var i = 0; i < mySelectObjs.length; i++) {
		mySelectObjs[i].style.fontSize = inputSize + "px";
	}	
	
	// Checks whether there are elements and change their sizes
	if (document.getElementById("chatInput")) {
		var inputSizeChat = inputSize + 2;
		document.getElementById("chatInput").style.fontSize = inputSizeChat + "px";
	}
	
	setCookie("textSize",textSize,30);
	setCookie("inputSize",inputSize,30);
}

/**
 * Function that creates / modifies a cookie.
 * 
 * @param c_name		: Cookie's name
 * @param value			: Contents of the cookie
 * @param exdays		: Number of days until the cookie expires
 */
function setCookie(c_name,value,exdays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

/**
 * Retrieves the value of a cookie
 * 
 * @param c_name		: Cookie's name
 */
function getCookie(c_name)	{
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++) {
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x==c_name) {
			return unescape(y);
		}
	}
}

/**
 * Delete a cookie by setting the date of expiry to yesterday
 * 
 * @param c_name		: Cookie's name
 */
function deleteCookie(c_name){
	date = new Date();
	date.setDate(date.getDate() -1);
	document.cookie = escape(c_name) + '=;expires=' + date;
}

/**
 * Checks if there is sized cookies,
 * If available, the system components will receive the new size
 */
function checkCookie() {
	// Get all cookies of size
	textSize = getCookie("textSize");
	inputSize = getCookie("inputSize");

	if (textSize!=null && textSize!="" || inputSize!=null && inputSize!="") {
		document.body.style.fontSize = textSize + "px";
		
		// If there are inputs on the page, set the sizes of them
		if (document.getElementsByTagName("input")) {
			//Get all input elements
			var myInputObjs = new Array();
			myInputObjs = document.getElementsByTagName("input");
			
			for (var i = 0; i < myInputObjs.length; i++) {
				myInputObjs[i].style.fontSize = inputSize + "px";
			}
		}
		
		// If there are selects on the page, set the sizes of them
		if (document.getElementsByTagName("select")) {
			//Get all select elements
			var mySelectObjs = new Array();
			mySelectObjs = document.getElementsByTagName("select");
			
			for (var i = 0; i < mySelectObjs.length; i++) {
				mySelectObjs[i].style.fontSize = inputSize + "px";
			}
		}
		
		// Checks whether there are elements and change their sizes
		if (document.getElementById("chatInput")) {
			var inputSizeChat = parseInt(getCookie('inputSize').substring(0,2)) + 2;
			document.getElementById("chatInput").style.fontSize = inputSizeChat + "px";
		}
		
	}		
}

/**
 * This function is active when the user clicks the button to enter a room,
 * put the information in the particular room in the inputs of modal window
 * 
 * @param roomName			: Room's name
 * @param roomId			: Room's id
 * @param listEnableUsers	: Array of users available
 * @param listAllowedUsers	: Array with users with permission
 */
function openUptRoomForm(roomName, roomId, listEnableUsers, listAllowedUsers) {
	document.uptRoomForm.roomName.value = roomName;
	document.uptRoomForm.roomId.value = roomId;
	document.uptRoomForm.list1.options.length = 0;
	document.uptRoomForm.list2.options.length = 0;
						
	var arrayListEnableUsers = eval(listEnableUsers);
	var arrayListAllowedUsers = eval(listAllowedUsers);
	
	var i = 0;
	for (i in arrayListEnableUsers){
		document.uptRoomForm.list1.options[i] = new Option(arrayListEnableUsers[i].nome, arrayListEnableUsers[i].id);
	}
	
	i++;
	for (j in arrayListAllowedUsers){
		var indice = parseInt(j) + i;
		document.uptRoomForm.list1.options[indice] = new Option("Selecionado "+arrayListAllowedUsers[j].nome, arrayListAllowedUsers[j].id);
	}
				
	var i = 0;
	for (i in arrayListAllowedUsers){
		document.uptRoomForm.list2.options[i] = new Option(arrayListAllowedUsers[i].nome, arrayListAllowedUsers[i].id);
	}
	
	move(document.uptRoomForm.list1,document.uptRoomForm.list1);
	myfilter2 = new filterlist(document.uptRoomForm.list1);
}

/**
 * Search an element from an attribute value
 * 
 * @param attribute			: Attribute name
 * @param value				: Attribute value
 */
function getElementByAttributeValue(attribute, value)
{
  var allElements = document.getElementsByTagName('*');
  for (var i = 0; i < allElements.length; i++)
   {
    if (allElements[i].getAttribute(attribute) == value)
    {
      return allElements[i];
    }
  }
}