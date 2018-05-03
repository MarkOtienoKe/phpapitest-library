<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiResponseTracker extends Model
{
    protected $fillable = ['url','method','request_time','server_response_code','total_response_time'];

    protected $table = 'tbl_api_response';

    protected $primaryKey = 'id';
}
