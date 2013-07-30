var site = function() {
  this.navLi = $('#nav li').children('ul').hide().end();
  this.init();
};

site.prototype = {
  init : function() {
    this.setMenu();
  },
  
  // Enables the slidedown menu, and adds support for IE6
  setMenu : function() {
    $.each(this.navLi, function() {
      if ( $(this).children('ul')[0] ) {
        var arrow=$.parseHTML('<sub>↴</sub>');
        var a=$('>a:first-child',this).append(arrow);
      }
    });
  

    this.navLi.hover(function() {
        // mouseover
        $(this).find('> ul').stop(true, true).css('min-width',$(this).width()).slideDown(50, '');
        }, function() {
        // mouseout
        $(this).find('> ul').stop(true, true).slideUp(50);     
    });
    
  }
 
}

$(document).ready(function(){
  new site;
});

