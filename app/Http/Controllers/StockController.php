<?php 
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\StockAddRequest;
use App\Http\Requests\StockEditRequest;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
class StockController extends Controller
{
	

	/**
     * List table records
	 * @param  \Illuminate\Http\Request
     * @param string $fieldname //filter records by a table field
     * @param string $fieldvalue //filter value
     * @return \Illuminate\View\View
     */
	function index(Request $request, $fieldname = null , $fieldvalue = null){
		$view = "pages.stock.list";
		$query = Stock::query();
		$limit = $request->limit ?? 10;
		if($request->search){
			$search = trim($request->search);
			Stock::search($query, $search); // search table records
		}
		$orderby = $request->orderby ?? "stock.stock_id";
		$ordertype = $request->ordertype ?? "desc";
		$query->orderBy($orderby, $ordertype);
		if($fieldname){
			$query->where($fieldname , $fieldvalue); //filter by a table field
		}
		$records = $query->paginate($limit, Stock::listFields());
		return $this->renderView($view, compact("records"));
	}
	

	/**
     * Select table record by ID
	 * @param string $rec_id
     * @return \Illuminate\View\View
     */
	function view($rec_id = null){
		$query = Stock::query();
		$record = $query->findOrFail($rec_id, Stock::viewFields());
		return $this->renderView("pages.stock.view", ["data" => $record]);
	}
	

	/**
     * Display form page
     * @return \Illuminate\View\View
     */
	function add(){
		return $this->renderView("pages.stock.add");
	}
	

	/**
     * Save form record to the table
     * @return \Illuminate\Http\Response
     */
	function store(StockAddRequest $request){
		$modeldata = $this->normalizeFormData($request->validated());
		
		$arrival = (int)$request->input('arrival');
		$assetType = $request->input('asset');

		$balances = DB::table('assets')->where('asset', $assetType)->pluck('balance')->first();
		//save Stock record
		$record = Stock::create($modeldata);
		$rec_id = $record->stock_id;

		$update2 = $balances + $arrival;
		DB::table('assets')->where('asset', $assetType)->update(['balance' => $update2]);

		return $this->redirect("stock", "Record added successfully");
	}
	

	/**
     * Update table record with form data
	 * @param string $rec_id //select record by table primary key
     * @return \Illuminate\View\View;
     */
	function edit(StockEditRequest $request, $rec_id = null){
		$query = Stock::query();
		$record = $query->findOrFail($rec_id, Stock::editFields());
		if ($request->isMethod('post')) {
			$modeldata = $this->normalizeFormData($request->validated());
			$record->update($modeldata);
			return $this->redirect("stock", "Record updated successfully");
		}
		return $this->renderView("pages.stock.edit", ["data" => $record, "rec_id" => $rec_id]);
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
		$query = Stock::query();
		$query->whereIn("stock_id", $arr_id);
		//to raise audit trail delete event, use Eloquent 'get' before delete
		$query->get()->each(function ($record, $key) {
			$record->delete();
		});
		$redirectUrl = $request->redirect ?? url()->previous();
		return $this->redirect($redirectUrl, "Record deleted successfully");
	}
}
