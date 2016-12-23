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
  $infoq = "select course_name, instructor_name, instructor_id, course_id, sec_id, dept_name, semester, year, credit, avg(rate) from".$query3."as M natural left outer join evaluation group by course_name, instructor_name, instructor_id, course_id, sec_id, dept_name, semester, year, credit";

  $evalq = "(select index, account_id, rate, comment from".$query3."as M natural join evaluation)";
  $evalq = "(select index, account_id, user_name, rate, comment from".$evalq."as U natural join account)";
  
  $inforesult = pg_query($conn, $infoq);
  $info = pg_fetch_assoc($inforesult);
  $evalresult = pg_query($conn, $evalq);
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>강의 페이지</title>
  <link rel="stylesheet" href="./css/common.css">
  <link rel="stylesheet" href="./css/main.css">
  <script src="./js/jquery-1.12.4.min.js"></script>
  <style>
    .result{
      padding-bottom: 20px;
    }
    .result>div:not(.top){
      border-top: 1px solid #CCC;
      margin-top: 20px;
      padding-top: 20px;  
    }
    .lec_info div:not(.credit){
      margin-right: 30px;
      float:left;
    }
    .eval_info{
      border-top: 1px solid #CCC;
      margin-top: 20px;
      padding-top: 20px;
      text-align: center;
    }
    .eval_info .eval_btn{
      margin-top:10px;
    }
    .eval{
      padding-bottom:20px;
    }
    .eval div{
      margin-top: 20px;
    }
    .rate{
      font-size:18pt;
    }
    .edit_wrap{
      text-align: right;
    }
    .edit_wrap span{
      margin-left : 20px;
      cursor: pointer
    }
    .edit_wrap span:hover{
      color: #CCC;
    }
  </style>
</head>
<body>
  <?php include("./header.php") ?>
  <div id="content">
    <div class="left">
      <div class="box result">
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
        <div class="eval_info">
          <div class="rate_wrap">
            <strong>총평 </strong><span class="rate"><?=round($info["avg"],2)?></span>
          </div>
          <div class="eval_btn">
            <button value="<?=implode(",", $info) ?>">평가하기</button>
          </div>
        </div>
      </div>
      
      <?php while($eval = pg_fetch_assoc($evalresult)){?>
      <div class="box eval">
        <div class="account">
          <strong><?=$eval["user_name"]?></strong> <span style="font-size:9pt">님의 의견</span>
        </div>
        <div class="rate_wrap">
          <strong>점수 </strong><span class="rate"><?=$eval["rate"]?></span>
        </div>
        <div class="comment">
          <?=$eval["comment"] ?>
        </div>
        <?php 
          /*자기가 쓴거거나, 관리자로 접속시에만 수정 삭제 가능*/
          if($eval["account_id"] === $_SESSION["id"] || $_SESSION["id"] === "admin"){
         ?>
        <div class="edit_wrap">
          <span class="update">
            <input type="hidden" value="<?=$eval["index"]?>">
            수정
          </span>
          <span class="delete">
            <input type="hidden" value="<?=$eval["index"]?>">
            삭제
          </span>
        </div>
        <?php } ?>
      </div>
      <?php }?>
    </div>

    <?php include("./right.php") ?>
  </div>
  <div id="footer">
    <div class="inner">
      <div class="copyright">2016 DB <strong>Term Project</strong></div>
    </div>
  </div>
  <script src="./js/lecture.js"></script>
  <script>
      $(".eval_btn button").on("click",function(){
        var array = (this.value).split(",");
        var course_id = array[3];
        var instructor_id = array[2];
        var sec_id = array[4];
        var semester = array[6];
        var year = array[7];
        location.href = "./write.php?course_id="+course_id+"&sec_id="+sec_id+"&year="+year+"&semester="+semester+"&instructor_id="+instructor_id;
      });
  </script>
</body>
</html>