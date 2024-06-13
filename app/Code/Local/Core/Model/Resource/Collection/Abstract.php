<?php

class Core_Model_Resource_Collection_Abstract
{
    protected $_resource = null;
    protected $_modelClass = null;
    protected $_select = [];
    protected $_data = [];
    public function setResource($resource)
    {
        $this->_resource = $resource;
        return $this;
    }
    public function setModelClass($modelClass)
    {
        $this->_modelClass = $modelClass;
        return $this;
    }
    public function select()
    {
        $this->_select['FROM'] = $this->_resource->getTableName();
        return $this;
    }
    public function addFieldToFilter($field, $value)
    {
        $this->_select['WHERE'][$field][] = $value;
        return $this;
    }
    public function addLimit($limit)
    {
        //addLimit($value);
        $this->_select['LIMIT'][] = $limit;
        return $this;
    }
    public function addCondition($condition)
    {
        // addCondition($condition)
        $this->_select['CONDITION'][] = $condition;
        return $this;
    }
    public function addGroupBy($GROUP)
    {
        //addGroupBy($column);
        $this->_select['GROUP BY'][] = $GROUP;
        return $this;
    }
    public function addOrderBy($GROUP)
    {
        //addGroupBy($column);
        $this->_select['ORDER BY'][] = $GROUP;
        return $this;
    }
    public function addOffset($OFFSET)
    {
        //addOffset($value);
        $this->_select['OFFSET'][] = $OFFSET;
        return $this;
    }
    public function addHaving($HAVING)
    {
        //addHaving($value);
        $this->_select['HAVING'][] = $HAVING;
        return $this;
    }
    public function addSum($column, $newName)
    {
        // ->addSum($column);
        $this->_select["SUM"] = "SUM($column) AS " . $newName;
        return $this;
    }
    public function addCount($column, $newName)
    {
        // ->addCount($column);
        $this->_select["COUNT"] = "Count($column) AS " . $newName;
        return $this;
    }

    public function load()
    {
        $sql = "SELECT *";

        if (isset ($this->_select["SUM"])) {
            $sql .= ",{$this->_select['SUM']}";
        }
        if (isset ($this->_select["COUNT"])) {
            $sql .= ",{$this->_select['COUNT']}";
        }
        $sql .= " FROM {$this->_select['FROM']}";
        if (isset ($this->_select["WHERE"])) {
            $whereCondition = [];
            foreach ($this->_select["WHERE"] as $column => $value) {
                foreach ($value as $_value) {
                    if (!is_array($_value)) {
                        $_value = array('eq' => $_value);
                    }
                    foreach ($_value as $_condition => $_v) {
                        switch ($_condition) {
                            case 'eq':
                                $whereCondition[] = "{$column} = '{$_v}'";
                                break;
                            case 'in':
                                if (is_array($_v)) {
                                    $_v = array_map(function ($v) {
                                        return "'{$v}'";
                                    }, $_v);
                                    $_v = implode(',', $_v);
                                }
                                // addFieldToFilter('$column',['in' => [$value1,$value2]])
                                $whereCondition[] = "{$column} IN ({$_v})";
                                break;
                            case 'like':
                                // addFieldToFilter('$column',['like' => 'a%'])
                                $whereCondition[] = "{$column} LIKE '{$_v}'";
                                break;
                            case 'gt':
                                $whereCondition[] = "{$column} > {$_v}";
                                break;
                            case 'lt':
                                $whereCondition[] = "{$column} < {$_v}";
                                break;
                            case 'lte':
                                $whereCondition[] = "{$column} <= {$_v}";
                                break;
                            case 'gte':
                                $whereCondition[] = "{$column} >= {$_v}";
                                break;
                            case 'neq':
                                $whereCondition[] = "{$column} <> {$_v}";
                                break;
                            case 'between':
                                // addFieldToFilter('$column',['between' => [$value1,$value2]])
                                $whereCondition[] = "{$column} BETWEEN {$_v[0]} AND {$_v[1]}";
                                break;
                        }
                    }
                }
            }
            $sql .= " WHERE " . implode(" AND ", $whereCondition);
        }
        if (isset ($this->_select["LIMIT"])) {
            $limit = implode(",", array_values($this->_select["LIMIT"]));
            $sql .= " LIMIT $limit";
        }
        if (isset ($this->_select["GROUP BY"])) {
            $GROUP = implode(",", array_values($this->_select["GROUP BY"]));
            $sql .= " GROUP BY $GROUP";
        }
        if (isset ($this->_select["ORDER BY"])) {
            $GROUP = implode(",", array_values($this->_select["ORDER BY"]));
            $sql .= " ORDER BY $GROUP";
        }
        if (isset ($this->_select["OFFSET"])) {
            $OFFSET = implode(",", array_values($this->_select["OFFSET"]));
            $sql .= " OFFSET $OFFSET";
        }
        if (isset ($this->_select["HAVING"])) {
            $HAVING = implode(",", array_values($this->_select["HAVING"]));
            $sql .= " HAVING $HAVING";
        }
        if (isset ($this->_select['CONDITION'])) {
            $sql .= " " . implode($this->_select['CONDITION']);
        }
        // echo $sql;die;
        $result = $this->_resource->getAdapter()->fetchAll($sql);
        foreach ($result as $row) {
            $this->_data[] = Mage::getModel($this->_modelClass)->setData($row);
        }
    }
    public function getData()
    {
        $this->load();
        return $this->_data;
    }
    public function getFirstItem()
    {
        $this->load();
        return (isset ($this->_data[0])) ? $this->_data[0] : null;
    }
}
