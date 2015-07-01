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

	require_once 'src/actions/AbstractAction.php';
	require_once 'pages/bases/PageController.php';
	
	require_once 'src/model/whiteboard/Room.php';
	
	require_once 'src/util/CURL.php';
	require_once 'src/util/RESTClient.php';
	
	/**
	 * Description : Plataform login class
	 */
	class LoginPlataformAction extends AbstractAction {
	
		public function __construct(){
			parent::__construct();
		}
	
		public function execute($action) {
			$msgs = Localization::getInstance();
			$forwards = $action->getForwards();
			
			// Recebe os valores enviados
			$roomCourse = $_POST["group"];
			$roomManager = $_POST['manager'];
			$userName = utf8_decode($_POST["name"]);
			$userEmail = $_POST["email"];
			$userPasswordPlataform = "mude";
		
			if (!empty($roomCourse) && 
				!empty($roomManager) && 
				!empty($userName) &&
				!empty($userEmail)) {
				
				/**
				 * Routine that checks which the browser used
				 * If an error occurs during the login, the system should return to the previous page
				 * If the browser used is Firefox, the system must go back two pages
				 * If is Chrome should back 1 page
				 * TODO Test with Internet Explorer
				 */
				$useragent = $_SERVER['HTTP_USER_AGENT'];
				
				if(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
					$browser_version=$matched[1];
					$browser = 'Firefox';
					$numReturnPages = 2;
				} else $numReturnPages = 1;
				
				/**
				 * Via rest, it checks if this tool (in this case the Whiteboard)
				 * have permission to use information from the Core
				 */
				$host = $_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"];
				$pass = md5(date("d/m/Y").$host);
				
				$server = "http://code.inf.poa.ifrs.edu.br/core/index.php/rest";
				$action = str_replace("%40", "@", $userEmail);
								
				$rest = new RESTClient();
				$rest->initialize(array('server' => $server, 'http_user' => $host, 'http_pass' => $pass));
				$granted = $rest->get($action);
				
				if ($granted == 1){ // Caso o usuário esteja cadastrado na Plataform
					// CHECKING USER IN WHITEBOARD
					$user = $this->dao->login($userEmail, $userPasswordPlataform);
		
					if (count($user) <= 0) {
						// Not in database, create new user
						if(!empty($userEmail) && !empty($userName)) {
		
							// Instantiates a new user;
							$user = new User();
							$user->setName($userName);
							$user->setEmail($userEmail);
							$user->setPassword($userPasswordPlataform);
							$user->setRoomcreator(0);
							$resultUser = $this->dao->saveNewUser($user);
		
							$user = $this->dao->login($userEmail, $userPasswordPlataform);
						}
					}
					
					if ($user->getName() != $userName) {
						// Upadate user;
						$resultUser = $this->dao->updateUserName($user->getUserId(), $userName);
					}
					
					// User contained in the database, loggin
					$_SESSION['id'] = $user->getUserId();
					$_SESSION['name'] = $user->getName();
					$_SESSION['roomCreator'] = $user->getRoomcreator();
					$_SESSION['email'] = $user->getEmail();
					$_SESSION['user'] = $user;
					
					// Verifies and creates, if necessary, the room of course
					$roomPlataform = $this->dao->getRoomByCourse($roomCourse);
					
					if (count($roomPlataform) <= 0) {
						$roomName = "Turma: ".$roomCourse;
											
						if ($user->getEmail() == $roomManager){
							$managerId = $user->getUserId();
						}
						else {
							$manager = $this->dao->login($roomManager, $userPasswordPlataform);
							
							if (count($manager) <= 0) {
								// Not in database, create new user coordinator
								$manager = new User();
								$manager->setName("Professor ".$roomCourse);
								$manager->setEmail($roomManager);
								$manager->setPassword($userPasswordPlataform);
								$manager->setRoomcreator(1);
								$resultManager = $this->dao->saveNewUser($manager);
		
								$manager = $this->dao->login($manager->getEmail(), $userPasswordPlataform);
							}
							$managerId = $manager->getUserId();
						}
						
						// Instantiates a new room;
						$roomPlataform = new Room();
						$roomPlataform->setName($roomName);
						$roomPlataform->setUserId($managerId);
						$roomPlataform->setActive(0);
						$roomPlataform->setActiveProduction(0);
						$roomPlataform->setCourse($roomCourse);
						$resultRoom = $this->dao->saveNewRoom($roomPlataform);
						
						$roomPlataform = $this->dao->getRoomByCourse($roomCourse);
						
						// Set manager permission of room
						$permission = new Permission();
						$permission->setUserId($managerId);
						$permission->setRoomId($roomPlataform->getRoomId());
						$resultPermission = $this->dao->savePermission($permission);
					}
		
					// Checks permissions
					$permissions = $this->dao->listPermissions($roomPlataform->getRoomId());
		
					$havePermission = false;
					foreach ($permissions as $permission){
						if ($permission->getUserId() == $user->getUserId()){
							$havePermission = true;
						}
					}
		
					if (!$havePermission) {
						$permission = new Permission();
						$permission->setUserId($user->getUserId());
						$permission->setRoomId($roomPlataform->getRoomId());
						$resultPermission = $this->dao->savePermission($permission);
					}
		
					$roomPlataform = $this->dao->getRoomByCourse($roomCourse);
		
					$_SESSION['plataform'] = true;
					
					unset($_POST["group"]);
					unset($_POST['manager']);
					unset($_POST["name"]);
					unset($_POST["email"]);
					
					// If the room is active, will be given a join
					if ($roomPlataform->getActive() == 1){
						$_SESSION["idRoom"] = $roomPlataform->getRoomId();
				
						$room = $this->dao->getRoom($roomPlataform->getRoomId());
						
						// put the production in the session
						$idProduction = $room->getActiveProduction();
						$_SESSION['idProduction'] = $idProduction;
						
						$history = new History();
						$history->setUserId($_SESSION["id"]);
						$history->setProductionId($idProduction);
						$history->setDate(date('Y-m-d'));
						$resultHistory = $this->dao->saveHistory($history);
	
						// Retrieving the users in the room
						$_REQUEST["users"] = $this->dao->getRoomUsers($_SESSION['idProduction']);
						
						// Showing the page
						$this->pageController->run($forwards['success']);
						
					}
					else{
						if ($user->getUserId() == $roomPlataform->getUserId()) {
							// If it is not active and the user is the owner of the room, will be given a start in the room
							
							$production = new Production();
							$production->setCreationDate(date('Y-m-d'));
							$production->setUpdateDate(date('Y-m-d'));
							$production->setRoomId($roomPlataform->getRoomId());
								
							$resultProduction = $this->dao->createProduction($production);
								
							if ($resultProduction)
								$_SESSION['idProduction'] = $production->getProductionId();
													
							$resultUpdateRoom = $this->dao->updateRoomState($roomPlataform->getRoomId(), true, $_SESSION['idProduction']);
							if ($resultUpdateRoom)
								$_SESSION["idRoom"] = $roomPlataform->getRoomId();
							
							$resultRoom = $this->dao->getRoom($roomPlataform->getRoomId());
							if ($resultRoom)
								$_SESSION["currentRoomManager"] = $resultRoom->getUserId();
							
							$history = new History();
							$history->setUserId($_SESSION["id"]);
							$history->setProductionId($_SESSION['idProduction']);
							$history->setDate(date('Y-m-d'));
							
							$resultHistory = $this->dao->saveHistory($history);
							
							// Retrieving the users in the room
							$_REQUEST["users"] = $this->dao->getRoomUsers($_SESSION['idProduction']);
							
							$this->pageController->run($forwards['success']);
							
										
					}
						else {
							// Otherwise, the room is closed and the user must wait until she opens
							unset($_SESSION['id']);
							unset($_SESSION['name']);
							unset($_SESSION['roomCreator']);
							unset($_SESSION['email']);
							unset($_SESSION['user']);
													
							// Closed room
							echo "<script type='text/javascript'>";
							echo "alert('".$msgs->getText('error.plataform.closeRoom')."');";
				
				// Without permission			echo "history.go(-{$numReturnPages});";
							echo "</script>";
						}
					}
				}
				else{
					// Without permission
					echo "<script type='text/javascript'>";
					echo "alert('".$msgs->getText('error.plataform.withoutPermission')."');";
					echo "history.go(-{$numReturnPages});";
					echo "</script>";
				}	
			}
			else {
				// Insufficient data
				echo "<script type='text/javascript'>";
				echo "alert('".$msgs->getText('error.plataform.insufficientData')."');";
				echo "history.go(-{$numReturnPages});";
				echo "</script>";
			}
		}
	}	
?>