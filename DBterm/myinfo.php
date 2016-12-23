<?php 
  /*$query1 = "(select * from evaluation where account_id = '$account_id')";
  $query2 = "(select * from $query1 as T natural left join teach)";
  $instructor = "(select index, instructor_id, instructor_name from $query2 as S natural left join instructor)";
  $section = "(select index, course_id, course_name, sec_id, semester, year from $query2 as M natural left join course)";
  $queryf = "(select * from $query2 as P natural left join $instructor as X)";
  $queryf = "(select * from $queryf as Q natural left join $section as Y)";*/
  /*로그인 상태 아니면 로그인 페이지로*/
  session_start();
  if(!isset($_SESSION["id"])){
    header('Location: ./');
  }
  include("./database.php");
  $conn = initDB();

  $account_id = $_GET["account_id"];

  $query = "(select * from evaluation where account_id = '$account_id')";
  $query = "(select * from $query as S natural left join instructor)";
  $query = "(select * from $query as M join course using (course_id))";
  $result = pg_query($conn,$query);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>마이 페이지</title>
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
    .lec_info div:not(:last-child){
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
      font-size:10pt;
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
      <h2>내 강의평</h2>
      <?php while($data = pg_fetch_assoc($result)){?>
        <div class="box result">
          <div class="top">
            <div class="name_wrap">
              <h2><?=$data["course_name"]?></h2>
            </div>
            <div class="prop_wrap">
              <strong>교수명 </strong><?=$data["instructor_name"]?>
            </div>
          </div>
          <div class="lec_info">
            <div class="course_id">
              <strong>과목 코드 </strong><?=$data["course_id"]."-".$data["sec_id"]?>
            </div>
            <div class="year">
              <strong>개설 학기 </strong><?=$data["year"]."-".$data["semester"]."R"?>
            </div>
            <div class="rate_wrap">
              <strong>총평 </strong><span class="rate"><?=$data["rate"]?></span>
            </div>
          </div>
          <p>
            <?=$data["comment"]?>
          </p>
          <?php 
            /*자기가 쓴거거나, 관리자로 접속시에만 수정 삭제 가능*/
            if($data["account_id"] === $_SESSION["id"] || $_SESSION["id"] === "admin"){
           ?>
          <div class="edit_wrap">
            <span class="update">
              <input type="hidden" value="<?=$data["index"]?>">
              수정
            </span>
            <span class="delete">
              <input type="hidden" value="<?=$data["index"]?>">
              삭제
            </span>
          </div>
          <?php } ?>
        </div>
      <?php  }?>
    </div>
    <?php include("./right.php") ?>
  </div>
  <div id="footer">
    <div class="inner">
      <div class="copyright">2016 DB <strong>Term Project</strong></div>
    </div>
  </div>
  <script src="./js/lecture.js"></script>
</body>
</html>