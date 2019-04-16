<?php /* Template Name: Importig1 */

/* Here is the function to get input from the add scripts form. It will have the name
of the scripts and the Author's name.  */

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
/* Attempt MySQL server connection. */
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
if(mysqli_multi_query($link, $sql)){
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
			$sql = "INSERT into  ca_scriptLines (scriptLineId,scriptid , act, scene, scriptline, lineText, characterId)
				   values ('" . $column[0] . "',(SELECT MAX(scriptId) FROM ca_Scripts) ,'" . $column[2] . "','" . $column[3] . "','" . $column[4] . "','" . $column[5] . "','" . $column[6] . "')";
				  /* "SELECT scriptId FROM ca_Scripts WHERE scriptName = 'scriptName' ";*/
				 /*  "SELECT MAX(scriptId) FROM ca_Scripts";*/
            $result = mysqli_multi_query($link, $sql); 
            
            
            
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


<?php
get_footer();
