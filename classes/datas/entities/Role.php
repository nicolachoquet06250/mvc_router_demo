<?php
	
	
	namespace mvc_router\data\gesture\custom\entities;
	
	
	use mvc_router\data\gesture\Entity;
	
	class Role extends Entity {
		/**
		 * @var int $id
		 * @primary_key
		 * @auto_increment
		 */
		public $id;
		/**
		 * @var string $name
		 * @sql_type varchar
		 */
		public $name;
		/**
		 * @var int $user_id
		 */
		public $user_id;
	}