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
    
    require_once 'src/model/whiteboard/Production.php';
    require_once 'src/model/whiteboard/History.php';
    require_once 'src/model/whiteboard/Room.php';
    require_once 'src/model/whiteboard/Permission.php';
    
	class StartRoomAction extends AbstractAction {
		
		public function __construct(){
            parent::__construct();
        }
        
		public function execute($action) {
			
			$forwards = $action->getForwards();
			
			if(!isset($_SESSION['idProduction'])) {
				
				if ($_GET['idProduction'] == "new"){
					$production = new Production();
					$production->setCreationDate(date('Y-m-d'));
					$production->setUpdateDate(date('Y-m-d'));
					$production->setRoomId($_GET["idRoom"]);
					
					$resultProduction = $this->dao->createProduction($production);
					
					if (($resultProduction))
						$_SESSION['idProduction'] = $production->getProductionId();
				} 
				else
					$_SESSION['idProduction'] = $_GET['idProduction'];
				
				$resultUpdateRoom = $this->dao->updateRoomState($_GET["idRoom"], true, $_SESSION['idProduction']);
				if ($resultUpdateRoom)
					$_SESSION["idRoom"] = $_GET["idRoom"];
				
				$resultRoom = $this->dao->getRoom($_GET["idRoom"]);
				if ($resultRoom)
					$_SESSION["currentRoomManager"] = $resultRoom->getUserId();
				
				$history = new History();
				$history->setUserId($_SESSION["id"]);
				$history->setProductionId($_SESSION['idProduction']);
				$history->setDate(date('Y-m-d'));
				
				$resultHistory = $this->dao->saveHistory($history);
			}
			// Retrieving the users in the room
			$_REQUEST["users"] = $this->dao->getRoomUsers($_SESSION['idProduction']);
			
			// Showing the page
			$this->pageController->run($forwards['success']);
		}		
	}
	
	class ListRoonsAction extends AbstractAction {
		
		public function __construct(){
            parent::__construct();
        }
        
		public function execute($action) {
			$forwards = $action->getForwards();
			
			$roons = $this->dao->listRoons();
			
			$_REQUEST["roons"] = $roons;
			$this->pageController->run($forwards['success']);	
		}		
	}
	
	class JoinRoomAction extends AbstractAction {
		
		public function __construct(){
            parent::__construct();
        }
        
		public function execute($action) {
			$forwards = $action->getForwards();
			
			$_SESSION["idRoom"] = $_GET["idRoom"];
			
			$room = $this->dao->getRoom($_GET["idRoom"]);
			
			if ($room){
				// If the room is open
				if ($room->getActive() != 0) {
					
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
					$_REQUEST["errorMsg"] = $this->message->getText("error.closeRoom");
					$this->pageController->run($forwards['error']);
				}
			}
			else{
				$_REQUEST["errorMsg"] = $this->message->getText("error.retrieveRoom");
				$this->pageController->run($forwards['error']);
			}
			
		}		
	}
	
	/**
	 * Description : White Board create room class
	 */
	class CreateRoomAction extends AbstractAction {
	
		public function __construct(){
			parent::__construct();
		}
	
		public function execute($action) {
			
			$forwards = $action->getForwards();
	
			$roomName = $_POST['name'];
			$user = $_SESSION['id'];
			$listUsers = explode("-", $_POST['idsSelecteds']);
	
	
			// Checks if all fields were provided
			if(
					!empty($_POST['name']) &&
					!empty($_SESSION['id'])
			) {
	
				// Instantiates a new room;
				$room = new Room();
				$room->setName($_POST['name']);
				$room->setUserId($_SESSION['id']);
				$room->setActive(0);
				$room->setActiveProduction(0);
				$room->setCourse($_POST['course']);
				$resultRoom = $this->dao->saveNewRoom($room);
				
				// List Rooms
				$listRoonsAction = new ListRoonsAction();
				$listRoonsAction->execute($action);
				
				$roons =  $_REQUEST["roons"];
				foreach ($roons as $srcRoom){
					if (is_null($srcRoom->getCode()))
						$newRoomId = $srcRoom->getRoomId();
				}
				
				// Generates the secret code of the room
				$room = $this->dao->getRoom($newRoomId);
				$code = md5($newRoomId);
				$room->setCode($code);
				$room->save();
				
				// Gives permission to the user who created the room
				$listUsers[] = $_SESSION['id'];
				
				// Instantiates a new room permission;
				foreach ($listUsers as $allowedUserId){
					if ($allowedUserId != 0){
						$permission = new Permission();
						$permission->setUserId($allowedUserId);
						$permission->setRoomId($newRoomId);
						$resultPermission = $this->dao->savePermission($permission);
					}
				}

				// Showing the page
				$this->pageController->run($forwards['success']);
				
			}
			else{
				// It will set a variable with the id of the button
				// that opens the modal window that was active
				$_SESSION['openModalWindow'] = "#btnOpenNewRoomForm";
				
				// Error if there are blank fields
				$_REQUEST["errorMsg"] = $this->message->getText("error.blankField");
				$this->pageController->run($forwards['error']);
			}
	
		}
	}
	
	/**
	 * Description : White Board update room class
	 */
	class updateRoomAction extends AbstractAction {
	
		public function __construct(){
			parent::__construct();
		}
	
		public function execute($action) {
	
			$forwards = $action->getForwards();
	
			// Checks if all fields were provided
			if(
					!empty($_POST['roomId']) &&
					!empty($_POST['roomName']) &&
					!empty($_POST['idsSelecteds'])
			) {
	
				$idRoom = $_POST['roomId'];
				$roomName = $_POST['roomName'];
				$listUsers = explode("-", $_POST['idsSelecteds']);
				$listUsers[] = $_SESSION['id'];
				$_POST['currentRoom'] = $idRoom;
					
				// Upadate user;
				$resultRoom = $this->dao->updateRoomData($idRoom, $roomName);
				
				// Delete old permissions
				$listPermissions = new ListPermissionsAction();
				$listPermissions->execute($action);
				$permissions = $_REQUEST["permissions"];
				
				foreach ($permissions as $permission){
					$resultDeletePermissions = $this->dao->deletePermission($permission);
				}
				
				// Instantiates a new room permission;
				foreach ($listUsers as $allowedUserId){
					if ($allowedUserId != 0){
						$permission = new Permission();
						$permission->setUserId($allowedUserId);
						$permission->setRoomId($idRoom);
						$resultPermission = $this->dao->savePermission($permission);
					}
				}

				// Showing the page
				$this->pageController->run($forwards['success']);
	
			}
			else{
				// It will set a variable with the id of the button
				// that opens the modal window that was active
				$_SESSION['openModalWindow'] = "#btnUptRoom";
				
				// Error if there are blank fields
				$_REQUEST["errorMsg"] = $this->message->getText("error.blankField");
				$this->pageController->run($forwards['error']);
			}
	
	
		}
	}
	
	/**
	 * Description : Enter in room with the code sent by email
	 */
	class EnterWithCodeAction extends AbstractAction {
	
		public function __construct(){
			parent::__construct();
		}
	
		public function execute($action) {
	
			$forwards = $action->getForwards();
	
			// Checks if all fields were provided
			if(!empty($_POST['roomCode'])) {
				
				$roomCode = $_POST['roomCode'];
				
				// Get room;
				$room = $this->dao->getRoomByCode($roomCode);
				
				if (is_object($room)){
					$_GET["idRoom"] = $room->getRoomId();
		
					// Join in room
					$joinRoomAction = new JoinRoomAction();
					$joinRoomAction->execute($action);
		
					$this->pageController->run($forwards['success']);
				}
				else
				{
					// Error if code ins't valid
					$_REQUEST["errorMsg"] = $this->message->getText("error.invalidCode");
					$this->pageController->run($forwards['error']);
				}
			}
			else{
				// Error if there are blank fields
				$_REQUEST["errorMsg"] = $this->message->getText("error.blankField");
				$this->pageController->run($forwards['error']);
			}
	
	
		}
	}
	
	/**
	 * Description : List all permissions of the selected room
	 */
	class ListPermissionsAction extends AbstractAction {
	
		public function __construct(){
			parent::__construct();
		}
	
		public function execute($action) {
			$forwards = $action->getForwards();
			
			$roomId = $_POST['currentRoom'];
	
			$permissions = $this->dao->listPermissions($roomId);
	
			$_REQUEST["permissions"] = $permissions;
			$this->pageController->run($forwards['success']);
		}
	}
	
	/**
	 * Description : List all productions of the selected room
	 */
	class ListProductionsAction extends AbstractAction {
	
		public function __construct(){
			parent::__construct();
		}
	
		public function execute($action) {
			$forwards = $action->getForwards();
	
			$roomId = $_POST['currentRoom'];
			
			$productions = $this->dao->listProductionsByRoom($roomId);
	
			$_REQUEST["productions"] = $productions;
			
			$this->pageController->run($forwards['success']);
		}
	}
	
?>