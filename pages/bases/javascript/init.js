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
 * Creates the tabs
 */
function createTabs() {
	$("#tabs").tabs();	
}

/*
 * Creates a jQuery modal dialog and attach an iFrame (linked to Midiateca) to it
 */
function createMidiatecaDlg() {
	$("#dialog-modal").dialog({
		height : 600,
		width : 1000,
		modal : true,
		autoOpen : false
	});
	
	$('<iframe id="iFrameMidiateca" name="iFrameMidiateca" src="http://place.niee.ufrgs.br/place/com/midiateca/buscar_qb" height="520" width="960"></iframe>')
	.appendTo('#dialog-modal');
}

/**
 * Init div to execute window modal 
 * 
 * @param no params
 * 
 */
function initModalWindow(){
	var divModal = document.createElement("div");
	divModal.setAttribute("class", "wModal");
	divModal.setAttribute("id", "modalWindow");
	
	var divMask = document.createElement("div");
	divMask.setAttribute("id", "mask");
    
	$("body").append(divModal);
	$("body").append(divMask);
}
