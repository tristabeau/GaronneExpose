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
                document.location.href="/";
            }
        }
    });
}

function modMembre(membre)
{
    $("#idMembre").val(membre);
    $("#formAction").attr("action", "index.php?v=admin&a=modMembre").submit();
}

function supMembre(membre)
{
    if(confirm("Voulez-vous supprimer ce membre ?")) {
        $("#idMembre").val(membre);
        $("#formAction").attr("action", "index.php?v=admin&a=supMembre").submit();
    }
}

function modArticle(article)
{
    $("#idArticle").val(article);
    $("#formAction").attr("action", "index.php?v=admin&a=modArticle").submit();
}

function supArticle(article)
{
    if(confirm("Voulez-vous supprimer cet article ?")) {
        $("#idArticle").val(article);
        $("#formAction").attr("action", "index.php?v=admin&a=supArticle").submit();
    }
}

function supCom(com, annee, mois, jour, permalien)
{
    if(confirm("Voulez-vous supprimer ce commentaire ?")) {
        $.ajax({
            type: "POST",
            url:  'ajax/supCom.php',
            async: false,
            data: "id="+com,
            success: function(result){
               document.location.href=annee+"/"+mois+"/"+jour+"/"+permalien;
            }
        });
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

function filtrerListe(cat)
{
    url = "article/liste/"+cat+"/";
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

function selectAnnee()
{
    if($("#annee").val() != "all") {
        $.ajax({
            type: "POST",
            url:  'ajax/getMois.php',
            async: false,
            data: "annee="+$("#annee").val(),
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

function selectMois()
{
    if($("#mois").val() != "all") {
        $.ajax({
            type: "POST",
            url:  'ajax/getJours.php',
            async: false,
            data: "annee="+$("#annee").val()+"&mois="+$("#mois").val(),
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


