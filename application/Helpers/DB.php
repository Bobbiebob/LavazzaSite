<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 20-1-20
 * Time: 10:29
 */

namespace Application\Helpers;


use PDO;
use PDOException;
use PDOStatement;

class DB
{

    public const AND = 'AND';
    public const OR = 'OR';

    /**
     * @var PDO
     */
    public static $_db = null;

    /**
     * @var PDOStatement
     */
    public $_query;

    public static function getPDOInstance()
    {
        if (is_null(self::$_db)) {
            try {
                $obj = new PDO('mysql:host=' . Config::get('database.host') . ';dbname=' . Config::get('database.database'), Config::get('database.username'), Config::get('database.password'));
                $obj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$_db = $obj;
            } catch (PDOException $e) {
                throw new \Exception("Database error: " . $e->getMessage());
            }
        }

        return self::$_db;
    }

    private $preparedData = [];

    private $_params = [
        'type' => 'select',
        'select' => '*',
        'table' => '',
        'whereNull' => [],
        'where' => [],
        'whereIn' => [],
        'whereRaw' => [],
        'join' => [],
        'whereOperator' => self:: AND
    ];

    private function resetQuery()
    {
        $this->_params = [
            'type' => 'select',
            'select' => '*',
            'table' => '',
            'whereNull' => [],
            'where' => [],
            'whereIn' => [],
            'whereRaw' => [],
            'join' => [],
            'whereOperator' => self:: AND
        ];
    }

    public function select($fields = [])
    {
        $this->resetQuery();
        if (count($fields) > 0) {
            $this->_params['select'] = implode(', ', $fields);
            $this->_params['type'] = 'select';
        }
        return $this;
    }

    public function join($table, $first, $operator, $second, $type = 'inner')
    {
        $this->_params['join'][] = [
            'table' => $table,
            'first' => $first,
            'operator' => $operator,
            'second' => $second,
            'type' => $type,
        ];

        return $this;
    }

    public function run()
    {
        try {
            $this->_query = DB::runRaw($this->query(), $this->preparedData);
        } catch (PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }

        return $this;
    }

    /**
     * Run a raw prepared PDO statement.
     *
     * @param string $query The query to exeucte
     * @param array $data The prepared data.
     * @return PDOStatement The executed PDO statement
     * @throws DatabaseException
     */
    public static function runRaw($query, array $data = [])
    {
        $query = DB::getPDOInstance()->prepare($query);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute($data);

        return $query;
    }

    /**
     * Check if the provided table name exists.
     *
     * @param string $table The table name.
     * @return bool True when the table exists.
     * @throws DatabaseException
     */
    public static function tableExists($table): bool
    {
        $db = new DB();

        return !(bool)$db->select([])
            ->table('INFORMATION_SCHEMA.TABLES')
            ->where('TABLE_NAME', $table)
            ->where('TABLE_SCHEMA', Config::get('database.database'))
            ->run()
            ->count();
    }

    public function count()
    {
        return $this->_query->rowCount();
    }

    public function fetch()
    {
        return $this->_query->fetch();
    }

    public function lastInsertId()
    {
        return DB::getPDOInstance()->lastInsertId();
    }

    public function fetchAll()
    {
        return $this->_query->fetchAll();
    }

    public function insert($fields)
    {
        $this->resetQuery();
        $this->_params['insert'] = $fields;
        $this->_params['type'] = 'insert';
        return $this;
    }

    public function update($fields)
    {
        $this->resetQuery();
        $this->_params['update'] = $fields;
        $this->_params['type'] = 'update';
        return $this;
    }

    public function delete()
    {
        $this->resetQuery();
        $this->_params['type'] = 'delete';
        return $this;
    }

    public function whereOperator($operator)
    {
        if ($operator == self:: AND || $operator == self:: OR) {
            $this->_params['whereOperator'] = $operator;
        }
        return $this;
    }

    public function table($table)
    {
        $this->_params['table'] = $table;
        return $this;
    }

    public function where($key, $operator, $value = null)
    {
        if (is_null($value)) {
            $value = $operator;
            $operator = '=';
        }
        $this->_params['where'][] = [
            'key' => $key,
            'operator' => $operator,
            'value' => $value
        ];
        return $this;
    }

    public function whereRaw(string $raw, array $params)
    {
        $this->_params['whereRaw'][] = [
            'raw' => $raw,
            'params' => $params
        ];
        return $this;
    }

    public function whereNull($value)
    {
        $this->_params['whereNull'] = $value;
        return $this;
    }

    public function whereIn(string $key, array $values)
    {
        $this->_params['whereIn'][] = [
            'key' => $key,
            'values' => $values
        ];
        return $this;
    }

    /**
     * Order by.
     *
     * @param array|string $columns
     * @param bool $desc
     * @return $this
     */
    public function orderBy($columns, $desc = false)
    {
        // If a string is provided convert it to an array.
        if (is_string($columns)) {
            $columns = [$columns];
        }

        $this->_params['orderBy'] = [
            'columns' => $columns,
            'desc' => $desc
        ];

        return $this;
    }

    /**
     * This function will form a valid SQL function from the earlier set parameters
     */
    public function query()
    {
        $func = strtolower($this->_params['type']) . 'Query';
        if (!method_exists($this, $func)) {
            throw new \Exception("Invalid query type (" . $this->_params['type'] . ").");
        }
        return $this->$func();
    }

    public function insertQuery()
    {
        if (count($this->_params['insert']) < 0 or !is_array($this->_params['insert'])) {
            throw new \Exception("Dataset given to insert is not valid.");
        }
        $this->preparedData = array_values($this->_params['insert']);
        return 'INSERT INTO ' . $this->_params['table'] . ' (' . implode(', ', array_keys($this->_params['insert'])) . ') VALUES (' . implode(',', array_fill(0, count($this->preparedData), '?')) . ')';
    }

    public function updateQuery()
    {
        if (count($this->_params['update']) < 0 or !is_array($this->_params['update'])) {
            throw new \Exception("Dataset given to insert is not valid.");
        }

        $prepData = [];

        $update = implode(', ', array_map(function ($key) use (&$prepData) {
            $prepData[] = $this->_params['update'][$key];

            return $key . ' = ?';
        }, array_keys($this->_params['update'])));

        $where = '';
        if (count($this->_params['where']) > 0 || count($this->_params['whereIn']) > 0 || count($this->_params['whereNull']) > 0 || count($this->_params['whereRaw']) > 0) {
            $where = ' WHERE';
            $i = 0;
            foreach ($this->_params['where'] as $value) {
                if ($i++ > 0) {
                    $where .= ' ' . $this->_params['whereOperator'];
                }
                $where .= ' ' . $value['key'] . ' ' . $value['operator'] . ' ?';
                $prepData[] = $value['value'];
            }

            foreach ($this->_params['whereIn'] as $value) {
                if ($i++ > 0) {
                    $where .= ' ' . $this->_params['whereOperator'];
                }
                $where .= ' ' . $value['key'] . ' IN (' . implode(',', array_fill(0, count($value['values']), '?')) . ')';
                $prepData = array_merge($prepData, $value['values']);
            }

            foreach ($this->_params['whereRaw'] as $value) {
                if ($i++ > 0) {
                    $where .= ' ' . $this->_params['whereOperator'];
                }
                $where .= ' ' . $value['raw'];
                $prepData = array_merge($prepData, $value['params']);
            }

            foreach ($this->_params['whereNull'] as $value) {
                if ($i++ == 1) {
                    $where .= ' ' . $this->_params['whereOperator'];
                }
                $where .= ' ' . $value . ' IS NULL';
            }
        }
        $this->preparedData = $prepData;

        return 'UPDATE ' . $this->_params['table'] . ' SET ' . $update . ' ' . $where;
    }

    public function selectQuery()
    {
        $where = '';
        $prepData = [];
        if (count($this->_params['where']) > 0 || count($this->_params['whereIn']) > 0 || count($this->_params['whereNull']) > 0 || count($this->_params['whereRaw']) > 0) {
            $where = ' WHERE';
            $i = 0;
            foreach ($this->_params['where'] as $value) {
                if ($i++ > 0) {
                    $where .= ' ' . $this->_params['whereOperator'];
                }
                $where .= ' ' . $value['key'] . ' ' . $value['operator'] . ' ?';
                $prepData[] = $value['value'];
            }

            foreach ($this->_params['whereIn'] as $value) {
                if ($i++ > 0) {
                    $where .= ' ' . $this->_params['whereOperator'];
                }
                $where .= ' ' . $value['key'] . ' IN (' . implode(',', array_fill(0, count($value['values']), '?')) . ')';
                $prepData = array_merge($prepData, $value['values']);
            }

            foreach ($this->_params['whereRaw'] as $value) {
                if ($i++ > 0) {
                    $where .= ' ' . $this->_params['whereOperator'];
                }
                $where .= ' ' . $value['raw'];
                $prepData = array_merge($prepData, $value['params']);
            }

            foreach ($this->_params['whereNull'] as $value) {
                if ($i++ == 1) {
                    $where .= ' ' . $this->_params['whereOperator'];
                }
                $where .= ' ' . $value . ' IS NULL';
            }
        }

        $join = implode(' ', array_map(function ($join) {
            return ' ' . $join['type'] . ' JOIN ' . $join['table'] . ' ON ' . $join['first'] . ' ' . $join['operator'] . ' ' . $join['second'];
        }, $this->_params['join']));

        $orderBy = isset($this->_params['orderBy']) ? 'ORDER BY ' . implode(', ', $this->_params['orderBy']['columns']) . ($this->_params['orderBy']['desc'] ? ' DESC' : '') : '';

        $this->preparedData = $prepData;
        return 'SELECT ' . $this->_params['select'] . ' FROM ' . $this->_params['table'] . $join . ' ' . $where . ' ' . $orderBy;
    }

    public function deleteQuery()
    {
        $where = '';
        $prepData = [];
        if (count($this->_params['where']) > 0 || count($this->_params['whereIn']) > 0 || count($this->_params['whereNull']) > 0 || count($this->_params['whereRaw']) > 0) {
            $where = ' WHERE';
            $i = 0;
            foreach ($this->_params['where'] as $value) {
                if ($i++ > 0) {
                    $where .= ' ' . $this->_params['whereOperator'];
                }
                $where .= ' ' . $value['key'] . ' ' . $value['operator'] . ' ?';
                $prepData[] = $value['value'];
            }
            foreach ($this->_params['whereIn'] as $value) {
                if ($i++ > 0) {
                    $where .= ' ' . $this->_params['whereOperator'];
                }
                $where .= ' ' . $value['key'] . ' IN (' . implode(',', array_fill(0, count($value['values']), '?')) . ')';
                $prepData = array_merge($prepData, $value['values']);
            }
            foreach ($this->_params['whereRaw'] as $value) {
                if ($i++ > 0) {
                    $where .= ' ' . $this->_params['whereOperator'];
                }
                $where .= ' ' . $value['raw'];
                $prepData = array_merge($prepData, $value['params']);
            }

            foreach ($this->_params['whereNull'] as $value) {
                if ($i++ == 1) {
                    $where .= ' ' . $this->_params['whereOperator'];
                }
                $where .= ' ' . $value . ' IS NULL';
            }
        }
        $this->preparedData = $prepData;
        return 'DELETE FROM ' . $this->_params['table'] . $where;
    }


    public static function object()
    {
        $db = new DB();
        return $db;
    }

}