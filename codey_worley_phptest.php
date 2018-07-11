<?php

// Codey Worley - fake commit - 7/10/18 7:22PM -m "init"

// This class should be usable to generate html for dynamic data arrays.
class dataTable {
	private $data = array(
		array('name'=>'Blaine Jones','state'=>'AZ','company'=>'Media Solutions',
			'phone'=>array(
				'cell'=>'4805550001',
				'office'=>'4806391200'
			),
			'email'=>array(
				'primary'=>'bjones@mediasolutionscorp.com',
				'me@there.com'
			)
		),
		array('name'=>'Joe Smith','city'=>'Phoenix','phone'=>'4805551111','email'=>'jsmith@some_email.com'),
		array('name'=>'John Doe','city'=>'Chandler','company'=>'Doe Co.','email'=>array('jdoe@gmail.com','personal'=>'email@email.com'),'phone'=>'6025550002')
	);

  // Pre determined heads for data table
  private $dataHeads = array("name" => "&nbsp;", "company" => "&nbsp;", "city" => "&nbsp;", "state" => "&nbsp;", "email" => "&nbsp;", "phone" => "&nbsp;");

  // Fix data format recursively
  private function formatData($array) {

    foreach($array as $field => $value) {

      if(is_array($value)) {
        // Recursive loop to save 2nd level changes
        $array[$field] = $this->formatData($value);

      } else {
        // Only format phone numbers
        if(is_numeric($value)) {
          $value = substr_replace($value, '(', 0, 0);
    			$value = substr_replace($value, ')', 4, 0);
    			$value = substr_replace($value, ' ', 5, 0);
    			$value = substr_replace($value, '-', 9, 0);
    			$array[$field] = $value;
        }
        // ******* add extra if's for any needed data changes in the future ********
      }
    }
    return $array;
  }

  // Print html
	function formatTable()	{

    // Get table data
    $tableData = $this->data;
    $tableHeads = $this->dataHeads;

		// Create table
		echo '<table border="1" cellspacing="0" cellpadding="5">' . "\n\n";

		// Create table heads
		echo '<tr>' . "\n";
		foreach($tableHeads as $field => $value) {
			echo '<th>'.strtoupper($field).'</th>' . "\n";
		}
		echo '</tr>' . "\n\n";

		// Iterate through client list
		foreach($tableData as $client) {

			// Fix empty fields to show &nbsp;
			$result = array_merge($tableHeads, $client);

      // Fix phone format (111) 111-1111 ******** change this note if you add more data changes in function ********
      $result = $this->formatData($result, false);

			// Create table row
			echo '<tr>' . "\n";
			foreach($result as $field => $value) {

				// Parse 2nd level fields
				if(is_array($value)) {

					// Create 2nd level column
					echo '<td valign="top" class="'.$field.'">' . "\n";

					// Insert multiple fields into col
					foreach($value as $field => $value) {
						if(is_string($field)) {
							echo '<strong>'.$field.':</strong> '.$value.'<br/>' . "\n";
						} else {
							echo $value . '<br/>' . "\n";
						}
					}

					// end 2nd level column
					echo '</td>' . "\n";

				} else {
					// Create column
					echo '<td valign="top" class="'.$field.'">'.$value.'</td>' . "\n";
				}
			}
			// end row
			echo '</tr>' . "\n\n";
		}
		// end table
		echo '</table>' . "\n";
	}
}

$dataTable = new dataTable();

$dataTable->formatTable();

?>
