<?php

namespace App\Database;

// Database class
class Database
{
    // Way to the database file
    private string $file_path;
    // Database class constructor
    function __construct()
    {
        $this->file_path = $_SERVER['DOCUMENT_ROOT'] . "/service/database.json";
    }
    // The method of inserting the list of objects into the database
    // $table - database root parameter
    // $insert_objects - array of added objects
    function insert(string $table, array $insert_objects): array
    {
        $data = $this->getDatabaseData();

        if (
            isset($data[$table]) == false ||
            isset($insert_objects) == false ||
            count($insert_objects) == 0
        ) {
            return array();
        }

        $data[$table] = array_merge($data[$table], $insert_objects);
        file_put_contents($this->file_path, json_encode($data));
        return $insert_objects;
    }
    // The method of update the list of objects into the database
    // $table - database root parameter
    // $key - A unique field of the object
    // $update_objects - array of updated objects
    function update(string $table, string $key, array $update_objects): array
    {
        $data = $this->getDatabaseData();

        if (
            isset($data[$table]) == false ||
            isset($update_objects) == false ||
            count($update_objects) == 0 ||
            isset($key) == null
        ) {
            return array();
        }

        $results = array();
        
        foreach ($data[$table] as &$object) {
            if (count($update_objects) == 0) {
                break;
            }
            
            foreach ($update_objects as $key_update => &$update_object) {
                if ($update_object[$key] == $object[$key]) {
                    foreach ($update_object as $field => $value) {
                        $object[$field] = $value;
                    }             
                    $results[] = $object;
                    unset($update_objects[$key_update]);
                    break;
                }
            }
            
        }

        if (count($results)) {
            file_put_contents($this->file_path, json_encode($data));
        }

        return $results;
    }
    // The method of delete the list of objects into the database
    // $table - database root parameter
    // $key - A unique field of the object
    // $delete_objects - array of deleted objects
    function delete(string $table, string $key, array $delete_objects): array
    {
        $data = $this->getDatabaseData();

        if (
            isset($data[$table]) == false ||
            isset($delete_objects) == false ||
            count($delete_objects) == 0 ||
            isset($key) == null
        ) {
            return array();
        }

        $results = array();
        
        foreach ($data[$table] as $key_object => &$object) {
            if (count($delete_objects) == 0) {
                break;
            } 
            foreach ($delete_objects as $key_delete => &$delete_object) {
                if ($delete_object[$key] == $object[$key]) {   
                    $results[] = $delete_object;
                    unset($delete_objects[$key_delete]);
                    unset($data[$table][$key_object]);
                    break;
                }
            }
        }

        if (count($results)) {
            file_put_contents($this->file_path, json_encode($data));
        }

        return $results;
    }
    // The method of select the list of objects into the database
    // $table - database root parameter
    // $select_all - Selects all objects from the table if True or selects objects according to the specified parameters
    // $key - selected object field for choice
    // $value - selected object value for choice
    public function select(string $table, bool $select_all = true, string $key = null, $value = null): array
    {
        $data = $this->getDatabaseData();

        if ($select_all) {
            return $data[$table];
        } else {
            if (
                isset($data[$table]) == false ||
                isset($key) == false
            ) {
                return array();
            }

            $results = array_filter($data[$table], function ($object) use ($key, $value) {
                return $object[$key] == $value;
            });

            return $results;
        }
    }
    // The method of get json data from file
    private function getDatabaseData(): array
    {
        $json = file_get_contents($this->file_path);
        $array = json_decode($json, true);

        return $array;
    }
}