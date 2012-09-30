<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Bookmark presenter to simplify views.
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file bookmark_presenter.php
 */

require_once(APPPATH . 'presenters/presenter.php');

class Bookmark_presenter extends Presenter
{
	// --------------------------------------------------------------------------
	
	/**
	 * easiest way to check whether it's an add or edit form.
	 * 
	 * @access public
	 * @return string
	 */
	public function title()
	{
		if (!$this->bookmark)
		{
			return 'Add Bookymark';
		}
		else
		{
			return 'Edit Bookymark';
		}
	}
	// --------------------------------------------------------------------------
	
	/**
	 * show a table of bookmarks.
	 * 
	 * @access public
	 * @return string
	 */
	public function table()
	{
		if (!$this->bookmark)
		{
			return '<div class="alert alert-danger">No bookmarks found. Add one!</div><!--alert-->';
		}
		else
		{
			$return = '<table class="table table-striped table-hover"><thead><th>URL</th><th>Description</th></thead><tbody>';
			// return '<pre>' . print_r($this->bookmark, TRUE) . '</pre>';
			foreach($this->bookmark as $item)
			{
				$return .= '<tr><td>' . $item->url . '</td>';
				$return .= '<td>' . $item->description . '</td>';
				$return .= '<td><div class="actions_wrap">
				<div class="btn-group">
  <a class="btn btn-mini btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
    <i class="icon-cog icon-white"></i>
    <span class="caret"></span>
  </a>
  <ul class="dropdown-menu">
    <li><a href="'.base_url().'bookmarks/edit/' . $item->id . '">Edit</a></li>
    <li><a href="'.base_url().'bookmarks/delete/' . $item->id . '">Delete</a></li>
  </ul>
</div><!--dropdown-menu-->
				</div><!--actions--></td></tr>';
			}
			$return .= '</tbody></table>';
			return $return;
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * display the url form field.
	 * 
	 * @access public
	 * @return string
	 */
	public function url_field()
	{
		$return = '';
		
		// form value
		if (set_value('url') != '') {$value = set_value('url');}
		else {$value = ($this->bookmark ? $this->bookmark->url : '');}
		
		$return .= '<div class="control-group form_item ' . (form_error('url') != '' ? 'error' : '') . '">'
		. form_label('URL: *', 'url_field', array('class' => 'control-label'))
		. '<div class="controls">'
		. form_input(array('name' => 'url', 'id' => 'url_field', 'class' => 'span3', 'value' => $value))
		. form_error('url')
		. '</div><!--controls-->
		</div><!--control-group-->';
		return $return;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * display the description form field.
	 * 
	 * @access public
	 * @return string
	 */
	public function description_field()
	{
		$return = '';
		
		// form value
		$value = set_value('description', ($this->bookmark ? $this->bookmark->description : ''));
		// if (set_value('description') != false) {$value = set_value('description');}
		// else {$value = (isset($this->bookmark) ? $this->bookmark->description : '');}
		
		$return .= '<div class="control-group form_item ' . (form_error('description') != '' ? 'error' : '') . '">'
		. form_label('Description: *', 'description_field', array('class' => 'control-label'))
		. '<div class="controls">'
		. form_input(array('name' => 'description', 'id' => 'description_field', 'class' => 'span3', 'value' => $value))
		. form_error('description')
		. '</div><!--controls-->
		</div><!--control-group-->';
		return $return;
	}
	
	// --------------------------------------------------------------------------
}
/* End of file bookmark_presenter.php */
/* Location: ./application/presenters/bookmark_presenter.php */