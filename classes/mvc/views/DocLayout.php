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
			$this->assign('scripts', ['switch_to_dark.js']);
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
			$menu .= "<a class='mdl-navigation__link".($this->get('current_page') === "api" ? " is-active" : "")."'
						 href='/documentation/api'>API</a>";
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
		
		public function body(): string {
			return "
	<div class='demo-layout-waterfall mdl-layout mdl-js-layout'>
		<header class='mdl-layout__header mdl-layout__header--waterfall'>
			<!-- Top row, always visible -->
			<div class='mdl-layout__header-row'>
				<!-- Title -->
				<span class='mdl-layout-title logo'>
					<img src='/static/images/logo_mvc_router_white.png'
						 data-base_src='/static/images/logo_mvc_router_white.png' alt='logo' style='height: 40px' />
					{$this->get('title')}
				</span>
				<div class='mdl-layout-spacer'></div>
				<div class='mdl-textfield mdl-js-textfield mdl-textfield--expandable
							mdl-textfield--floating-label mdl-textfield--align-right'>
					<label class='mdl-button mdl-js-button mdl-button--icon'
							for='waterfall-exp'>
						<i class='material-icons'>search</i>
					</label>
					<div class='mdl-textfield__expandable-holder'>
						<input class='mdl-textfield__input' placeholder='Recherche' type='search' name='sample'
								id='waterfall-exp'>
					</div>
				</div>
			</div>
			<!-- Bottom row, not visible on scroll -->
			<div class='mdl-layout__header-row'>
				<div class='mdl-layout-spacer'></div>
				<!-- Navigation -->
				{$this->menu()}
			</div>
		</header>
		<div class='mdl-layout__drawer logo'>
			<img src='/static/images/logo_mvc_router_black.png'
				 data-base_src='/static/images/logo_mvc_router_black.png' alt='logo' class='responsive-img' />
			<span class='mdl-layout-title'>{$this->get('short_title')}</span>
			{$this->menu('mobile')}
		</div>
		<main class='mdl-layout__content'>
			<div class='page-content'>
				{$this->page_content()}
			</div>
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
	</div>
			";
		}
	}