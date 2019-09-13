<?php
$measures = $this->getVar("measures");
$content = $this->getVar("content");

//var_dump($content);
print "<!--\n";
var_dump($measures);
print "\n--->\n";
print "<div class='label-sheet'>";
for($h=0;$h<$measures["nb"]["rows"];$h++) {
    print "<div class='label-row'>\n";
    for ($i = 0; $i < $measures["nb"]["cols"]; $i++) {
        print "<div class='label'>" . $content . "</div>\n";
    }
    print "</div>\n";
}
print "</div>";
?>
<style>
    div.label {
        border:1px solid black;
        display:inline-block;
        width:<?php print $measures["label"]["width"]*6; //."px"; ?>px;
        height:<?php print $measures["label"]["height"]*6; //."px"; ?>px;
        margin-right:<?php print $measures["padding"]["horizontal"]*6; //."px"; ?>px;
        margin-bottom:<?php print $measures["padding"]["vertical"]*6; //."px"; ?>px;
    }
    .remove {
        display:none;
    }
    .label-sheet {
        margin-top:<?php print $measures["margins"]["top"]*6; ?>px;
        margin-left:<?php print $measures["margins"]["left"]*6; ?>px;
    }

    #bundleList {
        line-height:22px;
    }
    .bundleName {
        padding:4px;
        border-radius: 6px;
        display: block;
        font-size:14px;
        margin-bottom:3px;
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
<?php
die();