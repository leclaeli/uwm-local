jQuery(document).ready(function ($) {

    $('.ui-icon.ui-icon-circle-plus').toggle(function () {
        $(this).removeClass('ui-icon-circle-plus').addClass('ui-icon-circle-minus');
        var index = $( ".ui-icon" ).index( this );
        var title = $(".list-posts li").eq(index);
        
        $.post(ajax_object.ajaxurl, 
        {
            action: 'ajax_action',
            post_id: $(".list-posts li").eq(index).attr('id'),
            li_index: index,
        }, function(data) {
                //alert(data); // alerts 'ajax submitted'
                //$("#select-result").append($("span").hasClass('ui-icon-circle-plus').toString());
                $( "#select-result" ).append(data);
            }
        );
    }, function() {
        $(this).removeClass('ui-icon-circle-minus').addClass('ui-icon-circle-plus');
        var index = $( ".ui-icon" ).index( this );
        $('.'+index).remove();
    }); 

/* ajax_action_search */

// $(".topic-li").prepend('<span class="ui-icon ui-icon-circle-plus"></span>');

//     $('.ui-icon.ui-icon-circle-plus').toggle(function () {
//         $(this).removeClass('ui-icon-circle-plus').addClass('ui-icon-circle-minus');
//         var index = $( ".ui-icon" ).index( this );
//         var title = $(".list-posts li").eq(index);
//         var test_array = [ 70, 71, 72];
//         $.post(ajax_object.ajaxurl, 
//         {
//             action: 'ajax_action_search',
//             post_id: $(".topic-li").eq(index-1).attr('id'),
//             li_index: index,
//             test: "test",
//             test_array: test_array,
//         }, function(data) {
//                 //alert(data); // alerts 'ajax submitted'
//                 //$("#select-result").append($("span").hasClass('ui-icon-circle-plus').toString());
//                 $( "#results" ).append(data);
//             }
//         );
//     }, function() {
//         $(this).removeClass('ui-icon-circle-minus').addClass('ui-icon-circle-plus');
//         var index = $( ".ui-icon" ).index( this );
//         $('.'+index).remove();
//     }); 

$(".topic-li a").append('<span class="ui-icon ui-icon-circle-plus"></span>');
var test_array = [];

//stop a tags from navigating to link
$('.topic-li a').click(function(e){
    e .preventDefault();
});

    $('.ui-icon.ui-icon-circle-plus').click(function () {
        // this = .ui-icon.ui-icon-circle-plus
        $(this).removeClass('ui-icon-circle-plus');

        var index = $( ".ui-icon" ).index( this );
        var title = $(".list-posts li").eq(index);
        //var post_content = $(".topic-li a").eq(index).text();
        var post_content = $('.topic-li a').eq(index).contents().get(0).nodeValue;
        $(".topic-li").eq(index).addClass('hide');
        var post_id = $(".topic-li").eq(index).attr('id');
        console.log(post_content); 
        $( "#selected-topics" ).append('<li class="'+post_id+'">' + post_content + '<span id="topics">Topics</span><span class="ui-icon ui-icon-circle-minus"></span></li>');
        
        //test_array.push(post_id);
        runAfter();

        var test_array = []
        $('.ui-icon-circle-minus').each(function() {
            var post_id = $(this).parent().attr('class');
            console.log(post_id);
            test_array.push(post_id);
            console.log(test_array);
        });
        $.post(ajax_object.ajaxurl, 
        {
            action: 'ajax_action_search',
            test: "test",
            test_array: test_array,
        }, function(data) {
                //alert(data); // alerts 'ajax submitted'
                //$("#select-result").append($("span").hasClass('ui-icon-circle-plus').toString());
                $( "#results .inner-results" ).remove();
                $( "#results" ).append(data);
        });
        
    });

    // this = .ui-icon.ui-icon-circle-plus
    function runAfter() {
        $('#selected-topics .ui-icon-circle-minus').click(function() {
            var selected_post_id = $(this).parent().attr('class');
            $('#list-topics #' +selected_post_id).removeClass('hide');
            var add_plus = $('#list-topics #' + selected_post_id + ' a .ui-icon');
            add_plus.addClass('ui-icon-circle-plus');
            $(this).parent().remove();


            var test_array = []
        $('.ui-icon-circle-minus').each(function() {
            var post_id = $(this).parent().attr('class');
            //console.log(post_id);
            test_array.push(post_id);
            //console.log(test_array);
        });
        if (test_array.length === 0) {
            $( "#results .inner-results" ).remove();
        } else {
            $.post(ajax_object.ajaxurl, 
        {
            action: 'ajax_action_search',
            test: "test",
            test_array: test_array,
        }, function(data) {
                console.log(data); // alerts any data that is submitted
                //$("#select-result").append($("span").hasClass('ui-icon-circle-plus').toString());
                $( "#results .inner-results" ).remove();
                $( "#results" ).append(data);
        });
        }
        
            
            //$(this).addClass('ui-icon-circle-plus');
            //var index = $( ".ui-icon" ).index( this );
           // var post_id = $(".topic-li").eq(index).attr('id');
            //console.log(index);
           
            //console.log(test_array);
        });
    }
    
        


    // $('#submit-names').click(function() {
    //     var test_array = []
    //     $('.ui-icon-circle-minus').each(function() {
    //         var post_id = $(this).parent().attr('class');
    //         console.log(post_id);
    //         test_array.push(post_id);
    //         console.log(test_array);
    //     });
    //     $.post(ajax_object.ajaxurl, 
    //     {
    //         action: 'ajax_action_search',
    //         test: "test",
    //         test_array: test_array,
    //     }, function(data) {
    //             //alert(data); // alerts 'ajax submitted'
    //             //$("#select-result").append($("span").hasClass('ui-icon-circle-plus').toString());
    //             $( "#results .inner-results" ).remove();
    //             $( "#results" ).append(data);
    //     });
    // });
});
