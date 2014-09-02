<!-- SEARCH WIDGET ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<form class="navbar-form navbar-right" role="search">
    <label class="sr-only" for="top_search_form">Recherche</label>
    <input id="top_search_form" type="text" placeholder="Recherche" onkeypress="if (event.keyCode == 13) {$('#searchBut').click(); return false;}" value="<?php echo(isset($_GET["s"]) ? $_GET["s"] : ""); ?>" />

    <button type="button" id="searchBut" onclick="search($('#top_search_form').val());">
        <span class="fa fa-search"></span>
        <span class="sr-only">Chercher</span>
    </button>
</form>  