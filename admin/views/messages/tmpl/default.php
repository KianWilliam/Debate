<?php

/*
 * @package component debate for Joomla! 3.x
 * @version $Id: com_debate 1.0.0 2018-10-13 23:26:33Z $
 * @author Kian William Nowrouzian
 * @copyright (C) 2017- Kian William Nowrouzian
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 
 This file is part of debate.
    debate is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    debate is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with debate.  If not, see <http://www.gnu.org/licenses/>. 
*/

?>
<?php


defined('_JEXEC') or die('Restricted access'); 
use Joomla\CMS\Factory; 
use Joomla\CMS\HTML\HTMLHelper; 
use Joomla\CMS\MVC\BaseModel;
use Joomla\CMS\Router\Route;
use Joomla\CMS\language\Text; 
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Table\Table;
HTMLHelper::_('behavior.tooltip');
HTMLHelper::_('behavior.modal');
HTMLHelper::_('formbehavior.chosen', 'select');  




//jimport('joomla.application.component.model'); 
 //JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_categories/models');
  BaseDatabaseModel::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_categories/models');

 Table::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_categories/tables');

 $mymodel = BaseDatabaseModel::getInstance('Category','CategoriesModel');
		
$user = Factory::getUser();
$userId = $user->get('id');

$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$this->sid	= $this->state->get('filter.id');
$this->stitle	= $this->state->get('filter.title');
$this->sfonderid	= $this->state->get('filter.fonderid');
$this->suserid	= $this->state->get('filter.userid');
$this->sthreadid	= $this->state->get('filter.threadid');
$this->scatid	= $this->state->get('filter.catid');
$this->screated	= $this->state->get('filter.created');



$canOrder = true; 
$saveOrder = $listOrder == 'a.ordering';
$jinput = Factory::getApplication()->input;

if(!empty($jinput->post->getArray())):
   $data = $jinput->post->getArray();
   
  // if(!empty($data)){
    //   $editform = $data['jform']['formid'];
   //}
   // better to do all these in model or main controller;
   
   if(!empty($data['jform']['edittype']) ):
   
   $userid = $data['jform']['userid'];
   $edittype = $data['jform']['edittype'];
   $reason = $data['jform']['reason'];
   $fonderid = $data['jform']['fonderid'];
   
   $messageid = $data['jform']['messageid'];
   $db = Factory::getDbo();
  
   switch($edittype):
   
   
	case "deprive";
	
		   $query = $db->getQuery(true);
           $query->select('*')->from($db->quoteName('#__debate_edit_users'))->where('messageid = '. $messageid);
		   $db->setQuery($query);
		   $result = $db->loadObject();		     
		   if(!empty($result)){
			   		   $query = $db->getQuery(true);
					   $query->delete()->from($db->quoteName('#__debate_edit_users'))->where('messageid = '. $messageid);
					   $db->setQuery($query);
					   $db->execute();
		   }
		    $query = $db->getQuery(true);
           $query->select('*')->from($db->quoteName('#__debate_badpost_users'))->where('messageid = '. $messageid);
		   $db->setQuery($query);
		   $result = $db->loadObject();		     
		   if(!empty($result)){
			   		   $query = $db->getQuery(true);
					   $query->delete()->from($db->quoteName('#__debate_badpost_users'))->where('messageid = '. $messageid);
					   $db->setQuery($query);
					   $db->execute();
		   }
		   //if user-admin accidently clicked reload button of browser or re-edit the same reocrd.
		    $query = $db->getQuery(true);
           $query->select('*')->from($db->quoteName('#__debate_deprive_users'))->where('messageid = '. $messageid);
		   $db->setQuery($query);
		   $result = $db->loadObject();	
		   	if(!empty($result)){
				 $query = $db->getQuery(true);
					   $query->delete()->from($db->quoteName('#__debate_deprive_users'))->where('messageid = '. $messageid);
					   $db->setQuery($query);
					   $db->execute();
					   $result=null;
			}


	if(empty($result)):
	   $query = $db->getQuery(true);
            $columns = array('userid',  'reason', 'deprivedate', 'messageid', 'fonderid');
            $values = array( $db->quote($userid),  $db->quote($reason),   $db->quote(Date('Y-m-d')), $db->quote($messageid), $db->quote($fonderid));
            $query
            ->insert($db->quoteName('#__debate_deprive_users'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
            $db->setQuery($query);
            $db->execute();
			
			 $query = $db->getQuery(true);
            $columns = array('userid',  'reason', 'deprivedate', 'messageid', 'fonderid');
            $values = array( $db->quote($userid),  $db->quote($reason),  $db->quote(Date('Y-m-d')), $db->quote($messageid), $db->quote($fonderid));
            $query
            ->insert($db->quoteName('#__debate_deprive_list'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
            $db->setQuery($query);
            $db->execute();
		endif;
	
	break;
	
	case "edit";
	
	
	 $query = $db->getQuery(true);
           $query->select('*')->from($db->quoteName('#__debate_badpost_users'))->where('messageid = '. $messageid);
		   $db->setQuery($query);
		   $result = $db->loadObject();		     
		   if(!empty($result)){
			   		   $query = $db->getQuery(true);
					   $query->delete()->from($db->quoteName('#__debate_badpost_users'))->where('messageid = '. $messageid);
					   $db->setQuery($query);
					   $db->execute();
		   }
		   
		    $query = $db->getQuery(true);
           $query->select('*')->from($db->quoteName('#__debate_deprive_users'))->where('messageid = '. $messageid);
		   $db->setQuery($query);
		   $result = $db->loadObject();		     
		   if(!empty($result)){
			   		   $query = $db->getQuery(true);
					   $query->delete()->from($db->quoteName('#__debate_deprive_users'))->where('messageid = '. $messageid);
					   $db->setQuery($query);
					   $db->execute();
		   }
		    $query = $db->getQuery(true);
           $query->select('*')->from($db->quoteName('#__debate_deprive_list'))->where('messageid = '. $messageid);
		   $db->setQuery($query);
		   $result = $db->loadObject();		     
		   if(!empty($result)){
			   		   $query = $db->getQuery(true);
					   $query->delete()->from($db->quoteName('#__debate_deprive_list'))->where('messageid = '. $messageid);
					   $db->setQuery($query);
					   $db->execute();
		   }
	 $query = $db->getQuery(true);
           $query->select('*')->from($db->quoteName('#__debate_edit_users'))->where('messageid = '. $messageid);
		   $db->setQuery($query);
		   $result = $db->loadObject();
		   if(!empty($result)){
		    $query = $db->getQuery(true);
					   $query->delete()->from($db->quoteName('#__debate_edit_users'))->where('messageid = '. $messageid);
					   $db->setQuery($query);
					   $db->execute();
					   $result=null;
		   }
		  
		   if(empty($result)):
		   
	    	  $query = $db->getQuery(true);
            $columns = array('userid',  'reason', 'editdate', 'messageid', 'fonderid');
            $values = array( $db->quote($userid),  $db->quote($reason),  $db->quote(Date('Y-m-d')), $db->quote($messageid), $db->quote($fonderid));
            $query
            ->insert($db->quoteName('#__debate_edit_users'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
            $db->setQuery($query);
            $db->execute();
			endif;
	
	break;
	
	case "bad";
	
	 $query = $db->getQuery(true);
           $query->select('*')->from($db->quoteName('#__debate_edit_users'))->where('messageid = '. $messageid);
		   $db->setQuery($query);
		   $result = $db->loadObject();		     
		   if(!empty($result)){
			   		   $query = $db->getQuery(true);
					   $query->delete()->from($db->quoteName('#__debate_edit_users'))->where('messageid = '. $messageid);
					   $db->setQuery($query);
					   $db->execute();
		   }
		   
		    $query = $db->getQuery(true);
           $query->select('*')->from($db->quoteName('#__debate_deprive_users'))->where('messageid = '. $messageid);
		   $db->setQuery($query);
		   $result = $db->loadObject();		     
		   if(!empty($result)){
			   		   $query = $db->getQuery(true);
					   $query->delete()->from($db->quoteName('#__debate_deprive_users'))->where('messageid = '. $messageid);
					   $db->setQuery($query);
					   $db->execute();
		   }
		    $query = $db->getQuery(true);
           $query->select('*')->from($db->quoteName('#__debate_deprive_list'))->where('messageid = '. $messageid);
		   $db->setQuery($query);
		   $result = $db->loadObject();		     
		   if(!empty($result)){
			   		   $query = $db->getQuery(true);
					   $query->delete()->from($db->quoteName('#__debate_deprive_list'))->where('messageid = '. $messageid);
					   $db->setQuery($query);
					   $db->execute();
		   }
		   
		    $query = $db->getQuery(true);
           $query->select('*')->from($db->quoteName('#__debate_badpost_users'))->where('messageid = '. $messageid);
		   $db->setQuery($query);
		   $result = $db->loadObject();	
		     if(!empty($result)){
		    $query = $db->getQuery(true);
					   $query->delete()->from($db->quoteName('#__debate_badpost_users'))->where('messageid = '. $messageid);
					   $db->setQuery($query);
					   $db->execute();
					   $result=null;
		   }
	
	if(empty($result)){
	  $query = $db->getQuery(true);
            $columns = array('userid',  'reason', 'baddate', 'messageid', 'fonderid');
            $values = array( $db->quote($userid), $db->quote($reason),  $db->quote(Date('Y-m-d')), $db->quote($messageid), $db->quote($fonderid));
            $query
            ->insert($db->quoteName('#__debate_badpost_users'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
            $db->setQuery($query);
            $db->execute();
			  $query = $db->getQuery(true);
              $query->select('*')->from($db->quoteName('#__debate_badpost_users'))->where('userid='.$db->quote($userid))->order('messageid DESC');
		      $db->setQuery($query);
			  $results = $db->loadObjectList();
			  if(count($results)>=3):
			 
				 $query = $db->getQuery(true);
                 $columns = array('userid',  'reason', 'deprivedate', 'messageid', 'fonderid');
            $values = array( $db->quote($results[0]->userid), $db->quote($results[0]->reason),   $db->quote(Date('Y-m-d')), $db->quote($results[0]->messageid), $db->quote($results[0]->fonderid));
            $query
            ->insert($db->quoteName('#__debate_deprive_users'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
            $db->setQuery($query);
            $db->execute();
			 $query = $db->getQuery(true);
                 $columns = array('userid',  'reason', 'deprivedate', 'messageid', 'fonderid');
            $values = array( $db->quote($results[0]->userid), $db->quote($results[0]->reason),   $db->quote(Date('Y-m-d')), $db->quote($results[0]->messageid), $db->quote($results[0]->fonderid));
            $query
            ->insert($db->quoteName('#__debate_deprive_list'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
            $db->setQuery($query);
            $db->execute();
						  $query = $db->getQuery(true);
						  $query->delete($db->quoteName('#__debate_badpost_users'))->where('userid = '.$db->quote($userid));
						   $db->setQuery($query);
                           $db->execute();

			
			  
			  endif;
	}

	
	break;
   
   endswitch;
   endif;

   endif;
   
   $document=Factory::getDocument();

?>
<script language="javascript" type="text/javascript">
function tableOrdering( order, dir, task )
{
	var form = document.adminForm;

	form.filter_order.value = order;
	form.filter_order_Dir.value = dir;
	document.adminForm.submit( task );
}
function confirmPost(task)
{
	var form = document.editform;
		var fidea = document.getElementById("fonderidea").value;
       

	  var radios = form.elements["jform[edittype]"];
	  
    console.log(radios);
    // loop through list of radio buttons
    for (var i=0, len=radios.length; i<len; i++) {
        if ( radios[i].checked ) { // radio checked?
            val = radios[i].value; // if so, hold its value in val
            break; // and break out of for loop
        }
    }
	  console.log(fidea + '-' + val);

	if(confirm("Are you sure to submit this record with new changes in title , body of the message or its type(badpost-deprive-edit)?") && fidea === val){
	document.editform.submit( task );
	return true;
	}
	else
	{
		alert("Form can not be submitted! what you select here as fonder idea about this message is different with fonder idea you input in message layout as:"+fidea);
		return false;
	}
}
Joomla.submitbutton = function(task)
	{
		
		if (task == 'messages.deleteMessages') {
			if(confirm("There are record(s) that might be the thread starter, once you delete those record(s), the whole thread(s) shall be unpublished!")){
					
					Joomla.submitform(task, document.getElementById('adminForm'));

                   return true;
			}
		}
			else
				if (task === 'message.edit' || task ==='messages.publish' || taks==='messages.unpublish' ) {
					console.log("you are very chossse!!!");
										Joomla.submitform(task, document.getElementById('adminForm'));

				}

			else
				return false;
		
		
	}
</script>

<form action="<?php echo Route::_('index.php?option=com_debate&view=messages'); ?>" method="post" name="adminForm" id="adminForm" style="">
<div id="j-sidebar-container" class="span2" >
		<?php echo $this->sidebar; ?>
	</div>
	<div class="span10" style='float:right;'>
	<div>
	<strong>Important Notice!</strong> Because of the mutual effects of actions between messages/message
	layouts with edited-messages, deprive-users, bad-users layouts and vice and versa, the search in here is designed for one record at a time
	for your own benefit not to make mistake!<strong> For instance in id field, you can not employ 12 AND 10 OR 9, you have to input just 12.</strong>
	The same for other fields.
	</div>
	<label style="font-weight:bold">Search factors:</label>
		<div>
			<input type="text" name="search_id" id="search_id" value="<?php echo $this->sid ?>" placeholder="id" title="<?php echo Text::_('Search in ids...'); ?>" />
			<input type="text" name="search_title" id="search_title" value="<?php echo $this->stitle ?>" placeholder="title" title="<?php echo Text::_('Search in titles...'); ?>" />
			<input type="text" name="search_userid" id="search_userid" value="<?php echo $this->suserid ?>" placeholder="userid" title="<?php echo Text::_('Search in userids...'); ?>" />
			<input type="text" name="search_catid" id="search_catid" value="<?php echo $this->scatid ?>" placeholder="catid" title="<?php echo Text::_('Search in catids...'); ?>" />
			<input type="text" name="search_threadid" id="search_threadid" value="<?php echo $this->sthreadid ?>" placeholder="threadid" title="<?php echo Text::_('Search in threadids...'); ?>" />
 			<input type="text" name="search_created" id="search_created" value="<?php echo $this->screated ?>" placeholder="YYYY-mm-dd" title="<?php echo Text::_('Search in dates...'); ?>" />

			<button type="submit">
				<?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?>
			</button>
			<button type="button" onclick="document.id('search_title').value='';document.id('search_userid').value='';document.id('search_catid').value='';document.id('search_threadid').value='';document.id('search_fonderid').value='';document.id('search_created').value='';this.form.submit();">
				<?php echo Text::_('JSEARCH_FILTER_CLEAR'); ?>
			</button>
		</div>
		<div>
			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value="">
					<?php echo Text::_('JOPTION_SELECT_PUBLISHED');?>
				</option>
				<?php
				//$default = 0;	
	             $p = array(0 => 'Not_Published', 1 => 'Published');	
	             $options = array();	
	             foreach($p as $key=>$value) :		
		                 $options[] = HTMLHelper::_('select.option', $key, $value);
	            endforeach;	
	            echo HTMLHelper::_('select.options', $options,  'value', 'text', $this->state->get('filter.published'), true);	
				?>
			</select>
		</div>
		
		
	
	</div>
	<div id="j-main-container" class="span10">
	
	<table class="table table-striped"  style="margin-left:15px;">
		<thead>
		    <tr>
                <th  align="left" style="width:1%">
                    <input type="checkbox" name="checkall-toggle" value="" onclick="Joomla.checkAll(this)" />
                </th>
                <th style="width:5%; text-align:center">
				
                    <?php echo HTMLHelper::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
				
                </th>
                								
                <th style="width:5%; text-align:center;">
				
                    <?php echo HTMLHelper::_('grid.sort', 'JPUBLISHED', 'a.published', $listDirn, $listOrder); ?>
					
					</th>
					<th style="width:1%;text-align:center; ">
				
					<?php echo HTMLHelper::_('grid.sort', 'Category Id', 'a.catid', $listDirn, $listOrder); ?>
					

                </th>
                <th style="width:9%; text-align:center;">
                    <?php echo HTMLHelper::_('grid.sort', 'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
                    <?php if ($canOrder && $saveOrder) : ?>
                        <?php echo HTMLHelper::_('grid.order', $this->items, 'filesave.png', 'items.saveorder'); ?>
                    <?php endif; ?>
                </th>
                <th style="width:1%">
                    <?php echo HTMLHelper::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                </th>
				<th style="width:9%;text-align:center;">
                    <div class="fonders">
					      <?php echo HTMLHelper::_('grid.sort', 'Fonder Ids', 'a.fonderid', $listDirn, $listOrder); ?>
					</div>
                </th>
				<th style="width:1%; text-align:center;">
                    <div class="threads">
					      <?php echo HTMLHelper::_('grid.sort', 'Thread Ids', 'a.threadid', $listDirn, $listOrder); ?>
					</div>
                </th>
            </tr>
	    </thead>
		<tfoot>
            <tr>
                <td colspan="10">
                     <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
		<tbody>
			<?php
                    $n = count($this->items);
                    foreach ($this->items as $i => $message) :
                        $ordering = ($listOrder == 'a.ordering');
                        $canCreate = true;
                        $canEdit = true;
                        $canCheckin = true;
                        $canEditOwn = true;
                        $canChange = true;
                        $messageID = $message->id;                        
                        $title = $this->escape($message->title);
						$categoryid = $message->catid;
						$row = $mymodel->getItem($categoryid);
            ?>
					<tr class="row<?php echo $i % 2; ?>">
							<td class="left">
                               <?php echo HTMLHelper::_('grid.id', $i, $messageID); ?>
                            </td>
							<td style="width:5%; text-align:center">
                                <a href="<?php echo Route::_('index.php?option=com_debate&task=message.edit&id='.(int) $message->id); ?>"><?php echo $title ?></a>
								<br />
								Category:<?php echo $row->title; ?>                               
                            </td>
							<td style="width:5%; text-align:center;">
                                <?php echo HTMLHelper::_('jgrid.published', $message->published, $i, 'messages.', true, 'cb'); ?>
                            </td>
							<td style="width:5%; text-align:center;">
                                <?php echo $categoryid; ?>
                            </td>
							<td class="order" style="text-align:center">
                               <?php if ($canChange) : ?>
                               <?php if ($saveOrder) : ?>
                                <?php if ($listDirn == 'asc') : ?>
                                    <span><?php echo $this->pagination->orderUpIcon($i, ($message->ordering == @$this->items[$i - 1]->ordering), 'messages.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                    <span><?php echo $this->pagination->orderDownIcon($i, $n, ($message->ordering == @$this->items[$i + 1]->ordering), 'messages.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                                <?php elseif ($listDirn == 'desc') : ?>
                                    <span><?php echo $this->pagination->orderUpIcon($i, ($message->ordering == @$this->items[$i - 1]->ordering), 'messages.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                    <span><?php echo $this->pagination->orderDownIcon($i, $n, ($message->ordering == @$this->items[$i + 1]->ordering), 'messages.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                                <?php endif; ?>
                               <?php endif; ?>
                               <?php $disabled = $saveOrder ? '' : 'disabled="disabled"'; ?>
                                <input  type="text" name="order[]" size="5" value="<?php echo $message->ordering; ?>" <?php echo $disabled ?> class="text-area-order" />
                             <?php else : ?>
                                <?php echo $message->ordering; ?>
                             <?php endif; ?>
                           </td>
						   <td align="center">
                              <?php echo $message->id; ?>
                           </td>
						    <td align="center"  style="text-align:center;">
                              <?php 
							  if(!empty($message->fonderid))
								  echo $message->fonderid."-".$message->fonderidea; 
							  else
									echo "This message is not edited at all.";
							  ?>
                           </td>
						    <td align="center" style="text-align:center;">
                              <?php echo $message->threadid; ?>
                           </td>
					</tr>
					<?php endforeach; ?>
	    </tbody>

	</table>
	</div>
	<div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
        <?php echo HTMLHelper::_('form.token'); ?>
    </div>
	

</form>

<?php 
$input = Factory::getApplication()->input;


		$fid= $input->get('fonderid');
		$uid= $input->get('userid');
		$mid= $input->get('messageid');
		$fidea = $input->get('fonderidea');
		
		
		
   if($fidea === "no" ){
	   
	   $db = Factory::getDbo();
	   
    $query = $db->getQuery(true);
					   $query->delete()->from($db->quoteName('#__debate_edit_users'))->where('messageid = '. $mid);
					   $db->setQuery($query);
					   $db->execute();
					    $query = $db->getQuery(true);
					   $query->delete()->from($db->quoteName('#__debate_badpost_users'))->where('messageid = '. $mid);
					   $db->setQuery($query);
					   $db->execute();
					    $query = $db->getQuery(true);
					   $query->delete()->from($db->quoteName('#__debate_deprive_users'))->where('messageid = '. $mid);
					   $db->setQuery($query);
					   $db->execute();
   
   }else
	  if(!empty($fid) && $fid!=='0' ){
		  
		  
?>	


<div id="myModal" class="modal " role="dialog" >

    <div class="modal-dialog">


    
    <div class="modal-header" style="font-size:1.2em; text-align:center;padding:5px;">

        <strong>Fill this form if you made any change to the original message sent by user and tell the reason or Simply CLOSE the modal. BE AWARE THAT
		THE OPTION YOU CHOOSE HERE (EDIT OR BAD OR DEPRIVE POST MUST BE THE SAME AS YOU TYPED IN USER MESSAGE AFTER CHANGE!) also each option
		has its own view backend. Delete action in those views shall be reflected in original record(s).</strong> <br />
		        <button id="closemodal" type="button" class="btn btn-default" data-dismiss="modal" >Close</button>

    </div>
    
    <div class="modal-body"> 
        
       
		 <form name="editform" action="index.php?option=com_debate&view=messages"  method="post" id="editform" class="editform " style="margin-left:10px;">
		 <label>The fonder idea you considered while editing the message:</label><input id="fonderidea" name="fonderidea" type="text" value="<?php echo $fidea ;?>" readonly />
		 <div class="radio">
		          <label><input type="radio" name="jform[edittype]"  value="edit"  checked  />Edit POST</label>
				  <label><input type="radio" name="jform[edittype]"   value="bad"    />Bad Post</label>
				  <label><input type="radio" name="jform[edittype]"   value="deprive"    />Deprive Post</label>
		 </div>

		
		<div class="form-group" ><label  for="reason">Reason</label>
		<textarea id="reason" autocomplete="adieux" class="form-control" name="jform[reason]"  required="true" style="width:50%;height:121px;" >
		</textarea>
		</div>
				
		    <input type="button" id="submitform" name="jform[submit]"   value="Submit" onclick="confirmPost('messages.default')" /> 	
		    <input type="reset" id="resetform" name="jform[reset]"   value="Reset" />			
		 
	      <input type="hidden" name="jform[userid]" value="<?php echo $uid ?>" />
		  <input type="hidden" name="jform[fonderid]" value="<?php echo $fid ?>" /> 
		  <input type="hidden" name="jform[messageid]"  value="<?php echo $mid ?>" />	
		  <input type="hidden" name="jform[task]" value="" />
           
		  
		 </form>
        
    </div>
    
    <div class="modal-footer">
	        

    </div>
    </div>
	</div>
	<?php

	}
	
	$closebutt = "
	jQuery(document).ready(function(){
		jQuery('#closemodal').click(function(){
		    
		    		 	if(confirm('You are closing modal box while you have changed some fields in record No.". $jinput->get('messageid')." if you close, you will have to go to that record and return back changes you made!'))

       			jQuery('#myModal').css('display', 'none');
		});
	
	});
	";
	$doc = Factory::getDocument();
	$doc->addScriptDeclaration($closebutt);
