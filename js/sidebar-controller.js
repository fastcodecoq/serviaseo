
alert("iam here")
 function list_hash__(){


    $(".lado-p a[href^='#!']").live("click",function(){
    

        var a = $(this);
          cmd = a.attr("href");
          cmd = cmd.split("#!/");
          cmd = filter = cmd[1];


      
           window.location = "/productos#!/" +  cmd;

      var vars_ = {

       min : 0,
       max : 10000,
       n_f : 0,
       f : filter

       };

       console.log(vars_);

      load_products(vars_);

    });

  }


  $(list_hash__);
