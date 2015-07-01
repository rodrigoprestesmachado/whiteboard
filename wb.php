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
	
	//TODO Warning: develop a solutions for session hijack 
	session_start();
	
	require_once 'src/util/EMail.php';
	require_once 'pages/bases/localization/Localization.php';
    
   	/* Importing action files */
	require_once 'src/actions/ActionDom.php';
   	
   	require_once 'src/actions/CommonsActions.php';
   	require_once 'src/actions/ElementActions.php';
	require_once 'src/actions/RoomActions.php';
	require_once 'src/actions/EduquitoActions.php';
	require_once 'src/actions/PlataformActions.php';
	require_once 'src/actions/PlaceActions.php';
   	
	$controller = Controller::getInstance();
    $controller->run();
 	 
	class Controller {
		private static $instance;
		private $mapping;
		private $dom;
		
		public static function getInstance() {
			if (!isset(self::$instance)) {
		    	$class = __CLASS__;
		    	self::$instance = new $class;
		    }
		    return self::$instance;
		}
		
		public function __construct() {
			/* mapping the actions */
 			$this->dom = new ActionDom('src/actions/ActionsConfiguration.xml');
			$this->mapping = $this->dom->getActionsMapping();
 		}
 		
 		/**
 		 * @return returns the dom object 
 		 */
 		public function getDom() {
 			return $this->dom;	
 		}
		
		/**
		 * Description: Method to execute controller
		 */
	   	public function run() {
	   		
	        $error = true;
            
	        if ($_REQUEST["do"] == "")
	        	$_REQUEST["do"] = "start";
	        
            /** Retreiving the action **/
			$do = $_REQUEST["do"];
			
			/** searching for actions **/
			foreach($this->mapping as $action) {
				
				if ($action->getName() == $do) {
					
					// geting action definition
					$class =  new ReflectionClass($action->getType());
					
					if ($class->isInstantiable()) {
						// instancing action
   						$object = $class->newInstance();
						
   						// verificando as permissoes do usuario
   						if($object->actionPermission($action)) {
							
							// verifies if the action needs de SSL
   							$this->setSSL($action->getSSL());  	
   						
							// TODO review this line because reflection
                            $class = new ReflectionClass($action->getType());
                            $object = $class->newInstance();
						
                            // verifies the input information
							if ($object->validadeInputData($action)) {
                            	// executing the action
	                            $error = false;
	   						    $object->execute($action);
                            }
                        }
					}
				}
			}
			
			if ($error) {
				
				$_POST["error"] = "We cant execute the action";
				
				if (isset($_REQUEST["ajax"])) {
					$action = $this->dom->getAction("ajaxError");
				}
				else {
					$action = $this->dom->getAction("actionNotFound");
				}
				$class =  new ReflectionClass($action->getType());
                $object = $class->newInstance();
				$object->execute($action);
			}
		}
		
		/**
		 * Description : Verifies the protocol that the action will be executed
		 */
	   	private function setSSL($mode) {
	   		if ($_SERVER['SERVER_NAME'] != "localhost") {	
		   		// if true then SSL
		   		if ($mode) {
			   		$port = $_SERVER["SERVER_PORT"];
		  			$ssl_port = "443";
		  			if ($port != $ssl_port) {
		    			$host = $_SERVER["HTTP_HOST"];
		    			$uri = $_SERVER["REQUEST_URI"];
		    			header("Location: https://whiteboard.inf.poa.ifrs.edu.br$uri");
		  			}
				}
		   		else {
		   			$port = $_SERVER["SERVER_PORT"];
		  			$http_port = "80";
		  			if ($port != $http_port) {
		    			$host = $_SERVER["HTTP_HOST"];
		    			$uri = $_SERVER["REQUEST_URI"];
		    			header("Location: http://$host$uri");
		  			}
		   		}	   		
	   		}
	   	}
	   	
	   	
	}
?>
