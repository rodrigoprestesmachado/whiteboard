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

	interface IDataBase {

		// If exists return the user object
		public function login($email, $password);
		
		// List the user's room
		public function listRoons();
		
		// Save the element in the data base
		public function saveElement($element);
		
		// Retrieve the element from data base
		public function retrieveElement($idProduction, $idElement);
		
		// Save or update a production object 
		public function createProduction($production);
		
		// Retrieves the elements of a production
		public function retrieveProduction($idProduction);
		
		// This method save the history of use the room
		public function saveHistory($history);
		
		// Indicates if the room is active or not
		public function updateRoomState($idRoom, $status, $production);
		
		// Retrieve a room from data base
		public function getRoom($idRoom);
		
		// Retrieve a room by Course from data base
		public function getRoomByCourse($course);
		
		// Retrieve the users that are working in one production (in the room)
		public function getRoomUsers($idProduction);
		
		// Save the new user in the data base
		public function saveNewUser($user);
		
		// Save the new room in the data base
		public function saveNewRoom($newRoom);
		
		//Update the data of user
		public function updateUserData($idUser, $userEmail, $userNewPassword);
		
		//Update the name of user
		public function updateUserName($idUser, $userName);
		
		//Update the data of room
		public function updateRoomData($idRoom, $roomName);
		
		// Retrieve a user from data base
		public function getUser($idUser);
		
		// Retrieve a user from data base
		public function getUserByEmail($email);
		
		// List all users
		public function listUsers();
		
		// List the user's room by code of MD5
		public function getRoomByCode($roomCode);
		
		// This method save the permission of use the room
		public function savePermission($permission);
		
		// List the permissions's room
		public function listPermissions($roomId);
		
		// Delete permission
		public function deletePermission($permission);
		
		// Retrieve all productions of room
		public function listProductionsByRoom($roomId);		
	}
	
?>