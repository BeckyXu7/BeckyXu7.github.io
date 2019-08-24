<?php

$user_semester = $_REQUEST["semester"];
$user_year = $_REQUEST["year"];
$course_code = $_REQUEST["course_code"];
$user_mode = $_REQUEST["mode"];
//echo $course_code;
//echo $semester;
//echo $user_mode; //External Internal
// if ($user_location = 'StLucia') {
// 	$user_location = 'St Lucia';
// }

// if ($semester == "2019S1") {
// 	$semester = "Semester 1, 2019";
// }

// if ($semester == "2019S2") {
// 	$semester = "Semester 2, 2019";
// }
$semester = $user_semester.", ".$user_year;

// if ($user_mode == "internal" || $user_mode == "Internal") {
// 	$user_mode = "Internal";
// }

// if ($user_mode == "external" || $user_mode == "External") {
// 	$user_mode = "External";
// }

//search_course:https://my.uq.edu.au/programs-courses/course.html?course_code=
//head:<div id="description" class="course">
//tail:</table>
//Gatton
//" target="_blank"

//course-offering-

ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)');

$search_link="https://my.uq.edu.au/programs-courses/course.html?course_code=".$course_code;

if (!empty($course_code) && !empty($semester) && !empty($user_mode)) {
	$search_course_HTML = @file_get_contents($search_link);
	$search_course_HTML = getMid($search_course_HTML,'<div id="description" class="course">','</table>');
	$result = strstr($search_course_HTML,'Semester 1, 2019');
	$mode = getMid($result,'course-offering-mode">','</td>'); //internal or external
	$webcode = null;
	$mode_checktime = 0;

	//echo $user_mode;
	while ($user_mode != $mode && $mode_checktime < 2) {
		$search_course_HTML = substr(strstr($search_course_HTML,$semester),16);
		//echo $search_course_HTML;
		$mode = getMid($search_course_HTML,'course-offering-mode">','</td>'); //Gatton, St Lucia, External
		$mode_checktime = $mode_checktime + 1;
		//echo $mode;
	}
	//echo $mode;
	if ($mode != '' && $user_mode == $mode) {
		$webcode = getMid($search_course_HTML,'section_1/','" target="_blank"'); //get course web code
	} else {
		echo "mode not found";
	}
	

	$search_link="https://course-profiles.uq.edu.au/student_section_loader/section_5/".$webcode;
	$result = @file_get_contents($search_link);
	//echo $search_link;

	if ($result  != "") {
		$result = '<table>'.getMid($result,'<table>','</table>').'</table>'; //get course web code
		//echo $result;
		$table = get_td_array($result);
		foreach ($table as $value) {
			//echo "1";
			foreach ($value as $rvalue) {
				echo $rvalue."<br/>";
			}
		}
	}
} else {
	echo 'error: No completed parameter';
}


// <tr>
// <td id="courseCode" colspan="4">MATH1051</td>
// </tr>

function generate_table($array) {

}

//not found return ''
function getMid($str, $leftStr, $rightStr)
{
    $left = strpos($str, $leftStr);
    $right = strpos($str, $rightStr,$left);
    if($left < 0 or $right < $left) return '';
    return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
}


//https://blog.csdn.net/qq15577969/article/details/90714561
function get_td_array($table) {
  $table = preg_replace("'<table[^>]*?>'si","",$table);
  $table = preg_replace("'<tr[^>]*?>'si","",$table);
  $table = preg_replace("'<td[^>]*?>'si","",$table);
  $table = str_replace("</tr>","{tr}",$table);
  $table = str_replace("</td>","{td}",$table);
  $table = preg_replace("'<[/!]*?[^<>]*?>'si","",$table);
  $table = preg_replace("'([rn])[s]+'","",$table);
  $table = str_replace(" ","",$table);
  $table = str_replace(" ","",$table);
  $table = explode('{tr}', $table);
  array_pop($table);
  foreach ($table as $key=>$tr) {
    $td = explode('{td}', $tr);
    array_pop($td);
    $td_array[] = $td;
  }
  return $td_array;
}

?>

<!--   $table = preg_replace("'<[/!]*?[^<>]*?>'si","",$table); -->