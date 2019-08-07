<h1>Label Maker</h1>
<div id="bundleList">
	<div class="bundleName" draggable="true" ondragstart="drag(event)" id="bundleName_preferred_labels">Preferred labels <span class="remove">⨯</span></div>
	<div class="bundleName" draggable="true" ondragstart="drag(event)" id="bundleName_idno">IDNO <span class="remove">⨯</span></div>
	<div class="bundleName" draggable="true" ondragstart="drag(event)" id="bundleName_description">Description <span class="remove">⨯</span></div>
	<div class="bundleName" draggable="true" ondragstart="drag(event)" id="bundleName_ca_entities">ca_entities <span class="remove">⨯</span></div>
</div>
<table style="margin-top:30px;">
	<tr><td></td><td style="text-align: center"><input type="text" id="labelWidth" style="width:40px;text-align:center;" value="400"/></td></tr>
	<tr><td><input type="text" id="labelHeight" style="width:40px;text-align:center;" value="300"/></td><td><div id="preview" ondrop="drop(event)" ondragover="allowDrop(event)"></div></td></tr>
</table>
<style>
	.bundleName {
		border:1px solid #ddd;
		background-color: #eee;
		color:#666;
		padding:12px;
		border-radius: 6px;
		display: inline;
		font-size:11px;
	}
	.remove {
		display:none;
	}

	#preview {
		width:400px;
		height:300px;
		border:1px solid;
		padding:20px;
	}

	#preview .bundleName {
		display: block;
	}
	#preview .remove {
		display: inline-block;
		float:right;
		cursor:pointer;
	}
</style>
<script>
    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        ev.target.appendChild(document.getElementById(data));
    }

    $("#labelWidth").on("blur", function() {
       $("#preview").width($(this).val()+"px");
	});

    $("#labelHeight").on("blur", function() {
        $("#preview").height($(this).val()+"px");
    });
    $(document).ready(function() {
        $("#preview").width($("#labelWidth").val()+"px");
        $("#preview").height($("#labelHeight").val()+"px");
	});
	$(".remove").on("click", function() {
	    $("#bundleList").append($(this).parent());
	});
</script>
