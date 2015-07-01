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
 
var rotationArray = new Array();
var actualRotatingElement = null;
var browser = (navigator.userAgent.toLowerCase().indexOf('chrome') > -1) ? 'chrome':'firefox';
var imageCounter = 0;

/**
 * Method used to create a new image
 *  
 * @param url - url to the image
 */
function createImage(url){	
	var img = $('<img/>', {
		src: url,
		width: '100px',
	    name: 'test',
	    id: 'image'+ (++tabCounter),
	    tabIndex: tabCounter
	}).load(function() {		
		$(this).appendTo("#writing")
		.resizable({
			ghost: true, 			
			aspectRatio: true, 
			autoHide: false,
			start: function(event, ui) {  },
			stop:  function(event, ui) {  
				endImageDragOrResize('#image'+ tabCounter);
			}
		})
		.bind({
			click: function(){
				controlRotation(this.parentNode);			
			},
			focus: function() {
				controlRotation(this.parentNode);
			}
		})		
		.parent()
		.css({"-webkit-transform": "rotate(0deg)", "-moz-transform": "rotate(0deg)"})
		.css("top", 132)
		.css("left", 252)
		.css("position", "absolute")
		.attr("tabindex",tabCounter)
		.attr("id","div"+'image'+ tabCounter)
		.keyup(function(event) {			
			keyboardEvents(this, event);
		})
		.mouseup(function(event) {			
			mouseEvents(this, event);
		})
		.draggable({
			containment: "#writing", 
			scroll: false,
			cursor: 'crosshair',
			start: function(event, ui) {  },			
			stop:  function(event, ui) {
				endImageDragOrResize('#image'+ tabCounter);
			}
		});
		
		tabIndexCalculation();
		
		logArea("newElement", "image");
	});
	
	focusedElementId = '#image'+tabCounter;
	
	console.log('createImage->id:'+'#image'+tabCounter);
	
	if ($("#dialog-modal").dialog('isOpen')) {
		$("#dialog-modal").dialog('close');								
	}	
	
	
}

/**
 * Method used to iniate a new image
 *  
 * @param url - url to the image
 */
function initiateImage(obj){	

	if(typeof obj.tabIndex == 'undefined')
		var tabIndex = obj.tabindex;
	else
		var tabIndex = obj.tabIndex;
	
	var img = $('<img/>', {
		src: obj.value,
		width: obj.width,
		height: obj.height,
	    name: 'test',
	    id: obj.id,
	    tabIndex: tabIndex
	}).load(function() {		
		$(this).appendTo("#writing")
		.resizable({
			ghost: true, 			
			aspectRatio: true, 
			autoHide: false,
			start: function(event, ui) {  },
			stop:  function(event, ui) {  
				endImageDragOrResize('#'+obj.id);
			}
		})
		.bind({
			click: function(){
				controlRotation(this.parentNode);			
			},
			focus: function() {
				controlRotation(this.parentNode);
			}
		})		
		.parent()
		.css({"-webkit-transform": "rotate(0deg)", "-moz-transform": "rotate(0deg)"})
		.css("top", obj.top)
		.css("left", obj.left)
		.css("position", "absolute")
		.attr("tabindex",tabIndex)
		.attr("id","div"+obj.id)
		.keyup(function(event) {			
			keyboardEvents(this, event);
		})
		.mouseup(function(event) {			
			mouseEvents(this, event);
		})
		.draggable({
			containment: "#writing", 
			scroll: false,
			cursor: 'crosshair',
			start: function(event, ui) {  },			
			stop:  function(event, ui) {
				endImageDragOrResize('#'+obj.id);
			}
		});
		
	});
}

/**
 * Method used to load a stored image
 *  
 * @param url - url to the image
 * @param width
 * @param height
 * @param id
 * @param rotation - only the number (do not include the unit)
 */
function loadImage(url, top, left, width, height, id, rotation, tabIndex){
	if (tabCounter < parseInt(tabIndex))
		tabCounter = parseInt(tabIndex);
	console.log('loadImage->id:'+id);
	
	var writing = document.getElementById("writing");
	var divImg = document.getElementById(id);
	
	
	divImg.style.width = width;
	divImg.style.height = height;
	
	divImg.parentNode.style.width = width;
	divImg.parentNode.style.height = height;
	divImg.parentNode.style.top = top;
	divImg.parentNode.style.left = left;
	divImg.parentNode.style.tabIndex = parseInt(tabIndex);
	$('#'+id).parent().css({"-webkit-transform": "rotate(" + rotation + "deg)", "-moz-transform": "rotate(" + rotation + "deg)"})
		
}
 
 function controlRotation(element) {
	console.log('Método controlRotation');
	if (actualRotatingElement == null || element != actualRotatingElement) {
		actualRotatingElement = element;
	}
 }
 
 function rotateClockwise() {				
	var rotateValue = getRotateValue(actualRotatingElement)+15;		
	
	if (getRotateValue(actualRotatingElement) >= 360) {
		actualRotatingElement.style.webkitTransform = "rotate(0deg)"
		actualRotatingElement.style.MozTransform = "rotate(0deg)";
	} 		
	actualRotatingElement.style.webkitTransform = 'rotate(' + rotateValue + 'deg)';	
	actualRotatingElement.style.MozTransform = 'rotate(' + rotateValue + 'deg)';	
	
	endImageDragOrResize('#image'+ imageCounter);
 }
 
 function rotateCounterClockwise() {
	var rotateValue = getRotateValue(actualRotatingElement)-15;		
	
	if (getRotateValue(actualRotatingElement) >= 360) {
		actualRotatingElement.style.webkitTransform = "rotate(0deg)";
		actualRotatingElement.style.MozTransform = "rotate(0deg)";
	} 		
	actualRotatingElement.style.webkitTransform = 'rotate(' + rotateValue + 'deg)';	
	actualRotatingElement.style.MozTransform = 'rotate(' + rotateValue + 'deg)';
	
	endImageDragOrResize('#image'+ imageCounter);
 }
 
 function getRotateValue(element) { 
	var matrix = null;	
	switch (browser) {
		case 'chrome': { matrix = window.getComputedStyle(element,null).getPropertyValue("-webkit-transform"); break; } 
		case 'firefox': { matrix = window.getComputedStyle(element,null).getPropertyValue("-moz-transform"); break; }
	}; 	
	
	var values = matrix.split('(')[1].split(')')[0].split(',');
	var a = values[0];
	var b = values[1];	
	var angle = Math.round(Math.atan2(b, a) * (180/Math.PI));
	
	return angle;
 }