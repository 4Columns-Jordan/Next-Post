<?php
// This is the template file for the buttons
$currentId = get_the_ID();
// getting the previous post's url
$prevPost = FCNP__getPostUrl($currentId, 'before');
// getting the next post's url
$nextPost = FCNP__getPostUrl($currentId, 'after');
?>

<div class="container">
    <div class="row justify-content-between">
        <div class="col-auto">
            <?php if(!empty($prevPost)): ?>
            <a href="<?php echo $prevPost ?>"><i class="fas fa-angle-left"></i> Previous Post</a>
            <?php endif; ?>
        </div>
        <div class="col-auto">
            <?php if(!empty($nextPost)): ?>
            <a href="<?php echo $nextPost ?>">Next Post <i class="fas fa-angle-right"></i></a>
            <?php endif; ?>
        </div>
    </div>
</div>