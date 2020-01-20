<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 20-1-20
 * Time: 10:37
 */

namespace Application\Helpers;


class Validator
{

    /**
     * Array that contains messages to return to the user.
     *
     * @var array
     */
    private $message = [];

    /**
     * Array that contains the friendly error messages.
     *
     * @var array
     */
    private $friendly = [];

    /**
     * Boolean that reports whether or not the validation was successful.
     *
     * @var bool
     */
    private $valid = true;

    /**
     *
     * Returns instance of Valiatior object which has validated input.
     *
     * @param string $input Input (usually $_POST will do)
     * @param array $rules Rules to test the $input against. Use an array: [ 'field' => 'test:arg1,arg2,arg3']
     * @param array $friendly Supply array to use friendly names in error messages, rather than actual field names.
     * @return Validator (this object)
     */
    public static function make($input, $rules, $friendly = [])
    {
        $object = new Validator;
        $object->input = $input;
        $object->rules = $rules;
        $object->friendly = $friendly;
        $object->run();
        return $object;
    }

    /**
     *
     * Check whether friendly name is given, if not, just return the input.
     *
     * @param string $key Field' name.
     * @return mixed either friendly name or the input.
     */
    private function getFriendly($key)
    {
        if (isset($this->friendly[$key])) {
            return $this->friendly[$key];
        }
        return $key;
    }

    /**
     *
     * Where the magic happens..
     *
     */
    public function run()
    {
        foreach ($this->rules as $field => $rules) {
            $rules = explode('|', $rules);

            foreach ($rules as $rule) {
                $parts = explode(':', $rule);
                $method = strtolower(array_shift($parts));
                $rest = array_shift($parts);
                $args = [];
                if (trim($rest) !== '') {
                    $args = explode(',', $rest);
                }
                if (method_exists($this, $method)) {
                    $res = $this->$method($field, ...$args);

                    if ($res === true) continue 2;

                    if ($res) {
                        // invalid.
                        $this->valid = false;
                        $this->message[] = $res;
                        continue;
                    }
                }
            }


        }
    }

    /**
     * @return bool whether the tests have come out valid or not..
     */
    public function isValid()
    {
        return (isset($this->valid) && $this->valid !== false);
    }

    /**
     * @return array Array consisting of messages to show to End-User.
     */
    public function getMessageBag()
    {
        return isset($this->message) ? $this->message : [];
    }

    /**
     * Check if the field is empty. This will always be valid but it will influence the following rules.
     *
     * @param string $field The input key.
     * @param mixed ...$args Useless here, just here for compatibility.
     * @return bool TRUE when the input is empty and the following rules should be ignored or FALSE when the input isn't empty.
     */
    private function nullable($field, ...$args)
    {
        return !isset($this->input[$field]) || trim($this->input[$field]) == '';
    }

    /**
     * Check if the field is required based on another field.
     *
     * @param string $field The input key.
     * @param mixed ...$args The first arg is the field name where this field depends on.
     * @return bool
     */
    private function required_with($field, ...$args)
    {
        if (!isset($this->input[$args[0]]) || trim($this->input[$args[0]]) == '') {
            return !isset($this->input[$field]) || trim($this->input[$field]) == '';
        }

        return $this->required($field, []);
    }

    /**
     * Check whether field is included in input data
     * @param string $field Key as in the input
     * @param mixed ...$args Useless here, just here for compatibility.
     * @return bool|string either string (message for user) or FALSE (= all fine)
     */
    private function required($field, ...$args)
    {
        if (!isset($this->input[$field]) || trim($this->input[$field]) == '') {
            return 'The field \'' . $this->getFriendly($field) . '\' is required.';
        }
        return false;
    }

    /**
     * Check whether value is one of the options (in_array).
     * @param string $field Key as in the input
     * @param mixed ...$args array of possible values
     * @return bool|string either string (message for user) or FALSE (= all fine)
     */
    private function in($field, ...$args)
    {
        if (!in_array($this->input[$field], $args)) {
            return '\'' . $this->input[$field] . '\' is is invalid.';
        }
        return false;
    }

    /**
     * Check whether value is present in DB.
     * @param string $field Key as in the input
     * @param mixed ...$args [0] = Table name, [1] = Column name, [2] = Exclude this value, [3] = Exclude this column
     * @return bool|string either string (message for user) or FALSE (= all fine)
     * @throws \App\Exceptions\DatabaseException
     */
    private function unique($field, ...$args)
    {
        $table = $args[0];
        $column = $args[1];
        $except = isset($args[2]) ? $args[2] : null;
        $exceptColumn = isset($args[3]) ? $args[3] : 'id';

        $query = (new DB)->select()
            ->table($table)
            ->where($column, $this->input[$field]);

        if ($except) {
            $query = $query->where($exceptColumn, '!=', $except);
        }

        $query->run();

        if ($query->count() > 0) {
            return '\'' . $this->input[$field] . '\' is already in our database.';
        }
        return false;
    }

    /**
     * Check whether value is present in DB.
     * @param string $field Key as in the input
     * @param mixed ...$args [0] = Table name, [1] = Column name, [2] = Exclude this value, [3] = Exclude this column
     * @return bool|string either string (message for user) or FALSE (= all fine)
     * @throws \App\Exceptions\DatabaseException
     */
    private function exists($field, ...$args)
    {
        $table = $args[0];
        $column = $args[1];
        $except = isset($args[2]) ? $args[2] : null;
        $exceptColumn = isset($args[3]) ? $args[3] : 'id';

        $query = (new DB)->select()
            ->table($table)
            ->where($column, $this->input[$field]);

        if ($except) {
            $query = $query->where($exceptColumn, '!=', $except);
        }

        $query->run();

        if ($query->count() == 0) {
            return '\'' . $this->input[$field] . '\' did not occur in our database.';
        }
        return false;
    }

    /**
     * Check whether input is a valid email address.
     * @param string $field Key as in the input
     * @param mixed ...$args Useless here, just here for compatibility.
     * @return bool|string either string (message for user) or FALSE (= all fine)
     */
    private function email($field, ...$args)
    {
        if (!filter_var($this->input[$field], FILTER_VALIDATE_EMAIL)) {
            return 'The field \'' . $this->getFriendly($field) . '\' has to be an e-mail address.';
        }
        return false;
    }

    /**
     * Check whether value matches with another field's value
     * @param string $field Key as in the input
     * @param mixed ...$args [0] represents the other field.
     * @return bool|string either string (message for user) or FALSE (= all fine)
     */
    private function match($field, ...$args)
    {
        $foreign = $args[0];
        if ($this->input[$field] != $this->input[$foreign]) {
            return 'Fields \'' . $this->getFriendly($field) . '\' and \'' . $this->getFriendly($foreign) . '\' need to match.';
        }
        return false;
    }

    private function min($field, ...$args)
    {
        $minimum = $args[0];
        if (strlen($this->input[$field]) < $minimum) {
            return 'The field \'' . $this->getFriendly($field) . '\' needs to be at least ' . $minimum . ' characters long.';
        }
        return false;
    }

    private function max($field, ...$args)
    {
        $maximum = $args[0];
        if (strlen($this->input[$field]) > $maximum) {
            return 'The field \'' . $this->getFriendly($field) . '\' cannot contain more than ' . $maximum . ' characters.';
        }
        return false;
    }

}