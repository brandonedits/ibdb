<?php require APPROOT . '/views/inc/header.php' ?>

    <?php flash('post_message'); ?>

    <div class="card card-body bg-light mt-5">

        <div class="alert alert-primary text-center">
            <?php echo $data['title']; ?>
        </div>

        <?php

            if(count($data['books']) == 0 && count($data['books']) == 0){
                echo 'Nothing needs to be reviewed!';
            }

        ?>

        <?php if(count($data['books']) > 0): ?>

            <div class="row mb-3">
                <div class="col-md-6">
                    <h3>Books in Review</h3>
                </div>
            </div>

        <?php endif; ?>

        <?php foreach($data['books'] as $book) : ?>

                <div class="card card-body mb-3">

                    <h4><?php echo $book->title; ?></h4>
                    <div class="bg-light">
                        Book added by: <b><?php echo $book->name; ?></b> on: <?php echo $book->created_at; ?>
                    </div>

                    <div class="mt-3">
                    
                        <a href="<?php echo URLROOT; ?>/books/viewBook/<?php echo $book->book_id; ?>" class="btn btn-outline-success">View</a>

                        <form  class="d-inline" action="<?php echo URLROOT; ?>/books/approveBook/<?php echo $book->book_id; ?>" method="post">
            
                            <input type="submit" value="Approve" class="btn btn-success">
                            
                        </form>
                    
                        <form  class="d-inline" action="<?php echo URLROOT; ?>/books/deleteBook/<?php echo $book->book_id; ?>" method="post">
            
                            <input type="submit" value="Delete" class="btn btn-danger">
                            
                        </form>

                    </div>
                    
                </div>
        
        <?php endforeach; ?>

        <?php if(count($data['reviews']) > 0): ?>

        <div class="row mb-3">
            <div class="col-md-6">
                <h3>Reviews in Review</h3>
            </div>
        </div>

        <?php endif; ?>

        <?php foreach($data['reviews'] as $review) : ?>

            <div class="card card-body mb-3 d-inline">

                <h6 class="d-inline">Book Reviewed:</h6>
                <?php echo $review->bookTitle; ?>

                <div class="bg-light">
                    Review added by: <b><?php echo $review->name; ?></b> on: <?php echo $review->reviewCreated; ?>
                </div>
                <br>

                <h6 class="d-inline">Review Title:</h6>
                <?php echo $review->review_title; ?>
                <br>
                <h6 class="d-inline">Review:</h6>
                <?php echo $review->comment; ?>

                <div class="mt-3">
                
                    <form  class="d-inline" action="<?php echo URLROOT; ?>/books/approveReview/<?php echo $review->reviewId; ?>" method="post">
        
                        <input type="submit" value="Approve" class="btn btn-success">
                        
                    </form>
                
                    <form  class="d-inline" action="<?php echo URLROOT; ?>/books/deleteReview/<?php echo $review->reviewId; ?>" method="post">
        
                        <input type="submit" value="Delete" class="btn btn-danger">
                        
                    </form>

                </div>
                
            </div>

        <?php endforeach; ?>

    </div>

<?php require APPROOT . '/views/inc/footer.php' ?>