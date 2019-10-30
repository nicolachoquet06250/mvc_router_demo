<?php
	
	
	namespace mvc_router\mvc\views;
	
	
	class Help extends DocLayout {
		protected function tabs_added_before_menu() {
			return "<a class='mdl-navigation__link is-active' href='/mvc-router/help'>Aide</a>";
		}
		
		public function page_content(): string {
			return <<<HTML
	<div class='mdl-grid'>
		<div class='mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
			<h3>Help</h3>
		</div>
	</div>
HTML;

		}
	}