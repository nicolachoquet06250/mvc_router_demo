<?php
	
	
	namespace mvc_router\mvc\views;
	
	
	use mvc_router\http\errors\Exception404;
	
	class Details extends DocLayout {
		
		private $pages = [
			'specs' => 'Spécifications',
			'tools' => 'Outils',
			'resources' => 'Resources',
		];
		
		public function tabs_added_before_menu() {
			$current_page = $this->get('current_page');
			switch($current_page) {
				case 'specs':
				case 'tools':
				case 'resources':
					$route = $this->inject->get_url_generator()
						->get_url_from_ctrl_and_method($this->inject->get_details_controller(), $current_page);
					return "<a class='mdl-navigation__link is-active' href='{$route}'>{$this->pages[$current_page]}</a>";
				default:
					return "";
			}
		}
		
		private function specs() {
			return "<h3>Spécifications</h3>";
		}
		
		private function tools() {
			return "<h3>Outils</h3>";
		}
		
		private function resources() {
			return "<h3>Resources</h3>";
		}
		
		/**
		 * @return string
		 * @throws Exception404
		 */
		public function page_content() {
			switch($this->get('current_page')) {
				case 'specs':
				case 'tools':
				case 'resources':
					$content = $this->{$this->get('current_page')}();
					break;
				default:
					throw new Exception404( "Désolé mais la page {$this->get('current_title')} n'à pas été trouvé");
			}
			return <<<HTML
	<div class='mdl-grid'>
		<div class='mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
			{$content}
		</div>
	</div>
HTML;

		}
	}