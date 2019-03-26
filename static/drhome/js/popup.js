$(function() {
    //alert($(window).height());
    $('#ClickMe').click(function() {
        $('#code').center();
        $('#goodcover').show();
        $('#code').fadeIn();
    });
	
	$('#closebt1').click(function() {
        $('.csm1').hide();
    });

	$('#goodcover').click(function() {
        $('#code').hide();
        $('#goodcover').hide();
    });
	
	$('.sm1').click(function() {
        $('.csm1').center();
        $('#goodcover').show();
        $('.csm1').fadeIn();
    });
	
	
	
	$('#goodcover').click(function() {
        $('#csm1').hide();
        $('#goodcover').hide();
    });
    /*var val=$(window).height();
	var codeheight=$("#code").height();
    var topheight=(val-codeheight)/2;
	$('#code').css('top',topheight);*/
    jQuery.fn.center = function(loaded) {
        var obj = this;
        body_width = parseInt($(window).width());
        body_height = parseInt($(window).height());
        block_width = parseInt(obj.width());
        block_height = parseInt(obj.height());

        if (!loaded) {

            obj.css({
                'position': 'fixed'
            });
            obj.css({
                'bottom':0,
            });
            $(window).bind('resize', function() {
                obj.center(!loaded);
            });
            $(window).bind('scroll', function() {
                obj.center(!loaded);
            });

        } else {
            obj.stop();
            obj.css({
                'position': 'fixed'
            });
            obj.animate({
                'bottom':0
            });
        }
    }

})