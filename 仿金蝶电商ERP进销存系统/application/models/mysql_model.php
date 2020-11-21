<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mysql_model extends CI_Model { 

    public function __construct(){
  		parent::__construct();
	}
	
	public function query($sql,$type=1) {
		$query = $this->db->query($sql);
		switch ($type) {
			case 1:
				$result = $query->row_array();break;  
			case 2:
				$result = $query->result_array();break;  	
			case 3:
				$result = $query->num_rows();break; 	
		}
		return $result;
	}

	public function get_results($table,$where='',$order='',$limit1=0,$limit2=0,$select='*') {
		$this->db->select($select);
		$this->db->from($this->db->dbprefix($table));
		if ($where) {
			$this->db->where($where);
		}
		if ($order) {
			$this->db->order_by($order);
		}
		if ($limit2>0) {
			$this->db->limit($limit2, $limit1);
		}
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_rows($table,$where=array(1=>1),$select='*') {
	    $query = $this->db->select($select)
		                            ->from($this->db->dbprefix($table))
									->where($where)
									->get();
		return $query->row_array();					
	}
	
	public function get_row($table,$where=array(1=>1),$select) {
	    $query = $this->db->select($select)
		                            ->from($this->db->dbprefix($table))
									->where($where)
									->get();
		$result = $query->row_array();							
		return $result[$select];					
	}
	
	public function get_count($table,$where=array(1=>1),$select='*') {
	    return $this->db->select($select)
		                            ->from($this->db->dbprefix($table))
									->where($where)
									->count_all_results();					
	}
	
	
	public function insert($table,$data){ 
		$table  = $this->db->dbprefix($table);
		if (isset($data[0]) && is_array($data[0])) {
			$this->db->insert_batch($table, $data);
		} else {
			$this->db->insert($table, $data);    	
		}
		$this->db->cache_delete_all();
		return $this->db->insert_id();  
	}
	
	public function update($table,$data,$where='') {
		$table  = $this->db->dbprefix($table);
		if (isset($data[0]) && is_array($data[0])) {
			$this->db->update_batch($table,$data,$where);
			if ($this->db->affected_rows()) {
				$result = true;  
			}     
		} else {
			if (is_array($data)&&count($data)>0) {
				if ($where) {
					$this->db->where($where);
				}
				$result = $this->db->update($table, $data);  
			} else {
				if (!is_array($data)) {
				    $result = $this->db->query('UPDATE '.$table.' SET '.$data .($where ? ' WHERE '.$where : ''));
				}
			}	
		}
		if (isset($result)) {
		    $this->db->cache_delete_all();
			return  $result;  
		} 
        return false;
    }

	public function delete($table,$where='') { 
		$table  = $this->db->dbprefix($table);
		if ($where) {
			$this->db->where($where);
		}
		$this->db->delete($table);
		if ($this->db->affected_rows()) {
		    $this->db->cache_delete_all();
			return  true; 
		} 
		return  false; 
	}

	
}