function modCat(cat)
{
    $("#idCategorie").val(cat);
    $("#formAction").attr("action", "index.php?v=admin&a=modCat").submit();
}

function supCat(cat)
{
    if(confirm("Voulez-vous supprimer cette catégorie ?")) {
        $("#idCategorie").val(cat);
        $("#formAction").attr("action", "index.php?v=admin&a=supCat").submit();
    }
}

function Annuler()
{
    $("#butAction").html("Créer le groupe");
    $("#nom").val("");
}

function AnnulerPresse()
{
    $("#fileName").val("Fichier...");
}

function modGroupe(groupe, nom)
{
    $("#idGroupe").val(groupe);
    $("#nom").val(nom);
    $("#butAction").html("Modifier le groupe");
}

function supGroupe(groupe)
{
    if(confirm("Voulez-vous supprimer ce groupe ?")) {
        $("#idGroupe").val(groupe);
        $("#formAction").attr("action", "index.php?v=admin&a=supGroupe").submit();
    }
}

function supPresse(presse)
{
    if(confirm("Voulez-vous supprimer cette revue de presse ?")) {
        $("#idPresse").val(presse);
        $("#formAction").attr("action", "index.php?v=admin&a=supPresse").submit();
    }
}

function connexion()
{
    $.ajax({
        type: "POST",
        url:  'ajax/connexion.php',
        async: false,
        data: "login="+$("#login").val()+"&password="+$("#password").val(),
        success: function(result){
            if (result == "0") {
                $("#erreurId").show("slow").delay(4000).hide("slow");
            }  else if (result == "1") {
                $("#erreurActive").show("slow").delay(4000).hide("slow");
            } else {
                document.location.href="index.php";
            }
        }
    });
}

function modMembre(membre)
{
    $("#idMembre").val(membre);
    $("#formAction").attr("action", "index.php?v=admin&a=modArtiste").submit();
}

function supMembre(membre)
{
    if(confirm("Voulez-vous supprimer ce membre ?")) {
        $("#idMembre").val(membre);
        $("#formAction").attr("action", "index.php?v=admin&a=supArtiste").submit();
    }
}
function modPartenaire(partenaire)
{
    $("#idPartenaire").val(partenaire);
    $("#formAction").attr("action", "index.php?v=admin&a=modPartenaire").submit();
}

function supPartenaire(partenaire)
{
    if(confirm("Voulez-vous supprimer ce partenaire ?")) {
        $("#idPartenaire").val(partenaire);
        $("#formAction").attr("action", "index.php?v=admin&a=supPartenaire").submit();
    }
}

function modArticle(article)
{
    $("#idArticle").val(article);
    $("#formAction").attr("action", "index.php?v=admin&a=modContenu").submit();
}

function supArticle(article)
{
    if(confirm("Voulez-vous supprimer cet article ?")) {
        $("#idArticle").val(article);
        $("#formAction").attr("action", "index.php?v=admin&a=supContenu").submit();
    }
}

function selectGroupe(groupe)
{
    document.location.href="staff/"+groupe;
}

function search(search)
{
    document.location.href="recherche/"+search;
}

function filtrerSearch(search)
{
    url = "recherche/";
    if ($("#annee").val() != "all"){
        url += $("#annee").val()+"/";
        
        if ($("#mois").val() != "all"){
            url += $("#mois").val()+"/";
            
            if ($("#jours").val() != "all"){
                url += $("#jours").val()+"/";        
            }
        }
    }
    
    url += search+"/"
    
    $("#formFiltres").attr("action", url).submit();
}

function filtrerListeEvenement()
{
    url = "evenements/";
    if ($("#annee").val() != "all"){
        url += $("#annee").val()+"/";
        
        if ($("#mois").val() != "all"){
            url += $("#mois").val()+"/";
            
            if ($("#jours").val() != "all"){
                url += $("#jours").val()+"/";        
            }
        }
    }
    
    $("#formFiltres").attr("action", url).submit();
}

function filtrerListe()
{
    url = "contenus/liste/";
    if ($("#annee").val() != "all"){
        url += $("#annee").val()+"/";

        if ($("#mois").val() != "all"){
            url += $("#mois").val()+"/";

            if ($("#jours").val() != "all"){
                url += $("#jours").val()+"/";
            }
        }
    }

    $("#formFiltres").attr("action", url).submit();
}

function filtrerProfil(pseudo)
{
    url = "profil/"+pseudo+"/";
    if ($("#annee").val() != "all"){
        url += $("#annee").val()+"/";
        
        if ($("#mois").val() != "all"){
            url += $("#mois").val()+"/";
            
            if ($("#jours").val() != "all"){
                url += $("#jours").val()+"/";        
            }
        }
    }
    
    $("#formFiltres").attr("action", url).submit();
}

function selectAnnee(cat)
{
    if($("#annee").val() != "all") {
        $.ajax({
            type: "POST",
            url:  'ajax/getMois.php',
            async: false,
            data: "annee="+$("#annee").val()+"&cat="+cat,
            success: function(result){
                $("#mois").html(result);
                $("#mois").prop("disabled", false);
            }
        });
    } else {
        $("#mois").prop("disabled", true);
        $("#mois").val("all");
    }

    $("#jours").prop("disabled", true);
    $("#jours").val("all");
}

function selectMois(cat)
{
    if($("#mois").val() != "all") {
        $.ajax({
            type: "POST",
            url:  'ajax/getJours.php',
            async: false,
            data: "annee="+$("#annee").val()+"&mois="+$("#mois").val()+"&cat="+cat,
            success: function(result){
                $("#jours").html(result);
                $("#jours").prop("disabled", false);
            }
        });
    } else {
        $("#jours").prop("disabled", true);
        $("#jours").val("all");
    }
}

function selectAnneeSearch(search)
{
    if($("#annee").val() != "all") {
        $.ajax({
            type: "POST",
            url:  'ajax/getMoisSearch.php',
            async: false,
            data: "annee="+$("#annee").val()+"&search="+search,
            success: function(result){
                $("#mois").html(result);
                $("#mois").prop("disabled", false);
            }
        });
    } else {
        $("#mois").prop("disabled", true);
        $("#mois").val("all");
        $("#jours").prop("disabled", true);
        $("#jours").val("all");
    }
}

function selectMoisSearch(search)
{
    if($("#mois").val() != "all") {
        $.ajax({
            type: "POST",
            url:  'ajax/getJoursSearch.php',
            async: false,
            data: "annee="+$("#annee").val()+"&mois="+$("#mois").val()+"&search="+search,
            success: function(result){
                $("#jours").html(result);
                $("#jours").prop("disabled", false);
            }
        });
    } else {
        $("#jours").prop("disabled", true);
        $("#jours").val("all");
    }
}

function selectAnneeProfil(profil)
{
    if($("#annee").val() != "all") {
        $.ajax({
            type: "POST",
            url:  'ajax/getMoisProfil.php',
            async: false,
            data: "annee="+$("#annee").val()+"&profil="+profil,
            success: function(result){
                $("#mois").html(result);
                $("#mois").prop("disabled", false);
            }
        });
    } else {
        $("#mois").prop("disabled", true);
        $("#mois").val("all");
        $("#jours").prop("disabled", true);
        $("#jours").val("all");
    }
}

function selectMoisProfil(profil)
{
    if($("#mois").val() != "all") {
        $.ajax({
            type: "POST",
            url:  'ajax/getJoursProfil.php',
            async: false,
            data: "annee="+$("#annee").val()+"&mois="+$("#mois").val()+"&profil="+profil,
            success: function(result){
                $("#jours").html(result);
                $("#jours").prop("disabled", false);
            }
        });
    } else {
        $("#jours").prop("disabled", true);
        $("#jours").val("all");
    }
}


