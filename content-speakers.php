<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>
     <?php
            
            
            $spk_name = explode(" ", get_the_title());
            $sns2 = substr($spk_name[1], 0, 1);
            
            //array_push($first_char_lnt, $sns2);
            //print_r($first_char_lnt);
            $first_char_lnt[]=$sns2;
            $n = $t-1;
            //echo $n;

        if ($first_char_lnt[$t] != $first_char_lnt[$n]) {
                $fc = $first_char_lnt[$t];
                //echo $fc;
                if ($t > 0) { echo "</ul>"; }
                echo "<div><a name='$fc'>$fc</a></div>";
                echo "<ul>";
                
        }
        
        ?>
    
    <li class="spk-list">
       
       
        
        <a href="<?php the_permalink(); ?>" rel="bookmark">
        <?php echo "$spk_name[1], $spk_name[0]";?></a>
    </li>

