<?php require_once( 'inc_connect.php' );?>

<!DOCTYPE HTML>
<html>
	<head>
		<link rel="stylesheet" href="iplatform.css" type="text/css"/>
	</head>
	<body>
		<?php

			$ikeyword = $_POST["ikeyword"];
			$category = $_POST["category"];
			$topic1 = $_POST["topic1"];


			/*Given the established information hierarchy, this broadens the search to prevent more null sets from being returned. */
			switch($topic1)
			{
				case "1100":
					$topic1 = "'1100', '1110'";
					break;
				case "1110":
					$topic1 = "'1110', '1111', '1112'";
					break;
				case "1500":
					$topic1 = "'1510', '1520'";
					break;
				case "1600":
					$topic1 = "'1600', '3420'";
					break;
				case "2000":
					$topic1 = "'2000', '2100', '2200'";
					break;
				case "2100":
					$topic1 = "'2100', '3100', '3200'";
					break;
				case "3000":
					$topic1 = "'3000', '3100', '3200', '3400'";
					break;
				case "3400":
					$topic1 = "'3400', '3410', '3420'";
					break;
				case "3420":
					$topic1 = "'3420', '3421', '3422'";
					break;
				case "4000":
					$topic1 = "'4000', '4100', '4200', '4300'";
					break;
				case "4300":
					$topic1 = "'4300', '4310'";
					break;
				case "":
					$topic1 = "''";
					break;
				default:
					$topic1 = "'".$topic1."'";
			}
			$topic2 = $_POST["topic2"];
			/*Same, but could honestly change given the change of what filters are allowed in each position, primary and secondary.*/
			switch($topic2)
			{
				case "1100":
					$topic2 = "'1100', '1110'";
					break;
				case "1110":
					$topic2 = "'1110', '1111', '1112'";
					break;
				case "1500'":
					$topic2 = "'1510', '1520'";
					break;
				case "1600":
					$topic2 = "'1600', '3420'";
					break;
				case "2000":
					$topic2 = "'2000', '2100', '2200'";
					break;
				case "2100":
					$topic2 = "'2100', '3100', '3200'";
					break;
				case "3000":
					$topic2 = "'3000', '3100', '3200', '3400'";
					break;
				case "3400":
					$topic2 = "'3400', '3410', '3420'";
					break;
				case "3420":
					$topic2 = "'3420', '3421', '3422'";
					break;
				case "4000":
					$topic2 = "'4000', '4100', '4200', '4300'";
					break;
				case "4300":
					$topic2 = "'4300', '4310'";
					break;
				case "":
					$topic2 = "''";
					break;
				default:
					$topic2 = "'" . $topic2 . "'";
			}
			/* Clear potentially cached queries. */
			unset($query);


			/*Start of a dynamic query builder. If the media/marketing perspective is present, include it in the "WHERE" parameters. */
			if ($category)
			{
				$sql[] = " category = '".$category."' ";
			}

			/*Are both topics included? If so, load them both into the query and check if at least two tags from the set of terms and associated terms are present (a successful cross reference).*/
			if (($topic1 != "''") && ($topic2 != "''"))
			{
				$sql[] = " tag_index.tag_id IN (".$topic1.", ".$topic2.") GROUP BY insights.id HAVING COUNT(tag_index.tag_id) >= 2 ";
			}

			/*But if only one of the queries are present (cases of both being present will be caught above) check matches for that one. */
			elseif (($topic1 != "''") || ($topic2 != "''"))
			{
				 $sql[] = " (tag_index.tag_id IN (".$topic1.") OR tag_index.tag_id IN (".$topic2."))";
			}

			/*The base query. The keyword is preloaded, since anything "like" a blank keyword matches any entry anyway. For now only pull the insight's text.*/
			$query = "SELECT insights.text
								FROM insights
								INNER JOIN tag_index
								ON insights.id = tag_index.insight_id
								WHERE insights.text
								LIKE '%".$ikeyword."%'";


			/*Check if the dynamic query builder yielded any result, if any non-keyword fields were filled out. If not, proceed with the base query. */
			if (!empty($sql)) {

				$query .= "AND" . implode(" AND ", $sql);

			}
			/*Load up the query function with the proper database connection and the pre-built query. */
			$result = mysql_query($query, $db);
			/*Bye!*/
			mysql_close($db);
		?>
		<div>
			<table>
				<tr>
					<td>
						<a href="http://67.243.130.200/iplatform/iplatform.html">Recalibrate your briefing</a>
					</td>
				</tr>
				<?php
					/*Basic result display.*/
					for ( $counter = 0; $row = mysql_fetch_row($result); $counter++ )
							{

								print( "<tr><td>" );
								foreach ( $row as $key => $value )
									print( "$value" );
								print( "</td></tr>" );
							}
				?>
				<tr>
					<td>
						<a href="http://67.243.130.200/iplatform/iplatform.html">Recalibrate your briefing</a>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
