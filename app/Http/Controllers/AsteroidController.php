<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;

class AsteroidController extends Controller
{
    //
    public function getData(Request $givenDate) {

        $startDate = $givenDate->input('start_date');  //get the start date
        $endDate = $givenDate->input('end_date');      //get the end date

        //get data from api in json form
        $data = Http::get("https://api.nasa.gov/neo/rest/v1/feed?start_date=$startDate&end_date=$endDate&api_key=3bgVg16RGcfNVEaoAR5sf3w0AIIXINtyKWsRgXEN");
        // echo $data['element_count'];
        
        //convert to an array
        $asteriod_allData = json_decode($data, true);
        $actualsize = 0.0;
        $actualsizeclosest = 0.0;
        // $getData_byDate = [];
        // $all_asteriodArray = [];
        // $velocityArray = [];
        // $distanceArray = [];
        // $diamete_in_km = [];
        // $asteriodsCount = [];
        
        //get all asteriods in one array
        foreach ($asteriod_allData['near_earth_objects'] as $key => $value) {
            $getData_byDate[$key] = $value;
            foreach ($getData_byDate[$key] as $value) {
                $all_asteriodArray[] = $value;
            }
        }
        
        //getting the fastest and  closest asteriods and their speed, distance value
        foreach ($all_asteriodArray as $singleAsteriod) {
            
            foreach ($singleAsteriod['close_approach_data'] as $getDetails) {
                //get the asteriods velocity array
                foreach ($getDetails['relative_velocity'] as $velocityKey => $value) {
                    if ($velocityKey == 'kilometers_per_hour') {
                        $velocityArray[] = $value;
                    }
                }
                //get the distance of every asteriods in array
                foreach ($getDetails['miss_distance'] as $distanceKey => $value) {
                    if ($distanceKey == 'kilometers') {
                        $distanceArray[] = $value;
                    }
                }
            }
        }
        
        //sorting in decending order by values so that highest velocity comes first
        arsort($velocityArray);
        //get highest speed
        $fastestAsteroidSpeed = Arr::first($velocityArray);   
        //get the index the fastest asteriod
        $fastestAsteroidIndexValue = array_key_first($velocityArray);
        //getting the details by the index value
        $fastestAsteroidId = $all_asteriodArray[$fastestAsteroidIndexValue]['id'];
        $fastestAsteroidName = $all_asteriodArray[$fastestAsteroidIndexValue]['name'];
        $getdiameter = $all_asteriodArray[$fastestAsteroidIndexValue]['estimated_diameter']['kilometers'];
        foreach($getdiameter as $key => $value) {
            $actualsize = ($value + $actualsize)/2;
        }
        $fastestAsteroidSize = $actualsize;
        

        //sorting in decending order by values so that closest one comes first
        asort($distanceArray);
        $closestAsteroidDistance = Arr::first($distanceArray);
        $closestAsteroidIndexValue = array_key_first($distanceArray);
        $closestAsteroidId = $all_asteriodArray[$closestAsteroidIndexValue]['id'];
        $closestAsteroidName = $all_asteriodArray[$closestAsteroidIndexValue]['name'];
        $getdiameterClosest = $all_asteriodArray[$closestAsteroidIndexValue]['estimated_diameter']['kilometers'];
        foreach($getdiameterClosest as $key => $value) {
            $actualsizeclosest = ($value + $actualsizeclosest)/2;
        }
        $closestAsteroidSize = $actualsizeclosest;
        
        //get the count of asteriods for each day
        $givenDates = array_keys($getData_byDate);
        foreach ($givenDates as $key => $value) {
            $asteriodsCount[$value] = count($getData_byDate[$value]);
        }
        $givenDates = array_keys($asteriodsCount);
        $finalAsteriodCount = array_values($asteriodsCount);
        
        return view('viewdata', compact('fastestAsteroidId','fastestAsteroidName', 'fastestAsteroidSpeed','fastestAsteroidSize', 'closestAsteroidId','closestAsteroidName', 'closestAsteroidDistance','closestAsteroidSize', 'givenDates', 'finalAsteriodCount'));

    }
}
