<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class BlameableObserver
{
    /**
    * @param Model $model
    */

    public function creating(Model $model)
    {
        $model->created_by = Auth::user()->name;
    }
    
    /**
    * @param Model $model
    */

    public function updating(Model $model)
    {
        $model->updated_by = Auth::user()->name;
    }

    /**
    * @param Model $model
    */

    public function deleted(Model $model)
    {
        $model->deleted_by = Auth::user()->name;
    }
}
