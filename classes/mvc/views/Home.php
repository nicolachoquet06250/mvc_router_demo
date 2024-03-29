<?php
	
	
	namespace mvc_router\mvc\views;
	
	
	class Home extends DocLayout {
		protected function first_div_content($device = 'desktop') {
			return "
	<h2>MVC ROUTER</h2>
	<p>Créez des projets Web avec le framework backend MVC ROUTER.</p>
	<p>MVC ROUTER est un framework open source pour le développement de webservices REST et de sites web en PHP.</p>
	<p>Créez vos vues, controllers, services, entitées et managers simplement puis injectez les directement dans vos classes par propriétés ou par paramètres de fonctions.</p>
	<p>Créez vos propres commandes affin de personnalisez le cli du framework.</p>
	<p".($device === 'mobile' ? " style='text-align: center;'" : '').">
		<a href='/documentation/get-started'>
			<button class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored'>Get Started</button>
		</a>
	</p>
			";
		}
		
		protected function second_div_content($device = 'desktop') {
			return ($device === 'mobile' ? "<center>" : '')."
	<img src='/static/images/logo_mvc_router_black.png' alt='logo'
		 data-base_src='/static/images/logo_mvc_router_black.png' style='width: 70%' />
			".($device === 'mobile' ? "</center>" : '');
		}
		
		public function page_content(): string {
			return "
<div class='mdl-grid'>
	<div class='mdl-cell mdl-cell--6-col mdl-cell--hide-phone mdl-cell--hide-tablet'>
		{$this->first_div_content()}
	</div>
	<div class='mdl-cell mdl-cell--12-col mdl-cell--hide-desktop logo'>
		{$this->second_div_content('mobile')}
	</div>
	<div class='mdl-cell mdl-cell--6-col mdl-cell--hide-phone mdl-cell--hide-tablet logo'
		 style='padding-top: 20px; padding-bottom: 20px; text-align: center'>
		{$this->second_div_content()}
	</div>
	<div class='mdl-cell mdl-cell--12-col mdl-cell--hide-desktop'>
		{$this->first_div_content('mobile')}
	</div>
</div>
";
		}
	}