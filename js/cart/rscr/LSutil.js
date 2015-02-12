var cookie = {
  setItem: function (name, value) {
    document.cookie = escape(name) + '=' + escape(value);
  },
  getItem: function (name) {
    var coos = document.cookie;
        coos = coos.split(';');
    for (x in coos) {
      var coo = coos[x].split('=');
      if (coo[0] == name) {
        return coo[1];
      }
    }
  }
}


if (!window.localStorage) window.localStorage = cookie;

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  //


var ls = window.localStorage;
   
    function salvarLS( val , callback ){


          var item = val,
              its = obtLS();

              its.push( item );              
              its = toJSON( its );              

              ls.items = its;    


              if(callback)
                   callback();          


    }


    function obtLS(){

        return toOBJ ( ls.items );

    }


    function cleanLS(){

           ls.removeItem("items");
           iniLS();   
           total = 0;        

    }

    function replaceLS(items){

        ls.items = toJSON(items);

     }


     function obtTotal(){

        var items = obtLS();
        var total = 0;

        for(x in items)
          if(items[x].active != -1){
           
             total += items[x].price;
             console.log(items[x].price);

           }

        return total;

     }


    function toJSON( val ){

       return JSON.stringify( val );

    }

    function toOBJ( val ){

          return JSON.parse( val );
    }

    function iniLS( val ){


      if(!ls.items)       
          ls.setItem('items', toJSON( new Array() ) );                    
       
        var lss = obtLS();
        console.log(lss);
              

   
      }