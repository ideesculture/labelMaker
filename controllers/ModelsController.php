<?php
require_once(__CA_MODELS_DIR__."/ca_bundle_displays.php");
require_once(__CA_LIB_DIR__."/ca/ResultContext.php");

class ModelsController  extends ActionController {
	# -------------------------------------------------------
	protected $opo_config; // plugin configuration file
	protected $ps_plugin_path;
	protected $ps_plugin_url;
	protected $ps_widget_content;
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
		return "";
	}

    public function Create() {
        $vs_table_name = $this->request->getParameter("results", pString);
        $this->view->setVar("tableName", $vs_table_name);

	    $this->view->setVar("bundles", [
	        "ca_objects"=>$this->opo_config->getAssoc("ca_objects"),
            "ca_collections"=>$this->opo_config->getAssoc("ca_collections"),
            "ca_entities"=>$this->opo_config->getAssoc("ca_entities")
        ]);

	    // Get results for current search
        $resultContext = ResultContext::getResultContextForLastFind($this->getRequest(),$vs_table_name);
        $list = $resultContext->getResultList();
        $numResults = sizeof($list);
        $this->view->setVar("numResults", $numResults);
        $vs_back_text = $numResults." résultats";

        $resultsLink = ResultContext::getResultsLinkForLastFind($this->getRequest(), $vs_table_name,  $vs_back_text, '');
        $this->view->setVar("resultsLink", $resultsLink);

        $layouts = [];
        if ($handle = opendir(__CA_BASE_DIR__."/app/plugins/labelMaker/layouts")) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != ".." && $entry != "readme.MD") {
                    array_push($layouts, "$entry\n");
                }
            }
            closedir($handle);
        }
        $this->view->setVar("layouts", $layouts);
        return $this->render('create_html.php');
    }

    public function CreateFloating() {
        $vs_table_name = $this->request->getParameter("results", pString);
        $this->view->setVar("tableName", $vs_table_name);

        $this->view->setVar("bundles", [
            "ca_objects"=>$this->opo_config->getAssoc("ca_objects"),
            "ca_collections"=>$this->opo_config->getAssoc("ca_collections"),
            "ca_entities"=>$this->opo_config->getAssoc("ca_entities")
        ]);

        // Get results for current search
        $resultContext = ResultContext::getResultContextForLastFind($this->getRequest(),$vs_table_name);
        $list = $resultContext->getResultList();
        $numResults = sizeof($list);
        $this->view->setVar("numResults", $numResults);
        $vs_back_text = $numResults." résultats";

        $resultsLink = ResultContext::getResultsLinkForLastFind($this->getRequest(), $vs_table_name,  $vs_back_text, '');
        $this->view->setVar("resultsLink", $resultsLink);

        $layouts = [];
        if ($handle = opendir(__CA_BASE_DIR__."/app/plugins/labelMaker/layouts")) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != ".." && $entry != "readme.MD") {
                    array_push($layouts, "$entry\n");
                }
            }
            closedir($handle);
        }
        $this->view->setVar("layouts", $layouts);
        return $this->render('create_floating_html.php');
    }

    public function Displays() {
        $t_display = new ca_bundle_displays();
        $this->view->setVar('t_display', $t_display);
        $this->view->setVar('display_list', $va_displays = caExtractValuesByUserLocale($t_display->getBundleDisplays(array('table'=>'ca_objects', 'user_id' => $this->request->getUserID(), 'access' => __CA_BUNDLE_DISPLAY_READ_ACCESS__)), null, null, array()));

        return $this->render('displays_html.php');
    }

    private function b64DecodeUnicode($str) {
        // Going backwards: from bytestream, to percent-encoding, to original string.
        $temp = urldecode(base64_decode($str));
        return $temp;
    }

    public function Preview() {
        $labelContent = $this->request->getParameter("labelContent", pString);
        $paperWidth = $this->request->getParameter("paperWidth", pFloat);
        $paperHeight = $this->request->getParameter("paperHeight", pFloat);
        $nbCols = $this->request->getParameter("nbColumns", pInteger);
        $nbRows = $this->request->getParameter("nbRows", pInteger);
        $labelWidth = $this->request->getParameter("labelWidth", pFloat);
        $labelHeight = $this->request->getParameter("labelHeight", pFloat);
        $horizontalPadding = $this->request->getParameter("horizontalPadding", pFloat);
        $verticalPadding = $this->request->getParameter("verticalPadding", pFloat);
        $marginTop = $this->request->getParameter("marginTop", pFloat);
        $marginLeft = $this->request->getParameter("marginLeft", pFloat);
        $vs_content = $this->b64DecodeUnicode($labelContent);

        $this->view->setVar("measures", array(
            "paper"=>array("width"=>$paperWidth, "height"=>$paperHeight),
            "margins"=>array("top"=>$marginTop, "left"=>$marginLeft),
            "nb"=>array("cols"=>$nbCols, "rows"=>$nbRows),
            "label"=>array("width"=>$labelWidth, "height"=>$labelHeight),
            "padding"=>array("horizontal"=>$horizontalPadding, "vertical"=>$verticalPadding)
        ));
        $this->view->setVar("content", $this->b64DecodeUnicode($labelContent));

        $vs_content= $this->render('generate_sample_pdf.php', true);
        print $vs_content;
        die();
    }

    public function Generate() {
        $vs_table_name = $this->request->getParameter("results", pString);
        $this->view->setVar("tableName", $vs_table_name);

        $labelContent = $this->request->getParameter("labelContent", pString);
        $paperWidth = $this->request->getParameter("paperWidth", pFloat);
        $paperHeight = $this->request->getParameter("paperHeight", pFloat);
        $nbCols = $this->request->getParameter("nbColumns", pInteger);
        $nbRows = $this->request->getParameter("nbRows", pInteger);
        $labelWidth = $this->request->getParameter("labelWidth", pFloat);
        $labelHeight = $this->request->getParameter("labelHeight", pFloat);
        $horizontalPadding = $this->request->getParameter("horizontalPadding", pFloat);
        $verticalPadding = $this->request->getParameter("verticalPadding", pFloat);
        $marginTop = $this->request->getParameter("marginTop", pFloat);
        $marginLeft = $this->request->getParameter("marginLeft", pFloat);
        $vs_content = $this->b64DecodeUnicode($labelContent);

        $this->view->setVar("measures", array(
            "paper"=>array("width"=>$paperWidth, "height"=>$paperHeight),
            "margins"=>array("top"=>$marginTop, "left"=>$marginLeft),
            "nb"=>array("cols"=>$nbCols, "rows"=>$nbRows),
            "label"=>array("width"=>$labelWidth, "height"=>$labelHeight),
            "padding"=>array("horizontal"=>$horizontalPadding, "vertical"=>$verticalPadding)
        ));
        $this->view->setVar("content", $this->b64DecodeUnicode($labelContent));

        // Get results for current search
        $resultContext = ResultContext::getResultContextForLastFind($this->getRequest(),$vs_table_name);
        $list = $resultContext->getResultList();
        $numResults = sizeof($list);
        $this->view->setVar("numResults", $numResults);
        $this->view->setVar("resultsIds", $list);
        $vs_back_text = $numResults." résultats";

        $resultsLink = ResultContext::getResultsLinkForLastFind($this->getRequest(), $vs_table_name,  $vs_back_text, '');
        $this->view->setVar("resultsLink", $resultsLink);

        $vs_content= $this->render('generate_pdf.php', true);
        print $vs_content;
        die();
    }

    public function PreviewPdf() {
        $labelContent = $this->request->getParameter("labelContent", pString);
        $paperWidth = $this->request->getParameter("paperWidth", pFloat);
        $paperHeight = $this->request->getParameter("paperHeight", pFloat);
        $nbCols = $this->request->getParameter("nbColumns", pInteger);
        $nbRows = $this->request->getParameter("nbRows", pInteger);
        $labelWidth = $this->request->getParameter("labelWidth", pFloat);
        $labelHeight = $this->request->getParameter("labelHeight", pFloat);
        $horizontalPadding = $this->request->getParameter("horizontalPadding", pFloat);
        $verticalPadding = $this->request->getParameter("verticalPadding", pFloat);
        $marginTop = $this->request->getParameter("marginTop", pFloat);
        $marginLeft = $this->request->getParameter("marginLeft", pFloat);
        $vs_content = $this->b64DecodeUnicode($labelContent);

        $this->view->setVar("measures", array(
            "paper"=>array("width"=>$paperWidth, "height"=>$paperHeight),
            "margins"=>array("top"=>$marginTop, "left"=>$marginLeft),
            "nb"=>array("cols"=>$nbCols, "rows"=>$nbRows),
            "label"=>array("width"=>$labelWidth, "height"=>$labelHeight),
            "padding"=>array("horizontal"=>$horizontalPadding, "vertical"=>$verticalPadding)
        ));
        $this->view->setVar("content", $this->b64DecodeUnicode($labelContent));

        $vs_content= $this->render('generate_sample_pdf.php', true);

	    try {
	        $o_pdf = new PDFRenderer();
            $this->view->setVar('PDFRenderer', $o_pdf->getCurrentRendererCode());
            $va_page_size =	PDFRenderer::getPageSize(caGetOption('pageSize', $va_template_info, 'A4'), 'mm', caGetOption('pageOrientation', $va_template_info, 'portrait'));
            $vn_page_width = $va_page_size['width']; $vn_page_height = $va_page_size['height'];
            $this->view->setVar("measures", array(
                "paper"=>array("width"=>$paperWidth, "height"=>$paperHeight),
                "margins"=>array("top"=>$marginTop, "left"=>$marginLeft),
                "nb"=>array("cols"=>$nbCols, "rows"=>$nbRows),
                "label"=>array("width"=>$labelWidth, "height"=>$labelHeight),
                "padding"=>array("horizontal"=>$horizontalPadding, "vertical"=>$verticalPadding)
            ));

            // TODO : A4 => LxH mm ? vérifier dans le PDFRenderer

            $o_pdf->setPage(caGetOption('pageSize', $va_template_info, 'A4'), caGetOption('pageOrientation', $va_template_info, 'portrait'), caGetOption('marginTop', $marginTop."mm", '0mm'), "0mm", '0mm', caGetOption('marginLeft', $marginLeft."mm", '0mm'));

            $va_template_info["filename"]="preview.pdf";
            $o_pdf->render($vs_content, array('stream'=> true, 'filename' => ($vs_filename = $this->view->getVar('filename')) ? $vs_filename : caGetOption('filename', $va_template_info, 'print_summary.pdf')));

            $vb_printed_properly = true;
        } catch (Exception $e) {
            $vb_printed_properly = false;
            $this->postError(3100, _t("Could not generate PDF"),"plugin labelMaker : PDF preview");
        }
        return;
    }

    public function GeneratePdf() {
        $vs_table_name = $this->request->getParameter("results", pString);
        $this->view->setVar("tableName", $vs_table_name);

        $labelContent = $this->request->getParameter("labelContent", pString);
        $paperWidth = $this->request->getParameter("paperWidth", pFloat);
        $paperHeight = $this->request->getParameter("paperHeight", pFloat);
        $nbCols = $this->request->getParameter("nbColumns", pInteger);
        $nbRows = $this->request->getParameter("nbRows", pInteger);
        $labelWidth = $this->request->getParameter("labelWidth", pFloat);
        $labelHeight = $this->request->getParameter("labelHeight", pFloat);
        $horizontalPadding = $this->request->getParameter("horizontalPadding", pFloat);
        $verticalPadding = $this->request->getParameter("verticalPadding", pFloat);
        $marginTop = $this->request->getParameter("marginTop", pFloat);
        $marginLeft = $this->request->getParameter("marginLeft", pFloat);
        $vs_content = $this->b64DecodeUnicode($labelContent);

        $this->view->setVar("measures", array(
            "paper"=>array("width"=>$paperWidth, "height"=>$paperHeight),
            "margins"=>array("top"=>$marginTop, "left"=>$marginLeft),
            "nb"=>array("cols"=>$nbCols, "rows"=>$nbRows),
            "label"=>array("width"=>$labelWidth, "height"=>$labelHeight),
            "padding"=>array("horizontal"=>$horizontalPadding, "vertical"=>$verticalPadding)
        ));
        $this->view->setVar("content", $this->b64DecodeUnicode($labelContent));

        // Get results for current search
        $resultContext = ResultContext::getResultContextForLastFind($this->getRequest(),$vs_table_name);
        $list = $resultContext->getResultList();
        $numResults = sizeof($list);
        $this->view->setVar("numResults", $numResults);
        $this->view->setVar("resultsIds", $list);
        $vs_back_text = $numResults." résultats";

        $resultsLink = ResultContext::getResultsLinkForLastFind($this->getRequest(), $vs_table_name,  $vs_back_text, '');
        $this->view->setVar("resultsLink", $resultsLink);

        $vs_content= $this->render('generate_pdf.php', true);
        $filename = "label_".$this->request->getUserID()."_".time();
        file_put_contents(__CA_APP_DIR__."/plugins/labelMaker/tmp/".$filename.".html", $vs_content);
        $command = "cd ".__CA_APP_DIR__."/plugins/labelMaker/tmp/ && wkhtmltopdf --page-size A4 --margin-bottom 0mm --margin-top ".$marginTop."mm --margin-left ".$marginLeft."mm --margin-right 0mm ".$filename.".html ".$filename.".pdf";
        exec($command, $output);
        if($output == []) {
            header("Content-type:application/pdf");
            header("Content-Disposition:attachment;filename=label.pdf");
            readfile(__CA_APP_DIR__."/plugins/labelMaker/tmp/".$filename.".pdf");
            //unlink(__CA_APP_DIR__."/plugins/labelMaker/tmp/".$filename.".html");
            unlink(__CA_APP_DIR__."/plugins/labelMaker/tmp/".$filename.".pdf");
            return;
        } else {
	        var_dump($output);die();
            // Handle errors...
        }

        return;

    }

    public function Save() {
	    //var_dump($_GET);
        $saveSettingsName = $this->request->getParameter("saveSettingsName", pString);
        $data = $this->request->getParameter("data", pString);
        $saveSettingsName = trim($saveSettingsName, "\"");
        print "Modèle enregistré sous : ".__CA_BASE_DIR__."/app/plugins/labelMaker/layouts/".$saveSettingsName;
	    file_put_contents(__CA_BASE_DIR__."/app/plugins/labelMaker/layouts/".$saveSettingsName, $data);
	    die();
    }

    public function Load() {
	    $layout = $this->request->getParameter("layout", pString);
	    //var_dump($layout);die();
	    $values = file_get_contents(__CA_BASE_DIR__."/app/plugins/labelMaker/layouts/".trim($layout));
	    print $values;
	    die();
    }
}
