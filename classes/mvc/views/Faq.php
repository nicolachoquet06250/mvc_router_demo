<?php
	
	
	namespace mvc_router\mvc\views;
	
	
	use mvc_router\http\errors\Exception404;
	
	class Faq extends DocLayout {
		
		private $pages = [
			'questions' => 'Questions',
			'answers' => 'Réponses',
			'contact_us' => 'Contactez nous',
		];
		
		public function tabs_added_before_menu() {
			$current_page = $this->get('current_page');
			switch($current_page) {
				case 'questions':
				case 'answers':
				case 'contact_us':
					$route = $this->inject->get_url_generator()
						->get_url_from_ctrl_and_method($this->inject->get_faq_controller(), $current_page);
					return "<a class='mdl-navigation__link is-active' href='{$route}'>{$this->pages[$current_page]}</a>";
				default:
					return "";
			}
		}
		
		private function questions() {
			return "<h3>Questions</h3>";
		}
		
		private function answers() {
			return "<h3>Réponses</h3>";
		}
		
		private function contact_us() {
			return "<h3>Contactez Nous</h3>";
		}
		
		/**
		 * @return string|void
		 * @throws Exception404
		 */
		public function page_content() {
			switch($this->get('current_page')) {
				case 'questions':
				case 'answers':
				case 'contact_us':
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