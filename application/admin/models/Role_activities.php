<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Role_activities extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
	function getAllPermissions() {
        $permissionsArr = array();
        $getPermissionData = $this->db->get_where(TBL_PERMISSION, array("pr_isActive"=> '1'));
        $permissionsArr = $getPermissionData->result_array();
        return $permissionsArr;
    }
	function getAllPermissionTypes($status = '') {
        if ($status != '') {
            $query = "SELECT * FROM " . TBL_PERMISSION_TYPE . " where  permisson_typestatus=" . $status;
        } else {
            $query = "SELECT * FROM " . TBL_PERMISSION_TYPE;
        }
        $getPermissionTypeData = $this->db->query($query);
        $PermissionTypeArr = $getPermissionTypeData->result_array();
        return $PermissionTypeArr;
    }
	function getAllSubPermissionTypes($parantid = '') {
      
        $query = "SELECT * FROM " . TBL_PERMISSION_TYPE . " where parant_id=".$parantid;
       
        $getPermissionTypeData = $this->db->query($query);
        $PermissionTypeArr = $getPermissionTypeData->result_array();
        return $PermissionTypeArr;
    }
	/*function getAllPermissionTypesID($typeID, $status = '') {
        $query = "SELECT * FROM " . TBL_PERMISSION_TYPE . " where  permisson_typestatus=" . $typeID . " AND permisson_typestatus=" . $status;

        $getPermissionTypeData = $this->db->query($query);
        $PermissionTypeArr = $getPermissionTypeData->result_array();
        return $PermissionTypeArr;
    }*/

   
}
