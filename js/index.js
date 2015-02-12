var clickController = function(obj){


	  $(obj.attr("data-target")).click();


}

var showController = function(obj){


	  $(obj.attr("data-target")).show();


}



var closeController = function(obj){


	  $(obj.attr("data-target")).hide();


}

var freezeEvent = function(e){

	e.preventDefault();
    e.stopPropagation();

}


var controllers = function(){
	

		   $("[data-click]").off("click").on("click", function(e){
							 			
		 			freezeEvent(e);
		 			clickController($(this));

		 	});


		    $("[data-close]").off("click").on("click", function(e){
							 			
		 			freezeEvent(e);
		 			closeController($(this));

		 	});


		 	 $("[data-show]").off("click").on("click", function(e){
							 			
		 			freezeEvent(e);
		 			showController($(this));

		 	});



	}





var ini_controllers = function(){

		   controllers();

	}