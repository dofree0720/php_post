<?php

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  
    $username = $_GET['user_id'];
    $password = $_GET['password'];

    // SQL 쿼리에 사용자 입력을 넣을 때는 항상 prepare와 bind_param을 사용하여 처리
    $select_query = "SELECT * FROM phplogin WHERE user_id=?";
    $stmt = $conn->prepare($select_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // password_verify 함수를 사용하여 비밀번호 검증
        if (password_verify($password, $row['password'])) {
            // 로그인 성공 시 세션에 사용자 정보 저장
            session_start();
            $_SESSION["user_id"] = $row["user_id"];
            
            // 로그인 성공 후 다른 페이지로 이동
            header("Location: posts.php");
            exit();
        } else {
            echo "비밀번호가 일치하지 않습니다.";
        }
    } else {
        echo "사용자가 존재하지 않습니다.";
    }

    $stmt->close();
    $conn->close();
}
?>
