<?php
Class Ravs_Show_All_Scripts extends Debug_Bar_Panel{

	function init(){
		$this->title( __( 'All Scripts' ) );
		$this->enqueue();
	}


	function render(){
		global $wp_scripts;
		?>
		<div class="wrap">
			<p><strong>Registered scripts:</strong>&nbsp;<?php echo count( $wp_scripts->registered ); ?></p>
			<p><strong>Enqueued scripts:</strong>&nbsp;<?php echo count( $wp_scripts->done ); ?></p>

			<table id="all_enq_scripts">
				<th>Enqueued</th>
				<th>Handle</th>
				<th>src</th>
				<th>Version</th>
				<th>Depandancies</th>
				<!-- <th>Data</th> -->
				<?php
					foreach( $wp_scripts->registered as $handle => $registered ){

						//check if script is enqueued for this visit
						$list = 'enqueued';
						$statusClass = '';
						$enqueued = '';
						if( in_array( $handle,  $wp_scripts->done ) ){
							$statusClass = ' class="ravs-active"';
							$enqueued = '&#10003;';
						}

						/**
						 * get script file link
						 * @var string
						 */
						$script_file_link = false !== strpos(  $registered->src, '//' ) ? self::get_valid_url( $registered->src ) : get_site_url( null, $registered->src );

						echo '<tr'.$statusClass.'>';
							echo '<td>'.$enqueued.'</td>';
							echo '<td>'.$registered->handle.'</td>';
							echo '<td><a href="'.$script_file_link.'" target="_blank">'.$registered->src.'</a></td>';
							echo '<td>'.$registered->ver.'</td>';
							echo '<td>'.implode( ', ', $registered->deps).'</td>';
							// echo '<td>'.$registered->extra['data'].'</td>';
						echo '</tr>';
						}
					?>
			</table>
		</div>
		<?php
	}

	function get_valid_url( $url ){

		if( false !== strpos( $url, 'http' ) ){
			return $url;
		}elseif( false !== strpos( $url, 'googleapis' ) ){
			return 'http:'.$url;
		}

		// put your login here
		$url = apply_filters( 'debug_bar_valid_url_check', $url );

		return $url;
	}

	function enqueue(){
		wp_enqueue_style( 'show-all-scripts-style-css', plugins_url( 'css/style.css', dirname( __FILE__ ) ) );
	}
}