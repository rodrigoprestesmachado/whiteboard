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

var counterLoginForm = -1;
var counterRegisterForm = -1;

/** 
 * Creates a listener to test the up and down were clicked
 */
$(document).ready(function() { 
	$(window).keydown(function(event) {

		if(typeof currentModalWindow == 'undefined')
			currentModalWindow = 'loginForm';
		
		switch(currentModalWindow){
			case 'dialogRegister':
				searchClass = 'counterNavigationRegister';
				counter = counterRegisterForm;
				break;
			default:
				searchClass = 'counterNavigationLoginForm';
				counter = counterLoginForm;
				break;
		}
		
	    switch(event.which)
		{
			// user presses the "down" key
			case 40:	
				var inputs = document.getElementsByClassName(searchClass);
				counterTabIndex = counter;
				
				if(counterTabIndex == (inputs.length-1))
					counterTabIndex = 0;
				else
					counterTabIndex++;
								
				inputs[counterTabIndex].focus(); 

				switch(currentModalWindow){
					case 'dialogRegister':
						counterRegisterForm = counterTabIndex;
						break;
					default:
						counterLoginForm = counterTabIndex;
						break;
				}				
				break;
						
			// user presses the "up" key
			case 38:
				var inputs = document.getElementsByClassName(searchClass);
				counterTabIndex = counter;

				if(counterTabIndex == 0)
					counterTabIndex = inputs.length-1;
				else
					counterTabIndex--;
				
				inputs[counterTabIndex].focus(); 
				
				switch(currentModalWindow){
					case 'dialogRegister':
						counterRegisterForm = counterTabIndex;
						break;
					default:
						counterLoginForm = counterTabIndex;
						break;
				}
				break;
		}
	});	
});