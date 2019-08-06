```bash
~$ php artisan model:list
                                                                                                                                                                                                      |
+----------------------------------+-------------------+-------------+-------------+--------------+
| Model                            | Table             | Table count | Scope count | Soft deleted |
+----------------------------------+-------------------+-------------+-------------+--------------+
| App\Models\Admin\Admin           | admins            | 3           | 3           |              |
| App\Models\Admin\Attribute       | attributes        | 148         | 148         |              |
| App\Models\Admin\Brand           | brands            | 152         | 152         |              |
| App\Models\Admin\Category        | categories        | 70          | 70          |              |
| App\Models\Admin\Newsletter      | newsletter        | 452         | 452         |              |
| App\Models\Admin\Product         | products          | 4485        | 4485        | 0            |
| App\Models\Admin\RedirectRule    | redirect_rules    | 2632        | 2632        |              |
| App\Models\Admin\Slide           | slides            | 2           | 2           |              |
| App\Models\Admin\User            | users             | 2644        | 2644        |              |
| App\Models\Admin\Warranty        | warranties        | 9           | 9           |              |
|                                  |                   |             |             |              |
| App\Models\Attribute             | attributes        | 148         | 148         |              |
| App\Models\Brand                 | brands            | 152         | 152         |              |
| App\Models\Category              | categories        | 70          | 70          |              |
| App\Models\Product               | products          | 4485        | 3079        | 197          |
| App\Models\User                  | users             | 2644        | 2644        |              |
| App\Models\Warranty              | warranties        | 9           | 9           |              |
+----------------------------------+-------------------+-------------+-------------+--------------+
```

```bash
~$ php artisan model:fields

 Choose model to show the fields from::
  [1] App\Models\Brand
  [2] App\Models\Category
  [3] App\Models\Product
  [4] App\Models\Warranty
 > 4

 Model: `App\Models\Warranty`
+------------+----------------------+----------+---------+-------+---------+----------+
| Field      | Type                 | Nullable | Default | Casts | Guarded | Fillable |
+------------+----------------------+----------+---------+-------+---------+----------+
| id         | int(10) unsigned     |          |         | int   | YES     |          |
| name       | varchar(255)         |          |         |       |         |          |
| length     | smallint(5) unsigned |          | 365     |       |         |          |
| created_at | timestamp            | YES      |         |       |         |          |
| updated_at | timestamp            | YES      |         |       |         |          |
+------------+----------------------+----------+---------+-------+---------+----------+
```

```bash
~$ php artisan db:drop

 Do you really wish to drop `laravel_commando` database? (yes/no) [no]:
 > yes

 [OK] Database `laravel_commando` dropped successfully
```

```bash
~$ php artisan db:exist

 ! [NOTE] Database `laravel_commando` exists
```

```bash
~$ php artisan db:create

 [OK] Database `laravel_commando` created successfully
```

```bash
~$ php artisan db:import-dump

 Lookup dir: /var/www/html/storage/app

 Choose dump to be imported: [laravel_commando-2019-08-03-20-17-24.sql]:
  [1] laravel_commando-2019-08-03-20-17-24.sql
  [2] laravel_commando-2019-07-23-12-48-28.sql
  [3] laravel_commando-2019-07-07-22-09-06.sql
 > 2

 Database 'laravel_commando' exist.
 What should we do: [I changed my mind, I don`t want to import dump]:
  [0] I changed my mind, I don`t want to import dump
  [1] Import dump over existing database `laravel_commando`
  [2] Recreate `laravel_commando` database (!!! CAUTION !!!) and than import dump
 > 2

 [OK] Dump file imported successfully
```

```bash
~$ php artisan db:summon

 [WARNING] This command will:

 * drop database `laravel_commando` if one exists
 * create empty database `laravel_commando`
 * migrate database (same as `php artisan migrate`)
 * seed database (same as `php artisan db:seed`)

 Do you really wish to continue? (yes/no) [no]:
 > y

 [OK] Database `laravel_commando` summoned successfully
```

```bash
~$ php artisan db:create

 [OK] Database `laravel_commando` created successfully


 ~$ php artisan db:dump

  [OK] Database `laravel_commando` dumped successfully

  Destination: `/var/www/html/storage/app/laravel_commando-2019-08-03-22-16-03.sql`
```