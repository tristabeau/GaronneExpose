$(function() {  
    $('#nav ul li a').each(function(){
        var path = window.location.href;
        var current = path.substring(path.lastIndexOf('/')+1);
        var url = $(this).attr('href').substring($(this).attr('href').lastIndexOf('/')+1);
        
        $(this).parent().first().removeClass('current_page_item');
        
        if ( url == "index.php") {
            if (current == url) {
                $(this).parent().first().addClass('current_page_item');
            } 
        } else  if (current.indexOf(url) == 0) {
            $(this).parent().first().addClass('current_page_item');
        }
    });  
    
    $(".rslides").responsiveSlides();
    
    $('.datepicker').appendDtpicker({
		"locale": "fr",
        'minuteInterval' : 15,
        'firstDayOfWeek' : 1,
        'closeOnSelected' : true,
        "futureOnly": true
	});   
    
    $('#selectDate').appendDtpicker({
		"locale": "fr",
        "dateOnly": true,
        'firstDayOfWeek' : 1,
        'closeOnSelected' : true
	});

    $.fn.editable.defaults.mode = 'inline';
    $('.footable').footable().on({
        'footable_resized' : function(e) {
            $('.editCommentaire').editable({
                type: 'text',
                url: 'ajax/updateCommentaire.php',
                title: 'Commentaire',
                maxlength: 50
            });
		},
        'footable_row_expanded' : function(e) {
            $('.editCommentaire').editable({
                type: 'text',
                url: 'ajax/updateCommentaire.php',
                title: 'Commentaire',
                maxlength: 50
            });
		},
    });
    
    $("#carousel").owlCarousel({
        items : 5
    });    
    
    $('.linkRoster').on('click', function(event){
        $("#selectJeu").val($(this).attr("id"));
        $('#formSelectJeu').submit();        
    });
    
    var kal = $('.kalendar').kalendar({ 
        events: [],
        monthHuman: [["JAN","Janvier"],["FEV","Février"],["MAR","Mars"],["Avr","Avril"],["MAI","Mai"],["JUIN","Juin"],["JUIL","Juillet"],["AOU","Août"],["SEP","Septembre"],["OCT","Octobre"],["NOV","Novembre"],["DEC","Décembre"]],
        dayHuman: [["D","Dimanche"],["L","Lundi"],["Ma","Mardi"],["Me","Mercredi"],["J","Jeudi"],["V","Vendredi"],["S","Samedi"]],
        urlText: "Détail",
		color: "black",
		eventcolors: {
			yellow: {
				background: "#FC0",
				text: "#000",
				link: "#000"
			},
			blue: {
				background: "#6180FC",
				text: "#FFF",
				link: "#FFF"
			}
		}
	});
    
    $( "#ex" ).autocomplete({
      minLength: 2,
      source: function( request, response ) {
        var term = request.term;
        if ( term in cache ) {
          response( cache[ encodeURIComponent(term.label) ] );
          return;
        }
 
        $.getJSON( "ajax/getMembre.php", request, function( data, status, xhr ) {
          cache[ term ] = data;
          response( data );
        });
      },
      select: function( event, ui ) {
        $("#selectMembreId").val(ui.item.value);
        $("#selectMembre").val(ui.item.label);
      }
    });
    
    $("#selectMembre").autocomplete({
        minLength: 2,
        source: function(req, add){
          $.ajax({
                url:'ajax/getMembre.php',
                type:"post",
                dataType: 'json',
                data: 'name='+req.term,
                async: true,
                cache: true,
                success: function(data){
                    var suggestions = [];  
                    //process response  
                    $.each(data, function(i, val){  
                        suggestions.push({"id": val.id, "value": val.value});  
                    });  
                    //pass array to callback  
                    add(suggestions); 
                }
            });
       },
       select: function( event, ui ) {
            $("#selectMembreId").val(ui.item.id);
      }
    });
   
});