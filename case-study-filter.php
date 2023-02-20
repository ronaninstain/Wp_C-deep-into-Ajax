<?php

/* Template Name: Case Study Filter */

get_header(vibe_get_header());

if (have_posts()) : while (have_posts()) : the_post();

?>
        <style>
            #filter-posts-container {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                grid-column-gap: 20px;
                grid-row-gap: 20px;

            }

            #filter-posts p {
                display: inline-block;
                font-weight: bold;
                font-size: 18px;
                margin: 0;
                margin-right: 15px;
            }

            #filter-posts {
                text-align: right;
            }

            .filter-form-wrapper {
                margin-bottom: 15px;
            }
        </style>
        <section id="title">
            <?php do_action('wplms_before_title'); ?>
            <div class="<?php echo vibe_get_container(); ?>">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pagetitle">
                            <?php
                            $breadcrumbs = get_post_meta(get_the_ID(), 'vibe_breadcrumbs', true);
                            if (vibe_validate($breadcrumbs) || empty($breadcrumbs))
                                vibe_breadcrumbs();

                            $title = get_post_meta(get_the_ID(), 'vibe_title', true);
                            if (vibe_validate($title) || empty($title)) {
                            ?>
                                <h1><?php the_title(); ?></h1>
                            <?php the_sub_title();
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php

        $v_add_content = get_post_meta($post->ID, '_add_content', true);

        ?>
        <section id="content">
            <div class="<?php echo vibe_get_container(); ?>">
                <div class="row">
                    <div class="col-md-12">

                        <div class="<?php echo vibe_sanitizer($v_add_content, 'text'); ?> content">
                            <div class="filter-hero">

                            </div>

                            <div class="case-study-posts">
                                <div class="filter-form-wrapper">
                                    <form id="filter-posts">
                                        <p>Filter by</p>
                                        <select name="challenge-filter" id="challenge-filter">
                                            <option value="all">All</option>
                                            <?php
                                            $terms = get_terms('challenge');
                                            foreach ($terms as $term) {
                                                echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </form>
                                </div>

                                <div id="filter-posts-container">
                                    <?php
                                    $args = array(
                                        'post_type' => 'case_study',
                                        'posts_per_page' => -1,
                                    );
                                    $query = new WP_Query($args);
                                    if ($query->have_posts()) {
                                        while ($query->have_posts()) {
                                            $query->the_post();
                                    ?>
                                            <div class="filter-post-single">
                                                <div class="filter-post-single-inner">
                                                    <?php the_post_thumbnail(); ?>
                                                    <h3><?php the_title(); ?></h3>
                                                    <div class="case-desc">
                                                        <?php the_excerpt(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                        wp_reset_postdata();
                                    } else {
                                        echo 'No posts found';
                                    }
                                    ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
<?php
    endwhile;
endif;
?>




<?php
get_footer(vibe_get_footer());



$taxonomy = 'challenge'; // Replace with your taxonomy name
$term_slug = 'case-1'; // Replace with your term slug

$args = array(
    'post_type' => 'case_study',
    'tax_query' => array(
        array(
            'taxonomy' => $taxonomy,
            'field' => 'slug',
            'terms' => $term_slug,
        ),
    ),
    'posts_per_page' => -1, // Set to -1 to retrieve all posts
);

$query = new WP_Query($args);

$count = $query->found_posts;

echo 'There are ' . $count . ' posts with the ' . $taxonomy . ' term ' . $term_slug . '.';
