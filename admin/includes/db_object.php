<?php
use google\appengine\api\cloud_storage\CloudStorageTools;

/**
 * Created by PhpStorm.
 * User: gousos
 * Date: 4/12/2016
 * Time: 6:38 μμ
 */
class Db_object
{
    //find the users
    public static function find_all()
    {
        global $database;
        return static::find_by_query("SELECT * FROM " . static::$db_table . " ");

    }

    public static function find_by_id($id)
    {
        global $database;
        $the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE id =" . $id . " LIMIT 1");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;

    }

    public static function find_by_query($sql)
    {
        global $database;
        $result_set = $database->query($sql);
        $the_obj_array = array();
        while ($row = mysqli_fetch_array($result_set)) {
            $the_obj_array[] = static::instantiation($row);//aray me oles tis grammes
        }
        return $the_obj_array;
    }

    public static function instantiation($the_record)
    {
        $calling_class = get_called_class();
        $the_object = new $calling_class();

        foreach ($the_record as $the_attribute => $value) {
            if ($the_object->has_the_attribute($the_attribute)) {
                $the_object->$the_attribute = $value;

            }
        }
        return $the_object;
    }

    public function has_the_attribute($the_attribute)
    {
        //php defined --return properties(fields)
        $object_properties = get_object_vars($this);
        //if the key exist predefined function
        return array_key_exists($the_attribute, $object_properties);
    }

    public function save()
    {
        isset($this->id) ? $this->update() : $this->create();
    }

    public function update()
    {
        global $database;
        $properties = $this->clean_properties();
        $properties_pairs = array();

        foreach ($properties as $key => $value) {
            $properties_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE  " . static::$db_table . "  SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE id= " . $database->escape_string($this->id);
        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;


    } // end of the update method


    public function delete()
    {
        global $database;
        $sql = "DELETE FROM " . static::$db_table . " WHERE id= " . $database->escape_string($this->id);
        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }


    public function create()
    {
        global $database;
        $properties = $this->clean_properties();
        $sql = "INSERT INTO " . static::$db_table . "(" . implode(",", array_keys($properties)) . ")";
        $sql .= "VALUES ('" . implode("','", array_values($properties)) . "')";

        if ($database->query($sql)) {
            $this->id = $database->the_insert_id();
            return true;

        } else {
            return false;
        }
    }


    protected function properties()
    {
        //return get_object_vars($this);
        $properties = array();
        foreach (static::$db_table_fields as $db_field) {
            if (property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }

    protected function clean_properties()
    {
        global $database;
        $clean_properties = array();

        foreach ($this->properties() as $key => $value) {
            $clean_properties[$key] = $database->escape_string($value);
        }
        return $clean_properties;
    }

    public static function count_all()
    {
        global $database;
        $sql = "SELECT COUNT(*) FROM " . static::$db_table;
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);
        return array_shift($row);
    }

    public static function all_photos()
    {
        global $database;
        $sql = "SELECT filename FROM photos";
        $result_set = $database->query($sql);
        while ($row = mysqli_fetch_array($result_set)) ;
        return $row;

    }

    public static function find_by_username()
    {
        global $database;
        $sql = "SELECT username FROM users";
        $result_set = $database->query($sql);
        while ($row = mysqli_fetch_array($result_set)) ;
        return $row;
    }


    public static function find_comments_by_id($id)
    {
        global $database;
        $sql = "SELECT * FROM" . self::$db_table . " WHERE photo_id=" . $id . " ORDER BY photo_id ASC";
        $result = $database->query($sql);

        while ($row = mysqli_fetch_array($result)) {
            return $row;
        }
    }
}
