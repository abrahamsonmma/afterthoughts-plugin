<?php
/**
 * @copyright St. Edward's University Library 2013
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package Afterthoughts
 */

/**
 * Controller for Afterthoughts admin pages.
 *
 * @package Afterthoughts
 */
class NotFoundException extends Exception{};

class MultiException extends Exception{};

class Afterthoughts_IndexController extends Omeka_Controller_AbstractActionController
{
    /**
     * Front admin page.
     */
    public function indexAction() {}

	/**
	 * Primary functions of Afterthoughts.
	 * Gets data from index and tries to add
	 * fields to elementsText.
	 */
	public function editAction()  {
		
		//get filenames
		$files = $_POST['afterthoughts-files'];
		if (!$files){
			$message = $this->_helper->flashMessenger('Please enter filenames.');
			$this->_helper->redirector('index');
		}
		
		//create array of filenames
		$filenames=explode("\r",$files);
		
		//explode adds a space to the beginning of each name, so trim it off
		array_walk($filenames, 'trim_value');

		//get html, elementid, and textinput, since they won't change per item
		$html = $_POST['afterthoughts-html'];
		$elementid = $_POST['afterthoughts-element-id'];
		$textinput = $_POST['afterthoughts-element-text'];
		$fileNotFound = array();
		$multiFile = array();
		$successMessage = ' ';
		$errorMessage = ' ';
		
		if (!$elementid){
			$message = $this->_helper->flashMessenger('Please select an element.');
			$this->_helper->redirector('index');
		}
		
		if (!$textinput){
			$message = $this->_helper->flashMessenger('Please enter data into the metadata field.');
			$this->_helper->redirector('index');
		}
		
		//loop through filenames and insert data into ElementText
		for($i=0;$i<count($filenames);$i++) {
			
			try {
				//retrieve current filename
				$filename = $filenames[$i];
				
				//attempt to find the file and create item
				$records = 
				get_db()->getTable('File')->findBy(array('original_filename'=>$filenames[$i]));
				
				if (empty($records)){
					throw new NotFoundException();
					}
				if ($records[1]){
					throw new MultiException();
					}
						
				//get item_id from File table
				$id = $records[0]['item_id'];
				
				//check for existing data (Need to add options to catch existing data fields)
				$elements = get_db()->getTable('ElementText')->findBy(array('item_id'=>$id));
				
				//build array of data
				$data = array('record_id' => $id, 'record_type' => 'item', 'element_id' => $elementid, 'html' => $html, 'text' => $textinput);
				
					//insert data into ElementText table
					if ($data){
					get_db()->insert('ElementText',$data);
					}
					$successMessage = $successMessage.$filenames[$i]." updated successfully!\r\n";
				}
			
			catch (NotFoundException $e){
				$fileNotFound [] = $filenames[$i];
				}
			
			catch (MultiException $e){
				$multiFile[] = $filenames[$i];
				}
			
			catch (Exception $e){
				$message = $this->_helper->flashMessenger($e->getMessage());
				$this->_helper->redirector('index');
				}
			
			//make absolutely sure it's cleared out of memory
			unset($records);
			
		}
		
		
		if (!empty($fileNotFound)){
			$message = 'File not found for ';
			foreach ($fileNotFound as $file){
				$errorMessage = $errorMessage.$message.$file.".\r\n";
			}
		}
		
		if (!empty($multiFile)){
			$message = 'Multiple files found for ';
			foreach ($multiFile as $file){
				$errorMessage = $errorMessage.$message.$file.".\r\n";
			}
		}
		
		$finalMessage = $successMessage.' '.$errorMessage;
		$message = $this->_helper->flashMessenger($finalMessage);
		$this->_helper->redirector('index');
	}
}

/**
 * Function to trim values of array.
 */
function trim_value(&$value) 
{ 
    $value = trim($value); 
}