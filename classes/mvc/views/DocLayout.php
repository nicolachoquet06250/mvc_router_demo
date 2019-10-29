<?php
	
	
	namespace mvc_router\mvc\views;
	
	
	class DocLayout extends Layout {
		protected $first_footer_list = [
			'title' => '',
			'list'  => [],
		];
		
		protected $second_footer_list = [
			'title' => '',
			'list'  => [],
		];
		
		protected $third_footer_list = [
			'title' => '',
			'list'  => [],
		];
		
		protected $fourth_footer_list = [
			'title' => '',
			'list'  => [],
		];
		
		protected $footer_bottom = [
			'title' => '',
			'list'  => [],
		];
		
		protected $tabs = [];
		
		protected $write_sub_menu = false;
		
		public function after_construct() {
			parent::after_construct();
			
			$this->assign( 'is_responsive', true );
			$this->assign( 'framework', Layout::MATERIAL_DESIGN_LIGHT );
			$this->assign( 'font_icons', Layout::MATERIAL_ICONS );
			$this->assign( 'title', 'Démo MVC ROUTER' );
			$this->assign( 'short_title', 'MVC ROUTER' );
			$this->assign( 'use_jquery', false );
			$this->assign( 'js_at_the_top', true );
			$this->assign( 'js_at_the_bottom', false );
			$this->assign('stylesheets', ['theme.css']);
			$this->assign('icon', '/static/images/favicon_black.ico');
			$this->assign('scripts', ['loader.js', 'switch_to_dark.js']);
		}
		
		public function page_content() {
			return '';
		}
		
		public function menu($navigation = 'desktop') {
			$menu = "<nav class='mdl-navigation {$navigation}-navigation'>";
			if($navigation === 'mobile') {
				$menu .= "
	<div class='mdl-grid-left'>
		<div class='mdl-cell mdl-cell--12-col'>
			<label class='mdl-switch mdl-js-switch mdl-js-ripple-effect' for='dark-theme'>
				<input type='checkbox' id='dark-theme' class='mdl-switch__input' onchange='switch2dark()'>
				<span class='mdl-switch__label'>Dark Thème</span>
			</label>
		</div>
	</div>
";
			}
			$menu .= "<a class='mdl-navigation__link".($this->get('current_page') === "home" ? " is-active" : "")."'
						 href='/home'>Home</a>";
			$menu .= "<a class='mdl-navigation__link".($this->get('current_page') === "documentation" ? " is-active" : "")."'
						 href='/documentation'>Documentation</a>";
			$menu .= "</nav>";
			return $menu;
		}
		
		protected function get_footer_list($list, $bottom = false) {
			$_list = "<div class='mdl-mega-footer__".($bottom ? "bottom-section" : "drop-down-section")."'>";
			if(!empty($list['title'])) {
				if($bottom) {
					$_list .= "<div class='mdl-logo'>{$list['title']}</div>";
				}
				else {
					$_list .= "<input class='mdl-mega-footer__heading-checkbox' type='checkbox' checked />";
					$_list .= "<h1 class='mdl-mega-footer__heading'>{$list['title']}</h1>";
				}
			}
			if(!empty($list['list'])) {
				$_list .= "<ul class='mdl-mega-footer__link-list'>";
				foreach( $list[ 'list' ] as $item => $link ) {
					$_list .= "<li><a href='{$link}'>{$item}</a></li>";
				}
				$_list .= "</ul>";
			}
			$_list .= "</div>";
			return $_list;
		}
		
		protected function get_documentation_menu() {
			if($this->write_sub_menu) {
				return "<div class='mdl-layout__tab-bar mdl-js-ripple-effect'>"
					.implode("\n", array_map(function($tab) {
						$method = str_replace([' ', '-'], '_', strtolower($tab));
						$method_in_link = str_replace('_', '-', $method);
						return "<a href='/documentation/{$method_in_link}' class='mdl-layout__tab ".($this->get('sub_page') === $method ? 'is-active' : '')."'>".ucfirst($tab)."</a>";
					}, $this->tabs))
					."</div>";
			}
			return '';
		}
		
		protected function get_documentation_menu_tab_content() {
			$content = '';
			if($this->write_sub_menu) {
				$content .= implode("\n", array_map(function($tab) {
					$method = str_replace([' ', '-'], '_', strtolower($tab));
					return "<section class='mdl-layout__tab-panel ".($this->get('sub_page') === $method ? 'is-active' : '')."'
								 id='scroll-{$method}'>
		<div class='page-content'>{$this->$method()}</div>
	</section>";
				}, $this->tabs));
			}
			return $content."
	<div class='page-content'>
		{$this->page_content()}
	</div>
			";
		}
		
		public function body(): string {
			return "<div class='mdl-layout mdl-js-layout mdl-layout--fixed-header'>
  <header class='mdl-layout__header'>
    <div class='mdl-layout__header-row'>
      <!-- Title -->
      <span class='mdl-layout-title'>
		{$this->get('title')}
	  </span>
    </div>
    <div class='mdl-layout__header-row'>
		<div class='mdl-layout-spacer'></div>
		<!-- Navigation -->
		{$this->menu()}
	</div>
    <!-- Tabs -->
    {$this->get_documentation_menu()}
  </header>
  <div class='mdl-layout__drawer'>
    <span class='mdl-layout-title logo' style='text-align: center;'>
		<img src='/static/images/logo_mvc_router_black.png'
			 data-base_src='/static/images/logo_mvc_router_black.png'
			 alt='logo' class='responsive-img' />
		<span class='mdl-layout-title'>{$this->get('short_title')}</span>
	</span>
	{$this->menu('mobile')}
  </div>
  <main class='mdl-layout__content'>
    <span id='top'></span>
    {$this->get_documentation_menu_tab_content()}
    <footer class='page-footer mdl-mega-footer'>
		<div class='mdl-mega-footer__middle-section'>
			{$this->get_footer_list($this->first_footer_list)}
			{$this->get_footer_list($this->second_footer_list)}
			{$this->get_footer_list($this->third_footer_list)}
			{$this->get_footer_list($this->fourth_footer_list)}
		</div>
		{$this->get_footer_list($this->footer_bottom, true)}
	</footer>
  </main>
</div>";
		}
		
		public function loader(): string {
			return "
	<div class='loader-container'>
		<div></div>
		<div class='container'>
			<div class='mdl-spinner mdl-spinner--single-color mdl-js-spinner is-active' id='loader'></div>
		</div>
		<div></div>
	</div>
			";
		}
	}