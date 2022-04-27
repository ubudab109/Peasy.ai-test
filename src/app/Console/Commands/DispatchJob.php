<?php

namespace App\Console\Commands;

use App\Models\UserRandom;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DispatchJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dispatch:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatching Queue';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
         /* CACHE KEY FOR FETCHING RESULTS */
         $cacheKey = 'user_query_results_20';

         /* CACHING */
         Cache::store('redis')->remember($cacheKey, now()->addSeconds(rand(5,60)), function () {
 
             $response = Http::get('https://randomuser.me/api/?results=20'); // REQUEST WITH HTTP CLIENT
 
             $res = $response->json(); // GET THE RESPONSE AS JSON
 
             $responseData = []; // TEMPORARY TO SAVE RESPONSE DATA
 
             $userRandomData = UserRandom::first();
             /* 
                 CHECK IF USER RANDOM HAVE A DATA, IF TRUE, THEN OLD DATA WILL UPDATE WITH NEW DATA
             */
             if ($userRandomData != null) {
 
                 $ageOldTmp = [] ;// TEMPORARY TO SAVE ALL AGE FROM OLD DATA USERS RANDOM
 
                 $oldData = json_decode($userRandomData->data, true); // GET OLD DATA USERS RANDOM
 
                 /* LOOPING AND PUSH NEW DATA TO OLD DATA USERS RANDOM */
                 foreach ($res['results'] as $newResults) {
                     array_push($oldData, $newResults);
                 }
 
                 /* LOOPING NEW DATA USERS RANDOM AND PUSH NEW AGE */
                 foreach ($oldData as $newAgeData) {
                     array_push($ageOldTmp, $newAgeData['dob']['age']);
                 }
 
                 $newMean        = array_sum($ageOldTmp) / count($ageOldTmp); // NEW MEAN AGE
 
                 /* NEW MEDIAN AGE */
                 $newCollectAge  = collect($ageOldTmp); 
                 $newMedian      = $newCollectAge->median();
 
                 /* UPDATE OLD DATA USERS RANDOM TO DATABASE */
                 $responseData['mean']       = floor($newMean);
                 $responseData['median']     = floor($newMedian);
                 $responseData['data']       = json_encode($oldData);
 
                 $userRandomData->update($responseData);
 
                 $apiRes = UserRandom::first();
 
             } else {
                 $ageTmp = []; // TEMPORARY TO SAVE ALL AGE FROM USERS
 
                 /* LOOPING RESULTS FOR GET ALL AGE FROM USERS AND PUSH TO AGE TEMPORARY ARRAY */
                 foreach ($res['results'] as $data) {
                     array_push($ageTmp, $data['dob']['age']);
                 }
                 
                 $mean = array_sum($ageTmp) / count($ageTmp); // CALCULATE MEAN FROM ALL AGE IN AGE TEMPORARY ARRAY
 
                 $collectAge = collect($ageTmp); // GET COLLECTION FROM AGE TEMPORARY ARRAY
                 $median = $collectAge->median(); // CALCULATE MEDIAN FROM AGE TEMPRARY ARRAY
 
                 /* SAVE ALL RESPONSE TO RESPONSE DATA TEMPRARY ARRAY */
                 $responseData['mean']       = floor($mean);
                 $responseData['median']     = floor($median);
                 $responseData['data']       = json_encode($res['results']);
                 
                 /* INSERT RESPONSE DATA TO USER RANDOM TABLE  */
                 $apiRes = UserRandom::create($responseData);
             }
 
             Log::info(
                 'Mean and Median Age : ' .
                 'Mean: '. $apiRes->mean. ' and Median : '. $apiRes->median
             );
         });
        return 0;
    }
}
