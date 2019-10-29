<?php


namespace mvc_router\data\gesture\custom\entities;


use mvc_router\data\gesture\Entity;

/**
 * Class User
 *
 * @package mvc_router\data\gesture\custom\entities
 *
 */
class User extends Entity {
	/**
	 * @var int $id
	 * @primary_key
	 * @auto_increment
	 */
	protected $id;
	/**
	 * @var int $fb_id
	 */
	protected $fb_id;
	/**
	 * @var string $address
	 * @sql_type varchar
	 */
	protected $address;
	/**
	 * @var string $email
	 * @sql_type varchar
	 */
	protected $email;
	/**
	 * @var string $phone
	 * @sql_type varchar
	 */
	protected $phone;
	/**
	 * @var string $password
	 * @sql_type varchar
	 */
	protected $password;
	/**
	 * @var string $description
	 * @sql_type text
	 */
	protected $description;
	/**
	 * @var string $profil_img
	 * @sql_type varchar
	 */
	protected $profil_img;
	/**
	 * @var bool $premium
	 * @sql_type tinyint
	 */
	protected $premium;
	/**
	 * @var bool $active
	 * @sql_type tinyint
	 */
	protected $active;
	/**
	 * @var string $activate_token
	 * @sql_type varchar
	 */
	protected $activate_token;
	/**
	 * @var string $website
	 * @sql_type varchar
	 */
	protected $website;
	/**
	 * @var string $pseudo
	 * @sql_type varchar
	 */
	protected $pseudo;
	/**
	 * @var string $first_name
	 * @sql_type varchar
	 */
	protected $first_name;
	/**
	 * @var string $last_name
	 * @sql_type varchar
	 */
	protected $last_name;
	/**
	 * @var string $fb_access_token
	 * @sql_type varchar
	 */
	protected $fb_access_token;
	/**
	 * @var string $local_access_token
	 * @sql_type varchar
	 */
	protected $local_access_token;
	/**
	 * @var string $role
	 * @sql_type varchar
	 */
	protected $role;
	/**
	 * @inheritDoc
	 */
	public function to_json() {
		$json = parent::to_json();
		unset($json['password']);
		$json['role'] = $this->get('role');
		return $json;
	}
	/**
	 * @inheritDoc
	 */
	public function get($key) {
		switch ($key) {
			case 'role':
				if(!$this->id) {
					return '';
				}
				$user_role = $this->inject->get_role_manager()->get_all_from_userid($this->id);
				if(empty($user_role)) {
					return '';
				}
				return $user_role->get('role');
			default:
				return parent::get($key);
		}
	}
}