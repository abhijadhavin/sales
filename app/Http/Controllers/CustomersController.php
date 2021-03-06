<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Address;
use App\Customers;
use App\Services;
use App\Leads;
use App\User_Center;
use Session;
use DB;
use Response;
use Validator;

class CustomersController extends Controller
{

	 /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	//
	public function index(Request $request) {
		$id = Auth::id();
		$roles = $this->get_current_user_roles();		 
		$centers = $this->get_current_user_centers();		 
		$links = array('customers.js');
		if(in_array('SUPER ADMIN', $roles)){
			$customers = Customers::where('status','1')->orderBy('id', 'desc')->paginate(10);
		} elseif(in_array('ADMIN', $roles)){ 
			$customers = Customers::where('status','1')
					 ->leftJoin('user_center', 'user_center.user_id', '=', 'customers.user_id')
					 ->whereIn('user_center.center_id', $centers)
					 ->orderBy('customers.id', 'desc')
					 ->paginate(10);
		}else{
			$customers = Customers::where('status','1')->where('user_id',$id)->orderBy('id', 'desc')->paginate(10);
		}		
		return view('customers/index',compact('customers'))->with('i', ($request->input('page', 1) - 1) * 10)->with('links', $links);	
	}

	protected function get_current_user_roles() {
		$id = Auth::id();
		$roles = array();
		$rolesData  =  DB::table('user_roles')
					->select('roles.name')
					->join('roles', 'user_roles.role_id', '=', 'roles.id')
					->where('user_id',$id)		    	
					->get();
		foreach ($rolesData as $key => $role) {
			$roles[] = strtoupper($role->name);
		}
		return $roles;    
	}

	public function get_current_user_centers() {
		$userId = Auth::id();
		$currentCenters = User_Center::where('user_id', $userId)->get(); 
		$ids = array();
		foreach ($currentCenters as $key => $row) {
			$ids[] = $row->center_id;
		}
		return $ids;
	}	
	 

	public function customer() {
		if (Session::has('servies_data')) {
			Session::forget('servies_data');
		}
		$links = array('sales.js');		
		return view('customers/customer')->with('links', $links);	
	}   

	public function storeCustomer(Request $request) {
		//print_r( $request); 	
		$id = Auth::id();			
		$validatedData = $request->validate([
			'op_date' => 'required',			
			'first_name' => 'required',
			'last_name' => 'required',
			'contact' => 'required',
			'email' => 'required',
			'street_address1' => 'required',
			'suburb' => 'required',
			'state' => 'required',
			'postcode' => 'required',
			'customer_type' => 'required',
			'form_type' => 'required'			
		]);

		$formtype = $request->form_type;
		$middleName	= (isset($request->middle_name) && !empty($request->middle_name)) ? $request->middle_name : '';
		$address2 = (isset($request->street_address2) && !empty($request->street_address2)) ? $request->street_address2 : '';
		if ( $formtype === 'lead') {

			$lead = new Leads();
			$lead->user_id = $id;
			$lead->executive_id = $id;
			$lead->first_name = $request->first_name;
			$lead->middle_name = $middleName;
			$lead->last_name = $request->last_name;
			$lead->contact = $request->contact;
			$lead->email = $request->email;
			$lead->customer_type = $request->customer_type;
			$lead->op_date = $request->op_date;
			$lead->comments = $request->comments;
			$lead->status =  '1';
			$lead->created_date =  date('Y-m-d');
			$lead->updated_date =  date('Y-m-d');
			$lead->building_type = '';
			$lead->building_number_suffix = '';
			$lead->building_name = '';
			$lead->number_first = '';
			$lead->number_last = '';
			$lead->street_name = '';
			$lead->street_type = '';
			$lead->street_address1 =  $request->street_address1;
			$lead->street_address2 =  $address2;
			$lead->suburb =  $request->suburb;				
			$lead->state =  $request->state;	
			$lead->city_town = '';
			$lead->postcode =  $request->postcode;	
			$lead->save();

		} else {
			$validatedData = $request->validate([			 
				'services' => 'required'			
			]);
			$task = new Customers();
			$task->user_id = $id;			
			$task->executive_id = $id;
			$task->first_name = $request->first_name;
			$task->middle_name = $middleName;
			$task->last_name = $request->last_name;
			$task->contact = $request->contact;
			$task->email = $request->email;
			$task->customer_type = $request->customer_type;
			$task->op_date = $request->op_date;
			$task->comments = $request->comments;
			$task->status =  '1';
			$task->created_date =  date('Y-m-d');
			$task->updated_date =  date('Y-m-d');
			$task->save();

			$custId = $task->id;
			if(!empty($custId)) {
				$caddress = new Address();
				$caddress->cust_id = $custId;
				$caddress->building_type = '';
				$caddress->building_number_suffix = '';
				$caddress->building_name = '';
				$caddress->number_first = '';
				$caddress->number_last = '';
				$caddress->street_name = '';
				$caddress->street_type = '';
				$caddress->street_address1 =  $request->street_address1;
				$caddress->street_address2 =  $address2;
				$caddress->suburb =  $request->suburb;				
				$caddress->state =  $request->state;	
				$caddress->city_town = '';
				$caddress->postcode =  $request->postcode;	
				$caddress->status =  '1';
				$caddress->created_at =  date('Y-m-d');
				$caddress->updated_at =  date('Y-m-d');
				$caddress->save();

				$services = $request->services;				
				if(isset($services) && count($services)>0  && Session::has('servies_data')){
					$servicesData = Session::get('servies_data');
					foreach ($servicesData as $key => $row) {
						$service = new Services();
						$service->cust_id = $custId;
						$service->cli_number = $row['cli_number'];	
						$service->product_type =  $row['product_type'];	
						$service->plan_name =  $row['plan_name'];	
						$service->plan_price =  $row['plan_price'];	
						$service->plan_type =  $row['plan_type'];	
						$service->handset_type =  $row['handset_type'];
						$service->handset_value =  $row['handset_value'];	
						$service->contract_stage =  $row['contract_stage'];	
						$service->id_status =  $row['id_status'];	
						$service->direct_debit_details =  $row['direct_debit_details'];	
						$service->order_status =  $row['order_status'];	
						$service->order_status_date =  $row['order_status_date'];	
						$service->status = '1';
						$service->created_date =  date('Y-m-d');
						$service->update_date =  date('Y-m-d');
						$service->save();
					}
					Session::forget('servies_data');					
				}
			}
		}
		
		return redirect('/')->with('message','Sales created successfully!');
	}

	public function services(Request $request) {
		$flag = false;
		$sessionData = array();
		if($request->ajax()){
			$validatedData = $request->validate([			 
				'cli_number' => 'required',
				'plan_name' => 'required',
				'plan_type' => 'required',
				'contract_stage' => 'required',
				'order_status' => 'required',
				'direct_debit_details' => 'required',
				'product_type' => 'required',
				'plan_value' => 'required',
				'handset_type' => 'required',
				'handset_value' => 'required',
				'id_status' => 'required',
				'order_status_date' => 'required'
			]);
			//return "AJAX";            
			$service = array();  
			$service['cli_number'] = $request->cli_number;	
			$service['product_type'] =  $request->product_type;	
			$service['plan_name'] =  $request->plan_name;	
			$service['plan_price'] =  $request->plan_value;	
			$service['plan_type'] =  $request->plan_type;	
			$service['handset_type'] =  $request->handset_type;	
			$service['handset_value'] =  $request->handset_value;	
			$service['contract_stage'] =  $request->contract_stage;	
			$service['id_status'] =  $request->id_status;	
			$service['direct_debit_details'] =  $request->direct_debit_details;	
			$service['order_status'] =  $request->order_status;	
			$service['order_status_date'] =  $request->order_status_date;	
			if (Session::has('servies_data')) {
				$serviceData = Session::get('servies_data');
			} else {
				$serviceData = array();
			}
			$oldId = $request->oldId;
			if($oldId > -1) {
				$serviceData[$oldId] = $service;			
			} else {
				$serviceData[] = $service;	
			}
			Session::put('servies_data', $serviceData);
			$sessionData = Session::get('servies_data');
			$flag = true;
		}
		return response()->json(['success' => $flag , 'response' => $sessionData]);
	}

	public function get_services_row(Request $request) {
		$id = $request->id;
		$flag = false;
		$response = 'Invliad input key';		
		if($request->ajax() && $id > -1){
			if (Session::has('servies_data')) {
				$serviceData = Session::get('servies_data');
				if(isset($serviceData) &&  is_array($serviceData) &&array_key_exists($id, $serviceData)) {
					$response = $serviceData[$id]; 
					$flag = true;
				} else {
				   $response = 'Invalid Id Key';
				}
			} else {
				$response = 'No Session Data'; 	
			}
		}  
		return response()->json(['success' => $flag, 'response' => $response]);
	}

	public function servicesDestroy(Request $request) {
		$id = $request->id;
		$flag = false;
		$sessioNewData = array();
		if($request->ajax()){
			if (Session::has('servies_data')) {
				$serviceData = Session::get('servies_data');
				if($id > -1) {
					unset($serviceData[$id]);
					Session::put('servies_data', $serviceData);
				}
				$sessioNewData = Session::get('servies_data');	
				$flag = true;
			}
		}
		return response()->json(['success' => $flag , 'response' => $sessioNewData]);
	}


	public function destroy($id) {                
		$customer = Customers::find($id);
		$customer->status = '0';
		$customer->save();        
		return redirect('/customer')->with('message', 'Customer has been deleted!!');
	} 

	
	public function leads(Request $request) {
		$id = Auth::id();
		$roles = $this->get_current_user_roles();		 
		$centers = $this->get_current_user_centers();
		$links = array('leads.js');			 		
		if(in_array('SUPER ADMIN', $roles)){
			$leads = Leads::where('status','1')->orderBy('id', 'desc')->paginate(10);
		} elseif(in_array('ADMIN', $roles)){ 						
			$leads = Leads::where('status','1')
					 ->leftJoin('user_center', 'user_center.user_id', '=', 'leads.user_id')
					 ->whereIn('user_center.center_id', $centers)
					 ->orderBy('leads.id', 'desc')
					 ->paginate(10);	
		}else{
			$leads = Leads::where('status','1')->where('user_id',$id)->orderBy('id', 'desc')->paginate(10);
		}	
		return view('customers/leads',compact('leads'))->with('i', ($request->input('page', 1) - 1) * 10)->with('links', $links);	
	}

	public function leadDestory($id) {                
		$customer = Leads::find($id);
		$customer->status = '0';
		$customer->save();        
		return redirect('/leads')->with('message', 'Lead has been deleted!!');
	}

	public function editLead($id) {
		if (Session::has('servies_data')) {
			Session::forget('servies_data');
		}
		$lead = Leads::findOrFail($id);   
		$links = array('edit_sales.js');		
		$data = [
			'links' => $links,
			'customer' => $lead			 
		];		
		return view('customers/edit')->with($data);
	} 


	public function update_lead_data(Request $request, $editId) {
		$lead = Leads::findOrFail($editId); 
		$id = Auth::id();			
		$validatedData = $request->validate([
			'op_date' => 'required',			
			'first_name' => 'required',
			'last_name' => 'required',
			'contact' => 'required',
			'email' => 'required',
			'street_address1' => 'required',
			'suburb' => 'required',
			'state' => 'required',
			'postcode' => 'required',
			'customer_type' => 'required',
			'form_type' => 'required'			
		]);

		$formtype = $request->form_type;
		$middleName	= (isset($request->middle_name) && !empty($request->middle_name)) ? $request->middle_name : '';
		$address2 = (isset($request->street_address2) && !empty($request->street_address2)) ? $request->street_address2 : '';
		if ( $formtype === 'lead') {	
			$lead->user_id = $id;
			$lead->executive_id = $id;
			$lead->first_name = $request->first_name;
			$lead->middle_name = $middleName;
			$lead->last_name = $request->last_name;
			$lead->contact = $request->contact;
			$lead->email = $request->email;
			$lead->customer_type = $request->customer_type;
			$lead->op_date = $request->op_date;
			$lead->comments = $request->comments;
			$lead->status =  '1';			
			$lead->updated_date =  date('Y-m-d');
			$lead->building_type = '';
			$lead->building_number_suffix = '';
			$lead->building_name = '';
			$lead->number_first = '';
			$lead->number_last = '';
			$lead->street_name = '';
			$lead->street_type = '';
			$lead->street_address1 = $request->street_address1;
			$lead->street_address2 = $address2;
			$lead->suburb =  $request->suburb;				
			$lead->state =  $request->state;	
			$lead->city_town = '';
			$lead->postcode =  $request->postcode;	
			$lead->save();
		} else {
			$validatedData = $request->validate([			 
				'services' => 'required'			
			]);
			$task = new Customers();
			$task->user_id = $id;			
			$task->executive_id = $id;
			$task->first_name = $request->first_name;
			$task->middle_name = $middleName;
			$task->last_name = $request->last_name;
			$task->contact = $request->contact;
			$task->email = $request->email;
			$task->customer_type = $request->customer_type;
			$task->op_date = $request->op_date;
			$task->comments = $request->comments;
			$task->status =  '1';
			$task->created_date =  date('Y-m-d');
			$task->updated_date =  date('Y-m-d');
			$task->save();

			$custId = $task->id;
			if(!empty($custId)) {
				$caddress = new Address();
				$caddress->cust_id = $custId;
				$caddress->building_type = '';
				$caddress->building_number_suffix = '';
				$caddress->building_name = '';
				$caddress->number_first = '';
				$caddress->number_last = '';
				$caddress->street_name = '';
				$caddress->street_type = '';
				$caddress->street_address1 =  $request->street_address1;
				$caddress->street_address2 =  $address2;
				$caddress->suburb =  $request->suburb;				
				$caddress->state =  $request->state;	
				$caddress->city_town = '';
				$caddress->postcode =  $request->postcode;	
				$caddress->status =  '1';
				$caddress->created_at =  date('Y-m-d');
				$caddress->updated_at =  date('Y-m-d');
				$caddress->save();

				$services = $request->services;				
				if(isset($services) && count($services)>0  && Session::has('servies_data')){
					$servicesData = Session::get('servies_data');
					foreach ($servicesData as $key => $row) {
						$service = new Services();
						$service->cust_id = $custId;
						$service->cli_number = $row['cli_number'];	
						$service->product_type =  $row['product_type'];	
						$service->plan_name =  $row['plan_name'];	
						$service->plan_price =  $row['plan_price'];	
						$service->plan_type =  $row['plan_type'];	
						$service->handset_type =  $row['handset_type'];
						$service->handset_value =  $row['handset_value'];	
						$service->contract_stage =  $row['contract_stage'];	
						$service->id_status =  $row['id_status'];	
						$service->direct_debit_details =  $row['direct_debit_details'];	
						$service->order_status =  $row['order_status'];	
						$service->order_status_date =  $row['order_status_date'];	
						$service->status = '1';
						$service->created_date =  date('Y-m-d');
						$service->update_date =  date('Y-m-d');
						$service->save();
					}
					Session::forget('servies_data');					
				}
				$lead->status = '2';
				$lead->save();  
			}
		}		
		return redirect('/leads')->with('message','Lead Updated successfully!'); 
	}	
	
	public function editSales($id) {
		if (Session::has('servies_data')) {
			Session::forget('servies_data');
		}			
		$customer = Customers::findOrFail($id);    	
		$links = array('cust_edit_sales.js');
		$address =  Address::where('cust_id', $id)->where('status', '1')->first();
		$data = [
			'links' => $links,
			'customer' => $customer,
			'address' => $address			 
		];		
		return view('customers/cust_edit')->with($data);
	} 

	public function load_services(Request $request, $custId) {
		$flag = false;
		$sessionData = array();
		if($request->ajax()){
			$serviceData = array();
			$services =  Services::where('cust_id', $custId)->where('status', '1')->get();
			foreach ($services as $key => $service) {
				$cli_number = $service->cli_number;	
				$product_type =  $service->product_type;	
				$plan_name =  $service->plan_name;	
				$plan_price =  $service->plan_price;	
				$plan_type =  $service->plan_type;	
				$handset_type =  $service->handset_type;	
				$handset_value =  $service->handset_value;	
				$contract_stage =  $service->contract_stage;	
				$id_status =  $service->id_status;	
				$direct_debit_details =  $service->direct_debit_details;	
				$order_status =  $service->order_status;	
				$order_status_date =  $service->order_status_date;	
				$service = array(); 
				$service['cli_number'] = $cli_number;	
				$service['product_type'] =  $product_type;	
				$service['plan_name'] =  $plan_name;	
				$service['plan_price'] =  $plan_price;	
				$service['plan_type'] =  $plan_type;	
				$service['handset_type'] =  $handset_type;	
				$service['handset_value'] =  $handset_value;	
				$service['contract_stage'] =  $contract_stage;	
				$service['id_status'] =  $id_status;	
				$service['direct_debit_details'] =  $direct_debit_details;	
				$service['order_status'] =  $order_status;	
				$service['order_status_date'] =  $order_status_date;				 	
				$serviceData[] = $service;
			}	
			Session::put('servies_data', $serviceData);
			$sessionData = Session::get('servies_data');
			$flag = true;
		}
		return response()->json(['success' => $flag , 'response' => $sessionData]);
	}

	public function update_sale_data(Request $request, $editId) {
		$customer = Customers::findOrFail($editId); 
		$address = Address::where('cust_id', $editId)->where('status', '1')->first();
		$id = Auth::id();			
		$validatedData = $request->validate([
			'op_date' => 'required',			 
			'first_name' => 'required',
			'last_name' => 'required',
			'contact' => 'required',
			'email' => 'required',
			'street_address1' => 'required',
			'suburb' => 'required',
			'state' => 'required',
			'postcode' => 'required',
			'customer_type' => 'required',
			'form_type' => 'required',
			'services' => 'required'			
		]);

		$formtype = $request->form_type;
		$middleName	= (isset($request->middle_name) && !empty($request->middle_name)) ? $request->middle_name : '';
		$address2 = (isset($request->street_address2) && !empty($request->street_address2)) ? $request->street_address2 : '';
		if ( $formtype !== 'lead') {			 
			$customer->user_id = $id;			
			$customer->executive_id = $id;
			$customer->first_name = $request->first_name;
			$customer->middle_name = $middleName;
			$customer->last_name = $request->last_name;
			$customer->contact = $request->contact;
			$customer->email = $request->email;
			$customer->customer_type = $request->customer_type;
			$customer->op_date = $request->op_date;
			$customer->comments = $request->comments;
			$customer->status =  '1';			
			$customer->updated_date =  date('Y-m-d');
			$customer->save();
			$wasChanged = $customer->wasChanged();
			if(isset($editId) && !empty($editId)){
				$address2 = (isset($request->street_address2) && !empty($request->street_address2)) ? $request->street_address2 : '';
				$custId = $editId;
				$address->cust_id = $custId;
				$address->building_type = '';
				$address->building_number_suffix = '';
				$address->building_name = '';
				$address->number_first = '';
				$address->number_last = '';
				$address->street_name = '';
				$address->street_type = '';
				$address->street_address1 = $request->street_address1;
				$address->street_address2 = $address2 ;
				$address->suburb =  $request->suburb;				
				$address->state =  $request->state;	
				$address->city_town = '';
				$address->postcode =  $request->postcode;	
				$address->status =  '1';				
				$address->updated_at =  date('Y-m-d');
				$address->save();
				$services = $request->services;				
				if(isset($services) && count($services)>0  && Session::has('servies_data')){
					Services::where('cust_id', $custId)->delete();						
					$servicesData = Session::get('servies_data');
					foreach ($servicesData as $key => $row) {
						$service = new Services();
						$service->cust_id = $custId;
						$service->cli_number = $row['cli_number'];	
						$service->product_type =  $row['product_type'];	
						$service->plan_name =  $row['plan_name'];	
						$service->plan_price =  $row['plan_price'];	
						$service->plan_type =  $row['plan_type'];	
						$service->handset_type =  $row['handset_type'];
						$service->handset_value =  $row['handset_value'];	
						$service->contract_stage =  $row['contract_stage'];	
						$service->id_status =  $row['id_status'];	
						$service->direct_debit_details =  $row['direct_debit_details'];	
						$service->order_status =  $row['order_status'];	
						$service->order_status_date =  $row['order_status_date'];	
						$service->status = '1';
						$service->created_date =  date('Y-m-d');
						$service->update_date =  date('Y-m-d');
						$service->save();
					}
					Session::forget('servies_data');					
				}
			}
		}
		return redirect('/customer')->with('message','Sales Updated successfully!'); 
	}

	public function download(Request $request) {
		$allFlag = (isset($request->records) && !empty($request->records)) ? 1 : 0; 
		$fillter = false;
		if($allFlag === 0) {
			$rules = [
				'formDate'  => 'required|date',
				'toDate'  => 'required|date|after:formDate'				
			];       

			$messages = [
				'formDate.required' => trans('Form Date required.'),
				'toDate.required' => trans('To Date Required'),
				'formDate.date' => trans('Invliad From Date Format'),
				'toDate.date' => trans('Invliad To Date Format')
			];

			$validator = Validator::make($request->all(), $rules, $messages);
	   
			if ($validator->fails()) {
				$messages = $validator->messages();
				return redirect('/customer')->with('message', $messages); 
			} else {
				$fillter = true;
			}
		}

		$headers = [
			'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',   
			'Content-type'        => 'text/csv',   
			'Content-Disposition' => 'attachment; filename=export_data.csv',   
			'Expires'             => '0',   
			'Pragma'              => 'public'
		];
		 
		$fieldList = [
			'customers.id', 
			'customers.first_name', 
			'customers.middle_name', 
			'customers.last_name', 
			'customers.contact', 
			'customers.email', 
			'customers.customer_type', 
			'customers.op_date', 
			'customers.comments', 
			'address.street_address1', 
			'address.street_address2', 
			'address.suburb', 
			'address.state', 
			'address.postcode',
			'services.cli_number',
			'services.product_type',
			'services.plan_name',
			'services.plan_price',
			'services.plan_type',
			'services.handset_type',
			'services.handset_value',
			'services.contract_stage',
			'services.id_status',
			'services.direct_debit_details',
			'services.order_status',
			'services.order_status_date'
		]; 
		if($fillter) {
			$fromDate = (isset($request->fromDate) && !empty($request->fromDate)) ? date('Y-m-d', strtotime($request->fromDate)) : '';
			$toDate = (isset($request->toDate) && !empty($request->toDate)) ? date('Y-m-d', strtotime($request->toDate)) : ''; 

			$result = DB::table('customers')
				->join('address', 'customers.id', '=', 'address.cust_id')			
				->rightJoin('services', 'customers.id', '=', 'services.cust_id')         
				->select($fieldList)
				->where('customers.status', '1')
				->where('customers.updated_date', ">=" , $fromDate)
				->where('customers.updated_date', "<=" , $toDate)
				->get();
		} else {
			$result = DB::table('customers')
				->join('address', 'customers.id', '=', 'address.cust_id')			
				->rightJoin('services', 'customers.id', '=', 'services.cust_id')         
				->select($fieldList)
				->where('customers.status', '1')
				->get();
		}

		foreach ($result as $key => $row) {
			$list[] = get_object_vars($row);			 
		}
		# add headers for each column in the CSV download
		array_unshift($list, array_keys($list[0]));	

	   $callback = function() use ($list) {
			$FH = fopen('php://output', 'w');
			foreach ($list as $row) { 
				fputcsv($FH, $row);
			}
			fclose($FH);
		};
		return Response::stream($callback, 200, $headers);
	}

}
