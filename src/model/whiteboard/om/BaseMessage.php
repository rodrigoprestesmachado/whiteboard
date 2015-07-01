<?php

require_once 'propel/om/BaseObject.php';

require_once 'propel/om/Persistent.php';


include_once 'propel/util/Criteria.php';

include_once 'src/model/whiteboard/MessagePeer.php';

/**
 * Base class that represents a row from the 'message' table.
 *
 * Message Table
 *
 * This class was autogenerated by Propel on:
 *
 * 02/15/13 21:36:52
 *
 * @package    src/model/whiteboard.om
 */
abstract class BaseMessage extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        MessagePeer
	 */
	protected static $peer;


	/**
	 * The value for the message_id field.
	 * @var        int
	 */
	protected $message_id;


	/**
	 * The value for the text field.
	 * @var        string
	 */
	protected $text;


	/**
	 * The value for the lang field.
	 * @var        string
	 */
	protected $lang;


	/**
	 * The value for the user_id field.
	 * @var        int
	 */
	protected $user_id;


	/**
	 * The value for the production_id field.
	 * @var        int
	 */
	protected $production_id;

	/**
	 * @var        User
	 */
	protected $aUser;

	/**
	 * @var        Production
	 */
	protected $aProduction;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	/**
	 * Get the [message_id] column value.
	 * Message id
	 * @return     int
	 */
	public function getMessageId()
	{

		return $this->message_id;
	}

	/**
	 * Get the [text] column value.
	 * Text
	 * @return     string
	 */
	public function getText()
	{

		return $this->text;
	}

	/**
	 * Get the [lang] column value.
	 * localization
	 * @return     string
	 */
	public function getLang()
	{

		return $this->lang;
	}

	/**
	 * Get the [user_id] column value.
	 * 
	 * @return     int
	 */
	public function getUserId()
	{

		return $this->user_id;
	}

	/**
	 * Get the [production_id] column value.
	 * 
	 * @return     int
	 */
	public function getProductionId()
	{

		return $this->production_id;
	}

	/**
	 * Set the value of [message_id] column.
	 * Message id
	 * @param      int $v new value
	 * @return     void
	 */
	public function setMessageId($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->message_id !== $v) {
			$this->message_id = $v;
			$this->modifiedColumns[] = MessagePeer::MESSAGE_ID;
		}

	} // setMessageId()

	/**
	 * Set the value of [text] column.
	 * Text
	 * @param      string $v new value
	 * @return     void
	 */
	public function setText($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->text !== $v) {
			$this->text = $v;
			$this->modifiedColumns[] = MessagePeer::TEXT;
		}

	} // setText()

	/**
	 * Set the value of [lang] column.
	 * localization
	 * @param      string $v new value
	 * @return     void
	 */
	public function setLang($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->lang !== $v) {
			$this->lang = $v;
			$this->modifiedColumns[] = MessagePeer::LANG;
		}

	} // setLang()

	/**
	 * Set the value of [user_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setUserId($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = MessagePeer::USER_ID;
		}

		if ($this->aUser !== null && $this->aUser->getUserId() !== $v) {
			$this->aUser = null;
		}

	} // setUserId()

	/**
	 * Set the value of [production_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setProductionId($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->production_id !== $v) {
			$this->production_id = $v;
			$this->modifiedColumns[] = MessagePeer::PRODUCTION_ID;
		}

		if ($this->aProduction !== null && $this->aProduction->getProductionId() !== $v) {
			$this->aProduction = null;
		}

	} // setProductionId()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (1-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      ResultSet $rs The ResultSet class with cursor advanced to desired record pos.
	 * @param      int $startcol 1-based offset column which indicates which restultset column to start with.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->message_id = $rs->getInt($startcol + 0);

			$this->text = $rs->getString($startcol + 1);

			$this->lang = $rs->getString($startcol + 2);

			$this->user_id = $rs->getInt($startcol + 3);

			$this->production_id = $rs->getInt($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 5; // 5 = MessagePeer::NUM_COLUMNS - MessagePeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Message object", $e);
		}
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      Connection $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MessagePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MessagePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Stores the object in the database.  If the object is new,
	 * it inserts it; otherwise an update is performed.  This method
	 * wraps the doSave() worker method in a transaction.
	 *
	 * @param      Connection $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MessagePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Stores the object in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      Connection $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave($con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aUser !== null) {
				if ($this->aUser->isModified()) {
					$affectedRows += $this->aUser->save($con);
				}
				$this->setUser($this->aUser);
			}

			if ($this->aProduction !== null) {
				if ($this->aProduction->isModified()) {
					$affectedRows += $this->aProduction->save($con);
				}
				$this->setProduction($this->aProduction);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MessagePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setMessageId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += MessagePeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aUser !== null) {
				if (!$this->aUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUser->getValidationFailures());
				}
			}

			if ($this->aProduction !== null) {
				if (!$this->aProduction->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProduction->getValidationFailures());
				}
			}


			if (($retval = MessagePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(MessagePeer::DATABASE_NAME);

		if ($this->isColumnModified(MessagePeer::MESSAGE_ID)) $criteria->add(MessagePeer::MESSAGE_ID, $this->message_id);
		if ($this->isColumnModified(MessagePeer::TEXT)) $criteria->add(MessagePeer::TEXT, $this->text);
		if ($this->isColumnModified(MessagePeer::LANG)) $criteria->add(MessagePeer::LANG, $this->lang);
		if ($this->isColumnModified(MessagePeer::USER_ID)) $criteria->add(MessagePeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(MessagePeer::PRODUCTION_ID)) $criteria->add(MessagePeer::PRODUCTION_ID, $this->production_id);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MessagePeer::DATABASE_NAME);

		$criteria->add(MessagePeer::MESSAGE_ID, $this->message_id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getMessageId();
	}

	/**
	 * Generic method to set the primary key (message_id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setMessageId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Message (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setText($this->text);

		$copyObj->setLang($this->lang);

		$copyObj->setUserId($this->user_id);

		$copyObj->setProductionId($this->production_id);


		$copyObj->setNew(true);

		$copyObj->setMessageId(NULL); // this is a pkey column, so set to default value

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     Message Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     MessagePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new MessagePeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a User object.
	 *
	 * @param      User $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setUser($v)
	{


		if ($v === null) {
			$this->setUserId(NULL);
		} else {
			$this->setUserId($v->getUserId());
		}


		$this->aUser = $v;
	}


	/**
	 * Get the associated User object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     User The associated User object.
	 * @throws     PropelException
	 */
	public function getUser($con = null)
	{
		// include the related Peer class
		include_once 'src/model/whiteboard/om/BaseUserPeer.php';

		if ($this->aUser === null && ($this->user_id !== null)) {

			$this->aUser = UserPeer::retrieveByPK($this->user_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = UserPeer::retrieveByPK($this->user_id, $con);
			   $obj->addUsers($this);
			 */
		}
		return $this->aUser;
	}

	/**
	 * Declares an association between this object and a Production object.
	 *
	 * @param      Production $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setProduction($v)
	{


		if ($v === null) {
			$this->setProductionId(NULL);
		} else {
			$this->setProductionId($v->getProductionId());
		}


		$this->aProduction = $v;
	}


	/**
	 * Get the associated Production object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Production The associated Production object.
	 * @throws     PropelException
	 */
	public function getProduction($con = null)
	{
		// include the related Peer class
		include_once 'src/model/whiteboard/om/BaseProductionPeer.php';

		if ($this->aProduction === null && ($this->production_id !== null)) {

			$this->aProduction = ProductionPeer::retrieveByPK($this->production_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ProductionPeer::retrieveByPK($this->production_id, $con);
			   $obj->addProductions($this);
			 */
		}
		return $this->aProduction;
	}

} // BaseMessage
