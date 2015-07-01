<?php

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

	class ActionDom {
		private $_document;
		private $_actionsMapping;
		
		/**
		 * @param Um arquivo de configuracao do controlador
		 */
		public function __construct($arquivoXML) {
			$this->_actionsMapping = array();
			$this->_document = new DOMDocument();
			$this->_document->load($arquivoXML);
			$this->createActionsMappings();
		}
		
		/**
		 * Retorna um array de objetos ActionMapping
		 * @return : Um array de objetos ActionMapping
		 */
		public function getActionsMapping() {
			return $this->_actionsMapping;
		}
		
		/**
		 * Descricao                : Retorna um objeto action mapping
		 * 
		 * @param string actionName : O nome da acao
		 * @return ActionMapping    :  Retorna um objeto action mapping
		 */
		public function getAction($actionName) {
			foreach ($this->_actionsMapping as $action) {
				if ($action->getName() == $actionName)
					return $action;
			}
			return null;
		}
		
		/**
		 * Metodo responsavel por criar o array de objetos ActionMapping
		 * @return : void
		 */
		private function createActionsMappings() {
			
			$actionsList = $this->_document->getElementsByTagName('action');
			
			foreach ($actionsList as $action) {
				
				$actionMapping = new ActionMapping();
				
				if ($action->hasAttribute("ssl")) {
						
					if ($action->getAttribute("ssl") == "false"){
						$actionMapping->setSSL(0);
					}
					else{
						$actionMapping->setSSL(1);
					}
				}
				
				if ($action->hasAttribute("authentication")) {
					
					if ($action->getAttribute("authentication") == "false"){
						$actionMapping->setAuthentication(0);
					}
					else{
						$actionMapping->setAuthentication(1);
					}
				}
				
				if ($action->hasChildNodes()) {
					$actionChildNode = $action->childNodes;
						
					foreach($actionChildNode as $actionChild) {
						if ($actionChild->nodeName == "name")
							$actionMapping->setName($actionChild->nodeValue);
						
						if ($actionChild->nodeName == "type")
							$actionMapping->setType($actionChild->nodeValue);
							
						if ($actionChild->nodeName == "role")
							$actionMapping->setRole($actionChild->nodeValue);
						
						if ($actionChild->nodeName == "forwards")
							$actionMapping->setForwards($this->createForwards($actionChild));
						
						if ($actionChild->nodeName == "validation")
							$actionMapping->setValidations($this->createValidation($actionChild));
						
					}
					
					$this->_actionsMapping[] = $actionMapping;
				}
			}
		}

		/**
		 * Metodo responsavel por mapear os forwards de cada acao e retornar 0um
		 * array de forwards
		 * @param Um nodo <forwards>
		 * @return Um array de forwards
		 */
		private function createForwards($node) {
			$forwardsArray = array();
			
			if ($node->hasChildNodes()) {
				$forwards = $node->childNodes;
                         
				foreach($forwards as $forward) {
                    if($forward->nodeName == "forward") {
                        if ($forward->hasAttribute("name"))
                            $name = $forward->getAttribute("name");

                        if ($forward->hasAttribute("path"))
                            $path = $forward->getAttribute("path");

                        $forwardsArray[$name] = $path;
                    }
                }
           }
									
			return $forwardsArray;
		}
		
		
		/**
		 * Descricao : Metodo responsavel por mapear os nodos fields de cada acao. 
		 * Este metodo retorna um array de objetos fields que serao validados posteriormente.
		 * 
		 * @param  Um nodo <field>
		 * @return Um array de objetos Field
		 */
		private function createValidation($node) {
			$fieldArray = array();
			
			if ($node->hasChildNodes()) {
				$fields = $node->childNodes;
                         
				foreach($fields as $field) {
					$fieldObject = new Field();
					
                    if($field->nodeName == "field") {
                        if ($field->hasAttribute("name")) {
                            $name = $field->getAttribute("name");
                            $fieldObject->setName($name);
                        }

                        if ($field->hasAttribute("method")) {
                            $method = $field->getAttribute("method");
                            $fieldObject->setMethod($method);
                        }
                        
                    	if ($field->hasAttribute("validationType")) {
                            $validationType = $field->getAttribute("validationType");
                            $fieldObject->setValidationType($validationType);
                        }

                        $fieldArray[] = $fieldObject;
                    }
                }
           }
           
			return $fieldArray;
		}

	}
	
	/**
	 * Objeto que representa a estrutura de cada acao que correspondente no
	 * arquivo em XML
	 */
	class ActionMapping {
		private $_name;
		private $_type;
        private $_role;
		private $_forwards;
		private $_validations;
		private $_ssl;
		private $_authentication;
		
		function __construct() {
			$this->_ssl = false;
			$this->_authentication = false;
			$this->_forwards = array();
			$this->_validations = array();
		}
		
		public function getName(){
			return $this->_name;
		}
	
		public function setName($name){
			$this->_name = $name;
		}
		
		public function getType() {
			return $this->_type;
		}
	
		public function setType($type){
			$this->_type = $type;
		}
		
		public function getForwards(){
			return $this->_forwards;
		}
	
		public function setForwards($forwards){
			$this->_forwards = $forwards;
		}
		
		public function addForwards($forwards){
			$this->_forwards[] = $forwards;
		}
		
		public function setValidations($validations){
			$this->_validations = $validations;
		}
		
		public function getValidations() {
			return $this->_validations;
		}
		
		public function addValidations($validations){
			$this->_validations[] = $validations;
		}
		
		public function getRole(){
			return $this->_role;
		}

		public function setRole($role){
			$this->_role = $role;
		}
		
		public function getSSL() {
			return $this->_ssl;
		}

		public function setSSL($ssl) {
			$this->_ssl = $ssl;
		}
		
		public function getAuthentication() {
			return $this->_authentication;
		}

		public function setAuthentication($authentication) {
			$this->_authentication = $authentication;
		}
		
	}
	
	class Field {
		private $name;
		private $method;
        private $validationType;
		
        function __construct() {
			$this->name  =  "";
			$this->method = "";
        	$this->validationType = "";
		}
		
		public function getName(){
			return $this->name;
		}
	
		public function setName($name){
			$this->name = $name;
		}

		public function getMethod() {
			return $this->method;
		}
	
		public function setMethod($method){
			$this->method = $method;
		}
		
		public function getValidationType() {
			return $this->validationType;
		}
	
		public function setValidationType($validationType){
			$this->validationType = $validationType;
		}
	}
?>