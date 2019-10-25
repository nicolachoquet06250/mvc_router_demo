<?php
	
	
	namespace mvc_router\mvc\views;
	
	
	class Documentation extends DocLayout {
		protected $first_footer_list = [
			'title' => 'Features',
			'list'	=> [
				'About'		 => '#',
				'Terms'		 => '#',
				'Partners'	=> '#',
				'Updates'	 => '#'
			],
		];
		
		protected $second_footer_list = [
			'title' => 'Details',
			'list'	=> [
				'Specs'		 => '#',
				'Tools'		 => '#',
				'Resources' => '#'
			],
		];
		
		protected $third_footer_list = [
			'title' => 'Technology',
			'list'	=> [
				'How it works'	=> '#',
				'Patterns'			=> '#',
				'Usage'				 => '#',
				'Products'			=> '#',
				'Contracts'		 => '#',
			],
		];
		
		protected $fourth_footer_list = [
			'title' => 'FAQ',
			'list'	=> [
				'Questions' => '#',
				'Answers' => '#',
				'Contact us' => '#',
			],
		];
		
		protected $footer_bottom = [
			'title' => 'Title',
			'list'	=> [
				'Help'							=> '#',
				'Privacy & Terms'	 => '#'
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
			$this->assign('stylesheets', array_merge($this->get('stylesheets'), [ 'prism.css' ]));
			$this->assign('scripts', array_merge($this->get('scripts'), [ 'table.js', 'prism.js' ]));
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
			$arrow = $hide ? 'keyboard_arrow_down' : 'keyboard_arrow_up';
			return "
	<thead>
		<tr>
			<th style='text-align: left; cursor: pointer;'
				onclick='toggleCell(document.querySelector(`#{$id_part}-cell`), this)'>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--11-col-desktop mdl-cell--7-col-tablet mdl-cell--3-col-phone'>
						{$title}
					</div>
					<div class='mdl-cell mdl-cell--1-col' style='text-align: right;'>
						<span class='material-icons'>{$arrow}</span>
					</div>
				</div>
			</th>
		</tr>
	</thead>
	<tbody>
		<tr id='{$id_part}-cell' class='hiddable'>
			<td style='text-align: left' class='".($hide ? 'hide' : '')."'>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						{$get_content()}
					</div>
				</div>
			</td>
		</tr>
	</tbody>
			";
		}
		
		protected function get_service_item(string $class, string $name, string $description = '') {
			$first_letter = substr(explode('\\', $class)[count(explode('\\', $class)) - 1], 0, 1);
			if(!$description) $description = 'Aucune description';
			return <<<HTML
<li class='mdl-list__item mdl-list__item--three-line'>
	<div class='mdl-list__item-primary-content'>
		<span class='mdl-list__item-avatar' style='color: black'>{$first_letter}</span>
		<span>{$class}</span>
		<div class='mdl-list__item-text-body'>
			<table class='mdl-data-table mdl-js-data-table' style='width: 100%'>
				<thead>
					<tr>
						<th>Nom</th>
						<th>Méthode Injection de dépendences</th>
						<th>description</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{$name}</td>
						<td>get_{$name}()</td>
						<td>{$description}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</li>
HTML;
		}
		
		protected function get_code_highlighted($language, $code) {
			return "<pre><code class='language-{$language}'>{$code}</code></pre>";
		}
		
		protected function get_started(): string {
			$url_generator = $this->inject->get_url_generator();
			return "
			<div class='mdl-grid'>
				<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
					<table class='mdl-data-table mdl-js-data-table' style='width: 100%'>
						{$this->get_table_group('Prérequis', function() use($url_generator) {
								return "<ul class='mdl-list'>
											<li class='mdl-list__item mdl-list__item--three-line'>
												<span class='mdl-list__item-primary-content'>
													<img class='mdl-list__item-avatar'
														 src='{$url_generator->get_static_url('images', 'logo_git.png', false)}'
														 alt='logo git' />
													<span>Un client GIT</span>
													<div class='mdl-list__item-text-body'>
														<section>
															<h5>Linux Debian</h5>
															{$this->get_code_highlighted('shell', 'sudo apt install git')}
														</section>
														<section>
															<h5>Linux Fedora</h5>
															{$this->get_code_highlighted('shell', 'dfn install git')}
														</section>
														<section>
															<h5>Windows</h5>
															Cliquez sur le lien suivant : <a href='https://git-scm.com/download/win'>https://git-scm.com/download/win</a>.
														</section>
														<section>
															<h5>Mac OSX</h5>
															Cliquez sur le lien suivant :
															<a href='https://code.google.com/archive/p/git-osx-installer/' target='_blank'>https://code.google.com/archive/p/git-osx-installer/</a>.
															<br />
															Cliquez sur le lien 'Download the installers here'.
															<br />
															Choisissez ensuite la version que vous voulez télécharger.
														</section>
													</div>
												</span>
											</li>
											<li class='mdl-list__item mdl-list__item--three-line'>
												<span class='mdl-list__item-primary-content'>
													<img class='mdl-list__item-avatar' alt='logo php'
														 src='{$url_generator->get_static_url('images', 'logo_mysql.png', false)}' />
													<span>MySQL</span>
													<div class='mdl-list__item-text-body'>
														<section>
															<h5>Linux Debian</h5>
															{$this->get_code_highlighted('shell', 'sudo apt install mysql')}
														</section>
														<section>
															<h5>Linux Fedora</h5>
															{$this->get_code_highlighted('shell', 'dfn install mysql')}
														</section>
														<section>
															<h5>Windows</h5>
															Cliquez sur le lien suivant : <a href='https://dev.mysql.com/downloads/mysql/'>https://dev.mysql.com/downloads/mysql/</a>.
															<br />
															Cliquez sur 'Download' de la première ligne.
														</section>
														<section>
															<h5>Mac OSX</h5>
															Cliquez sur le lien suivant : <a href='https://dev.mysql.com/downloads/mysql/'>https://dev.mysql.com/downloads/mysql/</a>.
															<br />
															Cliquez sur 'Download' de la première ligne.
														</section>
													</div>
												</span>
											</li>
											<li class='mdl-list__item mdl-list__item--three-line'>
												<span class='mdl-list__item-primary-content'>
													<img class='mdl-list__item-avatar' alt='logo php'
														 src='{$url_generator->get_static_url('images', 'logo_php.png', false)}' />
													<span>PHP 7.X CLI / CGI</span>
													<div class='mdl-list__item-text-body'>
														<section>
															<h5>Linux Debian</h5>
															{$this->get_code_highlighted('shell', 'sudo apt install php7.X php7.X-dev php7.X-curl php7.X-mysql php7.X-common php7.X-cli php7.X-cgi php7.X-json php7.X-readline composer')}
														</section>
														<section>
															<h5>Linux Fedora</h5>
															{$this->get_code_highlighted('shell', 'dfn install php7.X php7.X-dev php7.X-curl php7.X-mysql php7.X-common php7.X-cli php7.X-cgi php7.X-json php7.X-readline composer')}
														</section>
														<section>
															<h5>Windows</h5>
															Cliquez sur le lien suivant : <a href='https://windows.php.net/download'>https://windows.php.net/download</a>.
															<br />
															Télécharger la dernière version.
														</section>
														<section>
															<h5>Mac OSX</h5>
															{$this->get_code_highlighted('shell', 'curl -s http://php-osx.liip.ch/install.sh | bash -s 7.3
export PATH=/usr/local/php7.3/bin:\$PATH
php -v

PHP 7.3.11 (cli) (built: Feb	1 2018 13:23:34) ( NTS )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.2.0, Copyright (c) 1998-2018 Zend Technologies
		with Zend OPcache v7.2.2, Copyright (c) 1999-2018, by Zend Technologies
		with Xdebug v2.6.0, Copyright (c) 2002-2018, by Derick Rethans')}
														</section>
													</div>
												</span>
											</li>
											<li class='mdl-list__item mdl-list__item--three-line'>
												<span class='mdl-list__item-primary-content'>
													<img class='mdl-list__item-avatar'
														 src='{$url_generator->get_static_url('images', 'logo_phpstorm.png', false)}' />
													<span>Un IDE</span>
													<div class='mdl-list__item-text-body'>
														<section>
															<h5>JetBrains PhpStrom</h5>
															<p><a href='https://www.jetbrains.com/phpstorm/'>https://www.jetbrains.com/phpstorm/</a></p>
														</section>
														<section>
															<h5>Visual Studio Code</h5>
															<p><a href='https://code.visualstudio.com/'>https://code.visualstudio.com/</a></p>
														</section>
														<section>
															<h5>Eclipse PHP</h5>
															<p><a href='https://www.eclipse.org/pdt/'>https://www.eclipse.org/pdt/</a></p>
														</section>
														<section>
															<h5>Sublime Text</h5>
															<p><a href='http://www.sublimetext.com/'>http://www.sublimetext.com/</a></p>
														</section>
													</div>
												</span>
											</li>
										</ul>";
							}, false)}
						{$this->get_table_group('Installation', function() use($url_generator) {
								return "<p>
									Clonez le dépôt GIT <code>https://github.com/usernameachoquet06250/dependency_injection_system.git</code>
									dans un répertoire que vous nommerez comme vous voudrez.
								</p>
								<p>
									Allez sur la plateforme GIT de votre choix ( Github, GitLab, une plateforme interne, ou autre ) puis créez un dépôt pour y mettre le code qui customisera votre projet.
									{$this->get_code_highlighted('shell', 'cd [dir-name]
php exe.php install:install -p repo=[custom-git-repo] dir=[repo-dir-name]')}
								</p>
								<p>
									Si vous voulez faire une mise à jour de votre code, des bases de données ou installer de nouveaux packages composer lancez la commande suivante
									{$this->get_code_highlighted('shell', 'php exe.php install:update')}
								</p>
								<p>
									<a href='{$url_generator->get_url_from_ctrl_and_method($this->inject->get_doc_controller(), 'commands')}'>
										<button class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored'>
											Pour plus de détails sur les commandes
										</button>
									</a>
								</p>";
							})}
						{$this->get_table_group('Lancer une commande', function() {
								$date = date('Y-m-d:H:i:s');
								return "<p>
											Pour lancer une commande, Le framework met à disposition un utilitaire cli.
										</p>
										<p>
											Pour voir les commandes à disposition, leurs syntaxes et leurs paramètres, allez dans un terminal et tapez <code>php exe.php --help</code>
											{$this->get_code_highlighted('shell', "php exe.php --help
											
username@COMPUTER-NAME~{$date} | |=========================| clone |=========================|
username@COMPUTER-NAME~{$date} | |= repo -> php exe.php clone:repo
username@COMPUTER-NAME~{$date} | |= test_stats -> php exe.php clone:test_stats
username@COMPUTER-NAME~{$date} | |=========================| generate |=========================|
username@COMPUTER-NAME~{$date} | |= dependencies -> php exe.php generate:dependencies
username@COMPUTER-NAME~{$date} | |= base_files -> php exe.php generate:base_files
username@COMPUTER-NAME~{$date} | |= translations -> php exe.php generate:translations
username@COMPUTER-NAME~{$date} | |= service -> php exe.php generate:service
username@COMPUTER-NAME~{$date} | |=========================| help |=========================|
username@COMPUTER-NAME~{$date} | |= index -> php exe.php --help, help:index -p cmd=&lt;value&gt; [method=&lt;value&gt;?]
username@COMPUTER-NAME~{$date} | |= home -> php exe.php help:home
username@COMPUTER-NAME~{$date} | |=========================| install |=========================|
username@COMPUTER-NAME~{$date} | |= install -> php exe.php install:install -p [dir=&lt;value>&gt;demo] [repo=&lt;value&gt;?https://github.com/usernameachoquet06250/mvc_router_demo.git]
username@COMPUTER-NAME~{$date} | |= update -> php exe.php install:update
username@COMPUTER-NAME~{$date} | |= databases -> php exe.php install:databases
username@COMPUTER-NAME~{$date} | |=========================| start |=========================|
username@COMPUTER-NAME~{$date} | |= websocket_server -> php exe.php start:websocket_server -p [host=&lt;value&gt;?localhost] [address=&lt;value&gt;?127.0.0.1] [port=&lt;value&gt;?8080]
username@COMPUTER-NAME~{$date} | |= server -> php exe.php start:server -p [port=&lt;value&gt;?8080] [directory=&lt;value&gt;?]
username@COMPUTER-NAME~{$date} | |=========================| test |=========================|
username@COMPUTER-NAME~{$date} | |= helper_is_cli -> php exe.php test:helper_is_cli
username@COMPUTER-NAME~{$date} | |= mysql -> php exe.php test:mysql
username@COMPUTER-NAME~{$date} | |= number_of_lines_in_project -> php exe.php test:number_of_lines_in_project")}
										</p>";
							})}
					</table>
				</div>
			</div>
			";
		}
		
		protected function services(): string {
			$list = [];
			$services = $this->inject->get_services();
			ksort($services);
			foreach( $services as $service_class => $service ) {
				$description = isset($this->inject->get_phpdoc_parser()->get_class_doc($service_class)['description'])
					? str_replace("\n", '<br />', trim($this->inject->get_phpdoc_parser()->get_class_doc($service_class)['description'])) : '';
				$list[] = $this->get_service_item(
					$service_class,
					$service['name'],
					$description
				);
			}
			$list = implode("\n", $list);
			return <<<HTML
<div class='mdl-grid'>
	<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
		<p>MVC ROUTER met à disposition de base de nombreux services.</p>
		<ul class='demo-list-three mdl-list'>{$list}</ul>
	</div>
</div>
HTML;
		}
		
		protected function controllers(): string {
			return "<div class='mdl-grid'>
						<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
							<h3>Controlleurs</h3>
							<ul>
								<li>Viserys</li>
								<li>Daenerys</li>
							</ul>
						</div>
					</div>";
		}
		
		protected function views(): string {
			return "<div class='mdl-grid'>
						<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
							<h3>Vues</h3>
							<ul>
								<li>Viserys</li>
								<li>Daenerys</li>
							</ul>
						</div>
					</div>";
		}
		
		protected function entities(): string {
			return "<div class='mdl-grid'>
						<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
							<h3>Entitées</h3>
							<ul>
								<li>Viserys</li>
								<li>Daenerys</li>
							</ul>
						</div>
					</div>";
		}
		
		protected function managers(): string {
			return "<div class='mdl-grid'>
						<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
							<h3>Managers</h3>
							<ul>
								<li>Viserys</li>
								<li>Daenerys</li>
							</ul>
						</div>
					</div>";
		}
		
		protected function commands(): string {
			return "<div class='mdl-grid'>
						<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
							<h3>Commandes</h3>
							<ul>
								<li>Viserys</li>
								<li>Daenerys</li>
							</ul>
						</div>
					</div>";
		}
		
		protected function configurations(): string {
			return "<div class='mdl-grid'>
						<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
							<h3>Configurations</h3>
							<ul>
								<li>Viserys</li>
								<li>Daenerys</li>
							</ul>
						</div>
					</div>";
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