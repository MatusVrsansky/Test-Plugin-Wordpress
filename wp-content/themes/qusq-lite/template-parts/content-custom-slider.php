<?php
/**
 * Template part for displaying a custom slider of Posts with category -> Featured
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Qusq_Lite
 */

?>

<?php $posts = get_query_var('posts')?>
 <div id="slider">
    <span class="control_next">></span>
    <span class="control_prev"><</span>
    <ul class="list-items">
        <?php foreach( $posts as $post ):?>
            <li><a href="<?php echo $post->guid;?>"><?php echo $post->post_title?></a></li>
        <?php endforeach; ?>
    </ul>
</div>