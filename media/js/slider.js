var sl = {};

sl.ini = function(){
   var params = {}
   /* Задержка таймера*/
   params.interval = 7000;
   
   var slider = $('#slider');
   params.w =  slider.find('.wrapper').width();
   var item = slider.find('.it-slider');
   params.count = item.length;
   var full_width =  params.w * params.count;
   /**
   * Pager
   */
   var pager = '';
   for (var i = 0; i < params.count; i++) {
	        pager = pager + '<em id="p_'+ (+i + 1) +'"></em>';;
   }
   //slider.find('.wrapper').after('<label class="pager"><em class="prev" id="p_prev"></em>' + pager + '<em class="next" id="p_next"></em></label>');
   slider.find('.wrapper').after('<label class="pager">' + pager + '</label>');
   slider.prepend('<a href="#" class="prev" id="p_prev"></a><a href="#"  class="next" id="p_next"></a>')
   var em = $('.pager').width();
   //var margin = - em * (params.count + 1) ;
   var margin = - em/2 +50 ;
   $('.pager').css({'margin-left': margin});
   $('#p_1').addClass('active');
   slider.find('.wr-slider').width(full_width);
   item.width(params.w);
   return params;  
}

 sl.move = function (i, params)
{
   var wrapper = $('#slider .wr-slider');
   var w = (params.w ? params.w : 954);
   i = (i > params.count ? 1 : (i == 0 ? params.count : i) );
   $('.pager em').removeClass('active');
   $('#p_' + i).addClass('active');
   var l = -((i-1) * w);
   /*if (i == 1 && ! $.browser.msie)*/
   if (i == 1)
   {
     options = {opacity:0};
     options_h = {opacity:1};
     wrapper.stop().animate(options, 500).css({left:l}).animate(options_h,500); 
   }
   else
   {
      wrapper.stop().animate({left: l},500); 
   }
}

 sl.current = function(params)
{
    var left = $('#slider .wr-slider').position().left;
    var current = Math.round(-left/params.w) + 1;
    return current;
}

sl.anim = function(params)
{
    var next = sl.current(params) + 1;
    sl.move(next,params);
} 

$(function(){
   var cursor = {}
   var params = sl.ini();
   cursor.x_1 = 0, cursor.x_2 = 0;
   var v = 0;
   /* setInterval(function() {
    sl.anim(params);
    }, params.interval);*/
   $('#slider .pager em').click(function(){
        var ids = $(this).attr('id');
        if(ids)
        {
          var path = ids.split('_');
          var id = path[1];
          if(id == 'prev')
          {
             id = sl.current(params) - 1;
          }
          if(id == 'next')
          {
             id = sl.current(params) + 1;
          }
          sl.move(id , params);
        }  
   })
   
   $('#slider .prev').click(function(){
        var id = sl.current(params) - 1;
        sl.move(id , params);
        return !1;
   })
   
   $('#slider .next').click(function(){
        var id = sl.current(params) + 1;
        sl.move(id , params);
        return !1;
   })
   
   var it_slider = $('#slider .it-slider')
   
   it_slider.mousedown(function(e){
      cursor.x_1 = e.pageX;
      cursor.current = sl.current(params);
   })
   it_slider.mouseup(function(e){
      cursor.x_2 = e.pageX;
      v = cursor.x_2 - cursor.x_1;
      var next =  ( v > 0 ? cursor.current - 1 : cursor.current + 1);
      sl.move(next, params);
   });
   
   it_slider.bind('move',function(e){
      var  v = e.deltaX;
      var next =  ( v > 0 ? sl.current(params) - 1 : sl.current(params) + 1);
      sl.move(next, params);
   });
});