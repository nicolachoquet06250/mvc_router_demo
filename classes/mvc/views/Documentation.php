<?php
	
	
	namespace mvc_router\mvc\views;
	
	
	class Documentation extends DocLayout {
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
		
		protected $tabs = [
			'Get Started',
			'Services',
			'Controllers',
			'Views',
			'Entities',
			'Managers',
			'Commands',
			'Configurations'
		];
		
		private function get_next_tab_url() {
			$tabs = array_map(function($tab) {
				return str_replace([' ', '_'], '-', strtolower($tab));
			}, $this->tabs);
			foreach( $tabs as $key => $tab ) {
				if(str_replace('_', '-', $this->get('sub_page')) === $tab) {
					if(isset($tabs[$key + 1])) {
						return "/documentation/{$tabs[$key + 1]}";
					}
				}
			}
			return "/documentation/{$tabs[0]}";
		}
		
		private function get_prevent_tab_url() {
			$tabs = array_map(function($tab) {
				return str_replace([' '], '-', strtolower($tab));
			}, $this->tabs);
			for($key = count($tabs) - 1; $key > 0; $key--) {
				$tab = $tabs[$key];
				if($this->get('sub_page') === $tab) {
					if($key > 0) {
						return "/documentation/{$tabs[$key - 1]}";
					}
				}
			}
			return "/documentation/{$tabs[count($tabs) - 1]}";
		}
		
		protected function get_started(): string {
			return "
			<h3>Commencer</h3>
			<ul>
				<li>Eddard</li>
				<li>Catelyn</li>
		 		<li>Robb</li>
				<li>Sansa</li>
				<li>Brandon</li>
				<li>Arya</li>
				<li>Rickon</li>
			</ul>
			";
		}
		
		protected function services(): string {
			return "
			<h3>Services</h3>
			<ul>
				<li>Tywin</li>
				<li>Cersei</li>
				<li>Jamie</li>
				<li>Tyrion</li>
			</ul>
			";
		}
		
		protected function controllers(): string {
			return "
			<h3>Controlleurs</h3>
			<ul>
				<li>Viserys</li>
				<li>Daenerys</li>
			</ul>
			";
		}
		
		protected function views(): string {
			return "
			<h3>Vues</h3>
			<ul>
				<li>Viserys</li>
				<li>Daenerys</li>
			</ul>
			";
		}
		
		protected function entities(): string {
			return "
			<h3>Entitées</h3>
			<ul>
				<li>Viserys</li>
				<li>Daenerys</li>
			</ul>
			";
		}
		
		protected function managers(): string {
			return "
			<h3>Managers</h3>
			<ul>
				<li>Viserys</li>
				<li>Daenerys</li>
			</ul>
			";
		}
		
		protected function commands(): string {
			return "
			<h3>Commandes</h3>
			<ul>
				<li>Viserys</li>
				<li>Daenerys</li>
			</ul>
			";
		}
		
		protected function configurations(): string {
			return "
			<h3>Configurations</h3>
			<ul>
				<li>Viserys</li>
				<li>Daenerys</li>
			</ul>
			";
		}
		
		protected $write_sub_menu = true;
		
		public function page_content(): string {
			return "
	<div class='mdl-grid' style='margin-top: 100px;'>
		<div class='mdl-cell mdl-cell--6-col-desktop mdl-cell--4-col-tablet mdl-cell--2-col-phone'>
			<a href='{$this->get_prevent_tab_url()}'>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored'>Prevent</button>
			</a>
		</div>
		<div class='mdl-cell mdl-cell--6-col-desktop mdl-cell--4-col-tablet mdl-cell--2-col-phone' style='text-align: right'>
			<a href='{$this->get_next_tab_url()}'>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored'>Next</button>
			</a>
		</div>
	</div>
";
		}
	}