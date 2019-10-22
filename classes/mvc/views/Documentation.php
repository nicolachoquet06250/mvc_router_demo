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
			'Starks',
			'Lannisters',
			'Targaryens',
		];
		
		private function starks(): string {
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
		
		private function lannisters(): string {
			return "
			<ul>
				<li>Tywin</li>
				<li>Cersei</li>
				<li>Jamie</li>
				<li>Tyrion</li>
			</ul>
			";
		}
		
		private function targaryens(): string {
			return "
			<ul>
				<li>Viserys</li>
				<li>Daenerys</li>
			</ul>
			";
		}
		
		public function page_content(): string {
			$index = 0;
			$tabs = implode("\n", array_map(function($tab) use(&$index) {
				$result = "<a href='#".strtolower($tab)."-panel' class='mdl-tabs__tab ".($index === 0 ? 'is-active' : '')."'>".ucfirst($tab)."</a>";
				$index++;
				return $result;
			}, $this->tabs));
			
			$index = 0;
			$tabs_page = implode("\n", array_map(function($tab) use(&$index) {
				$result = "<div class='mdl-tabs__panel ".($index === 0 ? 'is-active' : '')."'
								id='".strtolower($tab)."-panel'>{$this->$tab()}</div>";
				$index++;
				return $result;
			}, $this->tabs));
			return "
<div class=\"mdl-tabs mdl-js-tabs mdl-js-ripple-effect\">
	<div class=\"mdl-tabs__tab-bar\">{$tabs}</div>
	{$tabs_page}
</div>
";
		}
	}