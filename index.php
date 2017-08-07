<?php
	require_once( 'inc_connect.php' );

	// Get the topics, turn them into a multidimensional array
	// We'll use this array more than once
	$query = "SELECT * FROM topics ORDER BY topic_name ASC";
	$result = mysql_query( $query ) or die ( mysql_error() );

	while ( $row = mysql_fetch_assoc( $result ) ) {
		$topics[] = array(
			'id'  => $row[ 'id' ],
			'name' => ucwords( $row[ 'topic_name' ] ),
			'primary' => $row[ 'primary' ]
		);
	}

?>
<?php include_once( './template/inc_header.php' );?>


			<form action="results.php" method="POST">
				<div>
					<h3>Perspective:</h3>

					<select name="category">
						<option>-- Select --</option>

						<?php
							$query = "SELECT *
												FROM categories
												ORDER BY cat_name ASC";
							$result = mysql_query( $query ) or die ( mysql_error() );

							while ( $row = mysql_fetch_assoc( $result ) ) {
								echo '<option value="'.$row[ 'id' ].'">'.ucwords( $row[ 'cat_name' ] ).'</option>';
							}
						?>
					</select>
				<div>

				<div>
				Topic 1:
				<select name="topic_one">
						<option>-- Select --</option>
						<?php
							foreach( $topics as $topic ) {
								if( $topic[ 'primary' ] == TRUE ) {
									echo '<option value="'.$topic[ 'id' ].'">'.$topic[ 'name' ].'</option>';
								}
							}
						?>
					</select>

					Topic 2:
					<select name="topic_two">
						<option value="">-- Select --</option>
						<?php
							foreach( $topics as $topic) {
								if( $topic[ 'primary' ] == FALSE ) {
									echo '<option value="'.$topic[ 'id' ].'">'.$topic[ 'name' ].'</option>';
								}
							}
						?>
					</select>
				</div>

				<div>
					Keyword:
					<input type="text" name="keyword"/><br/>
				</div>

				<div>
					<input type="submit" value="Submit">
				</div>
			</form>

<?php include_once( './template/inc_footer.php' );?>
