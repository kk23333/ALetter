<?php
/*
 * */
error_reporting(E_ALL);
header("Content-Type: text/html; charset=UTF-8");
include_once '../mysqli/opDB.class.php';
set_include_path(get_include_path() . PATH_SEPARATOR . '../');
include 'PHPExcel/IOFactory.php';
date_default_timezone_set('Asia/shanghai');
$inputFileType = 'Excel5';
$inputFileName = '../excel.xls';
$sheetname = 'Data Sheet #1';



/**  Define a Read Filter class implementing PHPExcel_Reader_IReadFilter  */
class chunkReadFilter implements PHPExcel_Reader_IReadFilter
{
	private $_startRow = 0;

	private $_endRow = 0;

	/**  Set the list of rows that we want to read  */
	public function setRows($startRow, $chunkSize) {
		$this->_startRow	= $startRow;
		$this->_endRow		= $startRow + $chunkSize;
	}

	public function readCell($column, $row, $worksheetName = '') {
		//  Only read the heading row, and the rows that are configured in $this->_startRow and $this->_endRow
		if (($row == 1) || ($row >= $this->_startRow && $row < $this->_endRow)) {
			return true;
		}
		return false;
	}
}

/**  Create a new Reader of the type defined in $inputFileType  **/
$objReader = PHPExcel_IOFactory::createReader($inputFileType);

/**  Define how many rows we want to read for each "chunk"  **/
$chunkSize = 100;
/**  Create a new Instance of our Read Filter  **/
$chunkFilter = new chunkReadFilter();

/**  Tell the Reader that we want to use the Read Filter that we've Instantiated  **/
$objReader->setReadFilter($chunkFilter);

/**  Loop to read our worksheet in "chunk size" blocks  **/
for ($startRow = 2; $startRow <= 200; $startRow += $chunkSize) {
	/**  Tell the Read Filter, the limits on which rows we want to read this iteration  **/
	$chunkFilter->setRows($startRow,$chunkSize);
	/**  Load only the rows that match our filter from $inputFileName to a PHPExcel Object  **/
	$objPHPExcel = $objReader->load($inputFileName);

	//	Do some processing here
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$row_index = 0;
	foreach($objWorksheet->getRowIterator() as $row){
		if($row_index != 0){
			$cellIterator = $row->getCellIterator();
		    $cellIterator->setIterateOnlyExistingCells(false);
			$cell_index = 0;
			foreach($cellIterator as $cell){
				if(empty($cell->getValue())){
					break;
				}else{
					echo $cell->getValue()."  ";
					$cell_index++;
				}
		    }
		}
		$row_index++;
		echo "<br> <br>";
	}
	echo '<br /><br />';
}


?>