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
 *  Enable only one text boxes to drag
 *  
 *  @param String : the id of node  
 */
function startElementDrag(idNode){	
	libStartElementDrag(idNode);
}

/**
 *  Disable all text boxes to drag  
 */
function stopElementDrag(idNode){
	libStopElementDrag(idNode);
}

/**
 * Verifies if a node is enable do drag 
 * 
 * @param String : the id of node
 * @returns {Boolean}
 */
function isNodeStopedDrag(idNode){
	return libIsNodeStopedDrag(idNode);
}

/**
 * Remove a node (text box) from the array of stopped drag elements
 * 
 * @param String : the id of node
 */
function removeStopedDragArray(idNode){
	libRemoveStopedDragArray(idNode);
}		