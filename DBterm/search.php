<?php 
  /*로그인 상태 아니면 로그인 페이지로*/
  session_start();
  if(!isset($_SESSION["id"])){
    header('Location: ./');
  }
  include("./database.php");
  $conn = initDB();
  $search = $_GET["search"];

  /*만약 검색결과가 이상하면 처리*/
  if($search === '%')
    $search = "!@#$!";

  $query1 = "(select instructor_id,instructor_name, course_id, sec_id, semester, year from teach natural left join instructor)";
  $query2 = "(select * from ".$query1."as T natural join course)";

  /*instructor name에 검색 스트링 포함되나 검사*/
  $query_f = "select * from ".$query2."as S where instructor_name like '%".$search."%'";
  /*coure name에 검색 스트링 포함되나 검사*/
  $query_f = $query_f." or course_name like '%".$search."%'";
  /*course_id name에 검색 스트링 포함되나 검사*/
  $query_f = $query_f." or course_id like '".$search."%'";

  $result = pg_query($conn, $query_f);
  $row = pg_num_rows($result);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>검색 결과</title>
  <link rel="stylesheet" href="./css/common.css">
  <link rel="stylesheet" href="./css/main.css">
  <script src="./js/jquery-1.12.4.min.js"></script>
  <style>
    table{
      width: 100%;
      border-collapse: collapse;;
    }
    th{
      text-align: center;
    }
    th,td{
      border-bottom: 1px solid #CCC;
      padding: 5px;
    }
    tr td:not(:nth-child(2)){
      text-align: center;
    }
    table button{
      width:200px;
    }
  </style>
</head>
<body>
  <?php include("./header.php") ?>
  <div id="content">
    <div class="left">
      <div class="box result">
        <h2>검색 결과</h2>
        <table>
          <tr>
            <th>개설학기</th>
            <th>과목명</th>
            <th>과목코드</th>
            <th>교수명</th>
            <th>평가하기</th>
          </tr>
          <?php while($data=pg_fetch_assoc($result)){ ?>
            <tr>
              <td><?php echo $data["year"]."-".$data["semester"]."R" ?></td>
              <td>
                <a href="./lecture.php?year=<?=$data['year']?>&semester=<?=$data['semester']?>&course_id=<?=$data['course_id']?>&sec_id=<?=$data['sec_id']?>&instructor_id=<?=$data['instructor_id']?>">
                  <?php echo $data["course_name"]; ?>
                </a>
              </td>
              <td><?php echo $data["course_id"]."-".$data["sec_id"]; ?></td>
              <td><?php echo $data["instructor_name"]; ?></td>
              <td><button value='<?=implode(',', $data);?>'>평가하기</button></td>
            </tr>
          <?php }?>
        </table>
      </div>
    </div>

    <?php include("./right.php") ?>
  </div>
  <div id="footer">
    <div class="inner">
      <div class="copyright">2016 DB <strong>Term Project</strong></div>
    </div>
  </div>
  <script>
    /*버튼 클릭시 해당 row에서 comment 쓸 떄 필요한 primary key를 get으로 넘겨줌*/
    $("table button").on("click",function(){
      var array = (this.value).split(",");
      var course_id = array[0];
      var instructor_id = array[1];
      var sec_id = array[3];
      var semester = array[4];
      var year = array[5];
      location.href = "./write.php?course_id="+course_id+"&sec_id="+sec_id+"&year="+year+"&semester="+semester+"&instructor_id="+instructor_id;
    });
  </script>
</body>
</html>