<?php

require_once 'propel/map/MapBuilder.php';
include_once 'creole/CreoleTypes.php';


/**
 * This class adds structure of 'production_history' table to 'whiteboard' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel on:
 *
 * 02/15/13 21:36:52
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    src/model/whiteboard.map
 */
class ProductionHistoryMapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'src/model/whiteboard.map.ProductionHistoryMapBuilder';

	/**
	 * The database map.
	 */
	private $dbMap;

	/**
	 * Tells us if this DatabaseMapBuilder is built so that we
	 * don't have to re-build it every time.
	 *
	 * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
	 */
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	/**
	 * Gets the databasemap this map builder built.
	 *
	 * @return     the databasemap
	 */
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	/**
	 * The doBuild() method builds the DatabaseMap
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap('whiteboard');

		$tMap = $this->dbMap->addTable('production_history');
		$tMap->setPhpName('ProductionHistory');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('PRODUCTION_HISTORY_ID', 'ProductionHistoryId', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('USER_ID', 'UserId', 'int', CreoleTypes::INTEGER, 'user', 'USER_ID', true, null);

		$tMap->addForeignKey('PRODUCTION_ID', 'ProductionId', 'int', CreoleTypes::INTEGER, 'production', 'PRODUCTION_ID', true, null);

		$tMap->addColumn('ACTION', 'Action', 'string', CreoleTypes::VARCHAR, true, 45);

		$tMap->addColumn('DATE', 'Date', 'int', CreoleTypes::DATE, true, null);

		$tMap->addColumn('VALUE', 'Value', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('USER_NAME', 'UserName', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('TYPE', 'Type', 'string', CreoleTypes::VARCHAR, false, 20);

	} // doBuild()

} // ProductionHistoryMapBuilder