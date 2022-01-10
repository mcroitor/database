# database
simple PHP library, PDO wrapper

## interface

```php
namespace mc;

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
     * insert values in table
     * @param string $table
     * @param array $values
     * @return void
     */
    public function insert(string $table, array $values): void;

    /**
     * Check if exists row with value(s) in table.
     * @param string $table
     * @param array $where
     * @return bool
     */
    public function exists(string $table, array $where): bool;

    /**
     * 
     * @param string $table
     * @param string $column
     */
    public function unique_values(string $table, string $column): array;
}

```
