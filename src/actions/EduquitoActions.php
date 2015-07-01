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
	
	/**
	 * Description : Eduquito login class
	 */
	class LoginEduquitoAction extends AbstractAction {
	
		public function __construct(){
			parent::__construct();
		}
	
		public function execute($action) {
			$msgs = Localization::getInstance();
			$forwards = $action->getForwards();
			
			//$_POST["course"] = "1";
			//$_POST['manager'] = "coordenador@eduquito.com";
			//$_POST["name"] = "Coordenador do Curso";
			//$_POST["email"] ="coordenador@eduquito.com";
	
			$roomCourse = $_POST["course"];
			$roomManager = $_POST['manager'];
			$userName = utf8_decode($_POST["name"]);
			$userEmail = $_POST["email"];
			$userPasswordEduquito = "mude";
		
			if (!empty($roomCourse) && 
				!empty($roomManager) && 
				!empty($userName) &&
				!empty($userEmail)) {
				
				// CHECKING USER IN EDUQUITO
				
				$bdHost = "143.54.193.37";
				$bdUser = "wb";
				$bdPassword = "wb";
				$bdDataBase = "EduquitoCurso".$roomCourse;
				
				// Connect to database
				$mysqli = mysqli_init();
				mysqli_options($mysqli,MYSQLI_OPT_CONNECT_TIMEOUT,3);
				mysqli_real_connect($mysqli, $bdHost, $bdUser, $bdPassword, $bdDataBase);
				
				$eduquitoConnected = true;
				
				// Checks whether any errors occurred
				if (mysqli_connect_errno())
					$eduquitoConnected = false;
				
				if ($eduquitoConnected){
					
					$nameLoginEduquito = $userName;
					$emailLoginEduquito = $userEmail;
					
					// Prepares a SQL query
					if ($sql = $mysqli->prepare("SELECT `cod_usuario` FROM `Usuario` WHERE `email` = ? AND `nome` = ?")) {
						
						$sql->bind_param('ss', $emailLoginEduquito, $nameLoginEduquito);
					
						// Run the query
						$sql->execute();
					
						$i = 0;
						$sql->bind_result($id);
						while ($sql->fetch()) {
							$i++;
						}
						
						if ($i >= 1)
							$permissionEduquito = true;
						else
							$permissionEduquito = false;
						
						// Close query
						$sql->close();
					}
					
					// Closes the connection to the database
					$mysqli->close();
				}
				
				if (!$eduquitoConnected || $permissionEduquito){
					// CHECKING USER IN WHITEBOARD
					$user = $this->dao->login($userEmail, $userPasswordEduquito);
		
					if (count($user) <= 0) {
						// Not in database, create new user
						if(!empty($userEmail) && !empty($userName)) {
		
							// Instantiates a new user;
							$user = new User();
							$user->setName($userName);
							$user->setEmail($userEmail);
							$user->setPassword($userPasswordEduquito);
							$user->setRoomcreator(0);
							$resultUser = $this->dao->saveNewUser($user);
		
							$user = $this->dao->login($userEmail, $userPasswordEduquito);
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
					$roomEduquito = $this->dao->getRoomByCourse($roomCourse);
		
					if (count($roomEduquito) <= 0) {
						$roomName = "Sala do curso ".$roomCourse;
		
						$_POST["name"] = $roomName;
						$_POST["course"] = $roomCourse;
						$_POST['idsSelecteds'] = $user->getUserId();
		
						if ($user->getEmail() == $roomManager){
							$_SESSION['id'] = $user->getUserId();
						}
						else {
							$manager = $this->dao->login($roomManager, $userPasswordEduquito);
		
							if (count($manager) <= 0) {
								// Not in database, create new user coordinator
								$manager = new User();
								$manager->setName("Coordenador do curso");
								$manager->setEmail($roomManager);
								$manager->setPassword($userPasswordEduquito);
								$manager->setRoomcreator(0);
								$resultManager = $this->dao->saveNewUser($manager);
		
								$manager = $this->dao->login($manager->getEmail(), $userPasswordEduquito);
							}
							$_SESSION['id'] = $manager->getUserId();
						}
		
						$createRoomAction = new CreateRoomAction();
						$createRoomAction->execute($action);
		
						$roomEduquito = $this->dao->getRoomByCourse($roomCourse);
		
						$_SESSION['id'] = $user->getUserId();
					}
		
					// Checks permissions
					$permissions = $this->dao->listPermissions($roomEduquito->getRoomId());
		
					$havePermission = false;
					foreach ($permissions as $permission){
						if ($permission->getUserId() == $user->getUserId()){
							$havePermission = true;
						}
					}
		
					if (!$havePermission) {
						$permission = new Permission();
						$permission->setUserId($user->getUserId());
						$permission->setRoomId($roomEduquito->getRoomId());
						$resultPermission = $this->dao->savePermission($permission);
					}
		
					$roomEduquito = $this->dao->getRoomByCourse($roomCourse);
		
					$_GET["idRoom"] = $roomEduquito->getRoomId();
		
					$_SESSION['eduquito'] = true;
					
					if ($roomEduquito->getActive() == 1){
						$joinRoomAction = new JoinRoomAction();
						$joinRoomAction->execute($action);
					}
					else{
						if ($user->getUserId() == $roomEduquito->getUserId()) {
							$startRoomAction = new StartRoomAction();
							$startRoomAction->execute($action);
						}
						else {
							unset($_SESSION['id']);
							unset($_SESSION['name']);
							unset($_SESSION['roomCreator']);
							unset($_SESSION['email']);
							unset($_SESSION['user']);
							session_destroy();
							
							// Closed room
							echo "<script type='text/javascript'>";
							echo "alert('".$msgs->getText('error.eduquitoCloseRoom')."');";
							echo "history.go(-1);";
							echo "</script>";
						}
					}
				}
				else{
					// Without permission
					echo "<script type='text/javascript'>";
					echo "alert('".$msgs->getText('error.eduquitoWithoutPermission')."');";
					echo "history.go(-1);";
					echo "</script>";
				}
			}
			else {
				// Without permission
				echo "<script type='text/javascript'>";
				echo "alert('".$msgs->getText('error.eduquitoInsufficientData')."');";
				echo "history.go(-1);";
				echo "</script>";
			}
		}
	}	
?>