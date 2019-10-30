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
			return <<<HTML
<div class='mdl-grid'>
	<div class='mdl-cell--3-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'></div>
	<div class='mdl-cell--6-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone' style='width: unset;'>
		<div class="demo-card-wide mdl-card mdl-shadow--2dp" style='width: 100%'>
			<div class="mdl-card__title faq contact-us">
				<h2 class="mdl-card__title-text">Contactez nous</h2>
			</div>
			<div class="mdl-card__supporting-text">
				<form action='{$this->inject->get_url_generator()
					->get_url_from_ctrl_and_method($this->inject->get_faq_controller(), 'contact_us')}' method='get' class='mdl-grid'>
					<div class='mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone' style='padding: 5px;'>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style='width: 100%;'>
							<input class="mdl-textfield__input" type="email"
								   pattern="[^@]+\@[^.]+\.[a-zA-Z]{2,3}" id="email" />
							<label class="mdl-textfield__label" for="email">Email ...</label>
							<span class="mdl-textfield__error">Email incorrect !</span>
						</div>
					</div>
					<div class='mdl-cell--6-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone' style='padding: 5px;'>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style='width: 100%;'>
							<input class="mdl-textfield__input" type="text" id="last_name" />
							<label class="mdl-textfield__label" for="last_name">Nom ...</label>
						</div>
					</div>
					<div class='mdl-cell--6-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone' style='padding: 5px;'>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style='width: 100%;' >
							<input class="mdl-textfield__input" type="text" id="first_name" />
							<label class="mdl-textfield__label" for="first_name">Prénom ...</label>
						</div>
					</div>
					<div class='mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone' style='padding: 5px;'>
						<div class="mdl-textfield mdl-js-textfield" style='width: 100%;'>
							<textarea class="mdl-textfield__input" type="text" rows="5" id="message" ></textarea>
							<label class="mdl-textfield__label" for="message">Message ...</label>
						</div>
					</div>
				</form>
			</div>
			<div class="mdl-card__actions mdl-card--border">
				<button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" type='submit'>
					Envoyer
				</button>
			</div>
			<!--<div class="mdl-card__menu">
				<button class="mdl-button mdl-button&#45;&#45;icon mdl-js-button mdl-js-ripple-effect">
					<i class="material-icons">share</i>
				</button>
			</div>-->
		</div>
	</div>
</div>
HTML;
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
		<div class='mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone' style='width: 100%'>
			{$content}
		</div>
	</div>
HTML;
		}
	}