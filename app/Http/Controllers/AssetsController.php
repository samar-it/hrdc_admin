<?php 
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssetsAddRequest;
use App\Http\Requests\AssetsEditRequest;
use App\Models\Assets;
use Illuminate\Http\Request;
use Exception;
class AssetsController extends Controller
{
	

	/**
     * List table records
	 * @param  \Illuminate\Http\Request
     * @param string $fieldname //filter records by a table field
     * @param string $fieldvalue //filter value
     * @return \Illuminate\View\View
     */
	function index(Request $request, $fieldname = null , $fieldvalue = null){
		$view = "pages.assets.list";
		$query = Assets::query();
		$limit = $request->limit ?? 10;
		if($request->search){
			$search = trim($request->search);
			Assets::search($query, $search); // search table records
		}
		$orderby = $request->orderby ?? "assets.asset";
		$ordertype = $request->ordertype ?? "desc";
		$query->orderBy($orderby, $ordertype);
		if($fieldname){
			$query->where($fieldname , $fieldvalue); //filter by a table field
		}
		$records = $query->paginate($limit, Assets::listFields());
		return $this->renderView($view, compact("records"));
	}
	

	/**
     * Select table record by ID
	 * @param string $rec_id
     * @return \Illuminate\View\View
     */
	function view($rec_id = null){
		$query = Assets::query();
		$record = $query->findOrFail($rec_id, Assets::viewFields());
		return $this->renderView("pages.assets.view", ["data" => $record]);
	}
	

	/**
     * Display form page
     * @return \Illuminate\View\View
     */
	function add(){
		return $this->renderView("pages.assets.add");
	}
	

	/**
     * Save form record to the table
     * @return \Illuminate\Http\Response
     */
	function store(AssetsAddRequest $request){
		$modeldata = $this->normalizeFormData($request->validated());
		
		//save Assets record
		$record = Assets::create($modeldata);
		$rec_id = $record->asset;
		return $this->redirect("assets", "Record added successfully");
	}
	

	/**
     * Update table record with form data
	 * @param string $rec_id //select record by table primary key
     * @return \Illuminate\View\View;
     */
	function edit(AssetsEditRequest $request, $rec_id = null){
		$query = Assets::query();
		$record = $query->findOrFail($rec_id, Assets::editFields());
		if ($request->isMethod('post')) {
			$modeldata = $this->normalizeFormData($request->validated());
			$record->update($modeldata);
			return $this->redirect("assets", "Record updated successfully");
		}
		return $this->renderView("pages.assets.edit", ["data" => $record, "rec_id" => $rec_id]);
	}
	

	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
	 * @param  \Illuminate\Http\Request
	 * @param string $rec_id //can be separated by comma 
     * @return \Illuminate\Http\Response
     */
	function delete(Request $request, $rec_id = null){
		$arr_id = explode(",", $rec_id);
		$query = Assets::query();
		$query->whereIn("asset", $arr_id);
		//to raise audit trail delete event, use Eloquent 'get' before delete
		$query->get()->each(function ($record, $key) {
			$record->delete();
		});
		$redirectUrl = $request->redirect ?? url()->previous();
		return $this->redirect($redirectUrl, "Record deleted successfully");
	}
	

	/**
     * List table records
	 * @param  \Illuminate\Http\Request
     * @param string $fieldname //filter records by a table field
     * @param string $fieldvalue //filter value
     * @return \Illuminate\View\View
     */
	function need_purchase(Request $request, $fieldname = null , $fieldvalue = null){
		$view = "pages.assets.need_purchase";
		$query = Assets::query();
		$limit = $request->limit ?? 10;
		if($request->search){
			$search = trim($request->search);
			Assets::search($query, $search); // search table records
		}
		$orderby = $request->orderby ?? "assets.asset";
		$ordertype = $request->ordertype ?? "desc";
		$query->orderBy($orderby, $ordertype);
		if($fieldname){
			$query->where($fieldname , $fieldvalue); //filter by a table field
		}
		$records = $query->paginate($limit, Assets::needPurchaseFields());
		return $this->renderView($view, compact("records"));
	}
}
