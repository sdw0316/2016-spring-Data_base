<?php 
  /*로그인 상태 아니면 로그인 페이지로*/
  session_start();
  if(!isset($_SESSION["id"])){
    header('Location: ./');
  }
  include("./database.php");
  $conn = initDB();

  $sec_id = $_GET["sec_id"];
  $course_id = $_GET["course_id"];
  $instructor_id = $_GET["instructor_id"];
  $semester = $_GET["semester"];
  $year = $_GET["year"];

  $query1 = "(select * from teach where sec_id='$sec_id' and course_id='$course_id' and instructor_id=$instructor_id and semester=$semester and year=$year)";
  $query2 = "(select instructor_id, instructor_name, course_id, sec_id, semester, year from".$query1."as T natural join instructor".")";
  $query3 = "(select * from".$query2."as S natural join course)";
  $infoq = "select distinct course_name, instructor_name, course_id, sec_id, semester, year, credit from".$query3."as M natural left outer join evaluation";

  //echo $infoq."<br>";

  $inforesult = pg_query($conn, $infoq);
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
          <input type="hidden" id="star" value="0">
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
            <textarea name="comment" id="comment" cols="30" rows="10" placeholder="평가 내용을 입력하세요."></textarea>
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
    var course_id = "<?=$_GET["course_id"]?>";
    var sec_id = "<?=$_GET["sec_id"]?>";
    var instructor_id = "<?=$_GET["instructor_id"]?>";
    var semester = "<?=$_GET["semester"]?>";
    var year = "<?=$_GET["year"]?>"; 
    var account = "<?=$_SESSION["id"]?>";

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
          mode : "insert",
          course_id : course_id,
          sec_id : sec_id,
          instructor_id : instructor_id,
          semester : semester,
          year : year,
          account : account,
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
              alert("강의평가 등록");
              history.back();
            }
            else{
              alert(data);
              alert("한개의 강의에 중복해서 평가 불가능합니다.");
            }
          }
        });
      }
    }
    
    btn.on("click",doSubmit);
  </script>
</body>
</html>