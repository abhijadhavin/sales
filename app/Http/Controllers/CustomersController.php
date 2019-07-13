<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Address;
use App\Customers;
use App\Services;
use App\Leads;
use Session;

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
		$links = array('customers.js');			
		if(in_array($id, array(4,3,2))){
			$customers = Customers::where('status','1')->orderBy('id', 'desc')->paginate(10);
		} else {
			$customers = Customers::where('status','1')->where('user_id',$id)->orderBy('id', 'desc')->paginate(10);
		}		
		return view('customers/index',compact('customers'))->with('i', ($request->input('page', 1) - 1) * 10)->with('links', $links);	
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
			'executive_id' => 'required',
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
		if ( $formtype === 'lead') {

			$lead = new Leads();
			$lead->user_id = $id;
			$lead->executive_id = $request->executive_id;
			$lead->first_name = $request->first_name;
			$lead->middle_name = $request->middle_name;
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
			$lead->street_address2 =  $request->street_address2;
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
			$task->executive_id = $request->executive_id;
			$task->first_name = $request->first_name;
			$task->middle_name = $request->middle_name;
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
				$caddress->street_address2 =  $request->street_address2;
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

			$serviceData[] = $service;
			Session::put('servies_data', $serviceData);
			$sessionData = Session::get('servies_data');
			$flag = true;
		}
		return response()->json(['success' => $flag , 'response' => $sessionData]);
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


	//
	public function leads(Request $request) {
		$id = Auth::id();
		$links = array('leads.js');	
		if(in_array($id, array(4,3,2))){		
			$leads = Leads::where('status','1')->orderBy('id', 'desc')->paginate(10);
		} else {
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
			'executive_id' => 'required',
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
		if ( $formtype === 'lead') {			
			$lead->user_id = $id;
			$lead->executive_id = $request->executive_id;
			$lead->first_name = $request->first_name;
			$lead->middle_name = $request->middle_name;
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
			$lead->street_address1 =  $request->street_address1;
			$lead->street_address2 =  $request->street_address2;
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
			$task->executive_id = $request->executive_id;
			$task->first_name = $request->first_name;
			$task->middle_name = $request->middle_name;
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
				$caddress->street_address2 =  $request->street_address2;
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
			'executive_id' => 'required',
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
		if ( $formtype !== 'lead') {
			
		}
		return redirect('/customer')->with('message','Sales Updated successfully!'); 
	}

}
