<?php require APPROOT . '/views/inc/header.php' ?>
    
    <?php flash('post_message'); ?>

    <div class="card card-body bg-light mt-5">
        <div class="row mb-3">
            <div class="col-md-6">
                <h3><?php echo $data['title']; ?></h3>
            </div>
        </div>
        
        <?php foreach($data['books'] as $book) : ?>
        
            <?php if($book->is_published == true): ?>
                <div class="card card-body mb-3">

                        <h4 class="d-inline"><a href="<?php echo URLROOT; ?>/books/viewBook/<?php echo $book->book_id; ?>"><?php echo $book->title; ?></a></h4>
                        Written by:

                        <?php

                            $authors = [];
                            foreach($data['authors'] as $author){
                                if($book->book_id == $author->book_id){
                                    $authors[] = $author->author;
                                }
                            }

                            echo implode(", ", $authors);

                        ?>
                        
                        <br>

                        ISBN: <?php echo $book->isbn; ?><br>
                        Genre: <?php echo $book->genre; ?>
                    
                </div>

            <?php endif; ?>
        
        <?php endforeach; ?>

    </div>

<?php require APPROOT . '/views/inc/footer.php' ?>