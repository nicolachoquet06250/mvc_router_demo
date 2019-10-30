<?php
	
	
	namespace mvc_router\mvc\views;
	
	
	use mvc_router\http\errors\Exception404;
	
	class Characteristics extends DocLayout {
		
		private $pages = [
			'about' => 'A propos',
			'partners' => 'Partenaires',
			'updates' => 'Mises à jour',
		];
		
		public function tabs_added_before_menu() {
			$current_page = $this->get('current_page');
			switch($this->get('current_page')) {
				case 'about':
				case 'partners':
				case 'updates':
					$route = $this->inject->get_url_generator()
						->get_url_from_ctrl_and_method($this->inject->get_characteristics_controller(), $current_page);
					return "<a class='mdl-navigation__link is-active' href='{$route}'>{$this->pages[$current_page]}</a>";
				default:
					return "";
			}
		}
		
		private function about() {
			return "<h3>A propos</h3>";
		}
		
		private function partners() {
			return "<h3>Partenaires</h3>";
		}
		
		private function updates() {
			return "<h3>Mises à jour</h3>";
		}
		
		/**
		 * @return string
		 * @throws Exception404
		 */
		public function page_content() {
			switch($this->get('current_page')) {
				case 'about':
				case 'partners':
				case 'updates':
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