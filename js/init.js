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
   
});