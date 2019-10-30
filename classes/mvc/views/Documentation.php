<?php
	
	
	namespace mvc_router\mvc\views;
	
	
	use mvc_router\parser\PHPDocParser;
	use ReflectionException;
	
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
			$this->assign('scripts', array_merge($this->get('scripts'), [ 'table.js', 'prism.js', 'documentation_functions.js' ]));
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
		<div class='mdl-list__item-text-body mdl-grid'>
			<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--hide-phone mdl-cell--hide-tablet mdl-cell--desktop-table'>
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
			<div class='mdl-cell mdl-cell--8-col-tablet mdl-cell--hide-phone mdl-cell--hide-desktop mdl-cell--tablet-table'>
				<table class='mdl-data-table mdl-js-data-table'>
					<thead>
						<tr>
							<th>Nom</th>
							<th>Méthode Injection de dépendences</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{$name}</td>
							<td>get_{$name}()</td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th colspan="2">Description</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="2" style='word-wrap: break-word; overflow-wrap: break-word;'>{$description}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class='mdl-cell mdl-cell--4-col-phone mdl-cell--hide-desktop mdl-cell--hide-tablet mdl-cell--phone-table'>
				<table class='mdl-data-table mdl-js-data-table'>
					<thead>
						<tr>
							<th>Nom</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{$name}</td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th>Méthode Injection de dépendences</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>get_{$name}()</td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style='word-wrap: break-word; overflow-wrap: break-word;'>{$description}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</li>
HTML;
		}
		
		protected function get_command_item(string $class, string $name, array $commands) {
			$first_letter = substr(explode('\\', $class)[count(explode('\\', $class)) - 1], 0, 1);
			$_commands = [];
			foreach( $commands as $command => $syntaxes ) {
				$_commands[] = '<thead><tr><th colspan="2">'.$command.'</th></tr></thead>';
				$_commands[] = '<tbody>'.implode("\n", array_map(function($syntax) {
					return "<tr><td colspan='2'>{$syntax}</td></tr>";
				}, $syntaxes)).'</tbody>';
			}
			$_commands = implode("\n", $_commands);
			
			return <<<HTML
<li class='mdl-list__item mdl-list__item--three-line'>
	<div class='mdl-list__item-primary-content'>
		<span class='mdl-list__item-avatar' style='color: black'>{$first_letter}</span>
		<span>{$class}</span>
		<div class='mdl-list__item-text-body mdl-grid'>
			<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--hide-phone mdl-cell--hide-tablet mdl-cell--desktop-table'>
				<table class='mdl-data-table mdl-js-data-table' style='width: 100%'>
					<thead>
						<tr>
							<th>Nom</th>
							<th>Méthode Injection de dépendences</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{$name}</td>
							<td>get_{$name}()</td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th colspan='2'>Commandes</th>
						</tr>
					</thead>
					{$_commands}
				</table>
			</div>
			<div class='mdl-cell mdl-cell--8-col-tablet mdl-cell--hide-phone mdl-cell--hide-desktop mdl-cell--tablet-table'>
				<table class='mdl-data-table mdl-js-data-table'>
					<thead>
						<tr>
							<th>Nom</th>
							<th>Méthode Injection de dépendences</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{$name}</td>
							<td>get_{$name}()</td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th colspan='2'>Commandes</th>
						</tr>
					</thead>
					{$_commands}
				</table>
			</div>
			<div class='mdl-cell mdl-cell--4-col-phone mdl-cell--hide-desktop mdl-cell--hide-tablet mdl-cell--phone-table'>
				<table class='mdl-data-table mdl-js-data-table'>
					<thead>
						<tr>
							<th>Nom</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{$name}</td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th>Méthode Injection de dépendences</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>get_{$name}()</td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th colspan='2'>Commandes</th>
						</tr>
					</thead>
					{$_commands}
				</table>
			</div>
		</div>
	</div>
</li>
HTML;

		}
		
		protected function get_code_highlighted($language, $code, $lines = false) {
			$lines = $lines ? 'line-numbers' : '';
			return "<pre><code class='language-{$language} {$lines}'>{$code}</code></pre>";
		}
		
		protected function get_header_card($title, $description = '', $links = []) {
			$map_links = function() use ($links) {
				return implode("\n", array_map(function($link) {
					$link_href = str_replace(['é', 'è', 'ê', 'ë'], 'e', $link);
					$link_href = str_replace(['à', 'â', 'ä'], 'a', $link_href);
					$link_href = str_replace([' ', "'"], '_', $link_href);
					$link_href = strtolower($link_href);
					return "<a href='#{$link_href}'
							   class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect'>{$link}</a>";
				}, $links));
			};
			$description = $description ? "<div class='mdl-card__supporting-text'>
		<p>{$description}</p>
	</div>" : "";
			
			return <<<HTML
<div class='mdl-card mdl-shadow--2dp'>
	<div class='mdl-card__title'>
		<h2 class='mdl-card__title-text'>{$title}</h2>
	</div>
	{$description}
	<div class='mdl-card__actions mdl-card--border'>{$map_links()}</div>
</div>
HTML;

		}
		
		protected function top_button($id_button = '', $next_id = '') {
			$id_button = $id_button ? " id='{$id_button}'" : '';
			return "
	<a href='#top' style='color: unset; text-decoration: none;'{$id_button}>
		<button class='mdl-button mdl-js-button mdl-button--icon'>
			<i class='material-icons'>keyboard_arrow_up</i>
		</button>
	</a>
".($next_id !== '' ? "\t<a href='#{$next_id}' style='color: unset; text-decoration: none;'>
		<button class='mdl-button mdl-js-button mdl-button--icon'>
			<i class='material-icons'>keyboard_arrow_down</i>
		</button>
	</a>" : '');
		}
		
		protected function get_started(): string {
			$url_generator = $this->inject->get_url_generator();
			$date = date('Y-m-d:H:i:s');
			$username = $this->get_username();
			$hostname = $this->get_hostname();
			return <<<HTML
<div class='mdl-grid'>
	<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-cell--desktop-table'>
		<div class='mdl-grid'>
			<div class='mdl-cell mdl-cell--3-col-desktop mdl-cell--hide-tablet mdl-cell--hide-phone'></div>
			<div class='mdl-cell mdl-cell--6-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				{$this->get_header_card(
				'Commencer',
				'',
				[
					'Prérequis',
					'Installation',
					'Lancer une commande',
				])}
			</div>
		</div>
		<div class='mdl-grid'>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Prérequis {$this->top_button('prerequis', 'installation')}</h3>
				<ul class='mdl-list'>
					<li class='mdl-list__item mdl-list__item--three-line'>
						<div class='mdl-list__item-primary-content'>
							<img class='mdl-list__item-avatar'
							     src='{$url_generator->get_static_url('images', 'logo_git.png', false)}'
							     alt='logo git'/>
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
									Cliquez sur le lien suivant :
									<a href='https://git-scm.com/download/win'>https://git-scm.com/download/win</a>.
								</section>
								<section>
									<h5>Mac OSX</h5>
									Cliquez sur le lien suivant :
									<a href='https://code.google.com/archive/p/git-osx-installer/'
									   target='_blank'>https://code.google.com/archive/p/git-osx-installer/</a>.
									<br/>
									Cliquez sur le lien 'Download the installers here'.
									<br/>
									Choisissez ensuite la version que vous voulez télécharger.
								</section>
							</div>
						</div>
					</li>
					<li class='mdl-list__item mdl-list__item--three-line'>
						<div class='mdl-list__item-primary-content'>
							<img class='mdl-list__item-avatar' alt='logo php'
							     src='{$url_generator->get_static_url( 'images', 'logo_mysql.png', false )}'/>
							<span>MySQL</span>
							<div class='mdl-list__item-text-body'>
								<section>
									<h5>Linux Debian</h5>
									{$this->get_code_highlighted( 'shell', 'sudo apt install mysql' )}
								</section>
								<section>
									<h5>Linux Fedora</h5>
									{$this->get_code_highlighted( 'shell', 'dfn install mysql' )}
								</section>
								<section>
									<h5>Windows</h5>
									Cliquez sur le lien suivant : <a
										href='https://dev.mysql.com/downloads/mysql/'>https://dev.mysql.com/downloads/mysql/</a>.
									<br/>
									Cliquez sur 'Download' de la première ligne.
								</section>
								<section>
									<h5>Mac OSX</h5>
									Cliquez sur le lien suivant : <a
										href='https://dev.mysql.com/downloads/mysql/'>https://dev.mysql.com/downloads/mysql/</a>.
									<br/>
									Cliquez sur 'Download' de la première ligne.
								</section>
							</div>
						</div>
					</li>
					<li class='mdl-list__item mdl-list__item--three-line'>
						<div class='mdl-list__item-primary-content'>
							<img class='mdl-list__item-avatar' alt='logo php'
							     src='{$url_generator->get_static_url( 'images', 'logo_php.png', false )}'/>
							<span>PHP 7.X CLI / CGI</span>
							<div class='mdl-list__item-text-body'>
								<section>
									<h5>Linux Debian</h5>
									{$this->get_code_highlighted( 'shell', 'sudo apt install php7.X php7.X-dev php7.X-curl php7.X-mysql php7.X-common php7.X-cli php7.X-cgi php7.X-json php7.X-readline composer' )}
								</section>
								<section>
									<h5>Linux Fedora</h5>
									{$this->get_code_highlighted( 'shell', 'dfn install php7.X php7.X-dev php7.X-curl php7.X-mysql php7.X-common php7.X-cli php7.X-cgi php7.X-json php7.X-readline composer' )}
								</section>
								<section>
									<h5>Windows</h5>
									Cliquez sur le lien suivant : <a
										href='https://windows.php.net/download'>https://windows.php.net/download</a>.
									<br/>
									Télécharger la dernière version.
								</section>
								<section>
									<h5>Mac OSX</h5>
									{$this->get_code_highlighted( 'shell', 'curl -s http://php-osx.liip.ch/install.sh | bash -s 7.3
		export PATH=/usr/local/php7.3/bin:\$PATH
		php -v
		
		PHP 7.3.11 (cli) (built: Feb	1 2018 13:23:34) ( NTS )
		Copyright (c) 1997-2018 The PHP Group
		Zend Engine v3.2.0, Copyright (c) 1998-2018 Zend Technologies
				with Zend OPcache v7.2.2, Copyright (c) 1999-2018, by Zend Technologies
				with Xdebug v2.6.0, Copyright (c) 2002-2018, by Derick Rethans' )}
								</section>
							</div>
						</div>
					</li>
					<li class='mdl-list__item mdl-list__item--three-line'>
						<div class='mdl-list__item-primary-content'>
							<img class='mdl-list__item-avatar'
							     src='{$url_generator->get_static_url( 'images', 'logo_phpstorm.png', false )}'/>
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
						</div>
					</li>
				</ul>
			</section>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Installation {$this->top_button('installation', 'lancer_une_commande')}</h3>
				<p>
					Clonez le dépôt GIT <code>https://github.com/usernameachoquet06250/dependency_injection_system.git</code>
					dans un répertoire que vous nommerez comme vous voudrez.
				</p>
				<p>
					Allez sur la plateforme GIT de votre choix ( Github, GitLab, une plateforme interne, ou autre ) puis créez un dépôt pour y mettre le code qui customisera votre projet.
					{$this->get_code_highlighted('shell', 'cd [dir-name]
php exe.php install:install -p repo=[custom-git-repo] dir=[repo-dir-name]
php exe.php install:update')}
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
				</p>
			</section>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Lancer une commande {$this->top_button('lancer_une_commande')}</h3>
				<p>
					Pour lanc	</table>mmande, Le framework met à disposition un utilitaire cli.
				</p>
				<p>
					Pour voir les commandes à disposition, leurs syntaxes et leurs paramètres, allez dans un terminal et tapez <code>php exe.php --help</code>
					{$this->get_code_highlighted('shell', "php exe.php --help
					
username@hostname~{$date} | |=========================| clone |=========================|
username@hostname~{$date} | |= repo -> php exe.php clone:repo
username@hostname~{$date} | |= test_stats -> php exe.php clone:test_stats
username@hostname~{$date} | |=========================| generate |=========================|
username@hostname~{$date} | |= dependencies -> php exe.php generate:dependencies
username@hostname~{$date} | |= base_files -> php exe.php generate:base_files
username@hostname~{$date} | |= translations -> php exe.php generate:translations
username@hostname~{$date} | |= service -> php exe.php generate:service
username@hostname~{$date} | |=========================| help |=========================|
username@hostname~{$date} | |= index -> php exe.php --help, help:index -p cmd=&lt;value&gt; [method=&lt;value&gt;?]
username@hostname~{$date} | |= home -> php exe.php help:home
username@hostname~{$date} | |=========================| install |=========================|
username@hostname~{$date} | |= install -> php exe.php install:install -p [dir=&lt;value>&gt;demo] [repo=&lt;value&gt;?https://github.com/usernameachoquet06250/mvc_router_demo.git]
username@hostname~{$date} | |= update -> php exe.php install:update
username@hostname~{$date} | |= databases -> php exe.php install:databases
username@hostname~{$date} | |=========================| start |=========================|
username@hostname~{$date} | |= websocket_server -> php exe.php start:websocket_server -p [host=&lt;value&gt;?localhost] [address=&lt;value&gt;?127.0.0.1] [port=&lt;value&gt;?8080]
username@hostname~{$date} | |= server -> php exe.php start:server -p [port=&lt;value&gt;?8080] [directory=&lt;value&gt;?]
username@hostname~{$date} | |=========================| test |=========================|
username@hostname~{$date} | |= helper_is_cli -> php exe.php test:helper_is_cli
username@hostname~{$date} | |= mysql -> php exe.php test:mysql
username@hostname~{$date} | |= number_of_lines_in_project -> php exe.php test:number_of_lines_in_project")}
				</p>
			</section>
		</div>
	</div>
</div>
HTML;
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
		<div class='mdl-grid'>
			<div class='mdl-cell mdl-cell--3-col-desktop mdl-cell--hide-tablet mdl-cell--hide-phone'></div>
			<div class='mdl-cell mdl-cell--6-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				{$this->get_header_card(
					'Les Services',
					'MVC ROUTER met à disposition de base de nombreux services.<br />
						Voici tous les services livés dans le core du framework.',
					[
						'Liste des services',
						'Comment les utiliser',
						'Comment en créer',
						'Comment les customiser',
					])}
			</div>
		</div>
		<div class='mdl-grid'>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Liste des services {$this->top_button('liste_des_services', 'comment_les_utiliser')}</h3>
				<ul class='mdl-list'>{$list}</ul>
			</section>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Comment utiliser un service {$this->top_button('comment_les_utiliser', 'comment_en_creer')}</h3>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--6-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						Pour utiliser un service, MVC ROUTER prend en charge deux manières de faire :
						<ul>
							<li style='list-style: none'>
								Par injection de dépendence:
								<ul>
									<li style='list-style: none'>
										Par paramètres
									</li>
									<li style='list-style: none'>
										Par propriétés
									</li>
								</ul>
							</li>
							<li style='list-style: none'>
								En utilisant la propriété <code>inject</code> de type DependencyWrapper et qui utilise donc le getter généré en fonction du nom donné dans le fichier <code>dependencies.yaml</code>
							</li>
						</ul>
					</div>
					<div class='mdl-cell mdl-cell--6-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						{$this->get_code_highlighted('php', '&lt;?php
	namespace mvc_router\mvc\controllers;
	
	use mvc_router\mvc\Controller;
	
	class MonController extends Controller {
		/**
		 * @var \mvc_router\services\Json $json_parser
		 */
		public $json_parser;
	
		public function ma_method(\mvc_router\services\Translate $translation) {
			$logger = $this->inject->get_logger_service();
			return $this->json_parser->encode([
				\'translation\' => $translation->__(\'ma phrase traduite\'),
			]);
		}
	}

', true)}
					</div>
				</div>
			</section>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Comment créer un service {$this->top_button('comment_en_creer', 'comment_les_customiser')}</h3>
				<p>Deux façons s'offrent à vous :</p>
				<ul>
					<li>Soit à la main :</li>
				</ul>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--6-col-desktop mdl-cell--4-col-tablet mdl-cell--4-col-phone'>
						Ouvrez un terminal puis tapez
						{$this->get_code_highlighted('shell', 'cd [project-custom-dir]
mkdir classes
cd classes
mkdir services
touch MonService.php





')}
					</div>
					<div class='mdl-cell mdl-cell--6-col-desktop mdl-cell--4-col-tablet mdl-cell--4-col-phone'>
						Ouvrez le fichier <code>[project-custom-dir]/classes/services/MonService.php</code> dans votre IDE préféré
						{$this->get_code_highlighted('php', '&lt;?php
	namespace my\service\namespace;
	
	use \mvc_router\services;
	
	class MonService extends Service {
		public function hello_world(): string {
			return "Hello World";
		}
	}
', true)}
					</div>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						Créez un fichier <code>[project-custom-dir]/dependencies.yaml</code>
						{$this->get_code_highlighted('yaml', 'add:
    services:
		\my\service\namespace\MonService:
			name: mon_service
			file: __DIR__/classes/services/MonService.php
', true)}
					</div>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						Reprenez votre terminal et tapez <code>php exe.php install:update</code>
						{$this->get_code_highlighted('shell', (function() {
							$date = date('Y-m-d:H:i:s');
							$username = $this->get_username();
							$hostname = $this->get_hostname();
							return "php exe.php install:update

username@hostname~{$date} | command: git pull
username@hostname~{$date} | Already up to date.
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: git -C C:\\Users\\nicol\\PhpstormProjects\\mvc_router\\demo pull
username@hostname~{$date} | Already up to date.
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: composer update
Loading composer repositories with package information
Updating dependencies (including require-dev)
Nothing to install or update
Generating autoload files
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: generate:dependencies -p custom-file=C:\\Users\\nicol\\PhpstormProjects\\mvc_router\\demo/update_dependencies.php
username@hostname~{$date} | DependencyWrapper.php and ConfWrapper.php has been generated !
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: generate:base_files -p custom-dir=C:\\Users\\nicol\\PhpstormProjects\\mvc_router\\demo
username@hostname~{$date} | All default files has been generated ! Don't forget to fill the classes/confs/mysql.json file
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: generate:translations
username@hostname~{$date} | Les langues fr-FR, en-GB, en-US ont bien été générés
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: install:databases
username@hostname~{$date} | user => true
username@hostname~{$date} | role => true
username@hostname~{$date} | ---------------------------------------------------------------------------

";
						})())}
					</div>
				</div>
				<ul>
					<li>Soit avec l'utilitaire CLI :</li>
				</ul>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						Ouvrez un terminal et tapez <code>php exe.php generate:service -p name=[service-name] site=[custom-dir-name] is_singleton=[true|false]</code>
						{$this->get_code_highlighted('shell', (function() {
							$date = date('Y-m-d:H:i:s');
							$username = $this->get_username();
							$hostname = $this->get_hostname();
							return "php exe.php generate:service -p name=hello_world site=demo is_singleton=true

username@hostname~{$date} | command: git pull
username@hostname~{$date} | Already up to date.
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: git -C C:\Users\\nicol\PhpstormProjects\mvc_router\demo pull
username@hostname~{$date} | Already up to date.
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: composer update
Loading composer repositories with package information
Updating dependencies (including require-dev)
Nothing to install or update
Generating autoload files
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: generate:dependencies -p custom-file=C:\Users\\nicol\PhpstormProjects\mvc_router\demo/update_dependencies.php
username@hostname~{$date} | DependencyWrapper.php and ConfWrapper.php has been generated !
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: generate:base_files -p custom-dir=C:\Users\\nicol\PhpstormProjects\mvc_router\demo
username@hostname~{$date} | All default files has been generated ! Don't forget to fill the classes/confs/mysql.json file
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: generate:translations
username@hostname~{$date} | Les langues fr-FR, en-GB, en-US ont bien été générés
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: install:databases
username@hostname~{$date} | user => true
username@hostname~{$date} | role => true
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | Le service hello_world à été généré et intégré dans dependencies.yaml avec succès !";
						})())}
					</div>
				</div>
			</section>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Comment customiser un service {$this->top_button('comment_les_customiser')}</h3>
				<p>Idem, deux façons s'offrent à vous :</p>
				<ul>
					<li>Soit à la main :</li>
				</ul>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--6-col-desktop mdl-cell--4-col-tablet mdl-cell--4-col-phone'>
						Ouvrez un terminal puis tapez
						{$this->get_code_highlighted('shell', 'cd [project-custom-dir]
mkdir classes
cd classes
mkdir services
touch MonService.php





')}
					</div>
					<div class='mdl-cell mdl-cell--6-col-desktop mdl-cell--4-col-tablet mdl-cell--4-col-phone'>
						Ouvrez le fichier <code>[project-custom-dir]/classes/services/MonService.php</code> dans votre IDE préféré
						{$this->get_code_highlighted('php', '&lt;?php
	namespace my\service\namespace;
	
	use \mvc_router\services;
	
	class MonService extends \mvc_router\services\MonService {
		public function hello_world(): string {
			return "Hello World";
		}
	}
', true)}
					</div>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						Créez ou ouvrez le fichier <code>[project-custom-dir]/dependencies.yaml</code>
						{$this->get_code_highlighted('yaml', 'extends:
    services:
		\my\service\namespace\MonService:
			class:
				old: \mvc_router\services\MonService
				new: \my\service\namespace\MonService
			name: mon_service
			file: __DIR__/classes/services/MonService.php
', true)}
					</div>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						Reprenez votre terminal et tapez <code>php exe.php install:update</code>
						{$this->get_code_highlighted('shell', (function() {
				$date = date('Y-m-d:H:i:s');
				$username = $this->get_username();
				$hostname = $this->get_hostname();
				return "php exe.php install:update

username@hostname~{$date} | command: git pull
username@hostname~{$date} | Already up to date.
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: git -C C:\\Users\\nicol\\PhpstormProjects\\mvc_router\\demo pull
username@hostname~{$date} | Already up to date.
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: composer update
Loading composer repositories with package information
Updating dependencies (including require-dev)
Nothing to install or update
Generating autoload files
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: generate:dependencies -p custom-file=C:\\Users\\nicol\\PhpstormProjects\\mvc_router\\demo/update_dependencies.php
username@hostname~{$date} | DependencyWrapper.php and ConfWrapper.php has been generated !
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: generate:base_files -p custom-dir=C:\\Users\\nicol\\PhpstormProjects\\mvc_router\\demo
username@hostname~{$date} | All default files has been generated ! Don't forget to fill the classes/confs/mysql.json file
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: generate:translations
username@hostname~{$date} | Les langues fr-FR, en-GB, en-US ont bien été générés
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: install:databases
username@hostname~{$date} | user => true
username@hostname~{$date} | role => true
username@hostname~{$date} | ---------------------------------------------------------------------------

";
			})())}
					</div>
				</div>
				<ul>
					<li>Soit avec l'utilitaire CLI :</li>
				</ul>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						Ouvrez un terminal et tapez <code>php exe.php generate:customized_service -p name=[service-name] site=[custom-dir-name] is_singleton=[true|false]</code>
						{$this->get_code_highlighted('shell', (function() {
				$date = date('Y-m-d:H:i:s');
				$username = $this->get_username();
				$hostname = $this->get_hostname();
				return "php exe.php generate:customized_service -p name=mon_service site=demo is_singleton=true

username@hostname~{$date} | command: git pull
username@hostname~{$date} | Already up to date.
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: git -C C:\Users\\nicol\PhpstormProjects\mvc_router\demo pull
username@hostname~{$date} | Already up to date.
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: composer update
Loading composer repositories with package information
Updating dependencies (including require-dev)
Nothing to install or update
Generating autoload files
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: generate:dependencies -p custom-file=C:\Users\\nicol\PhpstormProjects\mvc_router\demo/update_dependencies.php
username@hostname~{$date} | DependencyWrapper.php and ConfWrapper.php has been generated !
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: generate:base_files -p custom-dir=C:\Users\\nicol\PhpstormProjects\mvc_router\demo
username@hostname~{$date} | All default files has been generated ! Don't forget to fill the classes/confs/mysql.json file
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: generate:translations
username@hostname~{$date} | Les langues fr-FR, en-GB, en-US ont bien été générés
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | command: install:databases
username@hostname~{$date} | user => true
username@hostname~{$date} | role => true
username@hostname~{$date} | ---------------------------------------------------------------------------
username@hostname~{$date} | Le service mon_service à été généré en extension du service de base et intégré dans dependencies.yaml avec succès !";
			})())}
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
HTML;
		}
		
		protected function controllers(): string {
			return "<div class='mdl-grid'>
						<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
							<div class='mdl-grid'>
								<div class='mdl-cell mdl-cell--3-col-desktop mdl-cell--hide-tablet mdl-cell--hide-phone'></div>
								<div class='mdl-cell mdl-cell--6-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
									{$this->get_header_card(
										'Les Controlleurs',
										'<p>
												Les controlleurs de MVC ROUTER sont assez simple d\'utilisation.<br />
												Ils intègrent l\'injection de dépendence, et un système de routage grâce à l\'annotation <code>@route</code> dans la PHPDoc.<br />
											</p>
											<p>
												Les routes sont générées automatiquement en fonction des méthodes <code>public</code> des controlleurs.<br />
												La syntaxe d\'une route généré est la suivante : <code>/controlleur_name/methode</code>.<br />
												Si vous voulez qu\'une méthode <code>public</code> ne soit pas une route, pausez une annotation <code>@route_disabled</code> dessus.
											</p>
											<p>Pour changer le point d\'entré du site ou du WebService, un fichier <code>htaccess.php</code> est généré dans votre répertoire custom.</p>',
										[
											'Créer un controlleur',
											'Binder un controlleur à l\'injection de dépendences',
											'Changer le point d\'entré'
										]
									)}
								</div>
							</div>
							<div class='mdl-grid'>
								<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
									<h3>Créer un controlleur {$this->top_button('creer_un_controlleur', 'binder_un_controlleur_a_l_injection_de_dependences')}</h3>
									<div class='mdl-grid'>
										<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
											Par exemple
											{$this->get_code_highlighted('php', '&lt;?php
	namespace mvc_router\mvc;
	
	use Exception;
	use mvc_router\router\Router;
	use mvc_router\services\FileSystem;
	use mvc_router\services\Route;
	use mvc_router\services\UrlGenerator;
	
	class Routes extends Controller {
	
		/** @var \mvc_router\services\Translate $translation */
		public $translation;
	
		/**
		 * @route \/routes\/?(?&lt;stats&gt;stats)?
		 *
		 * @param views\Route $route_view
		 * @param Router      $router
		 * @param Route       $service_route
		 * @return views\Route
		 */
		public function index(views\Route $route_view, Router $router, Route $service_route) {
			$route_view->assign(\'service_route\', $service_route);
			$route_view->assign(\'router\', $router);
			$route_view->assign(\'stats\', $this->param(\'stats\') !== null);
	
			if($lang = $router->get(\'lang\')) $this->translation->set_default_language($lang);
	
			$route_view->assign(\'lang\', $this->translation->get_default_language());
	
			return $route_view;
		}
	
		/**
		 * @route /routes/url_generator
		 *
		 * @param UrlGenerator $urlGenerator
		 * @param FileSystem   $fileSystem
		 * @return false|string
		 * @throws Exception
		 */
		public function url_generator(UrlGenerator $urlGenerator, FileSystem $fileSystem) {
			$before_links = \'\';
			$link_with_stats = \'&lt;a href="\'.$urlGenerator->get_url_from_ctrl_and_method($this, \'index\', \'stats\').\'"&gt;
		Aller aux routes avec stats
	&lt;/a&gt;\';
			$link_without_stats = \'&lt;a href="\'.$urlGenerator->get_url_from_ctrl_and_method($this, \'index\').\'"&gt;
		Aller aux routes sans stats
	&lt;/a&gt;\';
			$link_refresh = \'&lt;a href="\'.$urlGenerator->get_url_from_ctrl_and_method($this, \'url_generator\').\'"&gt;
		Rafraichir
	&lt;/a&gt;\';
			return $before_links.\'&lt;br&gt;\'.$link_with_stats.\'&lt;br&gt;\'.$link_without_stats.\'&lt;br&gt;\'.$link_refresh;
		}
		
		/**
		 * @route_disabled
		 *
		 * @return string
		 */
		public function is_not_route() {
			return \'hello_world\';
		}
		
		/**
		 * @return string
		 */
		private function is_not_route2() {
			return \'hello_world\';
		}
	}
					
					', true)}
										</div>
									</div>
								</section>
								<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
									<h3>Binder un controlleur à l'injection de dépendences {$this->top_button('binder_un_controlleur_a_l_injection_de_dependences', 'changer_le_point_d_entre')}</h3>
									<div class='mdl-grid'>
										<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
											<p>Pour binder un controlleur à l'injection de dépdendences, rien de plus simple : </p>
											<p>Ouvrez le fichier <code>dependencies.yaml</code> à la racine de votre répertoire custom.</p>
											<p>Ajouter les lignes suivantes</p>
											{$this->get_code_highlighted('yaml', 'add:
  controllers:
    \mvc_router\mvc\Controllers\Documentation:
      name: \'documentation_controller\'
      file: \'__DIR__/classes/mvc/controllers/Documentation.php\'
					
					', true)}
											Une fois ces lignes ajoutées, ouvez un terminal et tapez la commande suivante
											{$this->get_code_highlighted('shell', 'php exe.php install:update')}
										</div>
									</div>
								</section>
								<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
									<h3>Changer le point d'entré {$this->top_button('changer_le_point_d_entre')}</h3>
									<div class='mdl-grid'>
										<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
											Le point d'entré par default correspond à la méthode <code>index</code> du controlleur qui est nomé <code>route_controller</code>.<br />
											Pour changer le point d'entré changez le paramètre de la méthode <code>root_route</code>.<br />
											Si la méthode du point d'entré à déjà une route associé, la route <code>/</code> y sera ajouté et cette méthode aura donc deux routes associés.
											{$this->get_code_highlighted('php', '&lt;?php
		
	try {
		mvc_router\dependencies\Dependency::get_wrapper_factory()->get_dependency_wrapper()->get_router()
			->root_route(\'route_controller\')->inspect_controllers();
	} catch(Exception $e) {
		exit($e->getMessage());
	}
					
					', true)}
										</div>
									</div>
								</section>
							</div>
						</div>
					</div>";
		}
		
		protected function views(): string {
			return <<<HTML
<div class='mdl-grid'>
	<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
		<div class='mdl-grid'>
			<div class='mdl-cell mdl-cell--3-col-desktop mdl-cell--hide-tablet mdl-cell--hide-phone'></div>
			<div class='mdl-cell mdl-cell--6-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				{$this->get_header_card(
					'Les Vues',
					'Les vues de MVC ROUTER sont de pures classes PHP qui étendent simplement la classe<code>View</code>.',
					[
						'Créer une vue',
						'Utiliser une vue',
						'Binder une vue à l\'injection de dépendences'
					]
				)}
			</div>
		</div>
		<div class='mdl-grid'>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Créer une vue {$this->top_button('creer_une_vue', 'utiliser_une_vue')}</h3>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						Voici un example de vue.<br />
						La méthode <code>render</code> est utilisée pour renvoyer le code HTML.<br />
						C'est elle qui est retournée à la fin du processus.<br />
						La méthode <code>get</code> sert à récupérer des variables envoyées dans la vue grâce à la méthode <code>assign</code>
						{$this->get_code_highlighted('php', '&lt;?php
	namespace mvc_router\mvc\views;
	
	
	use mvc_router\mvc\View;
	
	class Layout extends View {
		const NONE         = 0;
		const FROM_SCRATCH = 0;
		const BOOTSTRAP    = 2;
		const SEMANTIC_UI  = 3;
		const MATERIAL_DESIGN_LIGHT = 4;
		const FONT_AWESOME = 1;
		const GLYPHICON    = 2;
		const MATERIAL_ICONS = 3;
		
		/**
		 * @return string
		 */
		public function responsive_meta_tag(): string {
			return \'&lt;meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />\';
		}
		
		/**
		 * @param int $lib
		 * @return string
		 */
		public function font_icons( $lib = self::NONE ): string {
			switch( $lib ) {
				case self::FONT_AWESOME:
					return \'
	&lt;script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"
			integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ"
			crossorigin="anonymous">&lt;/script>
	&lt;script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"
			integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY"
			crossorigin="anonymous">&lt;/script>\';
				case self::GLYPHICON:
					return \'&lt;link rel="stylesheet" href="https://www.glyphicons.com/css/style.css?v=12">\';
				case self::MATERIAL_ICONS:
					return \'&lt;link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">\';
				default:
					return \'\';
			}
		}
		
		/**
		 * @param int $framework
		 * @param bool $jquery
		 * @param null $script_name
		 * @return string
		 */
		public function js( $framework = self::FROM_SCRATCH, $jquery = false, $script_name = null ): string {
			switch( $framework ) {
				case self::FROM_SCRATCH:
					if(substr($script_name, 0, strlen(\'http://\')) !== \'http://\' && substr($script_name, 0, strlen(\'https://\')) !== \'https://\') {
						$script_name = "/static/js/{$script_name}";
					}
					return "&lt;script src=\'{$script_name}\' data-base_src=\'{$script_name}\'>&lt;/script>";
				case self::BOOTSTRAP:
					$jquery_str = \'\';
					if( $jquery ) {
						$jquery_str = "&lt;script src=\'https://code.jquery.com/jquery-3.4.1.min.js\'>&lt;/script>";
					}
					return "
	{$jquery_str}
	&lt;script src=\'https://unpkg.com/popper.js@^1\'>&lt;/script>
	&lt;script src=\'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js\'
			integrity=\'sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM\'
			crossorigin=\'anonymous\'>&lt;/script>";
				case self::SEMANTIC_UI:
					$jquery_str = \'\';
					if( $jquery ) {
						$jquery_str = "&lt;script src=\'https://code.jquery.com/jquery-3.4.1.min.js\'>&lt;/script>";
					}
					return "
	{$jquery_str}
	&lt;script src=\'https://code.jquery.com/jquery-3.4.1.min.js\'>&lt;/script>
	&lt;script src=\'https://semantic-ui.com/dist/semantic.min.js\'>&lt;/script>";
				case self::MATERIAL_DESIGN_LIGHT:
					return \'&lt;script defer src="https://code.getmdl.io/1.3.0/material.min.js">&lt;/script>\';
				default:
					return \'\';
			}
		}
		
		/**
		 * @param int $framework
		 * @param null $stylesheet_name
		 * @return string
		 */
		public function css( $framework = self::FROM_SCRATCH, $stylesheet_name = null ) {
			switch( $framework ) {
				case self::FROM_SCRATCH:
					if(substr($stylesheet_name, 0, strlen(\'http://\')) !== \'http://\' && substr($stylesheet_name, 0, strlen(\'https://\')) !== \'https://\') {
						$stylesheet_name = "/static/css/{$stylesheet_name}";
					}
					return "&lt;link rel=\'stylesheet\' href=\'{$stylesheet_name}\' data-base_href=\'{$stylesheet_name}\' />";
				case self::BOOTSTRAP:
					return "&lt;link rel=\'stylesheet\' href=\'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css\'
							  integrity=\'sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T\'
							  crossorigin=\'anonymous\' />";
				case self::SEMANTIC_UI:
					return "&lt;link rel=\'stylesheet\' href=\'https://semantic-ui.com/dist/semantic.min.css\' />";
				case self::MATERIAL_DESIGN_LIGHT:
					$first_color = $this->get(\'material_first_theme_color\') ?? \'deep_purple\';
					$second_color = $this->get(\'material_second_theme_color\') ?? \'purple\';
					return "&lt;link rel=\'stylesheet\' href=\'https://code.getmdl.io/1.3.0/material.{$first_color}-{$second_color}.min.css\' />";
				default:
					return \'\';
			}
		}
		
		/**
		 * @return string
		 */
		protected function head(): string {
			$responsive_tag = $this->get( \'is_responsive\' ) ? $this->responsive_meta_tag() : \'\';
			$icons = $this->get( \'font_icons\' ) ? $this->font_icons( $this->get( \'font_icons\' ) ) : \'\';
			$framework = $this->get( \'framework\' );
			$icon = $this->get(\'icon\') ? "&lt;link rel=\'icon\' href=\'{$this->get(\'icon\')}\' />" : \'\';
			
			$stylesheets = $this->css( $framework )."\n";
			if( $this->get( \'stylesheets\' ) ) {
				foreach( $this->get( \'stylesheets\' ) as $stylesheet ) {
					$stylesheets .= $this->css( self::FROM_SCRATCH, $stylesheet );
				}
			}
			
			$scripts = $this->get_js();
			
			return "&lt;meta charset=\'utf-8\' />
	{$icon}
	&lt;title>{$this->get(\'title\')}&lt;/title>
	{$responsive_tag}
	{$stylesheets}
	{$icons}
	{$scripts}";
		}
		
		/**
		 * @param string $position
		 * @return string
		 */
		private function get_js($position = \'top\') {
			$framework = $this->get( \'framework\' )."\n";
			if($position === \'top\' && $this->get(\'js_at_the_top\') && !$this->get(\'js_at_the_bottom\')) {
				$scripts = $this->js( $framework, $this->get( \'use_jquery\' ) );
				if( $this->get( \'scripts\' ) ) {
					foreach( $this->get( \'scripts\' ) as $script ) {
						$scripts .= $this->js( self::FROM_SCRATCH, false, $script );
					}
				}
				return $scripts;
			}
			elseif(!$this->get(\'js_at_the_top\') && $position === \'bottom\' && $this->get(\'js_at_the_bottom\')) {
				$scripts = $this->js( $framework, $this->get( \'use_jquery\' ) )."\n";
				if( $this->get( \'scripts\' ) ) {
					foreach( $this->get( \'scripts\' ) as $script ) {
						$scripts .= $this->js( self::FROM_SCRATCH, false, $script );
					}
				}
				return $scripts;
			}
			
			return \'\';
		}
		
		/**
		 * @return string
		 */
		protected function page_header(): string {
			return \'\';
		}
		
		/**
		 * @return string
		 */
		protected function body(): string {
			return \'\';
		}
		
		/**
		 * @return string
		 */
		protected function footer(): string {
			return \'\';
		}
		
		/**
		 * @return string
		 */
		private final function main(): string {
			$header = $this->page_header();
			$footer = $this->footer();
			$_header = $header === \'\' ? \'\' : "&lt;header class=\'{$this->get(\'header_class\')}\'>{$header}&lt;/header>";
			$_footer = $footer === \'\' ? \'\' : "&lt;footer class=\'{$this->get(\'footer_class\')}\'>{$footer}&lt;/footer>";
			return "
			&lt;!DOCTYPE html>
			&lt;html lang=\'{$this->translate->get_default_language()}\'>
				&lt;head>
					{$this->head()}
				&lt;/head>
				&lt;body>
					{$_header}
					&lt;main class=\'{$this->get(\'main_class\')}\'>
						{$this->body()}
					&lt;/main>
					{$this->loader()}
					{$_footer}
					{$this->get_js(\'bottom\')}
				&lt;/body>
			&lt;/html>
		";
		}
		
		/**
		 * @return string
		 */
		protected function loader(): string {
			return \'\';
		}
		
		/**
		 * @return string
		 */
		public function render(): string {
			if( !$this->get( \'title\' ) ) {
				$this->assign( \'title\', \'MVC Router - Documentation\' );
			}
			return $this->main();
		}
	}', true)}
					</div>
				</div>
			</section>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Utiliser une vue dans un controlleur {$this->top_button('utiliser_une_vue', 'binder_une_vue_a_l_injection_de_dependences')}</h3>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
					Pour utiliser une vue, vous pouvez soit la récupérer
					soit comme paramètre, soit comme propriété, soit grâce à son getter dans la propriété <code>inject</code>.
					{$this->get_code_highlighted('php', '&lt;?php
	namespace mvc_router\mvc\controllers;
	
	
	use mvc_router\mvc\Controller;
	
	class Documentation extends Controller {
		
		/**
		 * @route /documentation
		 *
		 * @param \mvc_router\mvc\views\Documentation $view
		 * @return \mvc_router\mvc\views\Documentation
		 */
		public function index(\mvc_router\mvc\views\Documentation $view): \mvc_router\mvc\views\Documentation {
			if(!$view->get(\'sub_page\'))
				$view->assign(\'sub_page\', \'get_started\');
			$view->assign(\'current_page\', \'documentation\');
			return $view;
		}
		
		/**
		 * @route /documentation/views
		 *
		 * @param \mvc_router\mvc\views\Documentation $view
		 * @return \mvc_router\mvc\views\Documentation
		 */
		public function views(\mvc_router\mvc\views\Documentation $view): \mvc_router\mvc\views\Documentation {
			$view->assign(\'sub_page\', \'views\');
			return $this->index($view);
		}
	}
	
', true)}
					</div>
				</div>
			</section>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Binder une vue à l'injection de dépendences {$this->top_button('binder_une_vue_a_l_injection_de_dependences')}</h3>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						<p>Pour binder une vue à l'injection de dépdendences, rien de plus simple : </p>
						<p>Ouvrez le fichier <code>dependencies.yaml</code> à la racine de votre répertoire custom.</p>
						<p>Ajouter les lignes suivantes</p>
						{$this->get_code_highlighted('yaml', 'add:
  views:
    \mvc_router\mvc\views\Documentation:
      name: \'documentation_view\'
      file: \'__DIR__/classes/mvc/views/Documentation.php\'
					
					', true)}
						Une fois ces lignes ajoutées, ouvez un terminal et tapez la commande suivante
						{$this->get_code_highlighted('shell', 'php exe.php install:update')}
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
HTML;
		}
		
		protected function entities(): string {
			return <<<HTML
<div class='mdl-grid'>
	<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
		<div class='mdl-grid'>
			<div class='mdl-cell mdl-cell--3-col-desktop mdl-cell--hide-tablet mdl-cell--hide-phone'></div>
			<div class='mdl-cell mdl-cell--6-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				{$this->get_header_card(
					'Les entités',
					"Les entités de MVC ROUTER sont prévues pour gérer le stoquage d'une ligne d'une table d'une base de données relationnelle.",
					[
						'Créer une entité',
						'Utiliser une entité',
						'Binder une entité à l\'injection de dépendences',
						'Créer la table correspondante à une entité'
					]
				)}
			</div>
		</div>
		<div class='mdl-grid'>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Créer une entité {$this->top_button('creer_une_entite', 'utiliser_une_entite')}</h3>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						{$this->get_code_highlighted('php', '&lt;?php
	namespace mvc_router\data\gesture\custom\entities;


	use mvc_router\data\gesture\Entity;
	
	/**
	 * Class User
	 *
	 * @package mvc_router\data\gesture\custom\entities
	 *
	 */
	class User extends Entity {
		/**
		 * @var int $id
		 * @primary_key
		 * @auto_increment
		 */
		protected $id;
		/**
		 * @var int $fb_id
		 */
		protected $fb_id;
		/**
		 * @var string $address
		 * @sql_type varchar
		 */
		protected $address;
		/**
		 * @var string $email
		 * @sql_type varchar
		 */
		protected $email;
		/**
		 * @var string $phone
		 * @sql_type varchar
		 */
		protected $phone;
		/**
		 * @var string $password
		 * @sql_type varchar
		 */
		protected $password;
		/**
		 * @var string $description
		 * @sql_type text
		 */
		protected $description;
		/**
		 * @var string $profil_img
		 * @sql_type varchar
		 */
		protected $profil_img;
		/**
		 * @var bool $premium
		 * @sql_type tinyint
		 */
		protected $premium;
		/**
		 * @var bool $active
		 * @sql_type tinyint
		 */
		protected $active;
		/**
		 * @var string $activate_token
		 * @sql_type varchar
		 */
		protected $activate_token;
		/**
		 * @var string $website
		 * @sql_type varchar
		 */
		protected $website;
		/**
		 * @var string $pseudo
		 * @sql_type varchar
		 */
		protected $pseudo;
		/**
		 * @var string $first_name
		 * @sql_type varchar
		 */
		protected $first_name;
		/**
		 * @var string $last_name
		 * @sql_type varchar
		 */
		protected $last_name;
		/**
		 * @var string $fb_access_token
		 * @sql_type varchar
		 */
		protected $fb_access_token;
		/**
		 * @var string $local_access_token
		 * @sql_type varchar
		 */
		protected $local_access_token;
		/**
		 * @var string $role
		 * @sql_type varchar
		 */
		protected $role;
		/**
		 * @inheritDoc
		 */
		public function to_json() {
			$json = parent::to_json();
			unset($json[\'password\']);
			$json[\'role\'] = $this->get(\'role\');
			return $json;
		}
		/**
		 * @inheritDoc
		 */
		public function get($key) {
			switch ($key) {
				case \'role\':
					if(!$this->id) {
						return \'\';
					}
					$user_role = $this->inject->get_role_manager()->get_all_from_userid($this->id);
					if(empty($user_role)) {
						return \'\';
					}
					return $user_role->get(\'role\');
				default:
					return parent::get($key);
			}
		}
	}', true)}
					</div>
				</div>
			</section>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Utiliser une entité {$this->top_button('utiliser_une_entite', 'binder_une_entite_a_l_injection_de_dependences')}</h3>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						{$this->get_code_highlighted('php', '&lt;?php
	namespace mvc_router\mvc\controllers;
	
	use \mvc_router\mvc\Controller;
	use \mvc_router\data\gesture\custom\entities\User;
	
	class MonController extends Controller {
		public function index(User $user): string {
			$entity = $this->inject->get_user_entity();
			return $this->json($entity->to_json());
		}
	}
', true)}
					</div>
				</div>
			</section>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Binder une entité à l'injection de dépendences {$this->top_button('binder_une_entite_a_l_injection_de_dependences', 'creer_la_table_correspondante_a_une_entite')}</h3>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						Ouvrez le fichier <code>dependencies.yaml</code> et entrez les lignes suivantes :
						{$this->get_code_highlighted('yaml', 'add:
	data_models:
	    \mvc_router\data\gesture\custom\entities\User:
	        type: \'entity\'
	        name: \'user_entity\'
	        file: \'__DIR__/classes/datas/entities/User.php\'
', true)}
						Puis ouvrez un terminal et tapez la ligne de commande suivante :
						{$this->get_code_highlighted('shell', 'php exe.php install:update')}
					</div>
				</div>
			</section>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Créer la table correspondante à une entité {$this->top_button('creer_la_table_correspondante_a_une_entite')}</h3>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						Pour cela, il faut d'abbord créer le manager correspondant à l'entité.<br />
						<a href='{$this->get_next_tab_url()}'>
							<button class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored'>Aller aux managers</button>
						</a>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
HTML;
		}
		
		protected function managers(): string {
			return <<<HTML
<div class='mdl-grid'>
	<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
		<div class='mdl-grid'>
			<div class='mdl-cell mdl-cell--3-col-desktop mdl-cell--hide-tablet mdl-cell--hide-phone'></div>
			<div class='mdl-cell mdl-cell--6-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				{$this->get_header_card(
				'Les managers',
				"Les managers de MVC ROUTER sont prévues pour gérer les requêtes SQL liées à une tables d'une base de données relationnelle.",
				[
					'Créer un manager',
					'Utiliser un manager',
					'Binder un manager à l\'injection de dépendences',
					'Créer la table correspondante à un manager'
				]
			)}
			</div>
		</div>
		<div class='mdl-grid'>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Créer un manager {$this->top_button('creer_un_manager', 'utiliser_un_manager')}</h3>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						{$this->get_code_highlighted('php', '&lt;?php
	namespace mvc_router\data\gesture\custom\managers;


	use mvc_router\data\gesture\Manager;
	
	/**
	 * Class Manager
	 *
	 * @method array get_id_test_lol_from_id(int $id)
	 * @method \mvc_router\data\gesture\custom\entities\User[] get_all_from_id(int $id)
	 *
	 * @package mvc_router\data\gesture\custom
	 */
	
	class User extends Manager {}
', true)}
					</div>
				</div>
			</section>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Utiliser un manager {$this->top_button('utiliser_un_manager', 'binder_un_manager_a_l_injection_de_dependences')}</h3>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						{$this->get_code_highlighted('php', '&lt;?php
	namespace mvc_router\mvc\controllers;
	
	use \mvc_router\mvc\Controller;
	use \mvc_router\data\gesture\custom\managers\User;
	
	class MonController extends Controller {
		public function index(User $users): string {
			$manager = $this->inject->get_user_manager();
			return $this->json($manager->get_entity()->to_json());
		}
	}
', true)}
					</div>
				</div>
			</section>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Binder un manager à l'injection de dépendences {$this->top_button('binder_un_manager_a_l_injection_de_dependences', 'creer_la_table_correspondante_a_un_manager')}</h3>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						Ouvrez le fichier <code>dependencies.yaml</code> et entrez les lignes suivantes :
						{$this->get_code_highlighted('yaml', 'add:
	data_models:
	    \mvc_router\data\gesture\custom\managers\User:
	        type: \'manager\'
	        name: \'user_manager\'
	        file: \'__DIR__/classes/datas/managers/User.php\'
', true)}
						Puis ouvrez un terminal et tapez la ligne de commande suivante :
						{$this->get_code_highlighted('shell', 'php exe.php install:update')}
					</div>
				</div>
			</section>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Créer la table correspondante à un manager {$this->top_button('creer_la_table_correspondante_a_un_manager')}</h3>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						Ouvrez un terminal et tapez la ligne de commande suivante
						{$this->get_code_highlighted('shell', 'php exe.php install:databases')}
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
HTML;
		}
		
		/**
		 * @return string
		 * @throws ReflectionException
		 */
		protected function commands(): string {
			$helper = $this->inject->get_helpers();
			$parser = $this->inject->get_phpdoc_parser();
			$fs = $this->inject->get_service_fs();
			$slash = $helper->get_slash();
			$list = [];
			$cmds = [];
			$fs->browse_dir(function($path) use(&$cmds, $helper, $parser) {
				$path = explode($helper->get_slash(), $path);
				$cmd = end($path);
				$cmd = explode('.', $cmd)[0];
				$cmd = str_replace('Command', '', $cmd);
				$cmd = strtolower($cmd);
				$methods = $parser->get_class_methods(
					$this->inject->{'get_command_'.$cmd}(),
					PHPDocParser::COMMAND
				);
				$cmds[$cmd] = $methods;
			},  false, __DIR__.$slash.'..'.$slash.'..'.$slash.'..'.$slash.'..'.$slash.'classes'.$slash.'commands');
			$tmp = [];
			foreach($cmds as $key => $values) {
				$tmp[$key] = [];
				foreach($values as $value) {
					$doc = $parser->get_method_doc($this->inject->{"get_command_{$key}"}(), $value);
					$syntaxes = isset($doc['syntax']) ? (is_array($doc['syntax']) ? array_map(function($syntax) {
						return trim(htmlspecialchars($syntax));
					}, $doc['syntax']) : [
						trim(htmlspecialchars($doc['syntax']))
					]) :[
						"{$key}:{$value}"
					];
					$tmp[$key][$value] = $syntaxes;
				}
			}
			foreach( $tmp as $command => $commands ) {
				$list[] = $this->get_command_item($this->inject::get_class_from_name("command_{$command}"), $command, $commands);
			}
			$list = implode("\n", $list);
			
			return <<<HTML
<div class='mdl-grid'>
	<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
		<div class='mdl-grid'>
			<div class='mdl-cell mdl-cell--3-col-desktop mdl-cell--hide-tablet mdl-cell--hide-phone'></div>
			<div class='mdl-cell mdl-cell--6-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				{$this->get_header_card(
				'Les commandes',
				"Les commandes de MVC ROUTER ont une syntaxe assez simplifiés ce qui permet à un utilisateur lambda d'être rapidement au point.",
				[
					'Liste des commandes',
					'Utiliser une commande'
				]
			)}
			</div>
		</div>
		<div class='mdl-grid'>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Liste des commandes {$this->top_button('liste_des_commandes', 'utiliser_une_commande')}</h3>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						<ul class='mdl-list'>{$list}</ul>
					</div>
				</div>
			</section>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Utiliser une commande {$this->top_button('utiliser_une_commande')}</h3>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						<p>Il y a deux utilisations possibles de la commande.</p>
						<p>Soit dans un terminal</p>
						<p>Par example</p>
						{$this->get_code_highlighted('shell', 'php exe.php generate:translations')}
						<p>Soit dans votre code</p>
						<p>Par example</p>
						{$this->get_code_highlighted('php', '&lt;?php
	
	namespace mvc_router\mvc\controllers\backoffice;
	
	use mvc_router\mvc\Controller;
	
	class Translations extends Controller {
		/** @var \mvc_router\services\Translate $translation */
		public $translation;
		
		...
		
		/**
		 * @route /backoffice/translations/regenerate
		 * @param Logger $logger
		 * @param Router $router
		 * @return string
		 * @throws Exception
	     */
		public function regenerate_translations(Logger $logger, Router $router) {
			if($router->post(\'regenerate\')) {
				$logger->types(Logger::CONSOLE);
				$logger->separator(\'--------------------------------------------------------------\');
	
				$logger->log(\'Command: php exe.php generate:translation\');
				$logger->log_separator();
				$translation_command = $this->inject->get_commands()->run(\'generate:translations\');
				$logger->log($translation_command);
				$logger->log_separator();
	
				$reload_page = $this->translation->__(\'Recharger la page\');
	
				return "&lt;input type=\'button\' value=\'{$reload_page}\' onclick=\'window.location.reload()\' /&gt;";
			}
			return \'\';
		}
		
		...
		
	}
', true)}
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
HTML;
		}
		
		protected function configurations(): string {
			return <<<HTML
<div class='mdl-grid'>
	<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
		<div class='mdl-grid'>
			<div class='mdl-cell mdl-cell--3-col-desktop mdl-cell--hide-tablet mdl-cell--hide-phone'></div>
			<div class='mdl-cell mdl-cell--6-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				{$this->get_header_card(
				'Les configurations',
				"Les configurations de MVC ROUTER des classes PHP qui peuvent vous servir à récupérer certaines données en base de données ou alors à partir d'un fichier text, JSON, YAML ou encore XML",
				[
					'Créer une configuration',
					'Etendre une configuration',
					'Utiliser une configuration',
					'Binder une nouvelle conf à l\'injection de dépendences',
					'Binder une extension de conf à l\'injection de dépendences',
				]
			)}
			</div>
		</div>
		<div class='mdl-grid'>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Créer une configuration {$this->top_button('creer_une_configuration', 'etendre_une_configuration')}</h3>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						{$this->get_code_highlighted('php', '&lt;?php
	namespace mvc_router\confs\custom;
	
	use mvc_router\Base;
	
	class WebSocket extends Base {
		public function get_routes() {
			return [
				\'/chat\' => [
					\'controller\' => $this->inject->get_ws_chat(),
					\'allows\' => [\'*\'],
				]
			];
		}
	}
', true)}
						Ouvrez un terminal et tapez commande suivante
						{$this->get_code_highlighted('shell', 'php exe.php install:update')}
					</div>
				</div>
			</section>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Etendre une configuration {$this->top_button('etendre_une_configuration', 'utiliser_une_configuration')}</h3>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						Dans un répertoire <code>[custom-project-dir]/classes/confs</code>, créez un fichier <code>Mysql.php</code> et tapez le code suivant
						{$this->get_code_highlighted('php', '&lt;?php
	namespace mvc_router\confs\custom;

	class Mysql extends \mvc_router\confs\Mysql {
		public function before_construct() {
			parent::before_construct();
			$json = $this->inject->get_service_json();
			$fs = $this->inject->get_service_fs();
			$content = $json->decode($fs->read_file(__DIR__.\'/mysql.json\'), true);
			if(isset($content[\'host\']) && $content[\'host\']) $this->host = $content[\'host\'];
			if(isset($content[\'user\']) && $content[\'user\']) $this->user = $content[\'user\'];
			if(isset($content[\'pass\']) && $content[\'pass\']) $this->pass = $content[\'pass\'];
			if(isset($content[\'user_prefix\']) && $content[\'user_prefix\']) $this->user_prefix = $content[\'user_prefix\'];
			if(isset($content[\'db_prefix\']) && $content[\'db_prefix\']) $this->db_prefix = $content[\'db_prefix\'];
			if(isset($content[\'db_name\']) && $content[\'db_name\']) $this->db_name = $content[\'db_name\'];
			if(isset($content[\'port\']) && $content[\'port\']) $this->port = $content[\'port\'];
			$this->db_prefix = \'\';
		}
	}
', true)}
						Ouvrez un terminal et tapez commande suivante
						{$this->get_code_highlighted('shell', 'php exe.php install:update')}
					</div>
				</div>
			</section>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Utiliser une configuration {$this->top_button('utiliser_une_configuration', 'binder_une_nouvelle_configuration_a_l_injection_de_dependences')}</h3>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						{$this->get_code_highlighted('php', '&lt;?php
namespace mvc_router\commands;

use mvc_router\services\FileSystem;
use mvc_router\services\Trigger;

class TestCommand extends Command {
	
	...

	/**
	 * @return array|string
	 */
	public function mysql() {
		$mysql = $this->confs->get_mysql();
		if(!$mysql->is_connected()) {
			return \'ERROR : Mysql is not connected\';
		}
		$mysql->query(\'SELECT * FROM `user` WHERE email = $1 OR email = $2\', [
			\'nicolachoquet06250@gmail.com\',
			\'yannchoquet@gmail.com\'
		]);
		$users = [];
		while ($data = $mysql->fetch_assoc()) {
			$users[] = $data;
		}
		return $users;
	}

	...
	
}
', true)}
					</div>
				</div>
			</section>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Binder une nouvelle configuration à l'injection de dépendences {$this->top_button('binder_une_nouvelle_conf_a_l_injection_de_dependences', 'binder_une_extension_de_configuration_a_l_injection_de_dependences')}</h3>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						Ouvrez le fichier dependencies.yaml et entrez les lignes suivantes
						{$this->get_code_highlighted('yaml', 'add:
	confs:
	    \mvc_router\confs\custom\WebSocket:
	        name: \'websocket_routes\'
	        file: \'__DIR__/classes/confs/WebSocket.php\'
	        parent: \'\mvc_router\Base\'
', true)}
						Ouvrez un terminal et tapez commande suivante
						{$this->get_code_highlighted('shell', 'php exe.php install:update')}
					</div>
				</div>
			</section>
			<section class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
				<h3>Binder une extension de configuration à l'injection de dépendences {$this->top_button('binder_une_extension_de_conf_a_l_injection_de_dependences')}</h3>
				<div class='mdl-grid'>
					<div class='mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone'>
						Ouvrez le fichier dependencies.yaml et entrez les lignes suivantes
						{$this->get_code_highlighted('yaml', 'extends:
	confs:
	    \mvc_router\confs\Mysql:
	        class:
	            old: \'mvc_router\confs\Mysql\'
	            new: \'mvc_router\confs\custom\Mysql\'
	        name: \'mysql\'
	        file: \'__DIR__/classes/confs/Mysql.php\'
', true)}
						Ouvrez un terminal et tapez commande suivante
						{$this->get_code_highlighted('shell', 'php exe.php install:update')}
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
HTML;
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