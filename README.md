# database

Simple PHP library, PDO wrapper. Library provides an SQL builder also. You always can use `database.php` file directly, it has only one dependency, from `query` class. Feel free to remove exec method if you don't use it.

Project is defined into `\Mc\Sql` namespace;

Project is composed from 3 classes:

- `Database` - simple PDO wrapper
- `Query` - query builder
- `Crud` - class that implements C(reate) R(ead) U(pdate) D(elete)
  
Limitations:

- mysql and sqlite support

The `Crud` class simplifies interogation with database.
It provide only basic interface, based on table key:

- `insert` - creates record in the table, returns id.
- `select` - returns a record by id.
- `all` - returns an array of records.
- `update` - updates record by id.
- `delete` - removes record by id.

## examples

### database wrapper usage

Connection to sqlite database:

```php
$db = new \Mc\Sql\Database("sqlite:sample.db");
```

Connection to MySQL:

```php
$db = new \Mc\Sql\Database("mysql:host=localhost;dbname=database", "user", "password");
```

Select from table `variables` all fields:

```php
$variables = $db->select("variables");
```

### query builder

Build select query:

```php
use Mc\Sql\Query;

// query builder
$query_builder = Query::select()->table('variable');
echo $query_builder->build();

// select only 'name', 'value' fields
$query_builder = $query_builder->fields(['name', 'value']);
echo $query_builder->build();
```

### crud

Sample of usage:

```php
use Mc\Sql\Crud;

$db = new \Mc\Sql\Database("sqlite:sample.db");
$variable = new Crud($db, "variable", "name");

$language = $variable->select("language");
echo $language["name"] . ": " . $language["value"] . PHP_EOL;
```

## interface

The `\Mc\Sql\Database` class interface:

```php
namespace Mc\Sql;

use Mc\Sql\Query;

/**
 * PDO wrapper
 *
 * @author Croitor Mihail <mcroitor@gmail.com>
 */
class Database
{

    public const LIMIT1 = ['limit' => 1, 'offset' => 0];
    public const LIMIT10 = ['limit' => 10, 'offset' => 0];
    public const LIMIT20 = ['limit' => 20, 'offset' => 0];
    public const LIMIT100 = ['limit' => 100, 'offset' => 0];

    public const ALL = ["*"];

    public function __construct(string $dsn, ?string $login = null, ?string $password = null);

    /**
     * Close connection. After this queries are invalid and object recreating is obligatory.
     */
    public function close();

    /**
     * Common query method
     * @param string $query
     * @param string $error
     * @param bool $need_fetch
     * @return array
     */
    public function query(string $query, string $error = "Error: ", bool $need_fetch = true): array;

    /**
     * Method for dump parsing and execution
     * @param string $dump
     */
    public function parseSqlDump(string $dump): void;

    /**
     * Simplified selection.
     * @param string $table
     * @param array $data enumerate columns for selection. Sample: ['id', 'name'].
     * @param array $where associative conditions.
     * @param array $limit definition sample: ['offset' => '1', 'limit' => '100'].
     * @return array
     */
    public function select(string $table, array $data = ['*'], array $where = [], array $limit = []): array;

    /**
     * select column from table
     * @param string $table
     * @param string $column_name column name for selection.
     * @param array $where associative conditions.
     * @param array $limit definition sample: ['offset' => '1', 'limit' => '100'].
     */
    public function selectColumn(string $table, string $column_name, array $where = [], array $limit = []): array;

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
     * insert values in table, returns id of inserted data.
     * @param string $table
     * @param array $values
     * @return string|false
     */
    public function insert(string $table, array $values): string|false;

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
    public function uniqueValues(string $table, string $column): array;

    /**
     * count unique values from column. Result is an array of elements {<column_value>, <count>}
     * @param string $table
     * @param string $column
     * @return array
     */
    public function countUniqueValues(string $table, string $column): array;

    /**
     * Execute a query object.
     * @param Query $query
     * @return array
     */
    public function exec(Query $query): array;
}
```

The `\Mc\Sql\Query` class interface:

```php
namespace Mc\Sql;

/**
 * SQL query builder.
 */
class Query {
    /**
     * supported commands
     */
    public const SELECT = "SELECT";
    public const INSERT = "INSERT";
    public const UPDATE = "UPDATE";
    public const DELETE = "DELETE";

    /**
     * query configuration parameters
     */
    public const TYPE = "type";
    public const TABLE = "table";
    public const FIELDS = "fields";
    public const VALUES = "values";
    public const WHERE = "where";
    public const ORDER = "order";
    public const GROUP = "group";
    public const LIMIT = "limit";

    public function __construct(array $config);

    /**
     * return query command type
     * @return string
     */
    public function getType(): string;

    /**
     * create query for select
     * @return Query
     */
    public static function select(): query;

    /**
     * create query for insert
     * @return Query
     */
    public static function insert(): Query;

    /**
     * create query for update
     * @return Query
     */
    public static function update(): Query;

    /**
     * create query for delete
     * @return Query
     */
    public static function delete(): Query;

    /**
     * clone a query
     * @return Query
     */
    public function clone(): Query;

    /**
     * set fields and return new query
     * @param array $fields
     * @return Query
     */
    public function fields(array $fields): Query;

    /**
     * set values and return new query
     * @param array $values
     * @return Query
     */
    public function values(array $values): Query;

    /**
     * set where conditions and return new query
     * @param array $where
     * @return Query
     */
    public function where(array $where): Query;

    /**
     * set order conditions and return new query
     * @param array $order
     * @return Query
     */
    public function order(array $order): Query;

    /**
     * set limit conditions and return new query
     * @param array $limit
     * @return Query
     */
    public function limit(int $limit, int $offset = 0): Query;

    /**
     * set table and return new query
     * @param string $table
     * @return Query
     */
    public function table(string $table): Query;

    /**
     * return query string
     * @return string
     */
    public function build(): string;

/**
     * convert query object to string
     * @return string
     */
    public function __toString(): string;
}
```

The `\Mc\Sql\Crud` class interface:

```php
namespace Mc\Sql;

use \Mc\Sql\Database;

/**
 * Simple CRUD implementation
 */
class Crud
{
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
     * @return string|false
     */
    public function insert(array|object $data): string|false;

    /**
     * select a record by id / key
     *
     * @param int|string $id
     * @return array
     */
    public function select(int|string $id): array;

    /**
     * select <b>$limit</b> records from <b>$offset</b> record.
     *
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function all(int $offset = 0, int $limit = 100): array;

    /**
     * update a record by id / key
     * parameter <b>$data</b> must include the key
     *
     * @param array|object $data
     * @return array
     */
    public function update(array|object $data): array;

    /**
     * if $data object contains key property, table will be
     * updated, otherwise new line will be inserted.
     *
     * @param array|object $data
     * @return array if object is updated
     * @return string if object is inserted, the id of the new object
     * @return false if object is not inserted or updated
     */
    public function insertOrUpdate(array|object $data): array|string|false;

    /**
     * delete a record by id / key
     * 
     * @param int|string $id
     */
    public function delete(int|string $id): void;

    /**
     * return the table name, used for all CRUD operations
     * 
     * @return string
     */
    public function table(): string;

    /**
     * return the key name, used for all CRUD operations
     * 
     * @return string
     */
    public function key(): string;

    /**
     * return number of lines in the associated table
     * 
     * @return int
     */
    public function count(): int;
}
```
