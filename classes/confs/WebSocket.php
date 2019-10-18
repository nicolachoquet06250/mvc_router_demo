<?php
	
	
	namespace mvc_router\confs\custom;
	
	
	use mvc_router\Base;
	
	class WebSocket extends Base {
		public function get_routes() {
			return [
				'/chat' => [
					'controller' => $this->inject->get_ws_chat(),
					'allows' => ['*'],
				]
			];
		}
	}