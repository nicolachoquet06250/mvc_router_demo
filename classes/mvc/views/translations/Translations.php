<?php


namespace mvc_router\mvc\views;


class Translations extends Layout {
	
	private $lang;
	private $selected_default;
	private $options;
	private $url;
	private $table_of_translations;
	
	public function after_construct() {
		parent::after_construct();
		
		list($this->lang,
			$this->selected_default,
			$this->options,
			$this->url,
			$this->table_of_translations) = $this->generate_all_vars_string();
	}
	
	/**
	 * @return array
	 */
	private function generate_all_vars_string() {
		$lang = $this->get('lang');
		$translation = $this->translate;
		$router = $this->get('router');

		$selected_default = !$lang ? 'selected="selected"' : '';
		$options = '';
		foreach ($translation->get_languages() as $language => $name) {
			$selected_option = $lang && $lang === $language ? 'selected="selected"' : '';
			$options .= "<option value='{$language}' {$selected_option}>{$name}</option>";
		}
		$url = array_keys($router->get_current_route())[0];
		$table_of_translations = '';
		foreach ($translation->get_array($lang) as $key => $_translation) {
			$key = $translation->decode_text($key);
			$key_for_value = urlencode($key);
			$table_of_translations .= "
	<tr>
		<td>{$key}</td>
		<td>
			<input name='{$key_for_value}' type='text' style='width: 95%' 
				value=\"{$_translation}\" placeholder='{$this->__('Traduction')}' />
		</td>
		<td>
			<input type='button' onclick=\"window.location.href='{$url}?lang={$lang}&key_to_remove={$key_for_value}'\" value='{$this->__('Supprimer')}'>
		</td>
	</tr>
";
		}
		return [$lang, $selected_default, $options, $url, $table_of_translations];
	}
	
	/**
	 * @inheritDoc
	 */
	public function head(): string {
		$this->assign('is_responsive', true);
		$this->assign('font_icons', self::FONT_AWESOME);
		$this->assign('framework', self::BOOTSTRAP);
		$this->assign('scripts', ['functions.js']);
		return parent::head();
	}
	
	/**
	 * @inheritDoc
	 */
	public function page_header(): string {
		return "<form id='change-lang' method='get' action=''>
					<select name='lang' onchange='document.querySelector(\"#change-lang\").submit()'>
			<option value='' disabled {$this->selected_default}>{$this->__( 'Choisir' )}</option>
				{$this->options}
			</select>
		</form>";
	}
	
	/**
	 * @inheritDoc
	 */
	public function body(): string {
		$this->assign('main_style', 'margin-top: 5px; border-top: 1px solid black;');
		$regenerate_translations = $this->get('regenerate_translations');
		$regenerate_logs = '';
		if($regenerate_translations) {
			$regenerate_logs = $this->get('regenerate_logs');
		}
		
		return "<div style='display: inline-block; width: 20%; position: absolute; padding-top: 5px;'>
					<input type='button' onclick='regenerate_translations()' value='{$this->__('Régénérer les traductions')}' />
					<div id='regenerate_logs'>
						{$regenerate_logs}
					</div>
				</div>
				
				<div style='display: inline-block; width: 75%; position: absolute; margin-left: calc(20% + 5px); border-left: 1px solid black;'>
					<form action='' method='post'>
						<table style='width: 100%'>
							<thead>
								<tr>
									<th> {$this->__('Cléf')} </th>
									<th> {$this->__('Valeur')} </th>
									<th> {$this->__('Actions')} </th>
								</tr>
							</thead>
							<tbody>
								{$this->table_of_translations}
							</tbody>
							<tfoot>
								<tr>
									<th colspan='2'><button type='submit'>{$this->__('Valider')}</button></th>
								</tr>
								<tr>
									<td>
										<input id='key' type='text' style='width: 95%' placeholder='{$this->__('Cléf')}' />
									</td>
									<td>
										<input id='value' type='text' style='width: 95%' placeholder='{$this->__('Valeur')}' />
									</td>
									<td>
										<input onclick='add()' type='button' value='{$this->__('Ajouter')}' />
									</td>
								</tr>
							</tfoot>
						</table>
					</form>
				</div>";
	}
}