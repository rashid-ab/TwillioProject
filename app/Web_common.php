<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Web_common extends Model
{




    public static function get_data($table_name)
    {
	   	return $positions = DB::table($table_name)
	   	 ->orderBy('id', 'desc')
	    ->paginate(20);
	}

	public static function update_data($id,$data_array,$table_name)
    {
        return DB::table($table_name)->where('id', $id)->update($data_array);
    }

    public static function single_data($id,$table_name)
    {
        return DB::table($table_name)->where('id', $id)->first();
    }

    public static function get_events($event_category)
    {
	   //	return $positions = DB::table('events')
	   //	->join('event_types', 'events.type', '=', 'event_types.id')
	   //	->join('users', 'users.id', '=', 'events.user_id')
	   //	 ->orderBy('events.id', 'desc')
	   //	->select('events.title','events.event_datetime','events.venue','events.id as event_id','event_types.name','users.f_name','events.total_joins')
	   // ->paginate(20);
	    
	    return DB::table('events')           
             ->join('users', 'events.user_id', '=', 'users.id')
             ->join('event_types', 'events.type', '=', 'event_types.id')
            ->select('*','events.id as event_id')
            ->whereRaw('events.status = 1 AND events.event_category = '.$event_category.' ')
            ->orderBy('events.created_at','desc')
            ->get();
            
	}


	public static function event_detail($id)
    {
	   	return $positions = DB::table('events')
	   	->join('event_types', 'events.type', '=', 'event_types.id')
	   	->join('users', 'users.id', '=', 'events.user_id')
	   	->where('events.id',$id)
	   	->select('events.title','events.event_datetime','events.venue','events.id as event_id','event_types.name','users.f_name','events.total_joins')
	    ->first();
	}
	public static function event_links($id)
	{
		return $all_links=DB::table('event_files')
		->where('event_id',$id)
		->get();

	}

	public static function get_reported_events()
	{
		return $events=DB::table('reported_events')
		->select('users.f_name','reported_events.created_at as report_on','reported_events.report_type', 'users.l_name','users.email as reporter_email', 'users.id', 'events.title', 'event_types.name','events.id as event_id', 'events.title', 'events.event_datetime', 'events.venue','event_creater.f_name as creater_f_name', 'event_creater.l_name as creater_l_name','event_creater.email', 'event_creater.id as creater_id', 'events.total_joins')
		->join('events','reported_events.event_id', '=', 'events.id')
		->join('users','reported_events.user_id', '=', 'users.id')
		->join('event_types','events.type', '=', 'event_types.id')
		->join('users as event_creater','event_creater.id', '=', 'events.user_id')
		->orderBy('reported_events.created_at', 'desc')
		->paginate(20);
	}


	public static function get_user_token()
	{
		return DB::table('users')->select('device_token')->where('status','1')->get();

	}
	
	/**********************************************************************************/
	
	public static function get_event_detail($event_id)
    {
        return DB::table('events')           
             ->join('users', 'events.user_id', '=', 'users.id')
             ->join('event_types', 'events.type', '=', 'event_types.id')
            ->whereRaw('events.id='.$event_id.' ')
            ->first();
    }
    
    public static function count_event_comments($event_id)
    {
        return DB::table('event_comments')->selectRaw('count(*) AS comment_counter')->whereRaw('event_id = '.$event_id.' ')->first();
    }
    
    public static function count_event_planed($event_id)
    {
        return DB::table('planed_events')->selectRaw('count(*) AS planed_counter')->whereRaw('event_id = '.$event_id.' ')->first();
    }
    
    public static function count_event_liked($event_id)
    {
        return DB::table('liked_events')->selectRaw('count(*) AS liked_counter')->whereRaw('event_id = '.$event_id.' ')->first();
    }

/********************************** Zaid ****************************************/

    public static function delete_event($id,$data_array,$table_name)
    {
        return DB::table($table_name)->where('id', $id)->update($data_array);
    }
   

	public static function newpassword($id,$data_array,$table_name)
    {
        return DB::table($table_name)->where('id', $id)->update($data_array);
    }
    
    
    
/***********************************************************************************/


    public static function get_all_rates()
	{
		return DB::table('add_display_period')->select('*')->where('status','1')->get();

	}
	
	public static function delete_data($id,$data_array,$table_name)
    {
        return DB::table($table_name)->where('id', $id)->update($data_array);
    }
	
	

}