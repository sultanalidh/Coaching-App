<?php /* Template Name: ImportContacts */

/* Here is the function to get input from the add scripts form. It will have the name
of the scripts and the Author's name.  */
get_header();
?>

	<?php do_action( 'ocean_before_content_wrap' ); ?>

	<div id="content-wrap" class="container clr">

		<?php do_action( 'ocean_before_primary' ); ?>

		<div id="primary" class="content-area clr">

			<?php do_action( 'ocean_before_content' ); ?>

			<div id="content" class="site-content clr">

				<?php do_action( 'ocean_before_content_inner' ); ?>

				<?php
				// Elementor `single` location
				if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
					
					// Start loop
					while ( have_posts() ) : the_post();
						get_template_part( 'partials/page/layout' );
					endwhile;
				} ?>

				<?php do_action( 'ocean_after_content_inner' ); ?>

			</div><!-- #content -->

			<?php do_action( 'ocean_after_content' ); ?>

		</div><!-- #primary -->

		<?php do_action( 'ocean_after_primary' ); ?>

	</div><!-- #content-wrap -->

	<?php do_action( 'ocean_after_content_wrap' ); ?>
<?php

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "sultan_wrdp2", "12345", "sultan_wrdp2");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Escape user inputs for security

$scriptName = mysqli_real_escape_string($link, $_REQUEST['scriptName']);
$Author = mysqli_real_escape_string($link, $_REQUEST['Author']);

 
// Attempt insert query execution
$sql = "INSERT INTO ca_Scripts (scriptName, Author) VALUES
            ('$scriptName', '$Author')";
if(mysqli_query($link, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        
    while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            
    
			/* to import the data from a file to the data base and add it to the cs_Scripts table */
			$sql = "INSERT into ca_scriptLines (scriptLineId,scriptid, act, scene, scriptline, lineText, characterId)
				   values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] . "','" . $column[5] . "','" . $column[6] . "')";
				  /* "SELECT scriptId FROM ca_Scripts WHERE scriptName = 'scriptName' ";*/
				   /*"SELECT MAX(scriptId) FROM ca_Scripts";*/
            $result = mysqli_query($link, $sql); 
            
            
            
    if (! empty($result)) {
            $type = "success";
            $message = "CSV Data Imported into the Database";
    } 
    else {
        $type = "error";
        $message = "Problem in Importing CSV Data";
            }
        }
    }
}


// Close connection

mysqli_close($link);

?>
<?php
get_footer();
