
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- room
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `room`;


CREATE TABLE `room`
(
	`room_id` INTEGER  NOT NULL AUTO_INCREMENT COMMENT 'Room id',
	`name` VARCHAR(45)  NOT NULL COMMENT 'name of a room',
	`active` INTEGER COMMENT 'Indicates if the room is in use',
	`active_production` INTEGER(2) COMMENT 'Indicates the current production of a room',
	`code` VARCHAR(255) COMMENT 'Code',
	`course` VARCHAR(255) COMMENT 'Eduquito Course Id',
	`user_id` INTEGER(10),
	PRIMARY KEY (`room_id`),
	INDEX `room_FI_1` (`user_id`),
	CONSTRAINT `room_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`user_id`)
)Type=MyISAM COMMENT='Room Table';

#-----------------------------------------------------------------------------
#-- user
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;


CREATE TABLE `user`
(
	`user_id` INTEGER  NOT NULL AUTO_INCREMENT COMMENT 'User id',
	`name` VARCHAR(45)  NOT NULL COMMENT 'name',
	`email` VARCHAR(40)  NOT NULL COMMENT 'e-mail',
	`password` VARCHAR(20)  NOT NULL COMMENT 'password',
	`roomCreator` INTEGER COMMENT 'Right to create rooms',
	PRIMARY KEY (`user_id`),
	UNIQUE KEY `user_U_1` (`email`)
)Type=MyISAM COMMENT='User Table';

#-----------------------------------------------------------------------------
#-- production
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `production`;


CREATE TABLE `production`
(
	`production_id` INTEGER  NOT NULL AUTO_INCREMENT COMMENT 'Room id',
	`creation_date` DATE  NOT NULL COMMENT 'Creation date',
	`update_date` DATE  NOT NULL COMMENT 'Latest update',
	`room_id` INTEGER(10),
	PRIMARY KEY (`production_id`),
	INDEX `production_FI_1` (`room_id`),
	CONSTRAINT `production_FK_1`
		FOREIGN KEY (`room_id`)
		REFERENCES `room` (`room_id`)
)Type=MyISAM COMMENT='Production Table';

#-----------------------------------------------------------------------------
#-- element
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `element`;


CREATE TABLE `element`
(
	`element_id` INTEGER  NOT NULL AUTO_INCREMENT COMMENT 'Element id',
	`value` TEXT COMMENT 'Element value',
	`id` VARCHAR(10) COMMENT 'The element id',
	`tabindex` INTEGER COMMENT 'The element tabindex value',
	`css_top` INTEGER COMMENT 'The CSS top of a element',
	`css_left` INTEGER COMMENT 'The CSS left of a element',
	`css_width` INTEGER COMMENT 'Width of a element',
	`css_height` INTEGER COMMENT 'Height of a element',
	`rotation` INTEGER COMMENT 'Roration of a element',
	`last_change_by` INTEGER COMMENT 'Change of a element',
	`production_id` INTEGER(10),
	PRIMARY KEY (`element_id`),
	INDEX `element_FI_1` (`production_id`),
	CONSTRAINT `element_FK_1`
		FOREIGN KEY (`production_id`)
		REFERENCES `production` (`production_id`)
)Type=MyISAM COMMENT='Element Table';

#-----------------------------------------------------------------------------
#-- message
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `message`;


CREATE TABLE `message`
(
	`message_id` INTEGER  NOT NULL AUTO_INCREMENT COMMENT 'Message id',
	`text` TEXT  NOT NULL COMMENT 'Text',
	`lang` VARCHAR(45)  NOT NULL COMMENT 'localization',
	`user_id` INTEGER(10)  NOT NULL,
	`production_id` INTEGER(10)  NOT NULL,
	PRIMARY KEY (`message_id`),
	INDEX `message_FI_1` (`user_id`),
	CONSTRAINT `message_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`user_id`),
	INDEX `message_FI_2` (`production_id`),
	CONSTRAINT `message_FK_2`
		FOREIGN KEY (`production_id`)
		REFERENCES `production` (`production_id`)
)Type=MyISAM COMMENT='Message Table';

#-----------------------------------------------------------------------------
#-- history
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `history`;


CREATE TABLE `history`
(
	`user_id` INTEGER  NOT NULL,
	`production_id` INTEGER  NOT NULL,
	`date` DATE  NOT NULL COMMENT 'Interaction date',
	PRIMARY KEY (`user_id`,`production_id`),
	CONSTRAINT `history_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`user_id`),
	INDEX `history_FI_2` (`production_id`),
	CONSTRAINT `history_FK_2`
		FOREIGN KEY (`production_id`)
		REFERENCES `production` (`production_id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- production_history
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `production_history`;


CREATE TABLE `production_history`
(
	`production_history_id` INTEGER  NOT NULL AUTO_INCREMENT COMMENT 'id',
	`user_id` INTEGER  NOT NULL,
	`production_id` INTEGER  NOT NULL,
	`action` VARCHAR(45)  NOT NULL COMMENT 'name',
	`date` DATE  NOT NULL COMMENT 'Interaction date',
	`value` VARCHAR(255)  NOT NULL COMMENT 'name',
	`user_name` VARCHAR(255) COMMENT 'User name',
	`type` VARCHAR(20) COMMENT 'type',
	PRIMARY KEY (`production_history_id`),
	INDEX `production_history_FI_1` (`user_id`),
	CONSTRAINT `production_history_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`user_id`),
	INDEX `production_history_FI_2` (`production_id`),
	CONSTRAINT `production_history_FK_2`
		FOREIGN KEY (`production_id`)
		REFERENCES `production` (`production_id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- online
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `online`;


CREATE TABLE `online`
(
	`user_id` INTEGER  NOT NULL,
	`production_id` INTEGER  NOT NULL,
	`transmit` INTEGER COMMENT 'Indicates the user that is the presenter',
	PRIMARY KEY (`user_id`,`production_id`),
	CONSTRAINT `online_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`user_id`),
	INDEX `online_FI_2` (`production_id`),
	CONSTRAINT `online_FK_2`
		FOREIGN KEY (`production_id`)
		REFERENCES `production` (`production_id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- permission
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `permission`;


CREATE TABLE `permission`
(
	`user_id` INTEGER  NOT NULL,
	`room_id` INTEGER  NOT NULL,
	PRIMARY KEY (`user_id`,`room_id`),
	CONSTRAINT `permission_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`user_id`),
	INDEX `permission_FI_2` (`room_id`),
	CONSTRAINT `permission_FK_2`
		FOREIGN KEY (`room_id`)
		REFERENCES `room` (`room_id`)
)Type=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
