<?php 
namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
/**
 * Components data Model
 * Use for getting values from the database for page components
 * Support raw query builder
 * @category Model
 */
class ComponentsData{
	

	/**
     * name_option_list Model Action
     * @return array
     */
	function name_option_list(){
		$sqltext = "SELECT  DISTINCT name AS value FROM person ORDER BY name ASC";
		$query_params = [];
		$arr = DB::select($sqltext, $query_params);
		return $arr;
	}
	

	/**
     * asset_option_list Model Action
     * @return array
     */
	function asset_option_list(){
		$sqltext = "SELECT  DISTINCT asset AS value,asset AS label FROM assets ORDER BY asset ASC";
		$query_params = [];
		$arr = DB::select($sqltext, $query_params);
		return $arr;
	}
	

	/**
     * role_id_option_list Model Action
     * @return array
     */
	function role_id_option_list(){
		$sqltext = "SELECT role_id as value, role_name as label FROM roles";
		$query_params = [];
		$arr = DB::select($sqltext, $query_params);
		return $arr;
	}
	

	/**
     * Check if value already exist in User table
	 * @param string $value
     * @return bool
     */
	function user_username_value_exist(Request $request){
		$value = trim($request->value);
		$exist = DB::table('user')->where('username', $value)->value('username');   
		if($exist){
			return true;
		}
		return false;
	}
	

	/**
     * Check if value already exist in User table
	 * @param string $value
     * @return bool
     */
	function user_email_value_exist(Request $request){
		$value = trim($request->value);
		$exist = DB::table('user')->where('email', $value)->value('email');   
		if($exist){
			return true;
		}
		return false;
	}
	

	/**
     * getcount_collectionsdone Model Action
     * @return int
     */
	function getcount_collectionsdone(){
		$sqltext = "SELECT COUNT(*) AS num FROM collection";
		$query_params = [];
		$val = DB::selectOne($sqltext, $query_params);
		return $val->num;
	}
	

	/**
     * getcount_permissionsinthesystem Model Action
     * @return int
     */
	function getcount_permissionsinthesystem(){
		$sqltext = "SELECT COUNT(*) AS num FROM permissions";
		$query_params = [];
		$val = DB::selectOne($sqltext, $query_params);
		return $val->num;
	}
	

	/**
     * getcount_peopleregisteredinsystem Model Action
     * @return int
     */
	function getcount_peopleregisteredinsystem(){
		$sqltext = "SELECT COUNT(*) AS num FROM person";
		$query_params = [];
		$val = DB::selectOne($sqltext, $query_params);
		return $val->num;
	}
	

	/**
     * getcount_assets Model Action
     * @return int
     */
	function getcount_assets(){
		$sqltext = "SELECT COUNT(*) AS num FROM assets";
		$query_params = [];
		$val = DB::selectOne($sqltext, $query_params);
		return $val->num;
	}
}
