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
		
		private $tabs = [
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
		
		private function get_started(): string {
			return "
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
		
		private function services(): string {
			return "
			<ul>
				<li>Tywin</li>
				<li>Cersei</li>
				<li>Jamie</li>
				<li>Tyrion</li>
			</ul>
			";
		}
		
		private function controllers(): string {
			return "
			<ul>
				<li>Viserys</li>
				<li>Daenerys</li>
			</ul>
			";
		}
		
		private function views(): string {
			return "
			<ul>
				<li>Viserys</li>
				<li>Daenerys</li>
			</ul>
			";
		}
		
		private function entities(): string {
			return "
			<ul>
				<li>Viserys</li>
				<li>Daenerys</li>
			</ul>
			";
		}
		
		private function managers(): string {
			return "
			<ul>
				<li>Viserys</li>
				<li>Daenerys</li>
			</ul>
			";
		}
		
		private function commands(): string {
			return "
			<ul>
				<li>Viserys</li>
				<li>Daenerys</li>
			</ul>
			";
		}
		
		private function configurations(): string {
			return "
			<ul>
				<li>Viserys</li>
				<li>Daenerys</li>
			</ul>
			";
		}
		
		public function page_content(): string {
			$tabs = implode("\n", array_map(function($tab) {
				$method = str_replace([' ', '-'], '_', strtolower($tab));
				$method_in_link = str_replace('_', '-', $method);
				return "<a href='/documentation/{$method_in_link}' class='mdl-tabs__tab ".($this->get('sub_page') === $method ? 'is-active' : '')."'>".ucfirst($tab)."</a>";
			}, $this->tabs));
			
			$tabs_page = implode("\n", array_map(function($tab) {
				$method = str_replace([' ', '-'], '_', strtolower($tab));
				return "<div class='mdl-tabs__panel ".($this->get('sub_page') === $method ? 'is-active' : '')."'
								id='".$method."-panel'>{$this->$method()}</div>";
			}, $this->tabs));
			return "
<div class='mdl-tabs mdl-js-tabs mdl-js-ripple-effect'>
	<div class='mdl-tabs__tab-bar'>{$tabs}</div>
	{$tabs_page}
	<div class='mdl-grid' style='margin-top: 100px;'>
		<div class='mdl-cell mdl-cell--1'>
			<a href='{$this->get_prevent_tab_url()}'>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored'>Prevent</button>
			</a>
		</div>
		<div class='mdl-cell mdl-cell--10'></div>
		<div class='mdl-cell mdl-cell--1' style='text-align: right'>
			<a href='{$this->get_next_tab_url()}'>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored'>Next</button>
			</a>
		</div>
	</div>
</div>
";
		}
	}