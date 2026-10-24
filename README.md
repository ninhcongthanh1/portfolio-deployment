# Portfolio Deployment with Docker Compose

## 1. Giới thiệu

Dự án triển khai website Portfolio cá nhân bằng Docker Compose, tích hợp cơ sở dữ liệu, reverse proxy HTTPS, giám sát hệ thống và thu thập log tập trung.

Mục tiêu:
- Đóng gói ứng dụng bằng Docker.
- Quản lý các dịch vụ bằng Docker Compose.
- Cấu hình Nginx reverse proxy và HTTPS.
- Triển khai MySQL và phpMyAdmin.
- Giám sát hệ thống bằng Prometheus và Grafana.
- Thu thập và tìm kiếm log bằng Loki và Promtail.
- Áp dụng các biện pháp bảo mật cơ bản.

## 2. Công nghệ sử dụng

- Docker Engine và Docker Compose
- PHP và Apache
- MySQL
- phpMyAdmin
- Nginx
- Prometheus
- Grafana
- Node Exporter
- cAdvisor
- Loki
- Promtail

## 3. Kiến trúc hệ thống

Người dùng truy cập website thông qua Nginx. Nginx xử lý HTTPS và chuyển tiếp yêu cầu đến ứng dụng PHP.

Ứng dụng PHP kết nối MySQL để truy xuất dữ liệu Portfolio.

Prometheus thu thập số liệu từ chính Prometheus, Node Exporter và cAdvisor. Grafana sử dụng các số liệu này để trực quan hóa trạng thái hệ thống.

Promtail thu thập log Docker và gửi đến Loki. Grafana kết nối Loki để tìm kiếm và phân tích log.

## 4. Cấu trúc dự án

- `app/`: mã nguồn PHP và Dockerfile.
- `database/`: script khởi tạo cơ sở dữ liệu.
- `nginx/`: cấu hình Nginx và chứng chỉ TLS.
- `prometheus/`: cấu hình Prometheus.
- `grafana/`: cấu hình datasource Grafana.
- `loki/`: cấu hình Loki.
- `promtail-config.yml`: cấu hình thu thập log.
- `docker-compose.yml`: cấu hình các dịch vụ.
- `.env.example`: mẫu biến môi trường.

## 5. Yêu cầu

- Docker Engine.
- Docker Compose.
- Trình duyệt web.
- Kết nối Internet để tải Docker image lần đầu.

## 6. Cài đặt và triển khai

### Bước 1: Lấy mã nguồn

Clone repository về máy và chuyển vào thư mục dự án.

### Bước 2: Cấu hình môi trường

Sao chép file mẫu:

```bash
cp .env.example .env
```

Chỉnh sửa `.env`, đặt mật khẩu mạnh và không chia sẻ file này công khai.

### Bước 3: Chuẩn bị chứng chỉ HTTPS

Tạo chứng chỉ TLS theo cấu hình Nginx hoặc sử dụng chứng chỉ phù hợp với môi trường triển khai.

Đảm bảo các đường dẫn chứng chỉ khớp với cấu hình Nginx.

### Bước 4: Kiểm tra cấu hình

```bash
docker compose config -q
```

### Bước 5: Khởi chạy hệ thống

```bash
docker compose up -d
```

### Bước 6: Kiểm tra trạng thái

```bash
docker compose ps
```

### Bước 7: Xem log khi cần

```bash
docker compose logs --tail=100
```

## 7. Các địa chỉ truy cập

- Website: `https://localhost`
- phpMyAdmin: `http://localhost:8080`
- Prometheus: `http://localhost:9090`
- Grafana: `http://localhost:3000`

Các địa chỉ quản trị được cấu hình lắng nghe trên localhost. Khi triển khai trên máy khác, cần kiểm tra lại cấu hình cổng và mạng.

HTTPS sử dụng chứng chỉ tự ký nên trình duyệt có thể cảnh báo chứng chỉ chưa được tin cậy.

## 8. Giám sát hệ thống

Prometheus thu thập số liệu từ:
- Prometheus.
- Node Exporter.
- cAdvisor.

Grafana được sử dụng để truy vấn và trực quan hóa số liệu giám sát.

Ví dụ truy vấn PromQL:

```promql
container_memory_usage_bytes
```

```promql
rate(container_cpu_usage_seconds_total[5m])
```

## 9. Thu thập log

Promtail đọc log Docker theo cấu hình và gửi log đến Loki.

Ví dụ truy vấn LogQL:

```logql
{job="docker"}
```

```logql
{job="docker"} |= "error"
```

```logql
{job="docker"} |~ "(?i)error|exception|failed"
```

## 10. Biện pháp bảo mật

- Không đưa file `.env` lên GitHub.
- Không đưa khóa riêng TLS lên GitHub.
- Hạn chế cổng quản trị chỉ lắng nghe trên localhost.
- Sử dụng mạng Docker riêng cho các dịch vụ phù hợp.
- Cấu hình HTTPS và security headers tại Nginx.
- Tắt đăng ký tài khoản Grafana tự do.
- Sử dụng mật khẩu mạnh cho các dịch vụ.

## 11. Hạn chế

- Chứng chỉ tự ký không được trình duyệt tin cậy mặc định.
- Hệ thống được triển khai phục vụ mục đích học tập.
- Cần đánh giá bổ sung cấu hình bảo mật trước khi triển khai trên Internet thực tế.

## 12. Thông tin bài thực hành

- Đề tài: Triển khai Website Portfolio bằng Docker Compose.
- Môn học: Triển khai và Quản trị Hệ thống Phần mềm.
- Sinh viên: Ninh Cong Thanh
