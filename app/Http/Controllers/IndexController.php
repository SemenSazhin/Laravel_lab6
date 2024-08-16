<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kurses;
use App\Models\Users;
use App\Models\Zapis;
use App\Http\Controllers\Validator;
use Carbon\Carbon;

class IndexController extends Controller
{
	
	
	//начало работы
	public function start() 
    {
		$this->status();
        return view('login',['err'=>'','access'=>'']);
    }

	public function reg()
    {
        return view('register',['err'=>'','access'=>'']);
    }
//регистрация
	public function register(Request $request)
    {
		$this->status();
        $data=$request->all();
        $user=new Users;
        $userl=count($user->select('users.login')->where('users.login','=', $data['login'])->get());
		$userm=count($user->select('users.email')->where('users.email','=', $data['email'])->get());
		$rules=
		[
			'FIO' => 'required|regex:/[^А-я]/u|max:50',
			'email' => 'required|regex:/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i', 
			'image' => 'required',
			'login' => 'required|unique:users',
			'password' => 'required|regex:/(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{6,}/',
			'passwordrepeat' => 'required|same:password'
		];

		$messages=
		[
			'required' => 'Данное поле является обязательным',
			'regex'=>'Введите данные в нужном формате',
			'login.unique'=>'Пользователь с таким логином уже существует',
			'same'=>'Пароли не совпадают',
			'password.regex'=>'Пароль должен содержать не менее 6 символов, а также строчные и заглавные буквы',

		];
		$this->validate($request, $rules,$messages);		     
        	$data=$request->all();
           	 	$user->FIO=$data['FIO'];
				$user->email=$data['email'];
				$user->image=$data['image'];
           	 	$user->status=0;
           		$user->password=$data['password'];
           		$user->login=$data['login'];
            	$user->save();
            return view('login',['err'=>'','access'=>'Регистрация прошла успешно'] );
		
    }

//Вход
	public function login(Request $request)
    {
        $this->validate($request,[ 'login'=>'required',
        'password' => 'required',]);
		$zapis=new Zapis;
		
        $req=$request->all();
        $Users=new Users();
        $kurses=new Kurses();
        $userl=count($Users->select('users.status')->where('users.login','=', $req['login'])->get());
        $userp=count($Users->select('users.status')->where('users.login','=', $req['login'])->where('users.password','=', $req['password'])->get());
		$id=$Users->select('users.id')->where('users.login','=', $req['login'])->get();
		$id=$id[0]['id'];
		$data=$kurses->select('kurses.id','kurses.name','kurses.image','kurses.description','kurses.begin','kurses.price','kurses.count','kurses.status')->get();
        if ($userl!=0) 
        {
            if($userp!=0) 
            {
                $rol=count(Users::select('users.status')->where('users.login','=', $req['login'])->where('users.status', 1)->get());
                if($rol!=0)
                {
                    $admin=1;
                }
                else
                {
                    $admin=0;
                }
                $check=1;
				
                request()->session()->put('admin_status', $admin);
                request()->session()->put('check',$check);
				request()->session()->put('id',$id);
				$userdata=$Users->select('users.FIO','users.image')->where('users.id',$id)->get();
				$date=Carbon::now();
				if($admin==1)
				{
					$Users=new Users();
					$kurses=new Kurses;
					$zapis=new Zapis;
					//$id=intval(request()->session()->get('id'));
					$userzapis=$zapis->join('users','id_u','=' ,'users.id')->select('id_k', 'id_u','users.FIO')->get();
					$check= intval(request()->session()->get('check'));
        			$admin = intval(request()->session()->get('admin_status'));
        			$data=$kurses->select('kurses.id','kurses.name','kurses.image','kurses.description','kurses.begin','kurses.price','kurses.count','kurses.status')->get();
					$now=Carbon::now();
					return view('admin',  ['arr'=>$data,'id'=>$id,'date'=>$now, 'admin'=>$admin ,'check'=>$check,'userdata'=>$userdata,'zap'=>$userzapis]);
                	
				}
				else
				{
					$this->status();
					$id=intval(request()->session()->get('id'));
					$userzapis=$zapis->select('id_k', 'id_u')->where('id_u' , $id)->get();
					return view('index', ['arr'=>$data, 'admin'=>$admin ,'id'=>$id,'check'=>$check, 'zap'=>$userzapis,'date'=>$date,'userdata'=>$userdata]);
				}
            }
            else return view('login', ['err'=>'Вы ввели неверный пароль','access'=>'']);
        }
        else return view('login', ['err'=>'Такого пользователя не существует','access'=>'']);
    }
//выход
	public function quit() 
    {
        request()->session()->put('admin_status', 0);
        request()->session()->put('check',0);
		request()->session()->put('id',0);
        return view('login',['err'=>'','access'=>'']);
    }
	
//основные страницы
//фильтр+контент
	public function content($parameter) 
    {
		$Users=new Users();
		$id=intval(request()->session()->get('id'));
		
		$zapis=new Zapis;
		$userzapis=$zapis->select('id_k', 'id_u')->where('id_u' , $id)->get();
		$kurses=new Kurses;
		$up=new Kurses;
		$now=Carbon::now();
		$this->status();
		$check= intval(request()->session()->get('check'));
        $admin = intval(request()->session()->get('admin_status'));
		$userdata=$Users->select('users.FIO','users.image')->where('users.id',$id)->get();
		if($parameter=='all')
		{
        $data=$kurses->select('kurses.id','kurses.name','kurses.image','kurses.description','kurses.begin','kurses.price','kurses.count','kurses.status')->get();
		}
		else if($parameter=='active')
		{
			$data=$kurses->select('kurses.id','kurses.name','kurses.image','kurses.description','kurses.begin','kurses.price','kurses.count','kurses.status')->where('kurses.status',0)->get();
		}
		else if($parameter=='not')
		{
			$data=$kurses->select('kurses.id','kurses.name','kurses.image','kurses.description','kurses.begin','kurses.price','kurses.count','kurses.status')->where('kurses.status','<>',0)->get();
		}
        return view('index', ['arr'=>$data,'admin'=>$admin, 'id'=>$id,'check'=>$check,'zap'=>$userzapis,'userdata'=>$userdata]);
    }
	

	

	//вывод курса
	public function kurs($id)
	{
		$Users=new Users();
		$idus=intval(request()->session()->get('id'));
		$this->status();
		$kurses=new Kurses;
		$zapis=new Zapis;
		$userzapis=count($zapis->select('id_k', 'id_u')->where('id_u' , $idus)->where('id_k' , $id)->get());
		$userdata=$Users->select('users.FIO')->where('users.id',$idus)->get();
		if($userzapis==0)
		{
			$userzapis=0;
		}
		else
		{
			$userzapis=1;
		}
		$check= intval(request()->session()->get('check'));
        $admin = intval(request()->session()->get('admin_status'));
        $data = Kurses::find($id);
        $kurs = 
			[
                'id' => $data['id'],
                'name' => $data['name'],
                'image' => $data['image'],
                'description' => $data['description'],
                'begin' => $data['begin'],
				'price' => $data['price'],
				'count' => $data['count'],
				'status'=>$data['status']
            ];
        return view('kurs', ['data'=>$kurs,'admin'=>$admin,'id'=>$idus ,'check'=>$check,'zap'=>$userzapis,'userdata'=>$userdata]);
	}
//по языку
	public function language($name)
	{  
		$Users=new Users(); $id=intval(request()->session()->get('id'));
		$zapis=new Zapis;
		$userzapis=$zapis->select('id_k', 'id_u')->where('id_u' , $id)->get();
		$userdata=$Users->select('users.FIO','users.image')->where('users.id',$id)->get();
		$this->status();
		$kurses=new Kurses;
		$check= intval(request()->session()->get('check'));
        $admin = intval(request()->session()->get('admin_status'));
        $name=str_replace('_', ' ', $name);
        $kurs = Kurses::select('kurses.id','kurses.name','kurses.image','kurses.description','kurses.begin','kurses.price','kurses.count','kurses.status')->where('kurses.code', $name)->get();
        return view('lang', ['arr'=>$kurs,'name'=>$name,'id'=>$id,'admin'=>$admin ,'check'=>$check,'zap'=>$userzapis,'userdata'=>$userdata]);
	}

    //обновление статуса курсов
	public function status()
	{
		$zapis=new Zapis;
		$Users=new Users();
		$kurses=new Kurses;
		$up=new Kurses;
		$now=Carbon::now()->addHours(5);
		$c=$kurses->all()->count();
		for ($i = 1; $i < $c; $i++)
		{
			$id=$kurses->select('kurses.id')->where('kurses.id' ,'=',$i)->get();
			
			$count=$kurses->select('kurses.count')->where('kurses.id' ,'=',$i)->get();
			$countr=$count[0]['count'];
		
			$date=count(Kurses::select('kurses.begin')->where('kurses.id' ,'=',$i)->where('kurses.begin' ,'<', $now)->get());
			$countzap=count(Zapis::select('zapis.id')->where('zapis.id_k' ,'=',$i)->get());
			
			if($date!=0)
			{
				$kurses->where('kurses.id' ,'=',$i)->update(['status'=>1]);
			}
			elseif(intval($countzap)>=$countr)
			{
				$kurses->where('kurses.id' ,'=',$i)->update(['status'=>2]);
			}
			else
			{
				$kurses->where('kurses.id' ,'=',$i)->update(['status'=>0]);
			}
            
		}
		return;
	}
//кнопка записи
	public function zapis(Request $request)
	{
		$Users=new Users();
		 $this->status();
		$id=intval(request()->session()->get('id'));
		$check= intval(request()->session()->get('check'));
        $admin = intval(request()->session()->get('admin_status'));
		$req=$request->all();
		
		$zapis=new Zapis;
		$userzapis=$zapis->select('id_k', 'id_u')->where('id_u' , $id)->get();
		$userdata=$Users->select('users.FIO','users.image')->where('users.id',$id)->get();
		$kurses=new Kurses;
		$data=$kurses->select('kurses.id','kurses.name','kurses.image','kurses.description','kurses.begin','kurses.price','kurses.count','kurses.status')->get();
		$zapis->id_k=$req['data'];
		$zapis->id_u=$id;
		$c=count($zapis->select('zapis.id')->where('zapis.id_u',$id)->where('zapis.id_k',$req['data'])->get());
		if($c==0)
		{
		$zapis->save();
		}
		return view('index', ['arr'=>$data,'id'=>$id, 'admin'=>$admin ,'check'=>$check,'zap'=>$userzapis,'userdata'=>$userdata]);
	}

	//вывод курсов пользователя
	public function userkurs()
	{
		$Users=new Users();
		$kurses=new Kurses;
		
		 $this->status();
		$id=intval(request()->session()->get('id'));
		$check= intval(request()->session()->get('check'));
        $admin = intval(request()->session()->get('admin_status'));
		$zapis=new Zapis;
		$now=Carbon::now()->addDay();
		$data=$zapis->join('kurses', 'zapis.id_k', '=', 'kurses.id')->select('id_k', 'id_u','kurses.id','kurses.name','kurses.image','kurses.description','kurses.begin','kurses.price','kurses.count','kurses.status')->where('id_u' , $id)->get();
		$userdata=$Users->select('users.FIO','users.image')->where('users.id',$id)->get();
		
		return view('userkurs', ['arr'=>$data,'id'=>$id,'date'=>$now, 'admin'=>$admin ,'check'=>$check,'userdata'=>$userdata]);
	
	}

	//отмена записи
	public function userleave(Request $request)
	{
		$Users=new Users();
		 $this->status();
		$id=intval(request()->session()->get('id'));
		$check= intval(request()->session()->get('check'));
        $admin = intval(request()->session()->get('admin_status'));
		$req=$request->all();
		$now=Carbon::now()->addDay()->addHours(5);
		$zapis=new Zapis;
		$userzapis=$zapis->where('id_u' , $id)->where('id_k' , $req['id_k'])->delete();
		$data=$zapis->join('kurses', 'zapis.id_k', '=', 'kurses.id')->select('id_k', 'id_u','kurses.id','kurses.name','kurses.image','kurses.description','kurses.begin','kurses.price','kurses.count','kurses.status')->where('id_u' , $id)->get();
		$userdata=$Users->select('users.FIO','users.image')->where('users.id',$id)->get();
		
		return view('userkurs', ['arr'=>$data,'id'=>$id,'date'=>$now, 'admin'=>$admin ,'check'=>$check,'userdata'=>$userdata]);

	}
	 
	//админ
	public function admin() 
    {
		$this->status();
		$Users=new Users();
		$kurses=new Kurses;
		$zapis=new Zapis;
		$id=intval(request()->session()->get('id'));
		$userzapis=$zapis->join('users','id_u','=' ,'users.id')->select('id_k', 'id_u','users.FIO')->get();
		$userdata=$Users->select('users.FIO','users.image')->where('users.id',$id)->get();
		$check= intval(request()->session()->get('check'));
        $admin = intval(request()->session()->get('admin_status'));
        $data=$kurses->select('kurses.id','kurses.name','kurses.image','kurses.description','kurses.begin','kurses.price','kurses.count','kurses.status')->get();
		$now=Carbon::now()->addHours(5);
		return view('admin',  ['arr'=>$data,'id'=>$id,'date'=>$now, 'admin'=>$admin ,'check'=>$check,'userdata'=>$userdata,'zap'=>$userzapis]);

    }

	//добавление
	public function addform() 
    {
		$Users=new Users();
		$kurses=new Kurses;
		$zapis=new Zapis;
		$id=intval(request()->session()->get('id'));
		$userdata=$Users->select('users.FIO','users.image')->where('users.id',$id)->get();
		$check= intval(request()->session()->get('check'));
		$check= intval(request()->session()->get('check'));
        $admin = intval(request()->session()->get('admin_status'));
		$id=intval(request()->session()->get('id'));
		return view('add',  ['id'=>$id,'admin'=>$admin ,'check'=>$check,'userdata'=>$userdata]);

	}
		public function store(Request $request)
		{
			$this->validate($request,['name' => 'required',
			'count' => 'required', 'image' => 'required',
			'description' => 'required','price' => 'required',]);
			$now=Carbon::now()->addHours(5);
			$data=$request->all();
			$Users=new Users();
			$kurses=new Kurses;
			$zapis=new Zapis;
			$kurses->name=$data['name'];
			$kurses->code=$data['code'];
			$kurses->description=$data['description'];
			$kurses->count=$data['count'];
			$kurses->image=$data['image'];
			$kurses->price=$data['price'];
			$kurses->begin=$data['begin'];
			$kurses->save();
					
			$id=intval(request()->session()->get('id'));
			$userzapis=$zapis->join('users','id_u','=' ,'users.id')->select('id_k', 'id_u','users.FIO')->get();
			$userdata=$Users->select('users.FIO','users.image')->where('users.id',$id)->get();
			$admin= intval(request()->session()->get('admin_status'));
			$check= intval(request()->session()->get('check'));
			
			$statyas=$kurses->select('kurses.id','kurses.name','kurses.image','kurses.description','kurses.begin','kurses.price','kurses.count','kurses.status')->get();
			return view('admin',  ['arr'=>$statyas,'id'=>$id,'date'=>$now, 'admin'=>$admin ,'check'=>$check,'userdata'=>$userdata,'zap'=>$userzapis]);
		}
//удалить
	public function delete($id_del)
    {
		$now=Carbon::now()->addHours(5);
		$Users=new Users();
		$kurses=new Kurses;
		$zapis=new Zapis;
		$id=intval(request()->session()->get('id'));
		$userzapis=$zapis->join('users','id_u','=' ,'users.id')->select('id_k', 'id_u','users.FIO')->get();
		$userdata=$Users->select('users.FIO','users.image')->where('users.id',$id)->get();
		$admin= intval(request()->session()->get('admin_status'));
		$check= intval(request()->session()->get('check'));
		

        $kurses = Kurses::find($id_del);
        $kurses->where('kurses.id', '=', $id_del)->delete();
        $statyas=$kurses->select('kurses.id','kurses.name','kurses.image','kurses.description','kurses.begin','kurses.price','kurses.count','kurses.status')->get();
			return view('admin',  ['arr'=>$statyas,'id'=>$id,'date'=>$now, 'admin'=>$admin ,'check'=>$check,'userdata'=>$userdata,'zap'=>$userzapis]);
    }
	
//api
public function my_api($id)
{
	$data = Kurses::find($id);
        $kurs = 
			[
                'name' => $data['name'],
                'image' => $data['image'],
                'description' => $data['description'],
                'begin' => $data['begin'],
				'price' => $data['price'],
				'count' => $data['count'],
            ]; // Здесь может быть выборка из БД
	$responsecode = 200;
	$header = array (
	'Content-Type' => 'application/json; charset=UTF-8',
	'charset' => 'utf-8'
	);
	return response()->json($data , $responsecode, $header,JSON_UNESCAPED_UNICODE);
}







}
