# Attendance System

A brief description of your project.

## Table of Contents

- Installation
- Configuration
- Running the Application
- API Endpoints
- Testing
- License

## Installation

### Prerequisites

- PHP >= 8.0
- Composer
- Laravel 9.x
- MySQL or another database of your choice
- Node.js and npm (for front-end assets, if applicable)

### Steps

1. **Clone the repository**:
   ```bash
   git clone https://github.com/AmeraAmr51/Attendance-System.git
   cd Attendance-System

2. **Set up your database**:
- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=attendace_system
- DB_USERNAME=root
- DB_PASSWORD=


3. **Run Command**:
-php artisan migrate
-php artisan passport:install
-php artisan db:seed



# Apis

## login
Login URL : `http://localhost/api/user/login`

| #   | Method | URL       |
| :-- | :----- | :-------- |
| 1   | POST   | api/user/login |

### Body

```php
{
    "employee_id":"12345",
    "password":"password"
};

```
### loin.Response 
> {success} 200
> ```php
    {
        "response": {
                    "token": "your_token"
                },
        "message": "Login successful",
        "statuscode": 200
    }
---


## Attendance
Attendance URL : `http://localhost/api/user/attendance`

| #   | Method | URL       |
| :-- | :----- | :-------- |
| 1   | POST   | api/user/attendance |

### Body

```php
{
    "user_id":"1",
    "shift_id":"1",
    "clock_type":"clock_in",
    "location_type":"on-site",
};

```

## Headers

```php
{
    "Accept":"application/json",
    "Authorization":"your token"
};

```


### All these data are provided by Attendace System

    - user id
    - The user id of the source.
    - shift id
    - The shift id of the source.
    - clock_type
    - The clock type of the source and must be check_in or check_out.
    - location_type
    - The clock type of the source and must be on-site or remote.

---

### Attendance if user check in .Response 
> {success} 200
> ```php
    {
        "response": {
                    "id": "1",
                    "shift_id":"1",
                    "check_in":"2024-03-15 09:54:01"
                    "check_out":null,
                    "total_hour":null,
                    "location_type":"on-site",
                    "shift_name":"morning",
                },
        "message": "Success Attendance",
        "statuscode": 200
    }
---
### Attendance if user check out.Response 
> {success} 200
> ```php
    {
        "response": {
                    "id": "1",
                    "shift_id":"1",
                    "check_in":"2024-03-15 09:54:01"
                    "check_out":2024-03-15 17:54:01,
                    "total_hour":04:00:00,
                    "location_type":"on-site",
                    "shift_name":"morning",
                },
        "message": "Success Attendance",
        "statuscode": 200
    }
---



## User Total Hours
Total Hours URL : `http://localhost/api/user/total-hours`

| #   | Method | URL       |
| :-- | :----- | :-------- |
| 1   | GET   | api/user/total-hours |

## Headers

```php
{
    "Accept":"application/json",
    "Authorization":"your token"
};

```

### Params

```php
{
    "user_id":"1",
    "from":"2024-03-15",
    "to":"2024-04-15"
};

```
### Total Hours.Response 
> {success} 200
> ```php
    {
        "response": {
                    "data": "50:00:00"
                },
        "message": "Your Total Hours",
        "statuscode": 200
    }
---



# Notification by firebase 

-Make cron job to run every first day of the month 
