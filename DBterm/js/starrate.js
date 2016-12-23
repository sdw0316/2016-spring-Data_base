$(".star").on("mouseover",function(){
        var value = $(this).attr("value");
        for(var i=0;i<value;i++){
          $(".star").eq(i).addClass("active");
        }
        for(var i=value;i<6;i++){
          $(".star").eq(i).removeClass("active");
        }
      });

      $(".star").on("mouseout",function(){
        var value = $(this).attr("value");
        for(var i=value-1;i<6;i++){
          $(".star").eq(i).removeClass("active");
        }
      });
      $(".star").on("click", function(){
        var value = $(this).attr("value");
        $("#star").val(value);
      });

      $(".star_wrap").on("mouseout",function(){
        var value = $("#star").val();
        for(var i=0;i<value;i++){
          console.log($(".star").eq(i));
          $(".star").eq(i).addClass("active");
        }
        for(var i=value;i<6;i++){
          $(".star").eq(i).removeClass("active");
        }
      });   
