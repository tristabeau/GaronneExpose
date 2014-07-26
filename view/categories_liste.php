<div>
    <form name="formAction" method="post" action="" id="formAction">
        <input type="hidden" name="idCategorie" id="idCategorie" />
    </form>
    
    <button class="btn btn-primary" form="formAction" formaction="index.php?v=admin&a=newCat">Créer une catégorie</button>

    <br />
    <br />

    <?php echo $table; ?>
   
    <br />
    <br />
   
</div>
