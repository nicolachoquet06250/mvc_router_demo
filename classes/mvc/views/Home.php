<?php
	
	
	namespace mvc_router\mvc\views;
	
	
	class Home extends DocLayout {
		protected $first_footer_list = [
			'title' => 'Features',
			'list'  => [
				'About'     => '#',
				'Terms'     => '#',
				'Partners'  => '#',
				'Updates'   => '#'
			],
		];
		
		protected $second_footer_list = [
			'title' => 'Details',
			'list'  => [
				'Specs'     => '#',
				'Tools'     => '#',
				'Resources' => '#'
			],
		];
		
		protected $third_footer_list = [
			'title' => 'Technology',
			'list'  => [
				'How it works'  => '#',
				'Patterns'      => '#',
				'Usage'         => '#',
				'Products'      => '#',
				'Contracts'     => '#',
			],
		];
		
		protected $fourth_footer_list = [
			'title' => 'FAQ',
			'list'  => [
				'Questions' => '#',
				'Answers' => '#',
				'Contact us' => '#',
			],
		];
		
		protected $footer_bottom = [
			'title' => 'Title',
			'list'  => [
				'Help'              => '#',
				'Privacy & Terms'   => '#'
			],
		];
		
		public function page_content(): string {
			return "
<div class='mdl-grid'>
	<div class='mdl-cell mdl-cell--6-col'>
		<h2>MVC ROUTER</h2>
		<p>Créez des projets Web avec le framework backend MVC ROUTER.</p>
		<p>MVC ROUTER est un framework open source pour le développement de webservices REST et de sites web en PHP.</p>
		<p>Créez vos vues, controllers, services, entitées et managers simplement puis injectez les directement dans vos classes par propriétés ou par paramètres de fonctions.</p>
		<p>Créez vos propres commandes affin de personnalisez le cli du framework.</p>
		<p>
			<a href='/documentation/get-started'>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored'>Get Started</button>
			</a>
		</p>
	</div>
	<div class='mdl-cell mdl-cell--6-col logo' style='padding-top: 20px; padding-bottom: 20px;'>
		<img src='/static/images/logo_mvc_router_black.png'
			 data-base_src='/static/images/logo_mvc_router_black.png' style='width: 70%' />
	</div>
</div>
";
		}
	}