<?php
$measures = $this->getVar("measures");
$content = $this->getVar("content");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
    <style type="text/css">
        @page { margin-top: <?php print $measures["margins"]["top"]; ?>; margin-left: <?php print $measures["margins"]["left"]; ?>;
        margin-bottom: 0; margin-right: 0;}
        body {margin:0;margin-top:14mm;margin-bottom:-14mm;}
    </style>
</head>
<body>
<?php
print "<div class='label-sheet'>";
for($h=0;$h<$measures["nb"]["rows"];$h++) {
    print "<div class='label-row'>\n";
    for ($i = 0; $i < $measures["nb"]["cols"]; $i++) {
        print "<div class='label'>" . $content . "\n</div>";
    }
    print "</div>\n";
}
print "</div>";
?>
<style>
    .label-row {
        padding:0;
        margin:0;
    }
    div.label {
        display:inline-block;
        border:0.2mm solid lightgrey;
        width:<?php print $measures["label"]["width"]-0.4; //."px"; ?>mm;
        height:<?php print $measures["label"]["height"]-0.4; //."px"; ?>mm;
        margin-right:<?php print $measures["padding"]["horizontal"]; //."px"; ?>mm;
        margin-bottom:<?php print $measures["padding"]["vertical"]; //."px"; ?>mm;
    }
    .remove {
        display:none;
    }
    .label-sheet {
        margin-top:<?php print $measures["margins"]["top"]?>mm;
        margin-left:<?php print $measures["margins"]["left"]; ?>mm;
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