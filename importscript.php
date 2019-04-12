<?php /* Template Name: ImportScripts */ 



get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</section><!-- #primary -->


<?php



$conn=mysqli_connect("localhost", "sultan_wrdp2", "12345", "sultan_wrdp2");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}



if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        
    while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            /* Should I add the second quary here? */
            $sql = "INSERT into ca_Scripts (scriptName, scriptAuthor) values ('" . $column[0] . "','" . $column[0] . "')";
    
            /* to import the data from a file to the data base. */
            $sql = "INSERT into ca_scriptLine (scriptLineId, act, scene, line, lineText)
                   values ('" . $column[2] . "','" . $column[3] . "','" . $column[4] . "','" . $column[5] . "','" . $column[6] . "','" . $column[7] . "')";
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

?>
<?php
get_footer();