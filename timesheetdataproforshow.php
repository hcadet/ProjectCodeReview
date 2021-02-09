<?php
/***************************************************************************
*
*	ProjectTheme - copyright (c) - 
*	This file is used to display the piecharts and it is used by other file.
*
*	Programmer: Hernando Cadet	
*	since v1.2.5.3
*
***************************************************************************/

if ($current_user_id == 77){
	$iterneg = 1;
}

echo "<table cellpadding=\"15\" style=\"table-layout: fixed; width: 180%\"><tr>";

foreach($years as $val){	
	if(empty($arr_output[$val])){
        $today = getdate();
        $val = $today['year'] - 1;         
	}
	foreach($arr_output[$val] as $dates){
               
        $nonprojectTimeTotalarray = array();
                       
        //Get Dates//
		$exp_months = explode('-', date('Y-m-d' , $dates[0]['timesheet_date']));
        $months = $exp_months[1];	
        
        //Get Timesheet hours for non-projects	
		$non_project_count = count($arr_output_nonprojects[$val][$months]);        
        
		for($l=0; $l<$non_project_count; $l++){
			$hournonproject = $arr_output_nonprojects[$val][$months][$l]['timesheet_hours'];			
			$exploded_hournonproject = explode("-", $hournonproject);			
			$count_exploded_hournonproject_arr = count($exploded_hournonproject);            
            if($count_exploded_hournonproject_arr == 1){
                //Each Non project Hours
				$nonprojectTimeTotalarray[$arr_output_nonprojects[$val][$months][$l]['project_id']][$l] = $arr_output_nonprojects[$val][$months][$l]['timesheet_hours'];
				
			}
		} 		                 
        
        $litres ="hours";
        $country ="timetype";
////////////////////////////////////Non-Project TIME ANALYSIS/////////////////////////////////////////////////////////
        foreach($nonprojectTimeTotalarray as $nonkeystotal => $nonptotalval){                        
            $nonptotalval = array_filter($nonptotalval);       
            $nonpropertotal = ceil(array_sum($nonptotalval));
            $projectpernonTotalarrayPieChart[$litres] = $nonpropertotal;
            $identifiernonprojectarrayPieChart  = array($country => $nonkeystotal);
            $mergednonprojectTimeTotalarrayPieChartnon = array_merge($identifiernonprojectarrayPieChart, $projectpernonTotalarrayPieChart);
            $mergednonprojectTimeTotalarrayPieChart_encoden .= json_encode($mergednonprojectTimeTotalarrayPieChartnon).",";
        
        }
        
        $chartdivv = "chartdivv_non";			
        $charpiearr_no = $mergednonprojectTimeTotalarrayPieChart_encoden;
        echo "<td><hr>"; 
        echo "<h1>Non-project Time: </h1><br />";
        my_piechart($charpiearr_no, $litres, $country, $chartdivv);
        echo "</td>";	
		
	}	
}	
echo "</tr></table>";
////End Code Sample
?>