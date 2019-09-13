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
/*
        $t_item = $va_params["t_item"];

        $vs_table_name = $t_item->tableName();
        $vn_item_id = $t_item->getPrimaryKey();
        $vn_code = $t_item->getTypeCode();

        if (in_array($vs_table_name, ["ca_objects", "ca_collections"])) {
            $vs_url = caNavUrl($this->getRequest(), "etatsInrap", "Generer", "Modele5", array("object"=>$vn_item_id, "etat"=>"constat_etat_simple"));

            $vs_buf = "<div style=\"text-align:center;width:100%;margin:10px 0 20px 0;\">"
                . "<a style='background-color:#1ab3c8;color:white;padding:10px 6px;border-radius:6px;' href='".__CA_URL_ROOT__."/index.php/labelMaker/Models/Create/results/".$vs_table_name."'>Etiquettes INRAP</a></div>";

            $va_params["caEditorInspectorAppend"] = $va_params["caEditorInspectorAppend"] ."<div style='height:2px;'></div>".$vs_buf;
        }*/
        
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
