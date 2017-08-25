jQuery(document).ready(function() {
	jQuery('.square').each(function() {
    var imgWidth = jQuery(this).find('.crispgrid-image').width();
    jQuery(this).find('.crispgrid-image').height(imgWidth);
  });

  jQuery('.rectangle').each(function() {
    var imgWidth = jQuery(this).find('.crispgrid-image').width();
    var imgWidth = imgWidth * 2/3;
    jQuery(this).find('.crispgrid-image').height(imgWidth);
  });

  jQuery(window).on('resize', function(){
    jQuery('.square').each(function() {
      var imgWidth = jQuery(this).find('.crispgrid-image').width();
      jQuery(this).find('.crispgrid-image').height(imgWidth);
    });

    jQuery('.rectangle').each(function() {
      var imgWidth = jQuery(this).find('.crispgrid-image').width();
      var imgWidth = imgWidth * 2/3;
      jQuery(this).find('.crispgrid-image').height(imgWidth);
    });

    equalheight('.crispgrid');
  });
});

equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     jQueryel,
     topPosition = 0;
 jQuery(container).each(function() {

   jQueryel = jQuery(this);
   jQuery(jQueryel).height('auto')
   topPostion = jQueryel.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = jQueryel.height();
     rowDivs.push(jQueryel);
   } else {
     rowDivs.push(jQueryel);
     currentTallest = (currentTallest < jQueryel.height()) ? (jQueryel.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}

jQuery(window).load(function() {
  equalheight('.crispgrid');
});