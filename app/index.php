<?php
$host = getenv('DB_HOST') ?: 'db';
$dbname = getenv('DB_NAME') ?: 'portfolio';
$username = getenv('DB_USER') ?: 'portfolio_user';
$password = getenv('DB_PASSWORD') ?: '';

$projects = [];
$db_error = null;

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    $stmt = $pdo->query(
        "SELECT id, title, description, technology
         FROM projects
         ORDER BY id DESC"
    );
    $projects = $stmt->fetchAll();
} catch (Throwable $e) {
    $db_error = "Chưa thể kết nối cơ sở dữ liệu. Vui lòng kiểm tra dịch vụ MySQL.";
    error_log("Portfolio database error: " . $e->getMessage());
}

function escape_html($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portfolio cá nhân</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            color: #1f2937;
            line-height: 1.6;
        }
        header {
            background: #1e293b;
            color: white;
            padding: 45px 20px;
            text-align: center;
        }
        header h1 { margin: 0 0 10px; }
        main { max-width: 900px; margin: 30px auto; padding: 0 20px; }
        section {
            background: white;
            padding: 24px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px #0000000d;
        }
        h2 { color: #2563eb; margin-top: 0; }
        .project {
            border: 1px solid #e5e7eb;
            padding: 16px;
            margin: 12px 0;
            border-radius: 8px;
        }
        .technology { color: #64748b; font-size: 14px; }
        .status { color: #15803d; font-weight: bold; }
        .error { color: #b91c1c; }
        footer { text-align: center; padding: 20px; color: #64748b; }
    </style>
</head>
<body>
<header>
    <h1>Portfolio cá nhân</h1>
    <p>Website giới thiệu bản thân và các dự án đã thực hiện</p>
</header>

<main>
    <section>
        <h2>Giới thiệu</h2>
        <p>Xin chào! Tôi là sinh viên Công nghệ thông tin, đang học tập và thực hành triển khai hệ thống phần mềm bằng Docker.</p>
        <p>Mục tiêu: xây dựng, triển khai và giám sát các ứng dụng web.</p>
    </section>

    <section>
        <h2>Các dự án</h2>

        <?php if ($db_error): ?>
            <p class="error"><?= escape_html($db_error) ?></p>
        <?php elseif (count($projects) === 0): ?>
            <p>Chưa có dự án nào trong cơ sở dữ liệu.</p>
        <?php else: ?>
            <?php foreach ($projects as $project): ?>
                <article class="project">
                    <h3><?= escape_html($project['title']) ?></h3>
                    <p><?= escape_html($project['description']) ?></p>
                    <p class="technology">
                        Công nghệ: <?= escape_html($project['technology']) ?>
                    </p>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <section>
        <h2>Thông tin triển khai</h2>
        <p>Ứng dụng PHP chạy trong Docker container và sử dụng MySQL để lưu trữ dữ liệu.</p>
        <p class="status">Giao diện Portfolio đã được tải.</p>
    </section>
</main>

<footer>Portfolio Demo — Docker Compose</footer>
</body>
</html>
