<?php
    $display_label = $this->getVar("display_label");
    $placements = $this->getVar("placements");
    $display_id = $this->getVar("display_id");
    $layouts = $this->getVar("layouts");
    $bundles = $this->getVar("bundles");
    $numResults = $this->getVar("numResults");
    $resultsLink = $this->getVar("resultsLink");
$vs_table_name = $this->getVar("tableName");

?>
<script src="https://kit.fontawesome.com/03715dce34.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<h1>Création d'un format d'étiquette</h1>
<p>Mise en page : <u>absolue</u> (glisser/redimensionner/positionner) - <a href="<?php print __CA_URL_ROOT__."/index.php/labelMaker/Models/Create/results/".$vs_table_name; ?>">basculer en mise en page relative (suite de blocs)</a></p>

<p>Recherche courante : <?php print $resultsLink; ?></p>
<hr/>
<div id="bundleList">
    <?php foreach($bundles as $tablename => $table_settings): ?>
        <div class="bundleGroup"><b><?php print ( $table_settings["options"]["title"] ? : $tablename); ?></b></div>
        <?php foreach($table_settings["available_bundles"] as $bundle=>$settings):?>
	    <div class="bundleName" draggable="true" ondragstart="drag(event)" id="bundleName_<?php print $tablename."_".$bundle; ?>">
            <span class="text"><?php print $tablename.".".$bundle; ?></span> <span class="remove">⨯</span>
        </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>

<form id="formPreviewSettings" method="post" action="<?php print __CA_URL_ROOT__."/index.php/labelMaker/Models/Preview"; ?>" target="_blank">
    <input type="hidden" name="display" value="<?php print $display_id; ?>" />
    <span>Charger le format</span>
    <select id="labelList">
        <option value=""> </option>
        <?php foreach($layouts as $key=>$layout) : ?>
            <option value="<?php print $layout; ?>"><?php print $layout ?></option>
        <?php endforeach; ?>
    </select>
    <button id="loadLabelSettings">Charger</button> <button id="showOptions">Réglages avancés</button><br/>
    <div id="options">
    Enregistrer sous <input id="saveSettingsName" name="saveSettingsName" type="text" placeholder="référence d'étiquette" style="" /> <button id="saveSettings">Enregistrer</button>



    <div class="dimensionInput">
        <table>
            <tr>
                <td></td>
            </tr>
        </table>
        Format du papier <input type="text" id="paperWidth" name="paperWidth" style="width:40px;text-align:center;" value="210"/> x <input type="text" id="paperHeight" name="paperHeight" style="width:40px;text-align:center;" value="297"/> mm — <input type="text" id="nbColumns" name="nbColumns" style="width:40px;text-align:center;" value="2"/> colonnes <input type="text" id="nbRows" name="nbRows" style="width:40px;text-align:center;" value="10"/> lignes
    — Marges du bord de page <input type="text" id="marginTop" name="marginTop" style="width:40px;text-align:center;" value="10"/> mm du haut — <input type="text" id="marginLeft" name="marginLeft" style="width:40px;text-align:center;" value="10"/> mm du bord gauche</div>
    </div>
    <table style="margin-top:30px;">
        <tr>
            <td></td>
            <td style="text-align: center"><span class="dimensionInput"><input type="text" id="labelWidth" class="refreshOnBlur" name="labelWidth" style="width:40px;text-align:center;" value="40"/> mm</span></td>
            <td style="text-align: center" class="horizontalSeparator">
            </td>
            <td>
                <span class="dimensionInput"><input type="text" id="horizontalPadding" class="refreshOnBlur" name="horizontalPadding" style="width:20px;text-align:center;" value="5" /> mm</span>
            </td>
        </tr>
	    <tr>
            <td><span class="dimensionInput"><input type="text" id="labelHeight" class="refreshOnBlur" name="labelHeight" style="width:40px;text-align:center;" value="30"/> mm</span></td>
            <td style="border:1px solid;" id="previewTD">&nbsp;</td>
            <td id="horizontalPaddingDisplay"  class="horizontalSeparator" style="background-color:#eee;"></td>
            <td style="border:1px solid black;border-right:none;height:8px;"></td>
            <td style="width:8px;"></td>
            <td class="" style="vertical-align: top;text-align: left;padding-top:20px;">
            </td>

        </tr>
        <tr class="verticalSeparator">
            <td></td>
            <td class="verticalPaddingDisplay" style="background-color:#eee;"></td>
            <td class="verticalPaddingDisplay" class="horizontalSeparator" style="background-color:#eee;"></td>
            <td class="verticalPaddingDisplay" style="background-color:#eee;"></td>
        </tr>
        <tr>
            <td><span class="dimensionInput"><input type="text" id="verticalPadding" class="refreshOnBlur" name="verticalPadding" style="width:20px;text-align:center;" value="5"/> mm</span></td>
            <td style="border:1px solid black;border-bottom:none;height:8px;"></td>
            <td style="background-color:#eee;"  class="horizontalSeparator"></td>
            <td style="border:1px solid black;border-bottom:none;border-right:none;height:8px;"></td>
        </tr>
    </table>
    <p>&nbsp;</p>
    <div class="layoutButtons">
        <button id="boldButton" style="font-weight: bolder">B</button><button id="italicButton" style="font-style: italic">I</button><button id="underlineButton" style="text-decoration: underline">U</button><button id="alignLeftButton"><i class="fas fa-align-left"></i></button><button id="alignCenterButton"><i class="fas fa-align-center"></i></button><button id="alignRightButton"><i class="fas fa-align-right"></i></button>
    </div>
    <div id="preview" style="position:relative;" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <textarea id="labelContent" name="labelContent" style="display:none;width:100%;height:400px;"></textarea>
    <p>&nbsp;</p>


<p>
    <button id="formPreviewSettingsSubmit">Aperçu HTML</button>
    <button id="formPDFPreviewSettingsSubmit">Aperçu PDF</button>

</p>

</form>

<style>
    #formPreviewSettings button {
        background-color: #1ab3c8;
        border-radius: 6px;
        padding: 8px;
        margin-right: 10px;
        color: white;
        border: none;
    }
    .layoutButtons {
        /*display: none;*/
    }
    #formPreviewSettings .layoutButtons button {
        margin-right: 0;
    }
    tr.hidden td,
    tr td.hidden {
        display: none;
    }
    #options {
        display:none;
        padding: 12px;
        background-color: #eee;
        border: 1px solid #e5e5e5;
        margin-top: 10px;
    }
    .dimensionInput {
        font-size:0.8em;
    }
    #bundleList {
        line-height:22px;
    }
	.bundleName {
		border:1px solid #ddd;
		background-color: #ddd;
		padding:4px;
		border-radius: 6px;
		display: block;
        margin-bottom:3px;
        width:85%;
        margin-left:5%;
	}
    .bundleName,
    .bundleName .text {
        font-family: Arial, Helvetica, sans-serif;
        color:#666;
        font-size:10px;
    }

    .bundleName.active {
        background-color: rgba(28, 157, 178, 0.37);
    }

    #leftNavSidebar .bundleName {
        background-color: #eee;
    }
	.remove {
		display:none;
	}

	#preview {
		width:400px;
		height:300px;
		padding:20px;
        box-shadow: inset 0px 0px 4px 4px lightgrey ;
	}

	#preview .bundleName {
		display: block;
	}
	#preview .remove {
		display: inline-block;
		float:right;
		cursor:pointer;
        font-size: 1.5em;
        margin-top: -5px;
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
    .layoutButtons button {
        width:24px;
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

    .dimensionInput {
        display:none;
    }

    .box {
        margin: 40px;
        box-shadow: 5px 5px 10px #535353;
        border: 1px silver;
        border-radius: 4px;
        position: relative;
        width: 500px;
        height: 400px;
        overflow: hidden;
        /* limit size with min/max-width/height*/
        min-height: 100px;
        min-width: 200px;
        max-width: 999px;
        max-height: 800px;
    }

    .boxheader {
        background: #535353;
        color: white;
        padding: 5px;
    }

    .boxbody {
        font-size: 24pt;
        padding: 20px;
    }

    .win-size-grip {
        position: absolute;
        width: 16px;
        height: 16px;
        padding: 4px;
        bottom: 0;
        right: 0;
        cursor: nwse-resize;
        background: url(https://raw.githubusercontent.com/RickStrahl/jquery-resizable/master/assets/wingrip.png) no-repeat;
    }

    pre {
        margin: 20px;
        padding: 10px;
        background: #eee;
        border: 1px solid silver;
        border-radius: 4px;
    }


    .resizable {
        resize: both;   /* Options: horizontal, vertical, both */
        overflow: auto; /* fix for Safari */
    }

</style>
<script>

    function b64EncodeUnicode(str) {
        // first we use encodeURIComponent to get percent-encoded UTF-8,
        // then we convert the percent encodings into raw bytes which
        // can be fed into btoa.
        return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
            function toSolidBytes(match, p1) {
                return String.fromCharCode('0x' + p1);
            }));
    }
    function b64DecodeUnicode(str) {
        // Going backwards: from bytestream, to percent-encoding, to original string.
        return decodeURIComponent(atob(str).split('').map(function(c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));
    }
    $.fn.deserialize = function (serializedString)
    {
        var $form = $(this);
        $form[0].reset();
        serializedString = serializedString.replace(/\+/g, '%20');
        var formFieldArray = serializedString.split("&");
        //$populateFeedback.slideDown().html('');
        $.each(formFieldArray, function(i, pair){
            var nameValue = pair.split("=");
            var name = decodeURIComponent(nameValue[0]);
            var value = decodeURIComponent(nameValue[1]);
            // Find one or more fields
            var $field = $form.find('[name=' + name + ']');
            //$populateFeedback.append('<li>' + name + ' = ' + value + '</li>');

            if ($field[0].type == "radio"
                || $field[0].type == "checkbox")
            {
                var $fieldWithValue = $field.filter('[value="' + value + '"]');
                var isFound = ($fieldWithValue.length > 0);
                if (!isFound && value == "on") {
                    $field.first().prop("checked", true);
                } else {
                    $fieldWithValue.prop("checked", isFound);
                }
            } else {
                $field.val(value);
            }
        });
    }

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
        $(".active").removeClass("active");
        $("#"+ev.target.id).addClass("active");
        $("#"+ev.target.id).addClass("resizable");
    }

    function drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        ev.target.appendChild(document.getElementById(data));
        console.log(ev);
        console.log("coordonnées haut gauche boîte : "+jQuery("div#preview").offset().top+","+jQuery("div#preview").offset().left);
        console.log("coordonnées bas droite boîte : "+(jQuery("div#preview").offset().top+jQuery("div#preview").width())+","+(jQuery("div#preview").offset().left+jQuery("div#preview").height()));
        jQuery("#"+data).css("position","absolute");
        jQuery("#"+data).css("left",ev.layerX-(jQuery("#"+data).width()/2));
        jQuery("#"+data).css("top",ev.layerY);
        //var coordtop = ev.x - jQuery("div#preview").offset().top;
        //var coordleft = jQuery("div#preview").offset().left - ev.clientY;
        //console.log(coordtop);
        //console.log(coordleft);
        //
        //jQuery("#"+data).css("left",coordleft);
        //jQuery("#"+data).css("top",coordtop);
    }

    $(".refreshOnBlur").on("blur", function() {
       refresh();
	});
    var refresh = function() {
        $("#previewTD").width($("#labelWidth").val()+"px");
        $("#preview").width($("#labelWidth").val()*6+"px");
        $("#previewTD").height($("#labelHeight").val()+"px");
        $("#preview").height($("#labelHeight").val()*6+"px");
        if($("#verticalPadding").val() == "0") {
            $(".verticalSeparator").addClass("hidden");
        } else {
            $(".verticalPaddingDisplay").height($("#verticalPadding").val()+"px");
            $(".verticalSeparator").removeClass("hidden");
        }
        if($("#horizontalPadding").val() == "0") {
            $(".horizontalSeparator").addClass("hidden");
        } else {
            $("#horizontalPaddingDisplay").width($("#horizontalPadding").val()+"px");
            $(".horizontalSeparator").removeClass("hidden");
        }
        $("#labelContent").text(b64EncodeUnicode($("#preview").html()));
    }
    $(document).ready(function() {
        refresh();
	});
    $("#preview").on("mouseout", function() {
        refresh();
    });
	$(".remove").on("click", function() {
	    $("#bundleList").append($(this).parent());
	});

	$("#formPreviewSettingsSubmit").on("click", function() {
        $("#formPreviewSettings").submit();

    });
	$("#boldButton").on("click", function(event) {
        event.preventDefault();
	    $(".active").toggleClass("addBold");
    })
    $("#italicButton").on("click", function(event) {
        event.preventDefault();
        $(".active").toggleClass("addItalic");
    })
    $("#underlineButton").on("click", function(event) {
        event.preventDefault();
        $(".active").toggleClass("addUnderline");
    })
    $("#alignLeftButton").on("click", function(event) {
        event.preventDefault();

        $(".active").removeClass("alignRight");
        $(".active").removeClass("alignCenter");
        $(".active").addClass("alignLeft");
    })
    $("#alignCenterButton").on("click", function(event) {
        event.preventDefault();
        $(".active").removeClass("alignLeft");
        $(".active").removeClass("alignRight");
        $(".active").addClass("alignCenter");
    })
    $("#alignRightButton").on("click", function(event) {
        event.preventDefault();
        $(".active").removeClass("alignLeft");
        $(".active").removeClass("alignCenter");
        $(".active").addClass("alignRight");
    })

    $(document).on("click", "#preview .bundleName span.text", function() {
        $(this).parent().toggleClass("active");
        $(this).parent().toggleClass("resizable");
        refresh();
    });

    $("#leftNavSidebar").append($("<h3>Conteneurs disponibles</h3>"));
	$("#leftNavSidebar").append($("#bundleList"));

    $('#saveSettings').on("click", function(event){
        event.preventDefault();
        if($("#saveSettingsName").val() === "") {
            alert("Merci de donner une référence à votre format d'étiquette.");
        } else {
            serializedString = $("#formPreviewSettings").serialize();
            $.ajax({
                type: "POST",
                url : "<?php print __CA_URL_ROOT__ . '/index.php/labelMaker/Models/Save'; ?>",
                data: {
                    "data":serializedString,
                    "saveSettingsName":$("#saveSettingsName").val()
                },
                success: function (result) {
                    console.log("save : success");
                }
            });
        }

    });

    $("#loadLabelSettings").on("click", function(event) {
        event.preventDefault();
        console.log("<?php print __CA_URL_ROOT__ . '/index.php/labelMaker/Models/Load/layout/'; ?>"+$("#labelList").val());
        $.ajax({
            type: "GET",
            url : "<?php print __CA_URL_ROOT__ . '/index.php/labelMaker/Models/Load/layout/'; ?>"+$("#labelList").val(),
            success: function (result) {
                console.log("load : success");
                $("#formPreviewSettings").deserialize(result);
                var regex = / /gi
                $("#labelContent").val($("#labelContent").val().replace(regex,"+"));
                window.setTimeout(function() {
                    $("#preview").html(b64DecodeUnicode($("#labelContent").val()));
                    refresh();
                }, 250);

                //refresh();
            }
        });
    })
    $("#formPDFPreviewSettingsSubmit").on("click", function(event) {
        event.preventDefault();
        $("#formPreviewSettings").attr("action", "<?php print __CA_URL_ROOT__."/index.php/labelMaker/Models/PreviewPdf"; ?>");
        $("#formPreviewSettings").submit();
    });
    $("#formPreviewSettingsSubmit").on("click", function(event) {
        event.preventDefault();
        $("#formPreviewSettings").attr("action", "<?php print __CA_URL_ROOT__."/index.php/labelMaker/Models/Preview"; ?>");
        $("#formPreviewSettings").submit();
    });

    $('#showOptions').on("click", function(event) {
        event.preventDefault();
       $('.dimensionInput').toggle();
       $('#options').toggle();
    });
</script>
