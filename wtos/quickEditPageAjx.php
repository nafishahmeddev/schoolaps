<? 
## v-1.3 author Mizanur Rahaman  mizanur82@gmail.com for new wtos
session_start();
ob_start();

include('wtosConfigLocal.php');// load configuration
include('wtos.php'); // load wtos Library
ob_end_clean();

function viewQuickRows($options,$foreignIdValue)
{


 
global $os;
 $condition='';
 $fldACStr='';
extract($options);
if($foreignIdValue!='')
{ $condition .="  $foreignId!='' and $foreignId>0 ";
   $condition .=" and $foreignId='$foreignIdValue'";
}
  $tableQuery=str_replace('[condition]',$condition,$tableQuery);
// $tableQuery;
$rs=$os->mq($tableQuery);

?>
<table cellpadding="0" cellspacing="0" class="wtclass<? echo $functionId ?>">
<tr style="display:none;" ><td colspan="30" class="PageHeading"> <? echo $PageHeading ?></td></tr>
  
  
  <tr>
 
  <?
 foreach($fields as $fld=>$alise)
  {
    
	  ?>
     <td>  
	 <? echo $alise; ?>
	 </td>
	 <? } ?>
	  <td>&nbsp;   </td>  
	 
 </tr>
    

<?
$sl=1;
while($row=$os->mfa($rs))
{


 ?>

 
  
  <tr>
  <!--<td style="color:#FF8040; font-weight:bold;"><? echo $sl?> &nbsp;&nbsp; </td>-->
  <?
 foreach($fields as $fld=>$alise)
  {
     
   $inlineEditAllow=$os->val($inlineEdit,$fld);
   $className=$class[$fld];
    // 
	 
	 
	  ?>
     <td>  
	 <? if($type[$fld]=='T' || $type[$fld]=='' ||  $type[$fld]=='AC'){  ##  view date need to add for date fields
	 
	  ?> 
	  <? if( $inlineEditAllow=='yes'){ 
	  $os->editText($row[$fld],$table,$fld,$tableId,$row[$tableId] , $inputNameID='editText',$extraParams='class="'.$className.'" ',$ajaxPage='',$ajaxMethod='POST',$phpFunc='',$javascriptFunc='',$advanceOption='');
	  }else{ ?>
	  <? echo $row[$fld] ?>
	  <?  } ?>
	  
	
	
	
	
	
	  <? }else if($type[$fld]=='DD'){
	
	  if($relation[$fld]!='')
	  {
	    
	   if( substr($relation[$fld],0,6)=='select' )
	      {
		     $qq=explode('-fld-',$relation[$fld]);
			  $valueList='';
		      $qq[0]= $os->mq($qq[0]);
			  while( $out=$os->mfa($qq[0]))
			   {
			   
				 
				
			    // $os->ddDataType[$out[$qq[1]]]=$out[$qq[2]];
			   
			   # multiple value in 
						$valueList='';
						$valF=explode(',',$qq[2]);
						foreach($valF as $fieldn)
						{
						$valueList=$valueList.$out[trim($fieldn)]." ";
						
						}
			            $os->ddDataType[$out[$qq[1]]]=$valueList;
			   
			   
			   }
			     
	          
	        
	        } else
			{
			   $os->ddDataType=$os->{$relation[$fld]} ;
			
			}   
	 
	  
	  }
	  
	  
	  
	  echo $os->ddDataType[$row[$fld]];
	   ?> 
	 <select   class="<? echo $class[$fld] ?>" style="display:none;"> 
	 <? //  $os->onlyOption($os->ddDataType,$row[$fld]); ?>
	 
	 </select>
	 <?  } else if($type[$fld]=='D'){
	     echo $os->showDate($row[$fld]);
	 
	 }
	 ?>
	 
	 </td>
  
  <? 
  
  
  }

?>
 <td> 
 <?  if($delete){ ?>
 <input type="button" class="qdeleteButton" value="Del" title="Delete record"  onclick="<? echo $ajaxDeleteFunction ?>('<? echo $row[$tableId] ?>');" />
 <? } ?>
 
 </td>
   </tr>
  
  
  

<?
$sl++;
}

?>  
<tr><td colspan="15" style="border-bottom:groove #CCCCCC 2px; height:25px;">&nbsp; </td>
  </tr>
<tr class="formTR">
   
  <?   
  
  
  ##form
  
  foreach($fields as $fld=>$alise)
  { 
       $extraAttr = $os->val($extra,$fld);  
	  
	   ?>
     <td><div class="wtalise<? echo $functionId?>"> <? echo $alise ?> </div>
	  
	 <? if($type[$fld]=='T' || $type[$fld]=='' || $type[$fld]=='D'){ ?> 
	 
	 
	 <input type="text" value="" id="<? echo $functionId.$fld ?>" name="<? echo $fld ?>" class="<? echo $class[$fld] ?>" placeholder="<? echo $alise ?> " <? echo $extraAttr ?> />
	  
	  
	  <? }
	  else if($type[$fld]=='DD')
	  {
	$os->ddDataType=array();
	  if($relation[$fld]!='')
	  {
	    
	   if( substr($relation[$fld],0,6)=='select' )
	      {
		     $qq=explode('-fld-',$relation[$fld]);
			 
			 $valueList='';
		      $qq[0]= $os->mq($qq[0]);
			 
			  while( $out=$os->mfa($qq[0]))
			   {
			     
						# multiple value in 
						$valueList='';
						$valF=explode(',',$qq[2]);
						foreach($valF as $fieldn)
						{
						$valueList=$valueList.$out[trim($fieldn)]." ";
						
						}
						 $os->ddDataType[$out[$qq[1]]]=$valueList;
				        
				 
				 
				 
				// $os->ddDataType[$out[$qq[1]]]=$out[$qq[2]];
			   
			   }
	         
	        
	        
			} else
			{
			   $os->ddDataType=$os->{$relation[$fld]} ;
			
			}   
	 
	  
	  }
	  
	  
	  
	  
	   ?> 
	 <select  id="<? echo $functionId.$fld ?>" name="<? echo $fld ?>" class="<? echo $class[$fld] ?>" <? echo $extraAttr ?>> 
	 <?  $os->onlyOption($os->ddDataType); ?>
	 
	 </select>
	 <?  } 
	 else if($type[$fld]=='AC')
	  {
	$os->ddDataType=array();
	  if($relation[$fld]!='')
	  {
	    
	   if( substr($relation[$fld],0,6)=='select' )
	      {
		     $qq=explode('-fld-',$relation[$fld]);
			 
		      /*$qq[0]= $os->mq($qq[0]);
			  while( $out=$os->mfa($qq[0]))
			   {
			     $os->ddDataType[$out[$qq[1]]]=$out[$qq[2]];
			   
			   }*/
			   
			   $valueList='';
		      $qq[0]= $os->mq($qq[0]);
			  while( $out=$os->mfa($qq[0]))
			   {
			   
			   
			   # multiple value in 
						$valueList='';
						$valF=explode(',',$qq[2]);
						foreach($valF as $fieldn)
						{
						$valueList=$valueList.$out[trim($fieldn)]." ";
						
						}
			    $os->ddDataType[$out[$qq[1]]]=$valueList;
			   
			    // $os->ddDataType[$out[$qq[1]]]=$out[$qq[2]];
			   }
			    
			   
			   
			   
	   
	        
	        
			} else
			{
			   $os->ddDataType=$os->{$relation[$fld]} ;
			
			}   
	 
	  
	  }
	  
	  
	  $classAC='autoComp'.$fld;
	  
	   ?> 
	 
	    <input type="text" value="" id="<? echo $functionId.$fld ?>" name="<? echo $fld ?>" class="<? echo $class[$fld] ?> <? echo $classAC?>" <? echo $extraAttr ?> />
	  
	 <? 
	 if(is_array($os->ddDataType)){
	 
	 $acString=implode('##',$os->ddDataType);
	 $fldACStr .=$classAC.'-CLASSSTR-'.$acString.'-MULTIPLEAC-';
	// echo $fldACStr;
	 }
	    
	 
	 // $os->onlyOption($os->ddDataType); ?>
	 
	 
	 <?  } ?>
	 
	 </td>
  
  <? 
   
  
  
  }
  ?>
  <td> 
  
 <?  if($add){ ?>
  <input type="button" class="qaddButton" value="Add" title="Add new record"  onclick="<? echo $ajaxEditFunction ?>('<? echo $foreignIdValue ?>');" />
 <? } ?>
  
  </td>
   </tr> </table>


<? 

 
echo '-DATAFORM--AUTOCOMPLETE-'.$fldACStr.'-AUTOCOMPLETE--CALLBACKOUTPUT-'; //  auto complete within auto complete 
 // next  phpCallback followed by  javascript call back 
 $phpCallback=$afterSaveCallback['php'];
 if($phpCallback && $phpCallback!='')
 {
   $os->$phpCallback($options,$foreignIdValue); // you must define callback function in os  Callback($options,$foreignIdValue)
 }
 
echo  '-CALLBACKOUTPUT-';

}



if($os->get('getQuickEditValues')=='OK') 
{
    
	
	
	$aQEsessonKey=$os->get('aQEsessonKey');
	$options=$_SESSION[$aQEsessonKey];
	 $foreignIdValue=$os->get('foreignIdValue');
	 
	 if($foreignIdValue>0) /////   5555555
	{
	extract($options);
	##   code starts
	

	
	
	
 foreach($fields as $fld=>$alise)
  {
      $dataForSave[$fld]=$_GET[$fld];
	   if($type[$fld]=='D')##  view date need date format
	  {  
	     $dataForSave[$fld]=$os->saveDate($_GET[$fld]);
	  }
	
  
  
  }
  
  if(is_array($defaultValues) && count($defaultValues)>0){
  foreach($defaultValues as $fld=>$val)
  {
      $dataForSave[$fld]=$val;
	     
  }}
   
  
  
  if($foreignIdValue>0){
  
  $dataForSave[$foreignId]=$foreignIdValue;
  }
  
	// $dataForSave['addedBy']=$os->userDetails['adminId'];  jojo
	$dataForSave['addedDate']=date("Y-m-d h:i:s");
	$os->save($table,$dataForSave);
	
	
	##   view data
	
	viewQuickRows($options,$foreignIdValue);
	 
	
	}
	 
	
	exit();
}

if($os->get('getQuickViewValues')=='OK')
{
  
	
	$aQEsessonKey=$os->get('aQEsessonKey');
	$options=$_SESSION[$aQEsessonKey];
	$foreignIdValue=$os->get('foreignIdValue');
	
	
	 if($foreignIdValue>0)  
	{
 
	##   code start
	
	##   view datas
   viewQuickRows($options,$foreignIdValue);
	
	
	
	}
	
	exit();
}


if($os->get('getQuickDeleteValues')=='OK')
{
  
	
	$aQEsessonKey=$os->get('aQEsessonKey');
	$options=$_SESSION[$aQEsessonKey];
	$foreignIdValue=$os->get('foreignIdValue');
	$tableIdVal=$os->get('tableId');
	$table=$options['table'];
	$tableId=$options['tableId'];
	
	$tableQuery="delete from $table where  $tableId='$tableIdVal' ";
	$rs=$os->mq($tableQuery);
	viewQuickRows($options,$foreignIdValue);
	exit();
}