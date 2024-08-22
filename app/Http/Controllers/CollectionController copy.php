<?php 
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\CollectionAddRequest;
use App\Http\Requests\CollectionEditRequest;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
class CollectionController extends Controller
{
	

	/**
     * List table records
	 * @param  \Illuminate\Http\Request
     * @param string $fieldname //filter records by a table field
     * @param string $fieldvalue //filter value
     * @return \Illuminate\View\View
     */
	function index(Request $request, $fieldname = null , $fieldvalue = null){
		$view = "pages.collection.list";
		$query = Collection::query();
		$limit = $request->limit ?? 10;
		if($request->search){
			$search = trim($request->search);
			Collection::search($query, $search); // search table records
		}
		$orderby = $request->orderby ?? "collection.date_collected";
		$ordertype = $request->ordertype ?? "desc";
		$query->orderBy($orderby, $ordertype);
		if($fieldname){
			$query->where($fieldname , $fieldvalue); //filter by a table field
		}
		$records = $query->paginate($limit, Collection::listFields());
		return $this->renderView($view, compact("records"));
	}
	

	/**
     * Select table record by ID
	 * @param string $rec_id
     * @return \Illuminate\View\View
     */
	function view($rec_id = null){
		$query = Collection::query();
		$record = $query->findOrFail($rec_id, Collection::viewFields());
		return $this->renderView("pages.collection.view", ["data" => $record]);
	}
	

	/**
     * Display form page
     * @return \Illuminate\View\View
     */
	function add(){
		return $this->renderView("pages.collection.add");
	}
	

	/**
     * Save form record to the table
     * @return \Illuminate\Http\Response
     */
	function store(CollectionAddRequest $request){

		

    // Access the text field value using its name attribute (assetType)
   


		$modeldata = $this->normalizeFormData($request->validated());

		 $assetType = $request->input('asset');

		 $items = (int)$request->input('items_needed');


    $balances = DB::table('assets')->where('asset', $assetType)->pluck('balance')->first();
		
		// Check if collection is empty (no adapters)

		/*if ($balances->isEmpty()) {
			// Handle the case where there are no adapters
			return $this->redirect("collection", "No adapters found");
		} */

		// Assuming adapters have positive balances, check if any are >= 0
		if ($balances <= 0){
			return $this->redirect("collection", $assetType." is not found ");
		} 
		
		//save Collection record
		$record = Collection::create($modeldata);
		$rec_id = $record->collection_id;
    $update2 = $balances - $items;
		DB::table('assets')->where('asset', $assetType)->update(['balance' => $update2]);
		return $this->redirect("collection", "Record added successfully");
	}
    /**
     * Before create new record
     * @param array $modeldata // validated form data used to create new record
     */
    private function beforeAdd($modeldata){
       
    }
	

	/**
     * Update table record with form data
	 * @param string $rec_id //select record by table primary key
     * @return \Illuminate\View\View;
     */
	function edit(CollectionEditRequest $request, $rec_id = null){
		$query = Collection::query();
		$record = $query->findOrFail($rec_id, Collection::editFields());
		if ($request->isMethod('post')) {
			$modeldata = $this->normalizeFormData($request->validated());
			$record->update($modeldata);
			return $this->redirect("collection", "Record updated successfully");
		}
		return $this->renderView("pages.collection.edit", ["data" => $record, "rec_id" => $rec_id]);
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
		$query = Collection::query();
		$query->whereIn("collection_id", $arr_id);
		//to raise audit trail delete event, use Eloquent 'get' before delete
		$query->get()->each(function ($record, $key) {
			$record->delete();
		});
		$redirectUrl = $request->redirect ?? url()->previous();
		return $this->redirect($redirectUrl, "Record deleted successfully");
	}
}
