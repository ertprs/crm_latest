<?php

class Common_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }	

    /************************
    * 
    * Retrieves a single record
    * 
    * @param        primary key 
    * @return       records or false
    * 
    */

    public function getById($table,$id) {
        $this->db->where($id);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return array();
    }

    /***************************
    *
    * function to check if the exists
    * 
    * @param        email (assoc array)
    * @return       bool
    * 
    */

    public function isExists($data) {
        $select_query = $this->db->get_where($this->table, $data);
        if ($select_query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /************************
    * 
    * get single record (or) selected data from a table
    * 
    * @param        fields, where(assoc array) 
    * @return       records or false
    * 
    */

    public function getRow($table, $select = '', $wdata = '',$join = array(), $order_by = '', $order = '') {
        if ($select != '') {
            $this->db->select($select);
        }
        if(!empty($join)){
            foreach($join as $table => $joinOn){
                $this->db->join($table , $joinOn);
            }
        }
        if ($wdata != '') {
            $this->db->where($wdata);
        }

        if(!empty($order_by)){
            $this->db->order_by($order_by, $order);
        }
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return array();
        }
    }

    /************************
    * 
    * get col (or) selected data from a table
    * 
    * @param        fields, where(assoc array) 

    * @return       records or false

    * 

    */

    public function getColumn($select = '', $wdata = '',$join = array()) {

        if ($select != '') {

            $this->db->select($select);

        }

        if(!empty($join)){

            foreach($join as $table => $joinOn){

                $this->db->join($table , $joinOn);

            }

        }

        if ($wdata != '') {

            $this->db->where($wdata);

        }

        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {

            return $query->row()->$select;

        } else {

            return array();

        }

    }



    /************************

    * 

    * get all record (or) selected data from a table

    * 

    * @param        fields, where(assoc array) 

    * @return       records or false

    * 

    */



    public function getResult($table, $select = '', $wdata = '', $limit = '', $offset = 0, $order_by = '', $order = 'ASC',$join = array()) {

        if ($select != '') {

            $this->db->select($select);

        }

        if(!empty($join)){

            foreach($join as $table => $joinOn){

                $this->db->join($table , $joinOn);

            }

        }

        if ($wdata != '') {

            $this->db->where($wdata);

        }

        if ($limit != '') {

            $this->db->limit($limit, $offset);

        }

        if ($order_by != '') {

            $this->db->order_by($order_by, $order);

        }

        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {

            return $query->result();

        } else {

            return array();

        }

    }



    /**********************

    *

    * inserts a record of data to the table

    * 

    * @param        data(assoc array)

    * @return       insert id or false

    * 

    * 

    */

    public function insert($table, $data) {

        $this->db->insert($table, $data);

        if ($this->db->affected_rows() > 0) {

            return $this->db->insert_id();

        } else {

            return FALSE;

        }

    }



    /************************

    *

    * updates records to the table

    * 

    * @param        updated data (assoc array), where(assoc array)

    * @return       bool

    * 

    */

    public function update($table, $update_data, $where) {

        $this->db->where($where);

        $query = $this->db->update($table, $update_data);

        if ($this->db->affected_rows() > 0) {

            return TRUE;

        } else {

            return FALSE;

        }

    }



    /************************

    * 

    * deletes a record from a table.

    * 

    * @param        primary key

    * @return       bool

    * 

    */

    public function deleteById($table,$id) {

        $this->db->where($id);

        if ($this->db->delete($table)) {

            return TRUE;

        } else {

            return FALSE;

        }

    }

    public function delete($table, $wdata='') {
        if ($wdata != '') {
            $this->db->where($wdata);
        }
        $query = $this->db->delete($table);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }



    /************************

    * 

    * Count record from a table.

    * 

    * @param        primary key

    * @return       bool

    * 

    */



    public function countallRecords($table){

        $this->db->count_all_results($table);

    }



    public function getStore($categoryID){

        $this->db->select('store.*');

        $this->db->from('store');

        $this->db->join('category', 'store.category_id = category.id', 'left');

        $this->db->where('category.id', $categoryID);                             

        $this->db->group_by('store.store_id', 'ASC'); 

        $getdata = $this->db->get();

        if ($getdata->num_rows() > 0) {

            return $getdata->result();

        } else {

            return array();

        }

    }



    public function getSubcategory($categoryID){

        $this->db->select('subcategory.*,category.category_name');

        $this->db->from('subcategory');

        $this->db->join('category', 'subcategory.category_id = category.id', 'left');

        $this->db->where('subcategory.category_id', $categoryID);             

        $getdata = $this->db->get();

        if ($getdata->num_rows() > 0) {

            return $getdata->result();

        } else {

            return array();

        }

    } 

    public function get_records_by_id($table,$single,$where,$select,$order_by_field,$order_by_value ){
        if(!empty($select)){
            $this->db->select($select);
        }
        
        if(!empty($where)){
            $this->db->where($where);
        }
        
        if(!empty($order_by_field) && !empty($order_by_value)){
            $this->db->order_by($order_by_field, $order_by_value);
        }
        
        $query = $this->db->get($table);
        $result = $query->result_array();

        if(!empty($result)){
            if($single){
                $result = $result[0];
            }else{
                $result = $result;
            }  
        } else{
           $result = 0; 
        }
        return $result;             
    } 

}

//End of Common_Model.php

?>