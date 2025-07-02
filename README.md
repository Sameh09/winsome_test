#  Winsome Hr System

Functional Features
- Auth system using Laravel Breeze (Login/Logout)
- Manage employees (List, Create, Edit, View, Delete, Restore)
- Upload employee photo
- Assign employee to a department
- Filter employees by:
  - Name (search)
  - Status (active/inactive)
  - Hire date
- Export employee list as:
  - CSV
  - PDF
- Bulk delete selected employees
- Soft delete and restore employees
- Responsive UI using Bootstrap (Blade)

### Technical Features
- **Backend**: Laravel 12, MySQL
- **Frontend**: Blade templates (no Vue/React), Bootstrap 5
- **Database**:
  - Seeded with 10000 fake employee records
  - `employees` table uses foreign key to `departments`
  - Indexed columns: `name`, `status`, `hired_at`
  - Soft deletes enabled
- **Performance**:
  - Eager loading (`with('department')`)
  - Pagination using Laravel paginator
  - Cached index route with 60 seconds file/Redis cache
- **Validation**:
  - Form validation with error messages
  - Prevent form resubmission with PRG pattern

---

# API routes implemented

### Endpoints

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/api/employees` | List employees |
| GET | `/api/employees/{id}` | View single employee |
| POST | `/api/employees` | Create employee |
| PUT | `/api/employees/{id}` | Update employee |
| DELETE | `/api/employees/{id}` | Delete employee |

Response time < 300 ms 
![postman screenshot](https://github.com/user-attachments/assets/352c929a-ff6a-4c02-b658-efdc4a5ae9be)

[Winsome.Test.postman_collection.json](https://github.com/user-attachments/files/21022501/Winsome.Test.postman_collection.json)


# Installation Guide 

git clone https://github.com/Sameh09/winsome_test.git
cd winsome_test
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate
php artisan db:seed
php artisan serve


# default login credentials :-

Email    : admin@mail.com
Password : admin 

or Register New Account .



