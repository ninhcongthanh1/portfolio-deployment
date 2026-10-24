CREATE DATABASE IF NOT EXISTS portfolio
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE portfolio;

CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    technology VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO projects (title, description, technology)
VALUES
(
    'Website quản lý thực tập sinh',
    'Hệ thống hỗ trợ quản lý thông tin và quá trình thực tập của sinh viên.',
    'React, Vite, Backend API, MySQL'
),
(
    'NutriBot',
    'Ứng dụng hỗ trợ tra cứu và cung cấp thông tin về sản phẩm dinh dưỡng.',
    'Python, Machine Learning, Web API'
),
(
    'Portfolio Deployment',
    'Website giới thiệu cá nhân triển khai bằng Docker Compose.',
    'PHP, MySQL, Docker, Nginx'
);
