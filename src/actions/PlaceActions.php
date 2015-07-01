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

	require_once 'src/data/DAOFactory.php';
	require_once 'src/actions/AbstractAction.php';
    require_once 'pages/bases/PageController.php';
    require_once 'src/util/EMail.php';
    require_once 'src/util/class.phpmailer.php';
	
	/**
	 * 
	 * 
	 * 
	 * Description : Place login class
	 */
    
    /**
     * Link the user to a page
     */
	class LoginPlaceAction extends AbstractAction {
	
		public function __construct(){
			parent::__construct();
		}
	
		public function execute($action) {

			//error_reporting(E_ALL);
 			//ini_set("display_errors", 1);	
			$forwards = $action->getForwards();
			
			$strJson = str_replace('\\', '', $_POST['json']);
			$json = json_decode(utf8_encode($strJson));

			$data = $json->{'logindata'};
			
			$sucess = false;
			
			$createdUser = false;
			
			if (!is_null($data->{'email'})){
					
				$user = $this->dao->getUserByEmail($data->{'email'});
	
				if (!($user)){
					//  Store a new user									
					$user = new User();
					$user->setName($data->{'name'});
					$user->setEmail($data->{'email'});
					$user->setPassword($data->{'passoword'});
					
					if($data->{'roomCreator'} == 'F0')
						$user->setRoomcreator(true);		
					else
						$user->setRoomcreator(false);
					
					// Saving a new user
					$this->dao->saveNewUser($user);
					
					$createdUser = true;
					
				}
				//else{
					//TODO verificar a senha
				//}
				
				// Store data in PHP SESSION
				if ($user) {
					$sucess = true;
					
					$_SESSION['id'] = $user->getUserId();
					$_SESSION['name'] = $user->getName();
					$_SESSION['roomCreator'] = $user->getRoomcreator();
					$_SESSION['email'] = $user->getEmail();
					$_SESSION['user'] = $user;
				}
				else {
					//TODO ajustar quando o login nao funciona
					$sucess = false;
					$_REQUEST["errorMsg"] = $this->message->getText("error.loginFail");
					$this->pageController->run($forwards['error']);
				}			
			}
			else{
				//TODO ajustar quando o login nao funciona
				$sucess = false;
				$_REQUEST["errorMsg"] = $this->message->getText("error.loginFail");
				$this->pageController->run($forwards['error']);
			}
			
				
			if ($createdUser == true){

				// Verifica se o usuario foi criado, se sim, manda para uma pagina de sucesso
				$action = new ActionMapping();
				$action->setName("createdUserSuccess");
				$action->setType("ForwardAction");
				$action->setRole("");
				$action->setForwards(array("success"=>".createdUserSuccess"));
				
				$forwardAction = new ForwardAction();
				$forwardAction->execute($action);

			}
			else {
				if ($sucess){
		
					$_REQUEST["msg"] = "Sua conta foi criada com sucesso no Quadro Branco, por favor, volte e entre novamente";
					
					$action = new ActionMapping();
					$action->setName("listRoons");
					$action->setType("ListRoonsAction");
					$action->setRole("");
					$action->setForwards(array("success"=>".showUserPage", "error"=>".error"));
					
					$listRoonsAction = new ListRoonsAction();
					$listRoonsAction->execute($action);
				}				
			}
				
		}
	}
?>
