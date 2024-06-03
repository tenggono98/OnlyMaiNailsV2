<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActionDatabase extends Controller
{
    //

    // Delete Row Model ('modelName','Id')
    public static function deleteSingleModel($modelName,$id){
         // Correctly concatenate the namespace and model name
         try {
            // Correctly concatenate the namespace and model name
            $modelClass = "\\App\\Models\\" . $modelName;
            // Find the model instance by id
            $modelClass::find($id)->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


    // Disable Row Model ('modelName','Id')
    public static function toggleStatusSingleModel($modelName,$id){
        try {
            // Correctly concatenate the namespace and model name
            $modelClass = "\\App\\Models\\" . $modelName;

            // Find the model instance by id
            $model = $modelClass::find($id);

            // dd($model->status);

            if($model->status == 1)
                $model->status = '0';
            else
                $model->status = '1';

            $model->save();
            return true;



        } catch (\Exception $e) {
            return false;
        }
    }



    // Get Data Table All ('tableName','OrderBy')

    // public function getSingleTable($tableName,$orderBy = null){
    //     $table = $tableName
    // }

    public function getSingleleModel($ModeleName,$orderBy = null){
        $table = $ModeleName::orderBy($orderBy,'ASC')->get();

        return $table;
    }
}
