jQuery(document).ready(function ($) {
    // allow jQuery's "containts" selector to not have to match cases
    $.expr[":"].contains = $.expr.createPseudo(function(arg) {
        return function( elem ) {
            return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
        };
    });

    // jquery filter
    $( "#custom-search" ).keyup(function() {
        $('article').removeClass('found').show();
        var singleValues = $(this).val();
        $("#results").html( "<b>Single:</b> " + singleValues);
        //$(".entry-title:contains('" + singleValues + "')" )
        //.parents('article').addClass("found");
        //$('article').not(".found").hide();
    });



//$(".entry-title").append('<span class="ui-icon ui-icon-circle-plus"></span>');


    
// $( ".ui-icon" ).toggle(function() {
//     $(this).removeClass('ui-icon-circle-plus').addClass('ui-icon-circle-minus');
//     // `this` is the DOM element that was clicked
//     var index = $( ".ui-icon" ).index( this );
//     var title = $(".list-posts li").eq(index).find('h5').text();
        
//     $( "#select-result" ).append( "<p class='" + index + "'>" + index + ": " + title + "</p>");

//     }, function() {
//     $(this).removeClass('ui-icon-circle-minus').addClass('ui-icon-circle-plus');
//     var index = $( ".ui-icon" ).index( this );
//     $('.'+index).remove();
//  });

//var index = $( "#primary" ).index( 'article' );


});