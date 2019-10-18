<?php
	
	
	namespace mvc_router\mvc\controllers;
	
	
	use mvc_router\mvc\Controller;
	
	class WebSocket extends Controller {
		/**
		 * Test d'interface graphique pour un tchat privé siple à 2 ou plus sans authent
		 *
		 * @route /chat
		 *
		 * @param \mvc_router\mvc\views\WebSocket $view
		 * @return \mvc_router\mvc\views\WebSocket
		 */
		public function index(\mvc_router\mvc\views\WebSocket $view): \mvc_router\mvc\views\WebSocket {
			return $view;
		}
	}