<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 02/05/2018
 * Time: 17:44
 */

namespace App\Http\Controllers;


use App\ApiResponseTracker;
use App\Utilities\ApiUtilities;
use function config;

class EndPointsHandlerController extends Controller
{
    public function getEndPoints()
    {
        echo 'please wait ....';

        $endpoints = config('endpoints');

        foreach ($endpoints as $endpoint) {
            $url = $endpoint['base_url'];
            $headers = [
                'content_type' => $endpoint['content_type']
            ];
            $data = $endpoint['data'];
            if ($endpoint['method'] === 'GET') {
                ApiUtilities::IssueGETRequest($url, $headers, $data);

            }
            if ($endpoint['method'] === 'POST') {

                 ApiUtilities::IssuePOSTRequest($url, $headers, $data);
            }
        }

        // download response time data
        $fileType = 'csv';

       return self::exportApiResponseData($fileType);

    }


    public function exportApiResponseData($type){

        $response = ApiResponseTracker::get(['url','method','request_time','server_response_code','total_response_time'])->toArray();



        return \Excel::create('response_time', function($excel) use ($response) {

            $excel->sheet('sheet name', function($sheet) use ($response)

            {

                $sheet->fromArray($response);

            });

        })->download($type);

    }

}