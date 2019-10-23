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
		
		protected $write_sub_menu = true;
		
		public function after_construct() {
			parent::after_construct();
			
			// add material design light dropdown
			$this->assign('stylesheets', array_merge($this->get('stylesheets'), [
				'http://creativeit.github.io/getmdl-select/getmdl-select.min.css'
			]));
			$this->assign('scripts', array_merge($this->get('scripts'), [
				'http://creativeit.github.io/getmdl-select/getmdl-select.min.js',
				'table.js'
			]));
		}
		
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
		
		protected function get_table_group(string $title, callable $get_content, $hide = true) {
			$id_part = str_replace(' ', '-', $title);
			$id_part = strtolower($id_part);
			return "
	<tr>
		<th style='text-align: left; cursor: pointer;'
			onclick='toggleCell(document.querySelector(`#{$id_part}-cell`), this)'>
			<div class='mdl-grid'>
				<div class='mdl-cell mdl-cell--11-col-desktop mdl-cell--7-col-tablet mdl-cell--3-col-phone'>
					{$title}
				</div>
				<div class='mdl-cell mdl-cell--1-col' style='text-align: right;'>
					<span class='material-icons'>keyboard_arrow_down</span>
				</div>
			</div>
		</th>
	</tr>
	<tr id='{$id_part}-cell' class='hiddable'>
		<td style='text-align: left' class='".($hide ? 'hide' : '')."'>
			<div class='mdl-grid'>
				<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
					{$get_content()}
				</div>
			</div>
		</td>
	</tr>
			";
		}
		
		protected function get_started(): string {
			return "
			<div class='mdl-grid'>
				<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
					<h3>Commencer</h3>
					<table class='mdl-data-table mdl-js-data-table' style='width: 100%'>
						<tbody>
							{$this->get_table_group('Commencer', function() {
								return "<ul>
											<li>Eddard</li>
											<li>Catelyn</li>
									        <li>Robb</li>
											<li>Sansa</li>
											<li>Brandon</li>
											<li>Arya</li>
											<li>Rickon</li>
										</ul>";
							}, false)}
							
							{$this->get_table_group('Installation', function() {
								return "<ul>
											<li>Eddard</li>
											<li>Catelyn</li>
									        <li>Robb</li>
											<li>Sansa</li>
											<li>Brandon</li>
											<li>Arya</li>
											<li>Rickon</li>
										</ul>";
							})}
						</tbody>
					</table>

				</div>
			</div>
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