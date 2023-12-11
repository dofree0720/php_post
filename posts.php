<?php
session_start();

include('db.php');

// 로그인되어 있지 않으면 로그인 페이지로 리다이렉트
if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit();
}

// 게시물 목록 가져오기 (모든 사용자의 게시물)
$sql = "SELECT * FROM posts";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시물 페이지</title>
</head>
<body>
    <h2>게시물 페이지</h2>
    <p>안녕하세요, <?php echo $_SESSION["user_id"]; ?>님!</p>

    <!-- 게시물 목록 출력 -->
    <h3>게시물 목록</h3>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <a href="post.php?post_id=<?php echo $row['post_id']; ?>">
                    <?php echo $row["title"]; ?>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>

    <!-- 게시물 작성 폼 -->
    <h3>게시물 작성</h3>
    <form method="post" action="write.php">
        <label>제목: <input type="text" name="title" required></label><br>
        <label>내용: <textarea name="content" required></textarea></label><br>
        <input type="submit" name="write_post" value="게시물 작성">
    </form>
</body>
</html>
