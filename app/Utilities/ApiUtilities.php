<?php

namespace App\Utilities;

use App\ApiResponseTracker;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\TransferStats;

class ApiUtilities
{
    public static function IssueGETRequest($url, $headers, $data)
    {

        $client = new Client();
        try {

            $request = $client->request('GET', $url, [$headers, 'query' => $data,
                'on_stats' => function (TransferStats $stats) {

                    \Log::debug('The transfer time =>', [$stats->getTransferTime()]);

                    \Log::debug('The Handler stat data object =>', [$stats->getHandlerStats()['url']]);

                    \Log::debug('The effective uri=>', [$stats->getEffectiveUri()]);
                    if ($stats->hasResponse()) {

                        \Log::debug('The response body=>', [$stats->getResponse()->getStatusCode()]);

                    }
                    $startTime = \Carbon\Carbon::now()->toDateTimeString($stats->getHandlerStats()['starttransfer_time']);

                    $saveApiTrackingData = [
                        'url' => $stats->getHandlerStats()['url'],
                        'method' => 'GET',
                        'request_time' => $startTime,
                        'server_response_code' => $stats->getHandlerStats()['http_code'],
                        'total_response_time' => $stats->getTransferTime()
                    ];

                    ApiResponseTracker::insert($saveApiTrackingData);

                }
            ]);

            return json_decode((string)$request->getBody());

        } catch (RequestException $e) {

            $error = array(
                'error' => 'Server Error: Unsuccessful request.',
            );
            return json_encode($error);

        }


    }

    public static function IssuePOSTRequest($url, $headers, $data)
    {

        $client = new Client();

        try {

            $request = $client->request('POST', $url, [$headers, 'data' => $data,
                'on_stats' => function (TransferStats $stats) {

                    \Log::debug('The transfer time =>', [$stats->getTransferTime()]);

                    \Log::debug('The Handler stat data object =>', [$stats->getHandlerStats()]);

                    \Log::debug('The effective uri=>', [$stats->getEffectiveUri()]);
                    if ($stats->hasResponse()) {
                        \Log::debug('The response body=>', [$stats->getResponse()->getStatusCode()]);
                    }
                    $startTime = \Carbon\Carbon::now()->toDateTimeString($stats->getHandlerStats()['starttransfer_time']);
                    $saveApiTrackingData = [
                        'url' => $stats->getHandlerStats()['url'],
                        'method' => 'POST',
                        'request_time' => $startTime,
                        'server_response_code' => $stats->getHandlerStats()['http_code'],
                        'total_response_time' => $stats->getTransferTime()
                    ];

                    ApiResponseTracker::insert($saveApiTrackingData);

                }
            ]);
            return json_decode((string)$request->getBody());
        } catch (RequestException $e) {

            $error = array(
                'error' => 'Server Error: Unsuccessful request.',
            );
            return json_encode($error);

        }

    }

}
