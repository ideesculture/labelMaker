<?php


class labelMakerPlugin extends BaseApplicationPlugin
{
	# -------------------------------------------------------
	private $opo_config;
	private $ops_plugin_path;

	# -------------------------------------------------------
	public function __construct($ps_plugin_path)
	{
		$this->ops_plugin_path = $ps_plugin_path;
		$this->description = _t('labelMaker plugin');
		parent::__construct();
		$ps_plugin_path = __CA_BASE_DIR__ . "/app/plugins/labelMaker";

		if (file_exists($ps_plugin_path . '/conf/local/labelMaker.conf')) {
			$this->opo_config = Configuration::load($ps_plugin_path . '/conf/local/labelMaker.conf');
		} else {
			$this->opo_config = Configuration::load($ps_plugin_path . '/conf/labelMaker.conf');
		}
	}
	# -------------------------------------------------------
	/**
	 * Override checkStatus() to return true - this plugin always initializes ok
	 */
	public function checkStatus()
	{
		return array(
			'description' => $this->getDescription(),
			'errors' => array(),
			'warnings' => array(),
			'available' => ((bool)$this->opo_config->get('enabled'))
		);
	}

	# -------------------------------------------------------
	/**
	 * Insert into ObjectEditor info (side bar)
	 */
	public function hookAppendToEditorInspector(array $va_params = array()) {
		// Example for editor inspector hook
		$vs_buf = "";
		$va_params["caEditorInspectorAppend"] = $vs_buf;

		return $va_params;
	}
	# -------------------------------------------------------
	/**
	 * Insert menu
	 */
	public function hookRenderMenuBar($pa_menu_bar)
	{
		// No menu insertion for now

		return $pa_menu_bar;
	}


	# -------------------------------------------------------
	/**
	 * Get plugin user actions
	 */

	static public function getRoleActionList() {
		// No required role
		return array();
	}

	# -------------------------------------------------------
	/**
	 * Add plugin user actions
	 */
	public function hookGetRoleActionList($pa_role_list) {
		//No role action now
		return $pa_role_list;
	}
}
