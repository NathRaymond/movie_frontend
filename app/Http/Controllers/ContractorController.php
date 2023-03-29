<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Contractor;

class ContractorController extends Controller
{
    public function contractor_index(Request $request)
    {
        $data['contractors'] = Contractor::all();
        return view('contractor.contractor_page', $data);
    }

    public function download()
    {
        
        try {

            $database = config('app.db');

            // dd(config('app.db'));
            $user = config('app.dbuser');
            $pass = config('app.dbpass');
            $host = config('app.dbhost');
            $dir = 'server_db_backup.sql';
            // dd($user,$pass,$host,$dir);
            // try {
            //     unlink($dir);
            // } catch (\Exception $exception) {
            //     dd($exception->getMessage());
            // }

            // echo "<h3>Backing up database to `<code>{$dir}</code>`</h3>";
            // mysqldump -u [user name] –p [password] [options] [database_name] [tablename] > [dumpfilename.sql]
            // --add-drop-database --databases 
            // mysqldump --user=root --password=bismib_fashion@_mysql --host=localhost --events --routines --triggers elaravel_v2 --result-file=db_backup_new.sql 2>&1
            exec("mysqldump  --user={$user} --password={$pass} --host={$host} --events --routines --triggers  {$database}  --result-file={$dir} 2>&1", $output);

            $tableViewsCounts = DB::select('SELECT count(TABLE_NAME) AS TOTALNUMBEROFTABLES FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ?', [$database]);
            $tableViewsCounts = $tableViewsCounts[0]->TOTALNUMBEROFTABLES;
            
            $viewsCounts = DB::select('SELECT count(TABLE_NAME) AS TOTALNUMBEROFVIEWS FROM INFORMATION_SCHEMA.TABLES WHERE  TABLE_TYPE LIKE "VIEW" AND TABLE_SCHEMA = ?', [$database]);
            $viewsCounts = $viewsCounts[0]->TOTALNUMBEROFVIEWS;

            $tablesCount = $tableViewsCounts-$viewsCounts;


            $proceduresCounts = DB::select('SELECT count(TYPE) AS proceduresCounts FROM mysql.proc WHERE  TYPE="PROCEDURE" AND db = ?', [$database]);
            $proceduresCounts = $proceduresCounts[0]->proceduresCounts;

            $functionsCounts = DB::select('SELECT count(TYPE) AS functionsCounts FROM mysql.proc WHERE  TYPE="FUNCTION" AND db = ?', [$database]);
            $functionsCounts = $functionsCounts[0]->functionsCounts;

            $projectURL = url('/');
            $deviceIP = \Request::ip();

            $init_command = PHP_EOL.'-- '.$database.' Database Backup Generated time = '.YmdTodmYPm(\Carbon\Carbon::now()). PHP_EOL.PHP_EOL.
                            '-- Project URL = '.$projectURL.PHP_EOL.
                            '-- Device IP = '.$deviceIP.PHP_EOL.PHP_EOL.
                            '-- =============Objects Counting Start================= '.PHP_EOL.PHP_EOL.
                            '-- Total Tables + Views = '.$tableViewsCounts.PHP_EOL.
                            '-- Total Tables = '.$tablesCount.PHP_EOL.
                            '-- Total Views = '.$viewsCounts.PHP_EOL.PHP_EOL.
                            '-- Total Procedures = '.$proceduresCounts.PHP_EOL.
                            '-- Total Functions = '.$functionsCounts.PHP_EOL.
                            '-- =============Objects Counting End================= '.PHP_EOL.
                            PHP_EOL.PHP_EOL.
                            'SET FOREIGN_KEY_CHECKS=0; '. PHP_EOL.
                            'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";'. PHP_EOL.
                            'START TRANSACTION;'. PHP_EOL.
                            'SET time_zone = "+06:00";'.PHP_EOL.
                            'drop database if exists '.$database.';'. PHP_EOL.
                            'CREATE DATABASE IF NOT EXISTS '.$database.' DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;'. PHP_EOL.
                            'use '.$database.';'.PHP_EOL; 
                
            $data = file_get_contents($dir);

            $append_command = PHP_EOL.'SET FOREIGN_KEY_CHECKS=1;'.PHP_EOL.'COMMIT;'.PHP_EOL;
            // dd($data);
            file_put_contents ( $dir , $init_command.$data.$append_command);

            return response()->download($dir);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
    public function download1(){

        Artisan::call('backup:run');
        $path = storage_path('app/laravel-backup/*');
        $latest_ctime = 0;
        $latest_filename = '';
        $files = glob($path);
        foreach($files as $file)
        {
                if (is_file($file) && filectime($file) > $latest_ctime)
                {
                        $latest_ctime = filectime($file);
                        $latest_filename = $file;
                }
        }
        return response()->download($latest_filename);
    }
    public function store_contractor(Request $request)
    {
        try {
            $check = Contractor::where('name', $request->name)->first();
            if ($check) {
                throw new \Exception('This Contractor name is already existing');
            }
            $check = Contractor::where('email', $request->email)->first();
            if ($check) {
                throw new \Exception('This Email is already existing');
            }
            $check = Contractor::where('phone_number', $request->phone_number)->first();
            if ($check) {
                throw new \Exception('This Phone Number is already existing');
            }

            $input = $request->all();
            $input['name'] = $input['name'];
            $input['phone_number'] = $input['phone_number'];
            $input['email'] = $input['email'];
            $input['address'] = $input['address'];
            $input['sex'] = $input['sex'];
            $contractor = Contractor::create($input);

            return redirect()->back()->with('success', 'Contractor created successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    public function getcontractorInfor(Request $request)
    {
        $contractor = Contractor::where('id', $request->id)->first();
        return response()->json($contractor);
    }

    public function update_contractor(Request $request)
    {
        $contractor = Contractor::find($request->id);
        if ($contractor) {
            $input = $request->all();
            $contractor->fill($input)->save();
        }
        return redirect()->back()->with('success', 'contractor updated successfully');
    }

    public function destroy_contractor(Request $request)
    {
        $id = $request->id;
        Contractor::find($id)->delete();
        return redirect()->back()
            ->with('success', 'contractor deleted successfully');
    }
}
