<?php require_once( 'inc_connect.php' );?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>IPlatform</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="iplatform.css" type="text/css" media="screen" />
		<script type="text/javascript" src="digidaypulse.js"></script>
	</head>
	<body>
		<div id="queryfield">
			<table>
				<tr id="content0">
					<td id="headline0" class="headline" colspan="4" onClick="expandContent(this.id)">

						<form action="TK.php" method="post">
							Perspective:<select id="category" name="category">
								<option value=""></option>
								<option value="media">media</option>
								<option value="marketing">marketing</option>
							</select><br/>




							<?php
								$query = "SELECT * FROM `topics` ORDER BY `topic_name` ASC";
								$result = mysql_query( $query ) or die ( mysql_error() );

								while ( $row = mysql_fetch_assoc( $result ) ) {
									$topics[] = array(
										'id'  => $row[ 'id' ],
										'name' => ucwords( $row[ 'topic_name' ] ),
										'primary' => $row[ 'primary' ]
									);
								}
							?>
							Topic 1:
							<select id="topic1" name="topic1">
								<option value="">-- Select --</option>
								<?php
									foreach( $topics as $topic) {
										if( $topic[ 'primary' ] == TRUE ) {
											echo '<option value="'.$topic[ 'id' ].'">'.$topic[ 'name' ].'</option>';
										}
									}
								?>
							</select>

							Topic 2:
							<select id="topic2" name="topic2">
								<option value="">-- Select --</option>
								<?php
									foreach( $topics as $topic) {
										if( $topic[ 'primary' ] == FALSE ) {
											echo '<option value="'.$topic[ 'id' ].'">'.$topic[ 'name' ].'</option>';
										}
									}
								?>

							</select><br/>

							Keyword:<input type="text" id="ikeyword" name="ikeyword"/><br/>
								<input type="submit" value="Submit">
                        </form>
                    </td>
				</tr>
                <tr>
                    <div id="results">
                    </div>
                </tr>
			</table>
		</div>
	</body>
</html>
