<?php
session_start();

include('db.php');

// 로그인되어 있지 않으면 로그인 페이지로 리다이렉트
if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["write_post"])) {
    // 게시물 작성 처리
    $title = $_POST["title"];
    $content = $_POST["content"];
    $user_id = $_SESSION["user_id"];

    $sql = "INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $content, $user_id);
    $stmt->execute();
    $stmt->close();
    
    // 작성된 게시물 확인을 위한 페이지로 이동
    $last_inserted_id = $conn->insert_id;
    header("Location: post.php?post_id=$last_inserted_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시물 작성 페이지</title>
</head>
<body>
    <h2>게시물 작성</h2>
    <form method="post" action="write.php">
        <label>제목: <input type="text" name="title" required></label><br>
        <label>내용: <textarea name="content" required></textarea></label><br>
        <input type="submit" name="write_post" value="게시물 작성">
    </form>
    
    <!-- 게시물 목록 페이지로 이동하는 링크 -->
    <a href="posts.php">게시물 목록으로 돌아가기</a>
</body>
</html>
