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

var counterInviteFriends = -1;
var counterYouTubeForm = -1;
var counterLoadProduction = -1;
var counterShortcuts = -1;
var counterHelpLibras = -1;
var counterHelpAudio = -1;
var counterHelp = -1;
var counterMoveElement = -1;

var fristElementTabIndex = 1;
if (ownerRoom != 1)
	fristElementTabIndex = 2;
/** 
 * Creates a listener to test the up and down were clicked
 */
$(document).ready(function() { 
	$(window).keydown(function(event) {
	    switch(event.which)
		{
	 		// check for escape key
			case 27:	
				// the following seems to fix the symptom but only in case the document has the focus
		        event.preventDefault();
				break;	
						
			// user presses the "down" key
			case 40:	
				 if((typeof currentModalWindow == 'undefined') || (currentModalWindow == null)){
					var nextElement;
					var currentTabIndex = parseInt(document.getElementById(document.activeElement.id).getAttribute("tabIndex"));
				
					nextElement = getElementByAttributeValue("tabIndex", currentTabIndex+1);
					if (nextElement == null)
						if (currentTabIndex < 5000)
							nextElement = getElementByAttributeValue("tabIndex", "5000");
						else
							nextElement = getElementByAttributeValue("tabIndex", fristElementTabIndex);
					
					nextElement.focus();
				} else {
					switch(currentModalWindow){									
						case 'dialogInviteFriends':
							searchClass = 'counterNavigationInviteFriends';
							counterTabIndex = counterInviteFriends;
							break;
						case 'dialogYouTubeVideo':
							searchClass = 'counterNavigationYouTube';
							counterTabIndex = counterYouTubeForm;
							break;
						case 'dialogOpenProduction':
							searchClass = 'counterNavigationLoadProduction';
							counterTabIndex = counterLoadProduction;
							break;
						case 'dialogShortcuts':
							searchClass = 'counterNavigationShortcuts';
							counterTabIndex = counterShortcuts;
							break;
						case 'dialogHelpLibras':
							searchClass = 'counterNavigationHelpLibras';
							counterTabIndex = counterHelpLibras;
							break;
						case 'dialogHelpAudio':
							searchClass = 'counterNavigationHelpAudio';
							counterTabIndex = counterHelpAudio;
							break;
						case 'dialogHelp':
							searchClass = 'counterNavigationHelp';
							counterTabIndex = counterHelp;
							break;
						case 'dialogMoveElement':
							searchClass = 'counterNavigationMoveElement';
							counterTabIndex = counterMoveElement;
							break;									
					}

					var inputs = document.getElementsByClassName(searchClass);
					
					if(counterTabIndex == (inputs.length-1))
						counterTabIndex = 0;
					else
						counterTabIndex++;
									
					inputs[counterTabIndex].focus(); 

					switch(currentModalWindow){										
						case 'dialogInviteFriends':
							counterInviteFriends = counterTabIndex;
							break;
						case 'dialogYouTubeVideo':
							counterYouTubeForm = counterTabIndex;
							break;
						case 'dialogOpenProduction':
							counterLoadProduction = counterTabIndex;
							break;
						case 'dialogShortcuts':
							counterShortcuts = counterTabIndex;
							break;
						case 'dialogHelpLibras':
							counterHelpLibras = counterTabIndex;
							break;
						case 'dialogHelpAudio':
							counterHelpAudio = counterTabIndex;
							break;
						case 'dialogHelp':
							counterHelp = counterTabIndex;
							break;
						case 'dialogMoveElement':
							counterMoveElement = counterTabIndex;
							break;									
					}

				}
				break;
						
			// user presses the "up" key
			case 38:
				if((typeof currentModalWindow == 'undefined') || (currentModalWindow == null)){
					var backElement;
					var currentTabIndex = parseInt(document.getElementById(document.activeElement.id).getAttribute("tabIndex"));
				
					backElement = getElementByAttributeValue("tabIndex", currentTabIndex-1);
					if (backElement == null)
						if (currentTabIndex == 5000)
							backElement = getElementByAttributeValue("tabIndex", tabCounter);
						else
							backElement = getElementByAttributeValue("tabIndex", lastTabIndex);
					
					backElement.focus();
				} else {
					switch(currentModalWindow){									
					case 'dialogInviteFriends':
						searchClass = 'counterNavigationInviteFriends';
						counterTabIndex = counterInviteFriends;
						break;
					case 'dialogYouTubeVideo':
						searchClass = 'counterNavigationYouTube';
						counterTabIndex = counterYouTubeForm;
						break;
					case 'dialogOpenProduction':
						searchClass = 'counterNavigationLoadProduction';
						counterTabIndex = counterLoadProduction;
						break;
					case 'dialogShortcuts':
						searchClass = 'counterNavigationShortcuts';
						counterTabIndex = counterShortcuts;
						break;
					case 'dialogHelpLibras':
						searchClass = 'counterNavigationHelpLibras';
						counterTabIndex = counterHelpLibras;
						break;
					case 'dialogHelpAudio':
						searchClass = 'counterNavigationHelpAudio';
						counterTabIndex = counterHelpAudio;
						break;
					case 'dialogHelp':
						searchClass = 'counterNavigationHelp';
						counterTabIndex = counterHelp;
						break;
					case 'dialogMoveElement':
						searchClass = 'counterNavigationMoveElement';
						counterTabIndex = counterMoveElement;
						break;									
				}

				var inputs = document.getElementsByClassName(searchClass);

				if(counterTabIndex == 0)
					counterTabIndex = inputs.length-1;
				else
					counterTabIndex--;
				
				inputs[counterTabIndex].focus(); 

				switch(currentModalWindow){										
					case 'dialogInviteFriends':
						counterInviteFriends = counterTabIndex;
						break;
					case 'dialogYouTubeVideo':
						counterYouTubeForm = counterTabIndex;
						break;
					case 'dialogOpenProduction':
						counterLoadProduction = counterTabIndex;
						break;
					case 'dialogShortcuts':
						counterShortcuts = counterTabIndex;
						break;
					case 'dialogHelpLibras':
						counterHelpLibras = counterTabIndex;
						break;
					case 'dialogHelpAudio':
						counterHelpAudio = counterTabIndex;
						break;
					case 'dialogHelp':
						counterHelp = counterTabIndex;
						break;
					case 'dialogMoveElement':
						counterMoveElement = counterTabIndex;
						break;									
				}

			}
				break;
		}
	});		
});