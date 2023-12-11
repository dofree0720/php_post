<?php
session_start();

include('db.php');

// 게시물 ID가 전달되지 않으면 목록 페이지로 리다이렉트
if (!isset($_GET["post_id"])) {
    header("Location: posts.php");
    exit();
}

$post_id = $_GET["post_id"];

// 게시물 내용 조회
$sql = "SELECT * FROM posts WHERE post_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    // 게시물이 존재하지 않으면 목록 페이지로 리다이렉트
    header("Location: posts.php");
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시물 내용 확인</title>
</head>
<body>
    <h2>게시물 내용 확인</h2>
    <p>게시물 제목: <?php echo $row["title"]; ?></p>
    <p>게시물 내용: <?php echo $row["content"]; ?></p>
    <p>작성자: <?php echo $row["user_id"]; ?></p>

    <!-- 게시물 목록 페이지로 이동하는 링크 -->
    <a href="posts.php">게시물 목록으로 돌아가기</a>
</body>
</html>
