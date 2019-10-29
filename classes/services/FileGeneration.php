<?php
	
	namespace mvc_router\services\custom;
	
	
	class FileGeneration extends \mvc_router\services\FileGeneration {
		public function generate_base_htaccess( $custom_dir ) {
			parent::generate_base_htaccess( $custom_dir );
			$slash = $this->helpers->get_slash();
			$htaccess_php = '<?php

mvc_router\dependencies\Dependency::get_wrapper_factory()->get_dependency_wrapper()->get_router()
	->root_route(\'home_controller\')->inspect_controllers();
';
			file_put_contents(($this->helpers->is_unix() ? __DIR__.$slash.'..'.$slash.'..'.$slash : '').$custom_dir.$slash.'htaccess.php', $htaccess_php);
		}
	}