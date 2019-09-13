<?php
$measures = $this->getVar("measures");
$template = $this->getVar("content");
$resultsIds = $this->getVar("resultsIds");
$tableName = $this->getVar("tableName");

// Initiate template contents with ^ (carret) before metadata names
$template = str_replace("<span class=\"text\">", "<span class=\"text\">^", $template);

// Remove non needed html
$template = str_replace("<span class=\"remove\">⨯</span>", "", $template);
$template = str_replace(" active resizable\" draggable=\"true\" ondragstart=\"drag(event)", "", $template);

//resultPointer
$pointer = 0;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>Test</title>
    <style type="text/css">
        body {margin:0;}
    </style>
</head>
<body>
<?php
print "<div class='label-sheet'>";
for($h=0;$h<$measures["nb"]["rows"];$h++) {
    print "<div class='label-row'>";
    for ($i = 0; $i < $measures["nb"]["cols"]; $i++) {
        $vt_item = new $tableName($resultsIds[$pointer]);
        $vs_item_content = $vt_item->getWithTemplate($template);
        print "<div class='label'>" . $vs_item_content . "\n</div>";
        $pointer++;
        if($pointer == sizeof($resultsIds)) {
            break(2);
        }
    }
    print "</div>";
}
print "</div>";
?>
<style>
    .label-row {
        padding:0;
        margin:0;
        clear:both;
        height:<?php print $measures["label"]["height"]-0.4+$measures["padding"]["vertical"]; //."px"; ?>mm;
    }
    div.label {
        border:1pt solid lightgrey;
        width:<?php print $measures["label"]["width"]-0.4; //."px"; ?>mm;
        height:<?php print $measures["label"]["height"]-0.4; //."px"; ?>mm;
        margin-right:<?php print $measures["padding"]["horizontal"]; //."px"; ?>mm;
        margin-bottom:<?php print $measures["padding"]["vertical"]; //."px"; ?>mm;
        margin-top:0;
        margin-bottom:0;
        overflow: hidden;
        display:block;
        float:left;
    }
    .remove {
        display:none;
    }
    .label-sheet {
	    margin:0;
    }

    #bundleList {
        line-height:22px;
    }
    .bundleName {
        padding:4px;
        display: block;
        margin-bottom:3px;
        width:85%;
        margin-left:5%;
    }
    .bundleName,
    .bundleName .text {
        font-family: Arial, Helvetica, sans-serif;
        color:black;
        font-size:10px;
    }

    .remove {
        display:none;
    }

    .addBold {
        font-weight: bold;
    }
    .addItalic {
        font-style:italic;
    }
    .addUnderline {
        text-decoration: underline;
    }
    .alignCenter {
        text-align: center;
    }
    .alignRight {
        text-align: right;
    }
    .alignLeft {
        text-align: left;
    }
    </style>
</body>