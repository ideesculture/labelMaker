<?php
    $pa_displays = $this->getVar("display_list");
    $o_dm = Datamodel::load();

    function sortByName($a, $b) {
        return strcmp(strtolower($a['name']),strtolower($b['name']));
    }
usort($pa_displays, 'sortByName');
?>

<h1>Affichages disponibles</h1>

<?php foreach($pa_displays as $display_id=>$display) :
    //var_dump($display);

?>
    <a class="display_button_selector" href="<?php print __CA_URL_ROOT__."/index.php/labelMaker/Models/Create/display/".$display["display_id"] ;?>"><?php print $display["name"]; ?> <small>[<?php print $o_dm->getTableProperty($display["table_num"],"NAME_SINGULAR"); ?>]</small></a>
<?php endforeach; ?>

<style>
    .display_button_selector {
        background-color: #eee;
        padding:10px;
        border-radius: 6px;
        border:none;
        margin-bottom: 4px;
        display: block;
        color:black !important;
        text-decoration: none !important;
    }
</style>
