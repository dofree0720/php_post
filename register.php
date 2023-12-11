<?php

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // 'user_id' 및 'password' 파라미터가 모두 존재하는지 확인
    if (isset($_GET['user_id']) && isset($_GET['password'])) {
        $username = $_GET['user_id'];
        $password = password_hash($_GET['password'], PASSWORD_BCRYPT);

        $insert_query = "INSERT INTO phplogin (user_id, password) VALUES (?, ?)";

        // prepare statement
        $stmt = $conn->prepare($insert_query);

        // bind parameters
        $stmt->bind_param("ss", $username, $password);

        // execute the statement
        if ($stmt->execute()) {
            echo "회원가입이 정상적으로 완료되었습니다.";
        } else {
            echo "Error: 회원가입에 실패했습니다. " . $stmt->error;
        }

        // close the statement
        $stmt->close();

        $conn->close();
    } else {
        echo "Error: 'user_id' 및 'password'가 필요합니다.";
    }
}

?>
