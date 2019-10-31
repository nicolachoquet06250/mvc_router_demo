<?php
	
	
	namespace mvc_router\mvc\controllers\api;
	
	
	use mvc_router\http\errors\Exception404;
	use mvc_router\mvc\Controller;
	use mvc_router\router\Router;
	use mvc_router\services\Error;
	
	/**
	 * Class Mailer
	 * @package mvc_router\mvc\controllers\api
	 * @api
	 */
	class Mailer extends Controller {
		
		/**
		 * @route /mail/new
		 * @http_method post
		 * @param Router $router
		 * @return string
		 */
		public function send(Router $router) {
			return $this->json(
				[
					'email' => $router->post('email'),
					'first_name' => $router->post('first_name'),
					'last_name' => $router->post('last_name'),
					'_message' => $router->post('message'),
					'message' => 'L\'email à été envoyé avec succès !',
				]
			);
		}
	}