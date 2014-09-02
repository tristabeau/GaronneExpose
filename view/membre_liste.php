<div id="listMembre">
    <div id="lmembre">
        <form name="formAction" method="post" action="" id="formAction">
            <input type="hidden" name="idMembre" id="idMembre" value="" />
        </form>       
    
        <button class="btn btn-primary" id="bmembre" form="formAction" formaction="index.php?v=admin&a=newArtiste">Créer un artiste</button>
        
        <div id='search'>
            <label for='filter' id='filterSearch' >Recherche : </label>
            <input id='filter' name='filter' type='text'>
        </div>
    </div>

    <br />
    <br />

    <?php echo $table; ?>
   
    <br />
    <br />
   
</div>

<script type="text/javascript">

    +function ($) { "use strict"; 
        var groupes = new Array;
        $.ajax({ 
            url: "ajax/getGroupes.php", 
            dataType: 'json', 
            async: false,
            success: function(data)
            {
                groupes = data;
            }
        });
        
        $.fn.editable.defaults.mode = 'inline';
        $('.editGroupe').editable({
            source : groupes,
            type   : 'select',
            url: 'ajax/updateGroupe.php',
            title: 'Groupe',
            showbuttons: false
        });
        
    } (jQuery);
    
</script>                    
