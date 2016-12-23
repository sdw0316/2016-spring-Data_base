<?php 
  /*로그인 상태 아니면 로그인 페이지로*/
  session_start();
  if(!isset($_SESSION["id"])){
    header('Location: ./');
  }
  include("./database.php");
  $conn = initDB();
  $index = $_GET["index"];

  $query = "(select * from evaluation where index = $index)";
  $query = "(select * from $query as T natural join course)";
  $query = "(select * from $query as S join instructor using (instructor_id))";

  $inforesult = pg_query($conn, $query);
  $info = pg_fetch_assoc($inforesult);
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>평가 페이지</title>
  <link rel="stylesheet" href="./css/common.css">
  <link rel="stylesheet" href="./css/main.css">
  <script src="./js/jquery-1.12.4.min.js"></script>
  <style>
    .write{
      padding-bottom: 20px;
    }
    .write>div:not(.top){
      border-top: 1px solid #CCC;
      margin-top: 20px;
      padding-top: 20px;  
    }
    .lec_info div:not(.credit){
      margin-right: 30px;
      float:left;
    }
    .comment{
      float:left;
    }
    #comment{
      font-family: "맑은고딕";
      font-size: 10pt;
      border-radius: 3px;
      margin-left:10px;
      padding:10px;
      width:586px;
      resize: none;
    }
    .btn_wrap{
      text-align: right;
    }
    .btn_wrap>button{
      width:200px;
    }
    .star{
      color: #DDD;
      font-size:19pt;
      cursor: pointer;
    }
    .active{
      color: #000;
    }
  </style>
</head>
<body>
  <?php include("./header.php") ?>
  <div id="content">
    <div class="left">
      <div class="box write">
        <div class="top">
          <div class="name_wrap">
            <h2><?=$info["course_name"]?></h2>
          </div>
          <div class="prop_wrap">
            <strong>교수명 </strong><?=$info["instructor_name"]?>
          </div>
        </div>
        <div class="lec_info">
          <div class="course_id">
            <strong>과목 코드 </strong><?=$info["course_id"]."-".$info["sec_id"]?>
          </div>
          <div class="year">
            <strong>개설 학기 </strong><?=$info["year"]."-".$info["semester"]."R"?>
          </div>
          <div class="credit">
            <strong>학점 </strong><?=$info["credit"]."학점"?>
          </div>
        </div>
        <div class="eval_wrap">
          <span>
            <strong>별점평가</strong>
          </span>
          <input type="hidden" id="star" value="<?=$info['rate']?>">
          <span class="star_wrap">
            <span class="star" value="1">★</span>
            <span class="star" value="2">★</span>
            <span class="star" value="3">★</span>
            <span class="star" value="4">★</span>
            <span class="star" value="5">★</span>
          </span>
        </div>
        <div class="input_wrap">
          <div class="comment">
            <strong>평가내용</strong>
          </div>
          <div class="input">
            <textarea name="comment" id="comment" cols="30" rows="10" placeholder="평가 내용을 입력하세요."><?=$info['comment']?></textarea>
          </div>
          <div class="btn_wrap">
            <button>평가 등록</button>
          </div>
        </div>
      </div>
    </div> 
    <?php include("./right.php") ?>
  </div>
  <div id="footer">
    <div class="inner">
      <div class="copyright">2016 DB <strong>Term Project</strong></div>
    </div>
  </div>

  <script src="./js/starrate.js"></script>
  <script>
    var num = $(".eval_wrap input").eq(0).val();
    for(var i=0;i<num;i++){
      $(".star").eq(i).addClass("active");
    }

    var index = <?=$_GET["index"]?>;
    var rate = $("#star").val();
    var comment = $("textarea").eq(0);

    var btn = $(".btn_wrap button").eq(0);

    /*input checker*/
    function submitCheck(){
      if(comment.val() === "")
        return false;
      else
        return true;
    }

    /*write comment by using AJAX*/
    function doSubmit(){
      rate = $("#star").val();
      comment = $("textarea").eq(0);

      if(!submitCheck()){
        alert("입력 양식이 맞지 않습니다!");
      }
      else{
        var form = {
          mode : "update",
          index : index,
          rate : rate,
          comment : comment.val()
        }
        /*AJAX requeset*/
        $.ajax({
          type : 'POST',
          url : './ajax/write_ajax.php',
          datatype : 'json',
                data: form,
                /*response*/
                success:function(data){
                  if(data === "success"){
                    alert("평가 수정 완료");
                    history.back();
                  }
                  else{
                    alert(data);
                  }
                }
        });
      }
    }
    
    btn.on("click",doSubmit);
  </script>
</body>
</html>