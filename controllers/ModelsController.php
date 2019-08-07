<?php

class ModelsController  extends ActionController {
	# -------------------------------------------------------
	protected $opo_config; // plugin configuration file
	protected $ps_plugin_path;
	protected $ps_plugin_url;
	# -------------------------------------------------------
	#
	# -------------------------------------------------------
	public function __construct(&$po_request, &$po_response, $pa_view_paths = null)
	{
		parent::__construct($po_request, $po_response, $pa_view_paths);

		$this->ps_plugin_path = __CA_BASE_DIR__ . "/app/plugins/labelMaker";
		$this->ps_plugin_url  = __CA_URL_ROOT__ . "/app/plugins/labelMaker";
		if (file_exists($this->ps_plugin_path . '/conf/local/archeologyBoxes.conf')) {
			$this->opo_config = Configuration::load($this->ps_plugin_path . '/conf/local/labelMaker.conf');
		} else {
			$this->opo_config = Configuration::load($this->ps_plugin_path . '/conf/labelMaker.conf');
		}
	}

	public function Index() {
		return $this->render('index_html.php');
	}
}
