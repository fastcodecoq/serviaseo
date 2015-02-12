(function($){

	var _this;
	var element = false;
	var lock = false;
	var data = {

		 container : "#cont"

	}
	
   $.fn.sidebar = function(vars){



      if(vars instanceof Object)
      	  $.extend(data, vars);

      _this = $(this);
   	  
   	  iniPicker();
   	  listeners();

    show();

   	  console.log("sidebar plugin");
 

   }


   var show = function(){

        
         _this.css({ display : "block"});
         $(data.container).css({marginLeft : "13%"});


   }

  var hide = function(){

        
         _this.css({ display : "none" });
          $(data.container).css({marginLeft : "0"});


   }


   var set = {

   	  active : function(){
   
      			 	_this.addClass("active");
      			 	_this.removeClass("inactive");
   
   
      },
      inactive : function(){

      		      _this.addClass("inactive");
      			  _this.removeClass("active");


      },
      fullScreen : function(){

                _this.addClass("fullscreen");
              _this.removeClass("normal");


      },

      normalScreen : function(){

                _this.addClass("normal");
              _this.removeClass("fullscreen");


      }
   }


   var listeners = function(){

   	     $("a[data-action]").live("click", commands);
   	     $("*[contenteditable]").live("click", list_els)
   	     inputs_change();

   }


   var inputs_change = function(){


   		  _this.find("input[type='text']").change(change_);
   		  _this.find("input[type='hidden']").change(change_);


   }


   var change_ = function(e){


   		if(!element)
   			 return false;

   		var el = $(this);
		var what = el.attr("data-command");  
		var this_ = el.val();  	 


		if(element.attr("style"))
		{

			var style = element.attr("style");			
			    
			    style = style.split(";");

			    style.push(get_format(what,this_));

			    style = style.join(";");

		}

      var _style = (style) ? style : get_format(what, this_);


      element.attr("style", _style);
      console.log(_style);

   }

   var get_format = function(what, this_){

   	   switch(what){

   	   	 case 'background-image':

   	   	  return what + ": url(" + this_ +")";

   	   	 break;

   	   	 default:

   	   	  return  what + ":" + this_ + " !important";

   	   	 break;

   	   }

   }

   var list_els = function(e){

       	  e.stopPropagation();

   	   var el = $(this);

       //if(el.localName.toLowerCase() == "a"){

  
       	  //return false;

       //}
    
      if(!lock)
       element = el;

       console.log("element=");
       console.log(el);



   }


   var commands = function(e){

   			e.preventDefault();
   			e.stopPropagation();


   			var a = $(this);
   			var command = a.attr("data-command");


   			switch(command){

   				  case 'media':

   				    openMedios(a, function(rs, target){

   				    	  $("#thumbnail").html("<br /><img src='t/60/" + rs + "' alt='' style='max-width:60px'/>");
   				    	  target.val("f/" + rs).change();

   				    });

   				  break;

   			}


   }


  var iniPicker = function(){

  	 $("#colorpick").spectrum({
    color: "#3c78d8",
    showInput: true,
    className: "full-spectrum",
    showInitial: true,
    showPalette: true,
    showSelectionPalette: true,
    maxPaletteSize: 10,
    preferredFormat: "hex",
    localStorageKey: "spectrum.demo",
    move: function (color) {
        
    },
    show: function () {
    
    },
    beforeShow: function () {
    
    },
    hide: function () {
    
    },
    change: function() {
        
    },
    palette: [
        ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
        "rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
        ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
        "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"], 
        ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)", 
        "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)", 
        "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)", 
        "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)", 
        "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)", 
        "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
        "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
        "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
        "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)", 
        "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
    ]
});

  }


}
)(jQuery);


