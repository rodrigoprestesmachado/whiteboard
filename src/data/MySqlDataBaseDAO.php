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

    require_once 'src/data/IDataBase.php';
    require_once 'propel/Propel.php';
	Propel::init('conf/runtime-conf.php');
	
	require_once 'src/model/whiteboard/ElementPeer.php';
	require_once 'src/model/whiteboard/HistoryPeer.php';
	require_once 'src/model/whiteboard/ProductionPeer.php';
	require_once 'src/model/whiteboard/RoomPeer.php';
	require_once 'src/model/whiteboard/UserPeer.php';
	require_once 'src/model/whiteboard/User.php';
	require_once 'src/model/whiteboard/PermissionPeer.php';
	
	/**
	 * MySQL DAO (Data Access Object)
	 * 
	 * @author rodrigoprestes@users.sourceforge.net
	 * @version Out. 20, 2011
	 */
	class MySqlDataBaseDAO implements IDataBase {
    
		/**  
          * Description            : If exists return the user object
          * 
          * @param String email    : User e-mail
          * @param String password : User password
          * @return                : User object
          */
	    public function login($email, $password) {
        	try {
            	$criteria = new Criteria();
               	$criteria->add(UserPeer::EMAIL, $email);
               	$criteria->add(UserPeer::PASSWORD, $password);
               	return UserPeer::doSelectOne($criteria);
            }
            catch (Exception $e){
                return array();
            }
        }
        
	        /**  
          * Description            : List the user's room
          * 
          * @param String email    : User id
          * @return                : Collection of rooms
          */
		public function listRoons() {
        	try {
            	$criteria = new Criteria();
               	$criteria->addAscendingOrderByColumn('ROOM_ID');
               	return RoomPeer::doSelect($criteria);
            }
            catch (Exception $e){
                return array();
            }
        } 
        
        /**  
          * Description            : Save the element in the data base
          * 
          * @param String element  : Element object
          * @return                : true or false
          */
		public function saveElement($element) {
        	try {
            	return $element->save();
            }
            catch (Exception $e){
               return null;
            }
        }
        
        /**  
          * Description                 : Retrieve the element from data base
          * 
          * @param String $idProduction : The id of a production
          * @param String $idElement    : The id of an element
          * @return                     : Returns an element objet or null in case of fail
          */
		public function retrieveElement($idProduction, $idElement) {
        	try {
        		$criteria = new Criteria();
               	$criteria->add(ElementPeer::PRODUCTION_ID, $idProduction);
               	$criteria->add(ElementPeer::ID, $idElement);
               	return ElementPeer::doSelectOne($criteria);
            }
            catch (Exception $e){
            	return null;
            }
        }
        
        
        /**
         * Save or update a production object 
         * 
         * @param Production $production : A production object
         */
        public function createProduction($production) {
       		try {
       			return $production->save();
        	}
            catch (Exception $e){
            	echo $e;
            	return null;
            }
        }
        
        
      	/**  
          * Description                 : Retrieves the elements of a production
          * 
          * @param String $idProduction : The id of a production
          * @return                     : Returns a collection of elements
          */
		public function retrieveProduction($idProduction) {
        	try {
        		$criteria = new Criteria();
               	$criteria->add(ElementPeer::PRODUCTION_ID, $idProduction);
               	return ElementPeer::doSelect($criteria);
            }
            catch (Exception $e){
            	return null;
            }
        }
        
        /**  
          * Description                 : This method save the history of use the room
          * 
          * @param String $history      : History object
          * @return                     : Returns true if the object was saved
          */
		public function saveHistory($history){
        	try {
        		return $history->save();
            }
            catch (Exception $e){
            	return null;
            }
        }
        
        /**  
          * Description                 : Change the room state
          * 
          * @param String $idRoom       : Id of a room
          * @param String $status       : True if the room is active
          * @param String $status       : The id of a production
          * @return                     : Returns true if the status changed
          */
		public function updateRoomState($idRoom, $status, $idProduction) {
        	try {
        		
        		$criteria = new Criteria();
               	$criteria->add(RoomPeer::ROOM_ID, $idRoom);
               	$room = RoomPeer::doSelectOne($criteria);
               	
               	// Only the owner can update the room
               	if ($_SESSION['id'] == $room->getUserId()){
               		$room->setActive($status);
               		$room->setActiveProduction($idProduction);
               		return $room->save();	
               	}
               	else
               		return true;
            }
            catch (Exception $e){
            	return null;
            }
        }
        
        /**  
          * Description                 : Retrieve a room from data base
          * 
          * @param String $idRoom       : Id of a room
          * @return                     : Room object
          */
        public function getRoom($idRoom){
        	try {
        		$criteria = new Criteria();
               	$criteria->add(RoomPeer::ROOM_ID, $idRoom);
               	return RoomPeer::doSelectOne($criteria);
            }
            catch (Exception $e){
            	return null;
            }
        }
        
        /**
         * Description                 : Retrieve a room from data base
         *
         * @param String $course       : Course of a room
         * @return                     : Room object
         */
        public function getRoomByCourse($course){
        	try {
        		$criteria = new Criteria();
        		$criteria->add(RoomPeer::COURSE, $course);
        		return RoomPeer::doSelectOne($criteria);
        	}
        	catch (Exception $e){
        		return null;
        	}
        }
        
        /**  
          * Description                       : Retrieve the users that are working in one production (in the room)
          * 
          * @param String $idProduction       : Id of a production
          * @return                           : A collection of users 
          */
        public function getRoomUsers($idProduction){
        	try {
        		$criteria = new Criteria();
               	$criteria->add(HistoryPeer::PRODUCTION_ID, $idProduction);
               	$log = HistoryPeer::doSelect($criteria);
               	
               	$users = array();
               	foreach ($log as $history){
               		$users[] = $history->getUser();
               	}
               	
               	return $users;
            }
            catch (Exception $e){
            	return null;
            }
        }
        
        /**
         * Description                 : This method save the new user in database
         *
         * @param String $user         : User object
         * @return                     : Returns true if the object was saved
         */
        public function saveNewUser($user){
        	try {
        		return $user->save();
        	}
        	catch (Exception $e){
        		return null;
        	}
        }
        
        /**
         * Description                 : This method save the new room in database
         *
         * @param String $newRoom      : Room object
         * @return                     : Returns true if the object was saved
         */
        public function saveNewRoom($newRoom){
        	try {
        		return $newRoom->save();
        	}
        	catch (Exception $e){
        		return null;
        	}
        }
        
        /**
         * Description                 : This method updates the user's data in database
         *
         * @param String $idUser       : User object
         * @return                     : Returns true if the object was updated
         */
        public function updateUserData($idUser, $userEmail, $userNewPassword){
        	try {
        		$criteria = new Criteria();
        		$criteria->add(UserPeer::USER_ID, $idUser);
        		$user = UserPeer::doSelectOne($criteria);
        
        		$user->setEmail($userEmail);
        		$user->setPassword($userNewPassword);
        
        		return $user->save();
        	}
        	catch (Exception $e){
        		return null;
        	}
        }
        
        /**
         * Description                 : This method updates the user's data in database
         *
         * @param String $idUser       : User object
         * @return                     : Returns true if the object was updated
         */
        public function updateUserName($idUser, $userName){
        	try {
        		$criteria = new Criteria();
        		$criteria->add(UserPeer::USER_ID, $idUser);
        		$user = UserPeer::doSelectOne($criteria);
        
        		$user->setName($userName);
        		
        		return $user->save();
        	}
        	catch (Exception $e){
        		return null;
        	}
        }
        
        /**
         * Description                 : This method updates the room's data in database
         *
         * @param String $idRoom       : Room object
         * @return                     : Returns true if the object was updated
         */
        public function updateRoomData($idRoom, $roomName){
        	try {
        
        		$criteria = new Criteria();
        		$criteria->add(RoomPeer::ROOM_ID, $idRoom);
        		$room = RoomPeer::doSelectOne($criteria);
        
        		$room->setName($roomName);
        
        		return $room -> save();
        	}
        	catch (Exception $e){
        		return null;
        	}
        }
        
        /**
         * Description                 : Retrieve a user from data base
         *
         * @param String $idUser       : Id of a user
         * @return                     : User object
         */
        public function getUser($idUser){
        	try {
        		$criteria = new Criteria();
        		$criteria->add(UserPeer::USER_ID, $idUser);
        		return UserPeer::doSelectOne($criteria);
        	}
        	catch (Exception $e){
        		return null;
        	}
        }
        
        
       
        /**
         * Description                 : Retrieve a user from data base
         *
         * @param String $email        : An e-mail
         * @return                     : User object
         */
        public function getUserByEmail($email){
        	try {
        		$criteria = new Criteria();
        		$criteria->add(UserPeer::EMAIL, $email);
        		return UserPeer::doSelectOne($criteria);
        	}
        	catch (Exception $e){
        		return null;
        	}
        }
        
        /**
         * Description            : List all users
         *
         * @return                : Collection of users
         */
        public function listUsers() {
        	try {
        		$criteria = new Criteria();
        		$criteria->addAscendingOrderByColumn('NAME');
        		return UserPeer::doSelect($criteria);
        	}
        	catch (Exception $e){
        		return array();
        	}
        }
        
        /**
         * Description                 : Retrieve a room from data base by code
         *
         * @param String $roomCode     : code of a room
         * @return                     : Room object
         */
        public function getRoomByCode($roomCode){
        	try {
        		$criteria = new Criteria();
        		$criteria->add(RoomPeer::CODE, $roomCode);
        		return RoomPeer::doSelectOne($criteria);
        	}
        	catch (Exception $e){
        		return null;
        	}
        }
        
        /**
         * Description                 : This method save the new permission in database
         *
         * @param String $permission   : Permission object
         * @return                     : Returns true if the object was saved
         */
        public function savePermission($permission){
        	try {
        		return $permission->save(); 
        	}
        	catch (Exception $e){
        		return null;
        	}
        }
	
        /**
         * Description            : List the permissions's room
         *
         * @param String roomId   : Room id
         * @return                : Collection of permission
         */
			public function listPermissions($roomId) {
        	try {
            	$criteria = new Criteria();
               	$criteria->add(PermissionPeer::ROOM_ID, $roomId);
               	return PermissionPeer::doSelect($criteria);
            }
            catch (Exception $e){
                return array();
            }
        }

	        /**
         * Description                 : This method delete the permission in database
         *
         * @param Permission $permission : Permission object
         * @return                     : Returns true if the object was deleted
         */
        public function deletePermission($permission){
        	try {
				return PermissionPeer::doDelete($permission);
        		}
        	catch (Exception $e){
        		return null;
        	}
        }
        
        /**
         * Description            : List the productions's room
         *
         * @param String roomId   : Room id
         * @return                : Collection of permission
         */
        public function listProductionsByRoom($roomId) {
        	try {
        		$criteria = new Criteria();
        		$criteria->add(ProductionPeer::ROOM_ID, $roomId);
        		return ProductionPeer::doSelect($criteria);
        	}
        	catch (Exception $e){
        		return array();
        	}
        }
	
	}
	       
?>