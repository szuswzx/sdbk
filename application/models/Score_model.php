<?php
  class Score_model extends CI_Model
  {
	  public function __construct()
	  {
		  $this->load->database();
	  }
	  
	  public function get_score($studentNo)
	  {
		  $this->db->where(array('XH' => $studentNo));
		  $query = $this->db->get('sdbk_score_20152');
		  $scoreList = $query->result_array();
		  // 计算绩点
          $sumScore = 0; // 总学分
          $sumPoint = 0; // 总绩点
		  foreach ($scoreList as $item) 
		  {
			  $sumScore += $item['XF'];
			  $sumPoint += $item['XFJD'];
		  }
		  $point = number_format($sumPoint / $sumScore, 2);
		  
		  return array(0 => $scoreList, 1 => $point);    //返回每科成绩和绩点
	  }
  }
  