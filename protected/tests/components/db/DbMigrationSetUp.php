<?php
/**
 * DbMigrationSetUp class file.
 *
 * @author Paul Klimov <pklimov@quart-soft.com> 
 * @link http://www.quart-soft.com/
 * @copyright Copyright &copy; 2008-2011 QuartSoft ltd.
 * @license http://www.quart-soft.com/license/
 */

/**
 * This class extends {@link CDbMigration} and was created as helper 
 * for the unit test creation.
 */
class DbMigrationSetUp extends CDbMigration {
    public function up() {
        return true;
    }
}