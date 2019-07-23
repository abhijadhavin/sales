<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use Validator;
use Auth;
use Session;
use App\User;
use App\Roles;
use App\Center;
use App\User_roles;
use App\User_Center;
use DB;

class UsersController extends Controller
{  
	public function __construct() 
	{
		$this->middleware('auth');
	}

	protected function isSuperAdmin() {
		$roles = $this->get_current_user_roles();
		if(in_array('SUPER ADMIN', $roles)){
			return true;
		} else {
			return false;
		}
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

	public function index(Request $request) {  
		if($this->isSuperAdmin()) {   	
			$id = Auth::id();
			$links = array('users.js');					
			$users = User::where('status', '1')->orderBy('id', 'desc')->paginate(10);
			return view('users/index',compact('users'))->with('i', ($request->input('page', 1) - 1) * 10)->with('links', $links);	
		} else {
			return Redirect::back()->withErrors(['Access Denied!']);
		}	
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$roles = [];
		$roles = Roles::all();        
		$data = [            
			'roles' => $roles,
		];
		return view('users/create')->with($data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$rules = [
			'name'                  => 'required|string|max:255',
			'email'                 => 'required|email|max:255|unique:users',
			'password'              => 'required|string|confirmed|min:6',
			'password_confirmation' => 'required|string|same:password',
			'role' 					=> 'required'
		];        

		$messages = [
			'name.unique'         => trans('laravelusers.messages.userNameTaken'),
			'name.required'       => trans('laravelusers.messages.userNameRequired'),
			'email.required'      => trans('laravelusers.messages.emailRequired'),
			'email.email'         => trans('laravelusers.messages.emailInvalid'),
			'password.required'   => trans('laravelusers.messages.passwordRequired'),
			'password.min'        => trans('laravelusers.messages.PasswordMin'),
			'password.max'        => trans('laravelusers.messages.PasswordMax'),
			'role.required'       => trans('laravelusers.messages.roleRequired'),
		];

		$validator = Validator::make($request->all(), $rules, $messages);
	   
		if ($validator->fails()) {
			$messages = $validator->messages();
			return response()->json(['success' => false , 'response' => $messages]);
		}       
		$user = User::create([
			'name'             => $request->input('name'),
			'email'            => $request->input('email'),
			'password'         => bcrypt($request->input('password')),
		]);

		if (!empty($user->id)) {
			User_roles::create([
				'user_id'  => $user->id,
				'role_id'  => $request->input('role'),            
			]);
		}       

		Session::flash('alert-success', 'laravelusers.messages.user-creation-success');

		return response()->json(['success' =>  true , 'response' => trans('laravelusers.messages.user-creation-success')]);
	}


	public function edit($id)
	{
		$user = User::findOrFail($id);
		$roles = [];
		$currentRole = '';
		$roles = Roles::all();         
		$role =  User_roles::where('user_id', $id)->first();        	   	
		$data = [
			'user'  => $user,
			'roles' => $roles,
			'currentRole' =>  $role
		];      
		return view('users/edit')->with($data);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$user = User::find($id);
		$role =  User_roles::where('user_id', $id)->first(); 
		$emailCheck = ($request->input('email') != '') && ($request->input('email') != $user->email);
		$passwordCheck = $request->input('password') != null;
		$roleCheck = ($request->input('role') != '') && ($request->input('role') != $role->role_id);
		$rules = [
			'name' => 'required|max:255',
		];

		if ($emailCheck) {
			$rules['email'] = 'required|email|max:255|unique:users';
		}

		if ($passwordCheck) {
			$rules['password'] = 'required|string|min:6|max:20|confirmed';
			$rules['password_confirmation'] = 'required|string|same:password';
		}     

		 $messages = [
			'name.unique'         => trans('laravelusers.messages.userNameTaken'),
			'name.required'       => trans('laravelusers.messages.userNameRequired'),
			'email.required'      => trans('laravelusers.messages.emailRequired'),
			'email.email'         => trans('laravelusers.messages.emailInvalid'),
			'password.required'   => trans('laravelusers.messages.passwordRequired'),
			'password.min'        => trans('laravelusers.messages.PasswordMin'),
			'password.max'        => trans('laravelusers.messages.PasswordMax'),
			'role.required'       => trans('laravelusers.messages.roleRequired'),
		];   

		$validator = Validator::make($request->all(), $rules, $messages);
	   
		if ($validator->fails()) {
			$messages = $validator->messages();
			return response()->json(['success' => false , 'response' => $messages]);
		} 

		$user->name = $request->input('name');

		if ($emailCheck) {
			$user->email = $request->input('email');
		}

		if ($passwordCheck) {
			$user->password = bcrypt($request->input('password'));
		}             

		$user->save();

		if($roleCheck) {
			$role->role_id = $request->input('role');			
			$role->save();
		}		 

		Session::flash('alert-success', trans('laravelusers.messages.update-user-success'));

		return response()->json(['success' =>  true , 'response' => trans('laravelusers.messages.update-user-success')]);
	}


	public function destroy($id) {                
		$customer = User::find($id);
		$customer->status = '0';
		$customer->save();        
		return redirect('/users')->with('message', 'User has been deleted!!');
	} 


	public function center($id) {                
		$centers = Center::all(); 
		$userCenters = User_Center::where('user_id', $id)->get();
		$currentCenters = array();
		foreach ($userCenters as $key => $row) {
			$currentCenters[] = $row->center_id;
		}     
		$data = [            
			'centers' =>   $centers,
			'currentCenters' =>  $currentCenters
		];      
		return view('users/center')->with($data);
	}

	public function update_center(Request $request, $userId) {
		$currentCenters = User_Center::where('user_id', $userId)->get(); 
		$ids = array();
		foreach ($currentCenters as $key => $row) {
			$ids[] = $row->id;
		}
		if(count($ids) > 0) {
			User_Center::whereIn('id', $ids)->delete();		
		}     
		$newCenter = Input::get('center');
		if(isset($newCenter) && is_array($newCenter) && count($newCenter)>0) {
			foreach ($newCenter as $key => $center) {    			 
				User_Center::create([
					'user_id'  => $userId,
					'center_id'  => $center,            
				]);
			}
		}
		 
		if(isset($newCenter) && !empty($newCenter) && is_string($newCenter)) {
			User_Center::create([
				'user_id'   => $userId,
				'center_id' => $newCenter,            
			]);
		}
	 
		return response()->json(['success' =>  true , 'response' => trans('Center set Successfully!!!')]);
	}

}
