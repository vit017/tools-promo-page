<?php




//$tb_stock = TB_Stock::instance();

//$res = $tb_stock->read([], [], ['id' => 'desc', 'name2'=>'asc'], 0);
//$res = $tb_stock->create([
//    'name' => 'name 3',
//    'code' => 'code3',
//    'created_at' => time(),
//    'updated_at' => time(),
//    'date_active_start' => time(),
//    'header' => 'header 3',
//    'content' => 'контент 3',
//    'footer' => 'футер 3'
//]);
//$res = $tb_stock->delete([]);
//$res = $tb_stock->update(['name' => 'name 5'], ['id' => 26]);



class Table
{
    protected static $_driver = DBMysqli::class;

    protected function __construct()
    {
        $this->set_columns();
    }

    private function __clone()
    {
    }

    protected function set_columns()
    {
        $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '{$this->_name}'";
        $db_result = self::$_driver::query($query);
        while ($row = $db_result->fetch_row()) {
            array_push($this->_columns, $row[0]);
        }
    }

    protected function check_columns(array $input)
    {
        return array_values(array_intersect($this->_columns, $input));
    }

    protected function pre_select(array $input)
    {
        $cols = $this->check_columns($input);
        $pre = [];
        foreach ($cols as $col) {
            $pre[] = '`' . $col . '`';
        }
        return count($pre) ? implode(',', $pre) : '*';
    }

    protected function pre_filter(array $input)
    {
        $cols = $this->check_columns(array_keys($input));
        $pre = [];
        foreach ($cols as $col) {
            $pre[] = '`' . $col . '`' . '=' . '\'' . $input[$col] . '\'';
        }

        return count($pre) ? implode(',', $pre) : '1';
    }

    protected function pre_order(array $input)
    {
        $cols = $this->check_columns(array_keys($input));
        $pre = [];
        foreach ($cols as $col) {
            if (in_array(strtolower($input[$col]), ['asc', 'desc'])) {
                $pre[] = '`' . $col . '`' . ' ' . $input[$col];
            }
        }

        return count($pre) ? 'ORDER BY ' . implode(',', $pre) : '';
    }

    protected function pre_limit(int $limit) {
        return ($limit <= 0) ? '' : 'LIMIT ' . $limit;
    }

    protected function pre_read(array $select, array $filter, array $order, int $limit)
    {
        $db_filter = $this->pre_filter($filter);
        $db_select = $this->pre_select($select);
        $db_order = $this->pre_order($order);
        $db_limit = $this->pre_limit($limit);

        return "SELECT {$db_select} FROM `{$this->_name}` WHERE {$db_filter} {$db_order} {$db_limit}";
    }

    protected function pre_create(array $values) {
        $db_keys = [];
        $db_values = [];
        foreach ($this->_columns as $i => $col) {
            $db_keys[$i] = '`'.$col.'`';
            $db_values[$i] = array_key_exists($col, $values) ? '\''.$values[$col].'\'' : 'NULL';
        }
        $db_str_keys = implode(',',$db_keys);
        $db_str_values = implode(',',$db_values);

        return "INSERT INTO `{$this->_name}` ({$db_str_keys}) VALUES ({$db_str_values})";
    }

    public function read(array $select, array $filter, array $order, int $limit)
    {
        $db_query = $this->pre_read($select, $filter, $order, $limit);
        $db_result = [];
        $find = self::$_driver::query($db_query);
        if ($find) {
            while ($row = $find->fetch_object()) {
                $db_result[] = $row;
            }
        }

        return $db_result;
    }

    public function create(array $values) {
        $db_query = $this->pre_create($values);
        $created = self::$_driver::query($db_query);
        if ($created) {
            return self::$_driver::instance()->insert_id;
        }

        return false;
    }

    protected function pre_delete(array $filter) {
        $db_filter = $this->pre_filter($filter);

        return "DELETE FROM `{$this->_name}` WHERE {$db_filter}";
    }

    public function delete(array $filter) {
        $db_query = $this->pre_delete($filter);

        return self::$_driver::query($db_query);
    }

    protected function pre_update(array $values, array $filter) {
        $db_filter = $this->pre_filter($filter);
        foreach ($this->_columns as $i => $col) {
            if (!array_key_exists($col, $values)) {continue;}

            $db_update[] =  '`'.$col.'`'.'='.'\''.$values[$col].'\'';
        }
        $db_str_update = implode(',', $db_update);

        return "UPDATE `{$this->_name}` SET {$db_str_update} WHERE {$db_filter}";
    }

    public function update(array $values, array $filter) {
        $db_query = $this->pre_update($values, $filter);

        return self::$_driver::query($db_query);
    }

    public function load(array $input) {

    }
}



