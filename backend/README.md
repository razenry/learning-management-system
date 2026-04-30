# LMS Modular Monolith Backend

A high-performance, modular monolith Learning Management System (LMS) backend built with **Laravel 12**, **PostgreSQL**, **Redis**, and **Docker**. This project follows **Clean Architecture** principles using the **Service-Repository** pattern.

## 🚀 Key Features

- **Modular Monolith Architecture**: Scalable and maintainable structure with isolated feature modules.
- **Role-Based Access Control (RBAC)**: Fine-grained permissions for Superadmin, Admin, Guru, Siswa, and Wali Murid.
- **Subscription Management**: Automated program subscriptions (SNBT, TKA) and add-ons (Hafiz).
- **Location-Based QR Attendance**: Secure attendance system with QR code generation and GPS coordinate validation.
- **LMS (Learning Management System)**: 
    - Material management (PDF/Video/Text).
    - Assignments with auto-grading for Multiple Choice Questions (MCQ).
- **Hafiz Tracker**: Dedicated module for tracking Qur'an memorization progress (Juz/Ayat).
- **Automated Notifications**: Background processing (Queue) for WhatsApp and Email notifications.
- **API Documentation**: Integrated Swagger/OpenAPI documentation.

## 🛠 Tech Stack

- **Framework**: Laravel 12
- **Database**: PostgreSQL 16
- **Cache & Queue**: Redis
- **Architecture**: Modular Monolith + Clean Architecture
- **Authentication**: Laravel Sanctum
- **Permissions**: Spatie Laravel Permission
- **Deployment**: Docker & Docker Compose

## 📂 Project Structure

```text
app/
├── Core/               # Shared base classes (Controller, Service, Repository)
└── Modules/            # Feature modules
    ├── Auth/           # Registration, Login, Logout
    ├── Users/          # User management & Wali relations
    ├── Products/       # Course programs & Add-ons
    ├── Subscriptions/  # Billing & Activation
    ├── Classes/        # Classroom & Schedules
    ├── Attendance/     # QR Attendance with GPS
    ├── LMS/            # Materials & Assignments
    ├── Hafiz/          # Qur'an progress tracking
    └── Notifications/  # Queue-based WA/Email system
```

## ⚙️ Installation & Setup

### Prerequisites
- Docker & Docker Compose
- Git

### Steps
1. **Clone the repository**
   ```bash
   git clone https://github.com/razenry/learning-management-system.git
   cd learning-management-system/backend
   ```

2. **Setup environment variables**
   ```bash
   cp .env.example .env
   ```

3. **Start the environment**
   ```bash
   docker-compose up -d
   ```

4. **Install dependencies**
   ```bash
   docker exec app composer install
   ```

5. **Generate App Key**
   ```bash
   docker exec app php artisan key:generate
   ```

6. **Run Migrations & Seeders**
   ```bash
   docker exec app php artisan migrate:fresh --seed
   ```

7. **Access API Documentation**
   Visit `http://localhost/api/documentation` to view Swagger docs.

## 🛣 API Endpoints (Quick Look)

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/auth/register` | User Registration |
| POST | `/api/auth/login` | User Login |
| GET | `/api/users` | List Users (Admin only) |
| POST | `/api/attendance/generate-qr` | Generate session QR (Guru only) |
| POST | `/api/attendance/scan` | Scan QR for attendance (Siswa only) |
| POST | `/api/lms/assignments/{id}/submit` | Submit assignment |

## 🤝 Contribution

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

Distributed under the MIT License.
