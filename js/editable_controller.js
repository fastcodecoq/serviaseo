var w = $(window),
	d = $(document),
	editing = undefined,
	editor_ = undefined,
	temp__ = "";
var path = "panel";





function iconizer(){

	
 
 var editables = $("*[data-role='editable']");

   for(i=0; i < editables.length ; i++)
     {
     	
     		var el = $(editables[i]);


            switch(editables[i].localName){

            	case "img":

            	var id = "img_" + i;

     			var icon = "<a href='#edit' title='editar' class='edit-icon'  data-select='ok' data-filter='images' data-target='#" + id + "'><i class='icon-edit'></i></a>";

     			el.attr("id", id);

     	     	el.parent().css({position:"relative"}).append(icon);


            	break;

            	default:


            	var icon = "<a href='#edit' title='editar' class='edit-icon' contenteditable='false'> <i class='icon-edit'></i></a>";          
            	el.css({position:"relative"}).append(icon);

            	break;

            }



     }


}

function getCursorPos(range, node) {
    var treeWalker = document.createTreeWalker(
        node,
        NodeFilter.SHOW_TEXT,
        function(node) {
            var nodeRange = document.createRange();
            nodeRange.selectNode(node);
            return nodeRange.compareBoundaryPoints(Range.END_TO_END, range) < 1 ?
                NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_REJECT;
        },
        false
    );

    var charCount = 0;
    while (treeWalker.nextNode()) {
        charCount += treeWalker.currentNode.length;
    }
    if (range.startContainer.nodeType == 3) {
        charCount += range.startOffset;
    }
    return charCount;
}


function load_bar(){
	
	//$("boady").append("<div class='sidebar-'></div>")
	//$(".sidebar-").load(path + "/vistas/bar_editable.html");

	   var control  = "<div class='control' style='position:fixed;  bottom:0; width:100%; padding:10px; ' >"
                 +"<div class='toCenter' style=''>"
                 +"<a href='dev_off' class='btn'>Terminar edición</a>"
                 +"&nbsp;&nbsp;&nbsp;"
                 +"<a href='#guardar_' class='btn btn-success sucesss disabled'>Guardar</a>"
                 +"</div>"
                 +"</div>"
                 ;

	$("body").append(control);

}


function listen_edit(){

	$("*[data-role='editable']").live("dblclick", function(){

		openEditor($(this));
      

	});


	$("*[data-role='editable']:not('div')").live("keyup", function(){
		
		editing = $(this);
		$("a[href='#guardar_']").removeClass("disabled");


	});

}



function openEditor( obj ){

	    editing = obj;

		var tagName = editing.attr("tagName");		

		if(!tagName)
			tagName = editing[0].tagName;

			if( tagName != "IMG")
			
               $("#editor").fadeIn( function(){
				 
				 console.log(tagName);
				 var html = editing.html();

				 editing.addClass("editing_");

				 editor.setValue(html);
				 	
				 editor_ = true;
				 temp__ = html;

				 $(this).find("form:first").animate({marginTop:"70px"});

			});

}


function listen_hash(){

	$("#bar a[href^='#'] , a[href^='#guardar'], a[href^='#'].edit-icon , #editor a[href^='#'] ").live("click", function(e){


		e.preventDefault();
		e.stopPropagation();

		var a = $(this);

		switch(a.attr("href")){

			case "#edit":

			editing = $(this);
			$("a[href='#guardar_']").removeClass("disabled");

			var view = $(this).parents("*[data-role='vista']:first");

			var el = $(this).parent();			
			$(".blocked").remove();



			if(el[0].tagName.toLowerCase() != "img" && !$(this).attr("data-target"))
			{

			   el.focus();	
			   openEditor(el);		   			   

			}
			else
		    openMedios($(this), function(rs, target){

		    	console.log(target);
		        target.attr("src","f/" + rs[0]);
		    	closeMedios();
		    	resetObjs();

		    });

			break;

			case "#insertar-imagen":

			openMedios($(this), function(rs, target){

		    	console.log(target);
		        target.val("f/" + rs[0]);
		    	closeMedios();
		    	resetObjs();

		    });

			break;


			case "#guardar_":
			

			if(!editing)
			{

				dialog.show("Debes editar algo antes de guardar");
				return false;

			}

			var preg = confirm("Esto modificará el contenido de esta página, estas seguro de hacerlo?");


			if(preg)
			{

				console.log("editing");
				console.log(editing);

				var view = editing.parents("*[data-role='vista']:first");
				var vista = view.attr("data-view");								
				var tagName = view[0].tagName.toLowerCase();
				var attributes = view[0].attributes;
				$(view).find("*[title='editar']").removeAttr("title");
				var html = view.html();

				var attr = new Array();



				for(x in attributes){

					if(attributes[x].name && attributes[x].value)
						if(attributes[x].name != "data-view" && attributes[x].name != "title" && attributes[x].name != "data-role"){

							if( attributes[x].name === "class"){
								
								if( strlen(attributes[x].value) > 0)
         					        attr.push(attributes[x].name + "='" + attributes[x].value +"'");
							}
							else
					        attr.push(attributes[x].name + "='" + attributes[x].value +"'");
					       

						}							
					        

				}

				attr = attr.join(" ");										
	

				var html = "<" + tagName + " " + attr + " %vista:" + vista + "%>" + html + "</" + tagName + ">";	
								
				
				var info = {

					html : html,
					vista : vista

				};

				


				save_editable(info);				


			}else
			return false;

			break;

			case "#listo":


			cerrar($($(this).attr("rel")), function(){

				 if(temp__ == $("#textarea").val())
				 	return false;

				 $("a[href='#guardar_']").removeClass("disabled");				 
				 var content = $("#textarea").val();
				 if(editing.attr("tagName"))
				 editing.html(content);	
				 else				 			 
				 $(editing[0]).html(content);

				 editor_ = undefined;
				 editing.removeClass("editing_");

				 console.log("listo");

			});

			break;

			case "#t-left":

			 if(!editing){
			 
			 	dialog.show("No estas realizando una edición");

			  }

			  reemplazarSeleccion(editing,editing.getSelectionText(),"p","text-align:center");


			break;

			case "#t-bold":

			 if(!editing){
			 
			 	dialog.show("No estas realizando una edición");

			  }

			  var text = x.Selector.getSelected();
			  var range = window.getSelection().getRangeAt(0);
			  var pos = getCursorPos(range,editing);

			  dialog.show(pos);

			  reemplazarSeleccion(editing,text,"b");


			break;

		}

	});

}


function cerrar(obj, callback){

	 obj.fadeOut( function(){

	 	 if(callback)
	 	 	callback();

	 });

}

function save_editable(info){


	  console.log(info);

	  $.ajax({

	  	url : "api/update_content.php",
	  	data : info,
	  	dataType : "JSON",
	  	type : "POST",
	  	success : function(rs){

	  		console.log("success");
	  		console.log(rs);
	  		editing = undefined;

	  		dialog.show("Se han guardado los cambios");

	  		return;
	  		document.location.reload();

	  	},
	  	error : function(error){

	  		console.log(error);

	  		dialog.show("Error: no se pudo guardar los cambios ("+ error.responseText +")");

	  	}

	  });


}


function reemplazarSeleccion(control, texto,tag,style){ // v2011-12-21
    var inicio, seleccion;

    if("selectionStart" in control){ // W3C
        // Guardamos la posición inicial del cursor
        inicio = control.selectionStart;

        // Reemplazamos todo el contenido

        var sty = (style) ? style : "";

        control.value = control.value.substr(0, control.selectionStart) +
            "<"+ tag +" " + sty +">" + texto + "<"+ tag +" />" +
             control.value.substr(control.selectionEnd, control.value.length);

        // Movemos el cursor a la posición final
        control.selectionStart = inicio + texto.length;
        control.selectionEnd = inicio + texto.length;
        
        control.focus();

    }else if(document.selection){ // IE
        control.focus();

        // Obtenemos la selección y la reemplazamos por el nuevo texto
        seleccion = document.selection.createRange();
        seleccion.text = texto;

        seleccion.select();

    }else{
        // No sabemos dónde está el cursor: insertamos el texto al final
        dialog.show("Debes seleccionar texto para aplicar el formato");
    }
}


function media(){

	$("*[data-command='media-mannage']").live("click", function(e){

					e.preventDefault();
					e.stopPropagation();

   				    openMedios();

   		});


}


function closeEditor(){

 $("#editor a[href='#cerrar']").off('click').on('click', function(e){

               e.preventDefault();
               e.stopPropagation();


               var a = $(this);
               var target = a.attr("rel");

              
            $(target).find("form:first").animate({marginTop:"-600px"}, function(){

               $(target).hide();
               editing.focus()

            })
              

            });

}

function ini__(){

		iconizer();
		load_bar();
		listen_hash();
		listen_edit();
		media();
		closeEditor();

		/* $("[contenteditable]").live("paste", function(e){
		  
		  console.log(e);						   
		  var target = e.target;


		  	target.innerHTML = strip_tags(e.target.innerHTML);		  			 
		    

		 });  */

	


		// iniciamos el controlador

}



$(ini__);