<?php

require_once 'propel/om/BaseObject.php';

require_once 'propel/om/Persistent.php';


include_once 'propel/util/Criteria.php';

include_once 'src/model/whiteboard/ElementPeer.php';

/**
 * Base class that represents a row from the 'element' table.
 *
 * Element Table
 *
 * This class was autogenerated by Propel on:
 *
 * 02/15/13 21:36:52
 *
 * @package    src/model/whiteboard.om
 */
abstract class BaseElement extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ElementPeer
	 */
	protected static $peer;


	/**
	 * The value for the element_id field.
	 * @var        int
	 */
	protected $element_id;


	/**
	 * The value for the value field.
	 * @var        string
	 */
	protected $value;


	/**
	 * The value for the id field.
	 * @var        string
	 */
	protected $id;


	/**
	 * The value for the tabindex field.
	 * @var        int
	 */
	protected $tabindex;


	/**
	 * The value for the css_top field.
	 * @var        int
	 */
	protected $css_top;


	/**
	 * The value for the css_left field.
	 * @var        int
	 */
	protected $css_left;


	/**
	 * The value for the css_width field.
	 * @var        int
	 */
	protected $css_width;


	/**
	 * The value for the css_height field.
	 * @var        int
	 */
	protected $css_height;


	/**
	 * The value for the rotation field.
	 * @var        int
	 */
	protected $rotation;


	/**
	 * The value for the last_change_by field.
	 * @var        int
	 */
	protected $last_change_by;


	/**
	 * The value for the production_id field.
	 * @var        int
	 */
	protected $production_id;

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
	 * Get the [element_id] column value.
	 * Element id
	 * @return     int
	 */
	public function getElementId()
	{

		return $this->element_id;
	}

	/**
	 * Get the [value] column value.
	 * Element value
	 * @return     string
	 */
	public function getValue()
	{

		return $this->value;
	}

	/**
	 * Get the [id] column value.
	 * The element id
	 * @return     string
	 */
	public function getId()
	{

		return $this->id;
	}

	/**
	 * Get the [tabindex] column value.
	 * The element tabindex value
	 * @return     int
	 */
	public function getTabindex()
	{

		return $this->tabindex;
	}

	/**
	 * Get the [css_top] column value.
	 * The CSS top of a element
	 * @return     int
	 */
	public function getCssTop()
	{

		return $this->css_top;
	}

	/**
	 * Get the [css_left] column value.
	 * The CSS left of a element
	 * @return     int
	 */
	public function getCssLeft()
	{

		return $this->css_left;
	}

	/**
	 * Get the [css_width] column value.
	 * Width of a element
	 * @return     int
	 */
	public function getCssWidth()
	{

		return $this->css_width;
	}

	/**
	 * Get the [css_height] column value.
	 * Height of a element
	 * @return     int
	 */
	public function getCssHeight()
	{

		return $this->css_height;
	}

	/**
	 * Get the [rotation] column value.
	 * Roration of a element
	 * @return     int
	 */
	public function getRotation()
	{

		return $this->rotation;
	}

	/**
	 * Get the [last_change_by] column value.
	 * Change of a element
	 * @return     int
	 */
	public function getLastChangeBy()
	{

		return $this->last_change_by;
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
	 * Set the value of [element_id] column.
	 * Element id
	 * @param      int $v new value
	 * @return     void
	 */
	public function setElementId($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->element_id !== $v) {
			$this->element_id = $v;
			$this->modifiedColumns[] = ElementPeer::ELEMENT_ID;
		}

	} // setElementId()

	/**
	 * Set the value of [value] column.
	 * Element value
	 * @param      string $v new value
	 * @return     void
	 */
	public function setValue($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->value !== $v) {
			$this->value = $v;
			$this->modifiedColumns[] = ElementPeer::VALUE;
		}

	} // setValue()

	/**
	 * Set the value of [id] column.
	 * The element id
	 * @param      string $v new value
	 * @return     void
	 */
	public function setId($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ElementPeer::ID;
		}

	} // setId()

	/**
	 * Set the value of [tabindex] column.
	 * The element tabindex value
	 * @param      int $v new value
	 * @return     void
	 */
	public function setTabindex($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->tabindex !== $v) {
			$this->tabindex = $v;
			$this->modifiedColumns[] = ElementPeer::TABINDEX;
		}

	} // setTabindex()

	/**
	 * Set the value of [css_top] column.
	 * The CSS top of a element
	 * @param      int $v new value
	 * @return     void
	 */
	public function setCssTop($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->css_top !== $v) {
			$this->css_top = $v;
			$this->modifiedColumns[] = ElementPeer::CSS_TOP;
		}

	} // setCssTop()

	/**
	 * Set the value of [css_left] column.
	 * The CSS left of a element
	 * @param      int $v new value
	 * @return     void
	 */
	public function setCssLeft($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->css_left !== $v) {
			$this->css_left = $v;
			$this->modifiedColumns[] = ElementPeer::CSS_LEFT;
		}

	} // setCssLeft()

	/**
	 * Set the value of [css_width] column.
	 * Width of a element
	 * @param      int $v new value
	 * @return     void
	 */
	public function setCssWidth($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->css_width !== $v) {
			$this->css_width = $v;
			$this->modifiedColumns[] = ElementPeer::CSS_WIDTH;
		}

	} // setCssWidth()

	/**
	 * Set the value of [css_height] column.
	 * Height of a element
	 * @param      int $v new value
	 * @return     void
	 */
	public function setCssHeight($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->css_height !== $v) {
			$this->css_height = $v;
			$this->modifiedColumns[] = ElementPeer::CSS_HEIGHT;
		}

	} // setCssHeight()

	/**
	 * Set the value of [rotation] column.
	 * Roration of a element
	 * @param      int $v new value
	 * @return     void
	 */
	public function setRotation($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->rotation !== $v) {
			$this->rotation = $v;
			$this->modifiedColumns[] = ElementPeer::ROTATION;
		}

	} // setRotation()

	/**
	 * Set the value of [last_change_by] column.
	 * Change of a element
	 * @param      int $v new value
	 * @return     void
	 */
	public function setLastChangeBy($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->last_change_by !== $v) {
			$this->last_change_by = $v;
			$this->modifiedColumns[] = ElementPeer::LAST_CHANGE_BY;
		}

	} // setLastChangeBy()

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
			$this->modifiedColumns[] = ElementPeer::PRODUCTION_ID;
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

			$this->element_id = $rs->getInt($startcol + 0);

			$this->value = $rs->getString($startcol + 1);

			$this->id = $rs->getString($startcol + 2);

			$this->tabindex = $rs->getInt($startcol + 3);

			$this->css_top = $rs->getInt($startcol + 4);

			$this->css_left = $rs->getInt($startcol + 5);

			$this->css_width = $rs->getInt($startcol + 6);

			$this->css_height = $rs->getInt($startcol + 7);

			$this->rotation = $rs->getInt($startcol + 8);

			$this->last_change_by = $rs->getInt($startcol + 9);

			$this->production_id = $rs->getInt($startcol + 10);

			$this->resetModified();

			$this->setNew(false);

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 11; // 11 = ElementPeer::NUM_COLUMNS - ElementPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Element object", $e);
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
			$con = Propel::getConnection(ElementPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ElementPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ElementPeer::DATABASE_NAME);
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

			if ($this->aProduction !== null) {
				if ($this->aProduction->isModified()) {
					$affectedRows += $this->aProduction->save($con);
				}
				$this->setProduction($this->aProduction);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ElementPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setElementId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ElementPeer::doUpdate($this, $con);
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

			if ($this->aProduction !== null) {
				if (!$this->aProduction->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProduction->getValidationFailures());
				}
			}


			if (($retval = ElementPeer::doValidate($this, $columns)) !== true) {
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
		$criteria = new Criteria(ElementPeer::DATABASE_NAME);

		if ($this->isColumnModified(ElementPeer::ELEMENT_ID)) $criteria->add(ElementPeer::ELEMENT_ID, $this->element_id);
		if ($this->isColumnModified(ElementPeer::VALUE)) $criteria->add(ElementPeer::VALUE, $this->value);
		if ($this->isColumnModified(ElementPeer::ID)) $criteria->add(ElementPeer::ID, $this->id);
		if ($this->isColumnModified(ElementPeer::TABINDEX)) $criteria->add(ElementPeer::TABINDEX, $this->tabindex);
		if ($this->isColumnModified(ElementPeer::CSS_TOP)) $criteria->add(ElementPeer::CSS_TOP, $this->css_top);
		if ($this->isColumnModified(ElementPeer::CSS_LEFT)) $criteria->add(ElementPeer::CSS_LEFT, $this->css_left);
		if ($this->isColumnModified(ElementPeer::CSS_WIDTH)) $criteria->add(ElementPeer::CSS_WIDTH, $this->css_width);
		if ($this->isColumnModified(ElementPeer::CSS_HEIGHT)) $criteria->add(ElementPeer::CSS_HEIGHT, $this->css_height);
		if ($this->isColumnModified(ElementPeer::ROTATION)) $criteria->add(ElementPeer::ROTATION, $this->rotation);
		if ($this->isColumnModified(ElementPeer::LAST_CHANGE_BY)) $criteria->add(ElementPeer::LAST_CHANGE_BY, $this->last_change_by);
		if ($this->isColumnModified(ElementPeer::PRODUCTION_ID)) $criteria->add(ElementPeer::PRODUCTION_ID, $this->production_id);

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
		$criteria = new Criteria(ElementPeer::DATABASE_NAME);

		$criteria->add(ElementPeer::ELEMENT_ID, $this->element_id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getElementId();
	}

	/**
	 * Generic method to set the primary key (element_id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setElementId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Element (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setValue($this->value);

		$copyObj->setId($this->id);

		$copyObj->setTabindex($this->tabindex);

		$copyObj->setCssTop($this->css_top);

		$copyObj->setCssLeft($this->css_left);

		$copyObj->setCssWidth($this->css_width);

		$copyObj->setCssHeight($this->css_height);

		$copyObj->setRotation($this->rotation);

		$copyObj->setLastChangeBy($this->last_change_by);

		$copyObj->setProductionId($this->production_id);


		$copyObj->setNew(true);

		$copyObj->setElementId(NULL); // this is a pkey column, so set to default value

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
	 * @return     Element Clone of current object.
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
	 * @return     ElementPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ElementPeer();
		}
		return self::$peer;
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

} // BaseElement
