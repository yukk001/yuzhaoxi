<?php

class MyContractList
{
    private $contract_id;//主键ID
    private $dept_id;//部门
    private $contract_type;//合同类型
    private $second_type;//二级类型
    private $item_num;//项目编号
    private $item_name;//项目名称
    private $contract_num;//合同编号
    private $is_item; //是否为项目合同
    private $contract_state;//合同状态
    private $signed_time;//签订时间
    private $archive_time;//归档时间
    private $archive_address;//归档位置
    private $contract_name;//合同名称   
    private $party_a;//甲方    
    private $party_b;//乙方    
    private $party_c;//丙方    
    private $contract_content;//合同主要内容
    private $amount_min;//合同金额查询下限   
    private $amount;//合同金额   
    private $amount_max;//合同金额查询上限    
    private $payment_ratio;//付款比例   
    private $contract_term;//合同期限  
    private $bank_account;//银行账号   
    private $version;//版本   
    private $copies;//份数 
    private $leader;//合同负责人    
    private $archive_leader;//归档人    
    private $operators_type;//运营商类别   
    private $province;//省份   
    private $region;//地区 
    private $actual_collection;//实际收款
    private $actual_payment;//实际付款
    private $contract_runid;//合同审批流水号
    private $remarks;//备注
    
    
    private $begin_time;
    private $end_time;
    
    private $contract_query_type=1;

    private $start_pos = 0;

    private $row_number = 10;
    
    private $order_by_field;

    private $order_by_direct;


    public function __construct($dept_id="",$contract_type="",$second_type="",$item_num="",$item_name="",$contract_num="",$contract_state="",$signed_time="",$archive_time="",$archive_address="",$contract_name="",$party_a="",$party_b="",$party_c="",$contract_content="",$amount="",$payment_ratio="",$contract_term="",$bank_account="",$version="",$copies="",$leader="",$archive_leader="",$operators_type="",$province="",$region="",$actual_collection="",$actual_payment="",$contract_runid="")
    {

        $this->dept_id = $dept_id;
        $this->contract_type = $contract_type;
        $this->second_type = $second_type;
        $this->item_num = $item_num;
        $this->item_name = $item_name;
        $this->contract_num = $contract_num;
        $this->contract_state = $contract_state;
        $this->signed_time = $signed_time;
        $this->archive_time = $archive_time;
        $this->archive_address = $archive_address;
        $this->contract_name = $contract_name;
        $this->party_a = $party_a;
        $this->party_b = $party_b;
        $this->party_c = $party_c;
        $this->contract_content = $contract_content;
        $this->amount = $amount;
        $this->payment_ratio = $payment_ratio;
        $this->contract_term = $contract_term;
        $this->bank_account = $bank_account;
        $this->version = $version;
        $this->copies = $copies;
        $this->leader = $leader;
        $this->archive_leader = $archive_leader;
        $this->operators_type = $operators_type;
        $this->province = $province;
        $this->region = $region;
        $this->actual_collection = $actual_collection;
        $this->actual_payment = $actual_payment;
        $this->contract_runid = $contract_runid;
        $this->order_by_field = "CONTRACT.SIGNED_TIME";
        $this->order_by_direct = "DESC";
    
    }

    public function _get($property_name)
    {

        $property_name = strtolower ( $property_name );
        
        if (isset ( $this->$property_name ))
        {
            
            return $this->$property_name;
        }
        else
        {
            
            return NULL;
        }
    
    }

    public function _set($property_name, $value)
    {

        $property_name = strtolower ( $property_name );
        
        $this->$property_name = $value;
    
    }
    
    
    public function getContractListCount($r_connection = NULL)
    {

        if ($r_connection == NULL)
        {
            $r_connection = TD::conn ();
        }
        
        $select_expr = " COUNT( CONTRACT.CONTRACT_ID) as TOTAL_NUMBER ";
        $where_definition = $this->getCondition ();
        $table_reference = " CONTRACT ";
        $sql = "SELECT " . $select_expr . " FROM " . $table_reference . $where_definition;
        
        $total_number = 0;
        $r_cursor = exequery ( $r_connection , $sql );
        if ($row = mysql_fetch_array ( $r_cursor ))
        {
            $total_number = $row ["TOTAL_NUMBER"];
        }
        
        return $total_number;
    
    }

    public function getContractList($r_connection = NULL)
    {

        if ($r_connection == NULL)
        {
            $r_connection = TD::conn ();
        }
        
        $list = Array ();
        
        $select_expr = " CONTRACT.CONTRACT_ID, 
                         CONTRACT.DEPT_ID, 
                         CONTRACT.CONTRACT_TYPE,
                         CONTRACT.SECOND_TYPE,
                         CONTRACT.ITEM_NUM,
                         CONTRACT.IS_ITEM,
                         CONTRACT.ITEM_NAME,
                         CONTRACT.CONTRACT_NUM,
                         CONTRACT.CONTRACT_COUNTER_NUM,
                         CONTRACT.CONTRACT_STATE,
                         CONTRACT.SIGNED_TIME,
                         CONTRACT.ARCHIVE_TIME,
                         CONTRACT.ARCHIVE_ADDRESS,
                         CONTRACT.CONTRACT_NAME,
                         CONTRACT.PARTY_A,
                         CONTRACT.PARTY_B,
                         CONTRACT.PARTY_C,
                         CONTRACT.CONTRACT_CONTENT, 
                         CONTRACT.AMOUNT, 
                         CONTRACT.PAYMENT_RATIO,
                         CONTRACT.CONTRACT_TERM,
                         CONTRACT.BANK_ACCOUNT,
                         CONTRACT.VERSION,
                         CONTRACT.COPIES,
                         CONTRACT.LENDED_COPIES,
                         CONTRACT.LAST_COPIES,
                         CONTRACT.LEADER,
                         CONTRACT.ARCHIVE_LEADER,
                         CONTRACT.OPERATORS_TYPE,
                         CONTRACT.PROVINCE,
                         CONTRACT.REGION,
                         CONTRACT.ACTUAL_COLLECTION,
                         CONTRACT.ACTUAL_PAYMENT,
                         CONTRACT.CONTRACT_RUNID ,
                         CONTRACT.ORIGINAL_COPY ";
                         
        $where_definition = $this->getCondition ();
        
        $order_definition = " ORDER BY " . $this->order_by_field . " " . $this->order_by_direct;
        if ($this->start_pos != 0 || $this->row_number != 0)
        {
            $limit_definition = " LIMIT " . $this->start_pos . ", " . $this->row_number;
        }
        else
        {
            $limit_definition = "";
        }
        
        $sql = "SELECT " . $select_expr . " FROM CONTRACT " . $where_definition . $order_definition . $limit_definition;
        file_put_contents("contractlist_sql.txt",var_export($sql,true));
        $r_cursor = exequery ( $r_connection , $sql );
        while ( $row = mysql_fetch_array ( $r_cursor ) )
        {
            $list [$row ["CONTRACT_ID"]] = Array (
                   
					'DEPT_ID'		=>	$row['DEPT_ID'],
					'CONTRACT_TYPE'		=>	$row['CONTRACT_TYPE'],
					'SECOND_TYPE'		=>	$row['SECOND_TYPE'],
					'ITEM_NUM'	=>	$row['ITEM_NUM'],
					'IS_ITEM'		=>	$row['IS_ITEM'],
					'ITEM_NAME'		=>	$row['ITEM_NAME'],
					'CONTRACT_NUM'		=>	$row['CONTRACT_NUM'],
					'CONTRACT_COUNTER_NUM'		=>	$row['CONTRACT_COUNTER_NUM'],
					'SIGNED_TIME'		=>	$row['SIGNED_TIME'],
					'ARCHIVE_TIME'		=>	$row['ARCHIVE_TIME'],
					'ARCHIVE_ADDRESS'		=>	$row['ARCHIVE_ADDRESS'],
					'CONTRACT_NAME'		=>	$row['CONTRACT_NAME'],
					'PARTY_A'		=>	$row['PARTY_A'],
					'PARTY_B'		=>	$row['PARTY_B'],
					'PARTY_C'		=>	$row['PARTY_C'],
					'CONTRACT_CONTENT'		=>	$row['CONTRACT_CONTENT'],
					'AMOUNT'		=>	$row['AMOUNT'],
					'PAYMENT_RATIO'		=>	$row['PAYMENT_RATIO'],
					'CONTRACT_TERM'		=>	$row['CONTRACT_TERM'],
					'BANK_ACCOUNT'		=>	$row['BANK_ACCOUNT'],
					'COPIES'		=>	$row['COPIES'],
					'LENDED_COPIES'		=>	$row['LENDED_COPIES'],	
					'LAST_COPIES'   =>	$row['LAST_COPIES'],			
					'LEADER'		=>	$row['LEADER'],
					'ARCHIVE_LEADER'		=>	$row['ARCHIVE_LEADER'],
					'OPERATORS_TYPE'		=>	$row['OPERATORS_TYPE'],
					'PROVINCE'		=>	$row['PROVINCE'],
					'REGION'		=>	$row['REGION'],
					'ACTUAL_COLLECTION'		=>	$row['ACTUAL_COLLECTION'],
					'ACTUAL_PAYMENT'		=>	$row['ACTUAL_PAYMENT'],
					'CONTRACT_RUNID'		=>	$row['CONTRACT_RUNID'],
            		'ORIGINAL_COPY'		=>	$row['ORIGINAL_COPY']
            );
        }
        
        return $list;
    
    }

    private function getCondition()
    {

        
        
        if (! empty ( $this->contract_query_type ) && $this->contract_query_type != "")
        {
            if($this->contract_query_type==2) //合同管理员权限为所有合同
            {
                $str_condition = " WHERE CONTRACT.CONTRACT_ID !='' AND CONTRACT.DELETE_FLAG='1'  ";
                if (! empty ( $this->dept_id ) && $this->dept_id != "")//合同所属部门
	            {
	                $str_condition .= " AND CONTRACT.DEPT_ID = '" . $this->dept_id . "' ";
	            }
            }
            else
            {
                $str_condition = " WHERE CONTRACT.CONTRACT_NUM !='' AND CONTRACT.DELETE_FLAG='1'  AND CONTRACT.DEPT_ID = '" . $this->dept_id . "' ";
            }
            
        }
        else
        {
            $str_condition = " WHERE CONTRACT.CONTRACT_NUM !='' AND CONTRACT.DELETE_FLAG='1' ";
            if (! empty ( $this->dept_id ) && $this->dept_id != "")//合同所属部门
            {
                $str_condition .= " AND CONTRACT.DEPT_ID = '" . $this->dept_id . "' ";
            }
        }
        
        

        if (! empty ( $this->contract_num ) && $this->contract_num != "")//合同编号
        {
            $str_condition .= " AND CONTRACT.CONTRACT_NUM LIKE '%" . $this->contract_num . "%' ";
        }
        
        if (! empty ( $this->is_item ) && $this->is_item != "")//是否为项目合同
        {
            $str_condition .= " AND CONTRACT.IS_ITEM = '" . $this->is_item . "' ";
        }
        
        if (! empty ( $this->contract_name ) && $this->contract_name != "")//合同名称
        {
            
            $str_condition .= " AND CONTRACT.CONTRACT_NAME LIKE '%" . $this->contract_name . "%' ";
        }
        
        if (! empty ( $this->contract_type ) && $this->contract_type != "")//合同类型
        {
            
            $str_condition .= " AND CONTRACT.CONTRACT_TYPE = '" . $this->contract_type . "' ";
        }
        
        if (! empty ( $this->second_type ) && $this->second_type != "")//合同二级类型
        {
            $str_condition .= " AND CONTRACT.SECOND_TYPE = '" . $this->second_type . "' ";
        }
        
        if (! empty ( $this->item_num ) && $this->item_num != "")//合同项目编号
        {
            $str_condition .= " AND CONTRACT.ITEM_NUM = '" . $this->item_num . "' ";
        }     
        
        if (! empty ( $this->item_name ) && $this->item_name != "")//合同项目名称
        {
            $str_condition .= " AND CONTRACT.ITEM_NAME LIKE '%" . $this->item_name . "%' ";
        }     
        
        if (! empty ( $this->contract_state ) && $this->contract_state != "")//合同状态
        {
            $str_condition .= " AND CONTRACT.CONTRACT_STATE = '" . $this->contract_state . "' ";
        }     
        
        
        if (! empty ( $this->begin_time ) && trim ( $this->begin_time ) != "")
        {
            if (! empty ( $this->end_time ) && trim ( $this->end_time ) != "")
            {
                $str_condition .= " AND (CONTRACT.SIGNED_TIME BETWEEN '" . $this->begin_time . " 00:00:00' AND '" . $this->end_time . " 23:59:59') ";
            }
            else
            {
                $str_condition .= " AND CONTRACT.SIGNED_TIME >= '" . $this->begin_time . " 00:00:00' ";
            }
        }
        else
        {
            if (! empty ( $this->end_time ) && $this->end_time != NULL && trim ( $this->end_time ) != "")
            {
                $str_condition .= " AND CONTRACT.SIGNED_TIME <= '" . $this->end_time . " 23:59:59' ";
            }
        } 
          
        if (! empty ( $this->signed_time ) && $this->signed_time != "")//合同签订时间
        {
            
            $str_condition .= " AND CONTRACT.SIGNED_TIME = '" . $this->signed_time . "' ";
            
        } 
        
        
        
            
        
        if (! empty ( $this->archive_time ) && $this->archive_time != "")//合同归档时间
        {
            $str_condition .= " AND CONTRACT.ARCHIVE_TIME = '" . $this->archive_time . "' ";
        }     
        
        if (! empty ( $this->archive_address ) && $this->archive_address != "")//合同归档位置
        {
            $str_condition .= " AND CONTRACT.ARCHIVE_ADDRESS = '" . $this->archive_address . "' ";
        }            
        
         if (! empty ( $this->party_a ) && $this->party_a != "")//合同甲方
        {
            $str_condition .= " AND CONTRACT.PARTY_A LIKE '%" . $this->party_a . "%' ";
        }  
        
         if (! empty ( $this->party_b ) && $this->party_b != "")//合同乙方
        {
            $str_condition .= " AND CONTRACT.PARTY_B LIKE '%" . $this->party_b . "%' ";
        }  
        
         if (! empty ( $this->party_c ) && $this->party_c != "")//合同丙方
        {
            $str_condition .= " AND CONTRACT.PARTY_C LIKE '%" . $this->party_c . "%' ";
        }  
        
        if (! empty ( $this->contract_content ) && $this->contract_content != "")//合同主要内容
        {
            $str_condition .= " AND CONTRACT.CONTRACT_CONTENT LIKE '%" . $this->contract_content . "%' ";
        }  
        
        
        
        if (! empty ( $this->amount ) && $this->amount != "")//合同金额
        {
            $str_condition .= " AND CONTRACT.AMOUNT = '" . $this->amount . "' ";
        }  
         if (! empty ( $this->amount_min ) && trim ( $this->amount_min ) != "")
        {
            if (! empty ( $this->amount_max ) && trim ( $this->amount_max ) != "")
            {
                $str_condition .= " AND (CONTRACT.AMOUNT BETWEEN  ". $this->amount_min ."  AND  ". $this->amount_max .") ";
            }
            else
            {
                $str_condition .= " AND CONTRACT.AMOUNT >= ". $this->amount_min ." ";
            }
        }
        else
        {
            if (! empty ( $this->amount_max ) && $this->amount_max != NULL && trim ( $this->amount_max ) != "")
            {
                $str_condition .= " AND CONTRACT.AMOUNT <= ". $this->amount_max ." ";
            }
        } 
        
        
        if (! empty ( $this->payment_ratio ) && $this->payment_ratio != "")//合同付款比例
        {
            $str_condition .= " AND CONTRACT.PAYMENT_RATIO = '" . $this->payment_ratio . "' ";
        } 
        
        if (! empty ( $this->contract_term ) && $this->contract_term != "")//合同期限
        {
            $str_condition .= " AND CONTRACT.CONTRACT_TERM = '" . $this->contract_term . "' ";
        }  
        
        if (! empty ( $this->bank_account ) && $this->bank_account != "")//银行账号
        {
            $str_condition .= " AND CONTRACT.BANK_ACCOUNT LIKE '%" . $this->bank_account . "%' ";
        }  
        
        if (! empty ( $this->version ) && $this->version != "")//合同版本
        {
            $str_condition .= " AND CONTRACT.VERSION = '" . $this->version . "' ";
        }  
        
        if (! empty ( $this->copies ) && $this->copies != "")//合同份数
        {
            $str_condition .= " AND CONTRACT.COPIES = '" . $this->copies . "' ";
        }
        
        if (! empty ( $this->leader ) && $this->leader != "")//合同负责人
        {
            $str_condition .= " AND CONTRACT.LEADER = '" . $this->leader . "' ";
        }
        
        if (! empty ( $this->archive_leader ) && $this->archive_leader != "")//合同归档人
        {
            $str_condition .= " AND CONTRACT.ARCHIVE_LEADER = '" . $this->archive_leader . "' ";
        }
        
        if (! empty ( $this->operators_type ) && $this->operators_type != "")//合同运营商类别
        {
            $str_condition .= " AND CONTRACT.OPERATORS_TYPE = '" . $this->operators_type . "' ";
        }
        
        if (! empty ( $this->province ) && $this->province != "")//合同省份
        {
            $str_condition .= " AND CONTRACT.PROVINCE = '" . $this->province . "' ";
        }
        
        if (! empty ( $this->region ) && $this->region != "")//合同地区
        {
            $str_condition .= " AND CONTRACT.REGION = '" . $this->region . "' ";
        }
        
        if (! empty ( $this->actual_collection ) && $this->actual_collection != "")//合同实际收款
        {
            $str_condition .= " AND CONTRACT.ACTUAL_COLLECTION = '" . $this->actual_collection . "' ";
        }
        if (! empty ( $this->actual_payment ) && $this->actual_payment != "")//合同实际付款
        {
            $str_condition .= " AND CONTRACT.ACTUAL_PAYMENT = '" . $this->actual_payment . "' ";
        }
        if (! empty ( $this->contract_runid ) && $this->contract_runid != "")//合同审批流水号
        {
            $str_condition .= " AND CONTRACT.CONTRACT_RUNID = '" . $this->contract_runid . "' ";
        }
        file_put_contents("a.txt",var_export($str_condition,true));
        return $str_condition;
    
    }





}



?>
