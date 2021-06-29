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
        // $getData_byDate = [];
        // $all_asteriodArray = [];
        // $neo_velocity_kmph = [];
        // $neo_distance_km = [];
        // $diamete_in_km = [];
        // $neo_count_by_date = [];
        
        //get all asteriods in one array
        foreach ($asteriod_allData['near_earth_objects'] as $key => $value) {
            $getData_byDate[$key] = $value;
            foreach ($getData_byDate[$key] as $value) {
                $all_asteriodArray[] = $value;
            }
        }
        
        //getting the fastest and  closest asteriods and their speed, distance value
        foreach ($all_asteriodArray as $singleAsteriod) {
            foreach ($singleAsteriod['estimated_diameter'] as $diameter_key => $value) {
                
                if ($diameter_key == 'kilometers') {
                    $diamete_in_km[] = $value;
                }
                  
            }
            foreach ($singleAsteriod['close_approach_data'] as $specification) {
                foreach ($specification['relative_velocity'] as $relative_velocitykey => $value) {
                    if ($relative_velocitykey == 'kilometers_per_hour') {
                        $neo_velocity_kmph[] = $value;
                    }
                }
                foreach ($specification['miss_distance'] as $miss_distancekey => $value) {
                    if ($miss_distancekey == 'kilometers') {
                        $neo_distance_km[] = $value;
                    }
                }
            }
        }

        $neo_data_by_date_arrkeys = array_keys($getData_byDate);
        // echo "<pre>";
        // print_r($neo_data_by_date_arrkeys);
        // die;
        foreach ($neo_data_by_date_arrkeys as $key => $value) {
            $neo_count_by_date[$value] = count($getData_byDate[$value]);
        }
        // dd($getData_byDate);
        // dd(count($getData_byDate['2020-02-20']));
        // dd($estemetd_diameter['kilometers']);
        //    dd($neo_count_by_date);
        // dd($diamete_in_km);
        arsort($neo_velocity_kmph);
        // echo "Fastest Asteroid Id & Speed(in KM/Hour)" . "<br>";
        $fastestAseroid = Arr::first($neo_velocity_kmph);
        $fastestAseroidkey = array_key_first($neo_velocity_kmph);
        $fastestAseroidId = $all_asteriodArray[$fastestAseroidkey]['id'];
        $fastestAsteroidName = $all_asteriodArray[$fastestAseroidkey]['name'];
       
        $getdiameter = $all_asteriodArray[$fastestAseroidkey]['estimated_diameter']['kilometers'];
        foreach($getdiameter as $key => $value) {
            $actualsize = ($value + $actualsize)/2;
        }
        $fastestAsteroidSize = $actualsize;
        
        asort($neo_distance_km);
        $closestAseroid = Arr::first($neo_distance_km);
        $closestAseroidkey = array_key_first($neo_velocity_kmph);
        $closestAseroidId = $all_asteriodArray[$closestAseroidkey]['id'];
        $closestAsteroidName = $all_asteriodArray[$closestAseroidkey]['name'];
        $closestAsteroidSize = $all_asteriodArray[$closestAseroidkey]['absolute_magnitude_h'];
        // echo $closestAseroidId . "=" . $closestAseroid;

        $neo_count_by_date_arry_keys = array_keys($neo_count_by_date);
        $neo_count_by_date_arry_values = array_values($neo_count_by_date);
        // var_dump($fastestAseroidkey);
        // $data = json_encode($neo_count_by_date);
        // return view('barchart', compact('neo_count_by_date'));
        return view('viewdata', compact('fastestAseroidId','fastestAsteroidName', 'fastestAseroid','fastestAsteroidSize', 'closestAseroidId','closestAsteroidName', 'closestAseroid','closestAsteroidSize', 'neo_count_by_date_arry_keys', 'neo_count_by_date_arry_values'));

        // print_r($neo_by_date);

    }
}
