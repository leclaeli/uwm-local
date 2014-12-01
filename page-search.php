<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <div id="content" class="site-content" role="main">
            <?php /* The loop */ ?>
            <?php 
            while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" 
                <?php post_class(); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <!-- <input type="text" name="search-names" id="custom-search"> -->
                        <input type="submit" value="Search" id="submit-names"> 
                        <?php the_content(); ?>
                        <?php wp_link_pages(array(
                        'before' => '<div class="page-links"><span class="page-links-title">'
                        . __('Pages:', 'twentythirteen') . '</span>',
                        'after' => '</div>',
                        'link_before' => '<span>',
                        'link_after' => '</span>')); ?>
                    </div><!-- .entry-content -->   
                </article><!-- #post -->
            <?php 
            endwhile;
            ?>
            <div class="adv-search">
                <ul id="list-topics">
                <?php
                $args = array(
                    'post_type' => 'cpt_topics',
                    'numberposts' => -1,
                );
                $myposts = get_posts($args);
                foreach ($myposts as $post) : setup_postdata($post); ?>
                    <li class="topic-li" id="<?php echo $post->ID ?>">
                        <a href="<?php the_permalink(); ?>">
                        <?php the_title();?>
                        <span id="topics">Topics</span>
                        </a>
                    </li>
                <?php 
                endforeach;
                wp_reset_postdata(); ?>
                </ul>
            </div>
            <div class="adv-search">
                <ul id="selected-topics">
                <?php
                // function query_speakers() {
                //     global $wpdb;
                //     $meta_key1 = 'acf_topics';
                //     $posts = $wpdb->get_results("
                //         SELECT 
                //             ID,
                //             post_title
                //         FROM 
                //             $wpdb->posts,
                //             $wpdb->postmeta key1
                //         WHERE 
                //             post_status = 'publish' 
                //             AND post_type='cpt_speakers'
                //             AND $wpdb->postmeta.meta_value = '73' 
                            
                            
                //         ORDER BY comment_count 
                //             DESC LIMIT 0,4");
                //     return $posts;
                //  }
//$meta_values = get_post_meta( 58, 'acf_topics' );
//print_r($meta_values);
//echo $meta_values[0][0];
//$mv_posts = get_field('acf_topics');


global $wpdb;

 // $querystr = "
 //    SELECT ID, post_title, $wpdb->posts.*
 //    FROM $wpdb->posts, $wpdb->postmeta
 //    WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
 //    AND $wpdb->postmeta.meta_key = 'acf_topics' 
 //    AND $wpdb->postmeta.meta_value LIKE '%71%'
 //    AND $wpdb->posts.post_status = 'publish' 
 //    AND $wpdb->posts.post_type = 'cpt_speakers'
 //    AND $wpdb->posts.post_date < NOW()
 //    ORDER BY $wpdb->posts.post_date DESC
 // ";

 // $pageposts = $wpdb->get_results($querystr, OBJECT);
 //echo $pageposts->post_title;
//var_dump($pageposts);

        global $wpdb;
        $wp_join = "
                SELECT $wpdb->postmeta.post_id, $wpdb->posts.*,  $wpdb->postmeta.meta_key
                FROM $wpdb->postmeta
                LEFT JOIN $wpdb->posts
                ON $wpdb->posts.ID = $wpdb->postmeta.post_id
                WHERE $wpdb->postmeta.meta_key = 'acf_topics' ";
        $pageposts = $wpdb->get_results($wp_join, OBJECT);
        //var_dump($pageposts);

 foreach ($pageposts as $post ) {
        echo '<li>' . $post->post_title . $post->ID .  '</li>';
}
 

                
   //              global $wpdb;
   // $posts = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE post_status = 'publish'
   // AND post_type='cpt_speakers' ORDER BY comment_count DESC LIMIT 0,4");
   // foreach ($posts as $post ) {
   //     echo '<li>' . $post->post_title . '</li>';
   // }             
?>


                </ul>
            </div>
            <div id="results"></div>   
        </div><!-- #content -->
    </div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer();
