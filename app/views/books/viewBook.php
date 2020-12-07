<?php require APPROOT . '/views/inc/header.php' ?>

<div class="card card-body bg-light mt-5">

    <?php flash('post_message'); ?>

    <!-- five stars -->
    <?php if($data['book']->is_published == true): ?>

    <div class="d-inline">

        <form action="<?php echo URLROOT; ?>/books/rateBook/<?php echo $data['book']->book_id; ?>" method="post">

            <h2 class="d-inline"><?php echo $data['book']->title; ?></h2>

            <div class="d-inline">

                <?php
                
                    foreach($data['book_rating'] as $r):
                            $actualRating = round($r->rating);
                            $count = 0;
                        foreach(range(1, 5) as $rating):
                            $count++;
                ?>

                            <button name="rating" type="submit" value="<?php

                            echo $rating;                            
                            
                            ?>" class="btn btn-link p-0 <?php
                            
                                if($count > $actualRating){
                                    echo 'text-secondary';
                                }
                            
                            ?>"><i class="fa fa-star" data-index="<?php echo $rating; ?>"></i></button>
                <?php
                        endforeach;
                    endforeach;
                ?>
            </div>
        </form>

    <!-- Book NOT published -->
    <?php else: ?>

    <div class="d-inline">
        <h2 class="d-inline"><?php echo $data['book']->title; ?></h2>
    </div>

    <?php endif; ?>

        Author:
        
        <?php 

            $authors = [];
            foreach($data['authors'] as $author){
                if($data['book']->book_id == $author->book_id){
                    $authors[] = $author->author;
                }
            }

            echo implode(", ", $authors);

        ?>
        
        <br>ISBN: <?php echo $data['book']->isbn; ?>
        <br>Genere: <?php echo $data['book']->genre; ?>
        <br>Synopsis: <?php echo $data['book']->synopsis; ?>
        
        <!-- Admin can edit book info  -->
        <?php if(isAdmin() && $data['book']->is_published == false): ?>
        
        <hr>

        <div class="mt-3">
                    
            <a href="<?php echo URLROOT; ?>/books/editBook/<?php echo $data['book']->book_id; ?>" class="btn btn-dark">Edit</a>

            <form  class="d-inline" action="<?php echo URLROOT; ?>/books/approveBook/<?php echo $data['book']->book_id; ?>" method="post">

                <input type="submit" value="Approve" class="btn btn-success">
                
            </form>
            
            <form  class="d-inline" action="<?php echo URLROOT; ?>/books/deleteBook/<?php echo $data['book']->book_id; ?>" method="post">

                <input type="submit" value="Delete" class="btn btn-danger">
                
            </form>

        </div>

        <!-- User NOT admin -->
        <?php else: ?>
    
    </div>

    <br>
    
    <!-- Add Review -->
    <button class="add-review btn btn-primary"><?php echo $data['toggle']; ?></button>

    <form action="<?php echo URLROOT; ?>/books/viewBook/<?php echo $data['book']->book_id; ?>" method="post">

        <div class="review form-group <?php echo $data['d-none']; ?>">
            <br>
            
            <div class="form-group">
            
            <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" placeholder="Title" value="<?php echo $data['title']; ?>">
            <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
            </div>

            <textarea name="comment" class="form-control form-control-lg <?php echo (!empty($data['comment_err'])) ? 'is-invalid' : ''; ?>"> </textarea>
            <span class="invalid-feedback"><?php echo $data['comment_err']; ?></span>
            <br>
            <input type="submit" value="Submit" class="btn btn-success">
        </div>

    </form>

    <!-- REVIEWS -->

    <?php if(count($data['reviews']) > 0): ?>

        <h3 class="mt-3 mb-3">Reviews</h3>

    <?php endif; ?>

    <?php foreach($data['reviews'] as $review) : ?>

        <div class="card card-body mb-3">

            <div class="row">
                <div class="col">
                    <h5 class="d-inline"><?php echo $review->review_title; ?></h5>
        
                    Review by: <span class="font-weight-bold"><?php echo $review->name; ?></span>
                    on <?php echo $review->reviewCreated; ?>
                </div>
            </div>

    
            <p><?php echo $review->comment; ?></p>
            

            <div class="row">
                <div class="col">
                    <form  class="d-inline" action="<?php echo URLROOT; ?>/books/rateReview/<?php echo $review->bookId; ?>" method="post">

                        <!-- LIKE BTN -->
                        <button type="submit" name="<?php
                        $action = false;
                        // loop likes
                        foreach($data['likes'] as $like){
                            // likeID matches reviewId
                            if($like->review_id == $review->reviewId){
                                // action is like and loggedInUser is liker
                                if($like->action == 'like' && $like->likerId == $_SESSION['user_id']){
                                    $action = true;
                                } 
                            }
                        }

                        if($action){
                            echo 'unlike';
                        } else {
                            echo 'like';
                        }
                        
                        ?>" class="btn btn-sm bg-white">

                            <i class="fa fa-thumbs-up <?php
                            
                                // CSS add blue if logged-in-user liked
                                foreach($data['likes'] as $like){

                                    if($like->review_id == $review->reviewId){

                                        if($like->action == 'like' && $like->likerId == $_SESSION['user_id']){
                                            echo 'like-dislike';
                                        } 
                                    }
                                } 

                            ?>"></i>
                            <input type="hidden" name="reviewId" value="<?php echo $review->reviewId; ?>">
                        </button>

                        <span>

                        <?php // if(count($data['reviews']) > 0): ?>

                            <?php
     
                            $count = 0;
                            foreach($data['likes'] as $like){
                                
                                if($like->review_id == $review->reviewId && $like->action == 'like'){
                                    $count++;
                                }   
                            }
                            echo $count;

                            ?>

                        </span>

                        <!-- DISLIKE BTN -->
                        <button type="submit" name="<?php
                        $action = false;
                        // loop dislikes
                        foreach($data['dislikes'] as $dislike){
                            // dislikeId matches reviewId
                            if($dislike->review_id == $review->reviewId){
                                // action is dislike and loggedInUser is disliker
                                if($dislike->action == 'dislike' && $dislike->dislikerId == $_SESSION['user_id']){
                                    $action = true;
                                } 
                            }
                        }

                        if($action){
                            echo 'undislike';
                        } else {
                            echo 'dislike';
                        }
                        
                        ?>" class="btn btn-sm bg-white">
                        <i class="fa fa-thumbs-down <?php
                            // CSS add blue if logged-in-user disliked
                            foreach($data['dislikes'] as $dislike){

                                if($dislike->review_id == $review->reviewId){

                                    if($dislike->action == 'dislike' && $dislike->dislikerId == $_SESSION['user_id']){
                                        echo 'like-dislike';
                                    } 
                                }
                            } 

                        ?>"></i>
                            <input type="hidden" name="reviewId" value="<?php echo $review->reviewId; ?>">
                        </button>

                        <span>
                            
                            <?php
                                    
                            $count = 0;
                            foreach($data['dislikes'] as $dislike){
                                
                                if($dislike->review_id == $review->reviewId && $dislike->action == 'dislike'){
                                    $count++;
                                }   
                            }
                            echo $count;

                            ?>

                        </span>

                    </form>

                </div>
                
            </div>  

        </div>

    <?php endforeach; ?>

    <?php endif; ?>

</div>

<?php require APPROOT . '/views/inc/footer.php' ?>