<?php
Class Ravs_Show_All_Styles extends Debug_Bar_Panel{

	function init(){
		$this->title( __( 'All Styles' ) );
		$this->enqueue();
	}


	function render(){
		global $wp_styles;

		?>
		<div class="wrap">
			<p><strong>Registered styles:</strong>&nbsp;<?php echo count( $wp_styles->registered ); ?></p>
			<p><strong>Enqueued styles:</strong>&nbsp;<?php echo count( $wp_styles->done ); ?></p>

			<table id="all_enq_scripts">
				<th>Enqueued</th>
				<th>Handle</th>
				<th>src</th>
				<th>Version</th>
				<th>Depandancies</th>
				<!-- <th>Data</th> -->
				<?php
					foreach( $wp_styles->registered as $handle => $registered ){

						//check if script is enqueued for this visit
						$list = 'enqueued';
						$statusClass = '';
						$enqueued = '';
						
						if( in_array( $handle, $wp_styles->done ) ){
							$statusClass = ' class="ravs-active"';
							$enqueued = '&#10003;';
						}

						/**
						 * get style file link
						 * @var string
						 */
						$style_file_link = false !== strpos(  $registered->src, '//' ) ? self::get_valid_url( $registered->src ) : get_site_url( null, $registered->src );

						echo '<tr'.$statusClass.'>';
							echo '<td>'.$enqueued.'</td>';
							echo '<td>'.$registered->handle.'</td>';
							echo '<td><a href="'.$style_file_link.'" target="_blank">'.$registered->src.'</a></td>';
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