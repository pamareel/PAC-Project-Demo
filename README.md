# About

Website PAC-DSS dashboard with Laravel framework version 7.5.1 and SQL.

## Run project

1. Clone project

```
git clone <project url>
cd PAC-Project-Demo
```

2. Get composer from https://getcomposer.org/download/ 

3. Install composer to the project

```
cmd PAC-Project-Demo
composer install
```

4. After composer installing, create .env

```
copy .env.example .env
```

5. Config .env, change variables for your environment such as database connection.

```
DB_CONNECTION=sqlsrv
DB_HOST=127.0.0.1
DB_PORT=1433
DB_DATABASE=example 
DB_USERNAME=sa
DB_PASSWORD=Dockersql123
```

6. Change variable in \config\database.php for your database connection


```
'sqlsrv' => [
           'driver' => 'sqlsrv',
           'url' => env('DATABASE_URL'),
           'host' => env('DB_HOST', 'localhost'),
           'port' => env('DB_PORT', '1433'),
           'database' => env('DB_DATABASE', 'example'),
           'username' => env('DB_USERNAME', 'sa'),
           'password' => env('DB_PASSWORD', 'Dockersql123'),
           'charset' => 'utf8',
           'prefix' => '',
           'prefix_indexes' => true,
       ],
```

7. Run project

```
php artisan key:generate
php artisan serve
```

8. The project can be opened in browser “localhost:8000”

    * For policy maker user: “localhost:8000/DashboardPage”
    
    * For hospital user: “localhost:8000/DashboardHosUser”

## Data part

Make sure to have sql server run on your computer 

### Requirement list for data

1. Original data table:  A table named “drugs”

```
Table format of drugs
(Record_ID, Project_ID, BUDGET_YEAR, REAL_METHOD_ID, REAL_METHOD_NAME, DEPT_ID, DEPT_NAME, PROVINCE_NAME, GPU_ID, GPU_NAME, TPU_ID, TPU_NAME, PRICE_PROPOSAL, หน่วยของ_TPU, Real_Amount, Real_Unit_price, C_Cleaned_NA_ไม่สามารถคลีนได้, _9_gr, ED_NED, Top_Rank_GPU)
```
2. Calculated data table: All the tables can be calculated by using Python code given below.

 (https://drive.google.com/open?id=1LfA4E7Zr0V9wPPVFxSiMhxo4Cdml-tbI)
 
Note that the order for running Python code should follow step below and make sure that the connection detail in this code is changed to be the same as your connection.

* "costSaving_table_GPU.py" give a result as 2 tables named “CostSaving_GPU” and “CostSaving_hos_GPU”.
* "costSaving_table_TPU.py" give a result as 2 tables named “CostSaving_TPU” named “CostSaving_hos_TPU”.
* "find_PAC_value_GPU.py " give a result as a table named “PAC_hos_GPU”.
* "find_PAC_value_TPU.py" give a result as a table named “PAC_hos_TPU”.
* "find_Gini_GPU.py" give a result as a table named “Gini_drugs_GPU”.
* "find_Gini_TPU.py" give a result as a table named “Gini_drugs_TPU”.

Note that the result from Python code will be in ".xlsx" file which is needed to be converted again to ".csv" file for using in our project.

3. Additional data table. (https://drive.google.com/open?id=189K7H0eZH557CyJRnfUgaLxZXN-7-k_t)

* A table named “Region-Province” (provided)
* A table named “Hos_detail”: This data can be found in https://phdb.moph.go.th/main/index/downloadlist/57/0 (ข้อมูลพื้นฐานโรงพยาบาลในสังกัดสำนักงานปลัดกระทรวงสาธารณสุข). But it also needs to be rearranged and joined with other tables to be in the required format using sql command. (hos_detail.sql)

```
Table format of Hos_detail
BUDGET_YEAR, DEPT_ID, DEPT_NAME, ServicePlanType, PROVINCE_NAME, PROVINCE_EN, Pcode, Region, IP, OP, Total_Spend
```

