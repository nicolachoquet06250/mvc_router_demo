<?php


namespace mvc_router\confs\custom;


class Mysql extends \mvc_router\confs\Mysql {
	public function before_construct() {
		parent::before_construct();
		$json = $this->inject->get_service_json();
		$fs = $this->inject->get_service_fs();
		$content = $json->decode($fs->read_file(__DIR__.'/mysql.json'), true);
		if(isset($content['host']) && $content['host']) $this->host = $content['host'];
		if(isset($content['user']) && $content['user']) $this->user = $content['user'];
		if(isset($content['pass']) && $content['pass']) $this->pass = $content['pass'];
		if(isset($content['user_prefix']) && $content['user_prefix']) $this->user_prefix = $content['user_prefix'];
		if(isset($content['db_prefix']) && $content['db_prefix']) $this->db_prefix = $content['db_prefix'];
		if(isset($content['db_name']) && $content['db_name']) $this->db_name = $content['db_name'];
		if(isset($content['port']) && $content['port']) $this->port = $content['port'];
	}
}