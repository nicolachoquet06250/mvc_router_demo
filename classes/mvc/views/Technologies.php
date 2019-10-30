<?php
	
	
	namespace mvc_router\mvc\views;
	
	
	use mvc_router\http\errors\Exception404;
	
	class Technologies extends DocLayout {
		
		private $pages = [
			'how_to_works' => 'Fonctionnement',
			'patterns' => 'Patterns',
			'usage' => 'Utilisation',
			'products' => 'Produits',
			'contracts' => 'Contrats'
		];
		
		public function tabs_added_before_menu() {
			$current_page = $this->get('current_page');
			switch($current_page) {
				case 'how_to_works':
				case 'patterns':
				case 'usage':
				case 'products':
				case 'contracts':
					$route = $this->inject->get_url_generator()
						->get_url_from_ctrl_and_method($this->inject->get_technologies_controller(), $current_page);
					return "<a class='mdl-navigation__link is-active' href='{$route}'>{$this->pages[$current_page]}</a>";
				default:
					return "";
			}
		}
		
		private function how_to_works() {
			return "<h3>Fonctionnement</h3>";
		}
		
		private function patterns() {
			return "<h3>Patterns</h3>";
		}
		
		private function usage() {
			return "<h3>Utilisation</h3>";
		}
		
		private function products() {
			return "<h3>Produits</h3>";
		}
		
		private function contracts() {
			return "<h3>Contrats</h3>";
		}
		
		/**
		 * @return string
		 * @throws Exception404
		 */
		public function page_content() {
			switch($this->get('current_page')) {
				case 'how_to_works':
				case 'patterns':
				case 'usage':
				case 'products':
				case 'contracts':
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