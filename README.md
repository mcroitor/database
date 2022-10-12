# database

Simple PHP library, PDO wrapper. Library provides an SQL builder also. You always can use 
`database.php` file directly, it has only one dependency, from `query` class. Feel free
to remove exec method if you don't use it.

Project is defined into `\mc\sql` namespace;

Project is composed from 3 classes:

 * `database` - simple PDO wrapper
 * `query` - query builder
 * `crud` - class that implements C(reate) R(ead) U(pdate) D(elete)
  
Limitations:
 * where conditions are limited with compare operator, use `query_sql` method if you want
   to do something more complex 

## examples

### database wrapper usage
Connection to sqlite database:
```php
$db = new \mc\sql\database("sqlite:sample.db");
```
Connection to MySQL:
```php
$db = new \mc\sql\database("mysql:host=localhost;dbname=database", "user", "password");
```
Select from table `variables` all fields:
```php
$db->select("variables");
```
### query builder

Build select query:

```php
// query builder
$query_builder = query::select()->table('variable');
echo $query_builder->build();

// select only 'name', 'value' fields
$query_builder = $query_builder->fields(['name', 'value']);
echo $query_builder->build();
```

### crud

The `crud` class simplifies interogation with database.
It provide only basic interface, based on table key:

 - `insert` - creates record in the table, returns id.
 - `select` - returns a record by id.
 - `all` - returns an array of records.
 - `update` - updates record by id.
 - `delete` - removes record by id.

## interface

The `\mc\sql\database` class interface:

```php
namespace mc\sql;

class database {

    public function __construct(string $dsn, ?string $login = null, ?string $password = null);

    /**
     * Common query method
     * @global string $site
     * @param string $query
     * @param string $error
     * @param bool $need_fetch
     * @return array
     */
    public function query_sql(string $query, string $error = "Error: ", bool $need_fetch = true): array;

    /**
     * Method for dump parsing and execution
     * @param string $dump
     */
    public function parse_sqldump(string $dump);

    /**
     * Simplified selection.
     * @param string $table
     * @param array $data enumerate columns for selection. Sample: ['id', 'name'].
     * @param array $where associative conditions.
     * @param array $limit definition sample: ['from' => '1', 'total' => '100'].
     * @return array
     */
    public function select(string $table, array $data = ['*'], array $where = [], array $limit = []): array;

    /**
     * Delete rows from table <b>$table</b>. Condition is required.
     * @param string $table
     * @param array $conditions
     * @return array
     */
    public function delete(string $table, array $conditions): array;

    /**
     * Update fields <b>$values</b> in table <b>$table</b>. <b>$values</b> and 
     * <b>$conditions</b> are required. 
     * @param string $table
     * @param array $values
     * @param array $conditions
     * @return array
     */
    public function update(string $table, array $values, array $conditions): array;

    /**
     * insert values in table and returns id.
     * @param string $table
     * @param array $values
     * @return int
     */
    public function insert(string $table, array $values): int;

    /**
     * Check if exists row with value(s) in table.
     * @param string $table
     * @param array $where
     * @return bool
     */
    public function exists(string $table, array $where): bool;

    /**
     * Select unique values from column.
     * @param string $table
     * @param string $column
     */
    public function unique_values(string $table, string $column): array;

    /**
     * Execute a query object.
     * @param query $query
     * @return array
     */
    public function exec(\mc\sql\query $query): array;
}

```

The `\mc\sql\query` class interface:
```php
namespace mc\sql;

class query {
    public const SELECT = "SELECT";
    public const INSERT = "INSERT";
    public const UPDATE = "UPDATE";
    public const DELETE = "DELETE";

    public const TYPE = "type";
    public const TABLE = "table";
    public const FIELDS = "fields";
    public const VALUES = "values";
    public const WHERE = "where";
    public const ORDER = "order";
    public const LIMIT = "limit";

    public function __construct(array $config);
    public function get_type(): string;
    public static function select(): query;
    public static function insert(): query;
    public static function update(): query;
    public static function delete(): query;
    public function clone(): query;
    public function fields(array $fields): query;
    public function values(array $values): query;
    public function where(array $where): query;
    public function order(array $order): query;
    public function limit(int $limit, int $offset = 0): query;
    public function table(string $table): query;
    public function build(): string;
    protected function build_fields(): string;
    protected function build_values(): string;
    protected function build_where(): string;
    protected function build_order(): string;
    protected function build_limit(): string;
}
```

The `\mc\sql\crud` class interface:
```php
namespace mc\sql;

class crud {

    /**
     * crud constructor, must be passed a database object and a table name
     * the key is the primary key of the table, defaults to 'id' 
     * @param database $db
     * @param string $table
     * @param string $key
     */
    public function __construct(database $db, string $table, $key = "id");

    /**
     * insert a new record. Returns the id of the new record
     *
     * @param array|object $data
     */
    public function insert($data);

    /**
     * select a record by id / key
     * 
     * @param int|string $id
     * @return array
     */
    public function select($id);

    /**
     * select <b>$limit</b> records from <b>$offset</b> record.
     * 
     * @param int $offset
     * @param int $limit
     * @return array 
     */
    public function all($offset = 0, $limit = 100);

    /**
     * update a record by id / key
     * parameter <b>$data</b> must include the key
     * 
     * @param array|object $data
     */
    public function update($data);

    /**
     * delete a record by id / key
     * 
     * @param int|string $id
     */
    public function delete($id);

    /**
     * return the table name, userd for all CRUD operations
     * 
     * @return string
     */
    public function table();

    /**
     * return the key name, userd for all CRUD operations
     * 
     * return string
     */
    public function key();
}
```