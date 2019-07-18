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

<?php


/* replace the info below with your info */ 
$conn=mysqli_connect("localhost", "*****", "****", "******");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}



if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        /*  The name for the database can differ, I am using what I have in both the CSV file template and the database*/
    while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            $sql = "INSERT into ca_Contacts (cFirstName, cLastName, cEmail, cType)
                   values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "')";
            $result = mysqli_query($conn, $sql);
            
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
