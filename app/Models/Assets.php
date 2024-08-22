<?php 
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;
class Assets extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable;
	

	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'assets';
	

	/**
     * The table primary key field
     *
     * @var string
     */
	protected $primaryKey = 'asset';
	public $incrementing = false;
	

	/**
     * Table fillable fields
     *
     * @var array
     */
	protected $fillable = [
		'asset','balance'
	];
	public $timestamps = true;
	const CREATED_AT = 'date_created'; 
	

	/**
     * Set search query for the model
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param string $text
     */
	public static function search($query, $text){
		//search table record 
		$search_condition = '(
				asset LIKE ? 
		)';
		$search_params = [
			"%$text%"
		];
		//setting search conditions
		$query->whereRaw($search_condition, $search_params);
	}
	

	/**
     * return list page fields of the model.
     * 
     * @return array
     */
	public static function listFields(){
		return [ 
			"asset",
			"date_created",
			"updated_at",
			"balance" 
		];
	}
	

	/**
     * return exportList page fields of the model.
     * 
     * @return array
     */
	public static function exportListFields(){
		return [ 
			"asset",
			"date_created",
			"updated_at",
			"balance" 
		];
	}
	

	/**
     * return view page fields of the model.
     * 
     * @return array
     */
	public static function viewFields(){
		return [ 
			"asset",
			"date_created",
			"updated_at",
			"balance" 
		];
	}
	

	/**
     * return exportView page fields of the model.
     * 
     * @return array
     */
	public static function exportViewFields(){
		return [ 
			"asset",
			"date_created",
			"updated_at",
			"balance" 
		];
	}
	

	/**
     * return edit page fields of the model.
     * 
     * @return array
     */
	public static function editFields(){
		return [ 
			"asset",
			"balance" 
		];
	}
	

	/**
     * return needPurchase page fields of the model.
     * 
     * @return array
     */
	public static function needPurchaseFields(){
		return [ 
			"asset",
			"date_created",
			"updated_at",
			"balance" 
		];
	}
	

	/**
     * return exportNeedPurchase page fields of the model.
     * 
     * @return array
     */
	public static function exportNeedPurchaseFields(){
		return [ 
			"asset",
			"date_created",
			"updated_at",
			"balance" 
		];
	}
	

	/**
     * Audit log events
     * 
     * @var array
     */
	protected $auditEvents = [
		'created', 'updated', 'deleted'
	];
}
