# Quick Start - Project With Laravel 9.x and AdminLTE 3

### Step by step

Clone this Repository

```sh
git clone https://github.com/tushar5334/cms.git cms
```

Create the .env file

```sh
cd cms/
cp .env.example .env
```

Update environment variables in .env

```dosini
APP_NAME="Name Your Project"
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=<db-name>
DB_USERNAME=<db-user>
DB_PASSWORD=<db-password>
DB_PREFIX=tbl_

QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=2525
MAIL_USERNAME=<username>
MAIL_PASSWORD=<password>
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=<from-email-address>
MAIL_FROM_NAME="${APP_NAME}"
```

Install project dependencies

```sh
composer install
```

Migrate database

```sh
php artisan migrate
```

Seed data

```sh
php artisan tinker
```

Execute below commands to seed dummy data to tables to tinker terminal

```sh
App\Models\Admin\User::factory()->count(1)->create();
App\Models\Admin\Category::factory()->count(10)->create();
App\Models\Admin\Company::factory()->count(10)->create();
App\Models\Admin\Inquiry::factory()->count(10)->create();
App\Models\Admin\Page::factory()->count(10)->create();
App\Models\Admin\Product::factory()->count(10)->create();
App\Models\Admin\Segment::factory()->count(10)->create();
App\Models\Admin\SliderImage::factory()->count(10)->create();
```

Generate storage link

```sh
php artisan storage:link
```

To make queue in working condition execute below command.

```sh
php artisan queue:work
```

Server project to localhost

```sh
php artisan serve
```

Access the project
[http://127.0.0.1:8000/admin/login](http://127.0.0.1:8000/admin/login)

Credentials for login

```sh
Email:admin@admin.com
Password:password
```
