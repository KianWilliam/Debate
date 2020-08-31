<?php 
/*
 * @package component debate for Joomla! 3.x
 * @version $Id: com_debate 1.0.0 2020-01-13 23:26:33Z $
 * @author Kian William Nowrouzian
 * @copyright (C) 2019- Kian William Nowrouzian
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

 defined('_JEXEC') or die;
  use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
   HtmlHelper::_('jquery.framework');
HtmlHelper::_('behavior.formvalidator');
HtmlHelper::_('behavior.core');
		
	

 BaseDatabaseModel::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_debate/models');
 Table::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_debate/tables');
 $mymodel = BaseDatabaseModel::getInstance('Config','DebateModel');
 $row = $mymodel->getItem(1);
 
 					 
   $myrules = BaseDatabaseModel::getInstance('Rules','DebateModel');
   $rules = $myrules->getItems();
   $activerules = end($rules);

 $app = Factory::getApplication();
 $doc = Factory::getDocument();
 
 
 
  
 //use empty condition to avoid notice messages
 //if form is not validated, and return back to response layout, form value must be set with post data.
 $post = [];
 
   
 if(!empty($app->input->get('catid')))
   $catid = $app->input->get('catid');

if(!empty($app->input->get('firstid')))
   $firstid = $app->input->get('firstid');
else
	$firstid=null;



    if(!empty( $catid)){

	
			$this->form->setValue('catid', '', $catid);

	}
	
		
	    if(!empty( $app->input->get('threadid'))|| $app->input->get('threadid')==0)

           $threadid = $app->input->get('threadid');
	       
							$this->form->setValue('threadid', '', $threadid);


	

        if(!empty($app->input->get('title'))){	
		//assigning title to post array even when it is not in a form 
		   $title = $app->input->get('title', array(), 'post', array());
		
		
		
					$this->form->setValue('title', '', $title);

		}
		
		//for edit the message
		if(!empty($app->input->get('id')) && $app->input->get('id')!=0)
		{
			$messid = $app->input->get('id');
					$db = Factory::getDbo();
	$query = $db->getQuery('true');
	$query->select('*')->from($db->quoteName('#__debate'))->where('id = ' . $messid);
	$db->setQuery($query);
	$result = $db->loadObject();
	
	$this->form->setValue('message', '', $result->message);
	

	$id=$app->input->get('id');
	}
		else
			$id=0;
	
	
			$this->form->setValue('id', '', $id);

	
		if(!empty($app->input->get('firstid')) && $app->input->get('firstid')!==0)
		{
			$readonly = "
				jQuery('#adminForm #jform_title').prop('readonly', true);
			";
	        echo "<script> jQuery(document).ready(function(){jQuery('#jform_title').prop('readonly', true);}); jQuery(document).ready(function(){jQuery('#jform_title').attr('flag', '1');});  </script>";


		}
	

        $user = Factory::getUser();
	
 if(trim($row->forumoffline)=='No'):
 if(!empty($user->id)): 

	?>
	<style type="text/css">
 .debater button
 {
	 background-color: <?php echo $row->buttbakcolor ?>;
	 font-family: <?php echo $row->fontfamily; ?>;
	 color:#fff;
	 text-align:center;
	 padding:5px;
 }
	.adminform .span6:first-of-type
	{
		width:100%;
	}
	.roi a:link, .roi a:visited
	{
		 font-weight:  <?php echo $row->textfontweight; ?>;
	 font-style:  <?php echo $row->textfontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->textfontsize; ?>;
	}
	.debater label
	{
		  color : <?php echo $row->textcolor; ?>;
		  font-weight:  <?php echo $row->textfontweight; ?>;
	 font-style:  <?php echo $row->textfontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->textfontsize; ?>;
	}
	.mtitle
	{
		 color : <?php echo $row->titlecolor; ?>;
	 font-weight:  <?php echo $row->titlefontweight; ?>;
	 font-style:  <?php echo $row->titlefontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->titlefontsize; ?>;
	}
	.contentpane ,.contentpane iframe
	{
		border-radius:<?php echo $row->frameborderradius; ?>;
	}
	.forumainp a:link, .forumainp a:visited
 {
	  
		  font-weight:  <?php echo $row->textfontweight; ?>;
	 font-style:  <?php echo $row->textfontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->textfontsize; ?>;
 }
	</style>
	<div class="roi">
	<?php if($firstid==0 || $firstid===null):?>
	
			<a href="<?php echo Route::_('index.php?option=com_debate&view=category&id='.$catid); ?>">Return To Category</a>
	<?php else: ?>
			<a href="<?php echo Route::_('index.php?option=com_debate&view=message&id='.$firstid.'&catid='.$catid); ?>">Return to main message</a>
			
	<?php endif; ?>
	</div>
	<div class="maincontainer" style="float:left">
	<form action="<?php echo Route::_('index.php?option=com_debate&view=response&id='.$id.'&catid='.$catid); ?>" method="post" name="adminForm" id="adminForm" class="debater form-validate" enctype="multipart/form-data">
	
	<div class="form-horizontal">
		<fieldset class="adminform">
			<legend><?php
				if(!empty($title))
					echo "<div class='mtitle'>".$title."</div>";
				else
					echo "<div class='mtitle'>Your Message</div>";
			?></legend>
			<div class="row-fluid">
				<div class="span6">
					<?php echo $this->form->renderFieldset('details');  ?>
				</div>
			</div>
			
		</fieldset>
	</div>
    
	<div class="btn-toolbar">
		<div class="btn-group">
			<button type="button" class="btn btn-primary validate" onclick="Joomla.submitbutton('response.save')">
				<span class="icon-ok"></span><?php echo Text::_('JSUBMIT') ?>
			</button>
		</div>
		<div class="btn-group">
			<button type="button" class="btn" onclick="Joomla.submitbutton('response.cancel')">
				<span class="icon-cancel"></span><?php echo Text::_('JCANCEL') ?>
			</button>
		</div>
	</div>
    	
    <input type="hidden" name="jform[firstid]" value="<?php echo $firstid ?>"  />
	<input type="hidden" name="task" />
	<?php echo HTMLHelper::_('form.token'); ?>
    
	</form>
	<?php if($threadid!=0) :?>
	<div class="contentpane">
	<?php 
	    if(trim($row->showhistory)==='Yes'):

	    echo '<iframe id="blockrandom" name="iframe" src="index.php?option=com_debate&view=message&id='.$firstid.'&catid='.$catid.'" width="100%" height="299px" scrolling="auto" frameborder="1" title="Exchanged Messages" class="wrapper">
		This option will not work correctly. Unfortunately, your browser does not support inline frames.	</iframe>';
		
		endif;
		?>
    </div>
	<?php endif; ?>
	</div>
		<?php else: ?>
		<div>You have to login first</div>
		<?php endif;
 if(trim($row->publishrules)==='Yes'):
 
 ?>
 
 <?php
 else:
		echo "<div class='login'>You have to login first!</div>";

 endif;
 
		
else:
	echo "<div class='offline'>".$row->offlinemessage."</div>";
endif;
		
		?>
<div class='forumainp'>
	 <a href="<?php echo Route::_('index.php?option=com_debate&view=categories'); ?>">Forum Main Page</a>
</div> 
<div class="kianwilliam">This extension has been developed by <a href="https://kwproductions121.com">KWProdcutions.Co</a> &copy; Copyright Reserved.</div>


<?php
echo "<script src='".Uri::Base()."administrator/components/com_debate/models/debate.js'></script>";
echo "<script src='".Uri::Base()."components/com_debate/views/response/submitbutton.js'></script>";
$baseurl = Uri::Base();

$checktitle="
var isValid = true;
jQuery(document).ready(function(){
	jQuery('#jform_title').on('blur', function(){
			if(jQuery('#jform_title').attr('flag')!=1){

		 var token='victory';
						 var t = jQuery('#jform_title').val();
						 console.log('title:'+t);
						  jQuery.ajax({
							  type:'POST',
							  url:'".$baseurl."index.php',
							  data:{option:'com_debate', view:'chtitle', format:'json', title:t},
        success: function(result, status, xhr) {console.log('result'+result); var counter = 0;for(var i=0; i<result.length; i++){ if(result[i]==':'){counter++;console.log(result[i+2]+'counter:'+counter);}if( counter==4 && result[i]==':' && result[i+2]!=='t'){alert('Title exists, change it!');isValid=false; break;}else{isValid=true;}} console.log('isvalid'+isValid)},
        error: function() { console.log('ajax call failed'); }
    });
	
			}
	})
});
";
$doc->addScriptDeclaration($checktitle);



		


			
				
		
	
	
	



