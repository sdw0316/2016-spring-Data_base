$(".rate").each(function(){
  var num = parseInt(this.innerHTML);
  var html = "";
  for(var i=1;i<=num;i++){
    html += "<span>★</span>"
  }
  for(var i=5-num;i>=1;i--){
    html += "<span>☆</span>"
  }
  this.innerHTML = html;
  console.log(num);
})

$(".edit_wrap .update").on("click",function(){
  var index = $(this).find("input").eq(0).val();
  location.href = "./update.php?index="+index;
});

$(".edit_wrap .delete").on("click",function(){ 
  if(confirm("삭제 하시겠습니까?")){
    var index = $(this).find("input").eq(0).val();
    var data = { index : index};
    $.ajax({
          type : 'POST',
          url : './ajax/delete_ajax.php',
          datatype : 'json',
          data: data,
          /*response*/
          success:function(data){
            if(data === "success"){
              alert("삭제 완료");
              location.reload();
            }
            else{
              alert(data);
            }
          }
        });
  }
});