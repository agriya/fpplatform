<?php
/**
 * FP Platform
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    FPPlatform
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
class TaxonomyData {

	public $table = 'taxonomies';

	public $records = array(
		array(
			'id' => '1',
			'parent_id' => '',
			'term_id' => '1',
			'vocabulary_id' => '1',
			'lft' => '1',
			'rght' => '2'
		),
		array(
			'id' => '2',
			'parent_id' => '',
			'term_id' => '2',
			'vocabulary_id' => '1',
			'lft' => '3',
			'rght' => '4'
		),
		array(
			'id' => '3',
			'parent_id' => '',
			'term_id' => '3',
			'vocabulary_id' => '2',
			'lft' => '1',
			'rght' => '2'
		),
	);

}
