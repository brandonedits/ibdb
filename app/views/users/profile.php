<?php require APPROOT . '/views/inc/header.php' ?>

    <?php flash('post_message'); ?>
        
    <div class="card card-body bg-light mt-5">

    <div class="alert alert-primary text-center">
        <?php echo $data['title']; ?>
    </div>

    <?php if(count($data['books']) > 0): ?>

        <div class="row mb-3">
                <div class="col-md-6">
                    <h3>Your Books</h3>
                </div>
            </div>

    <?php else: ?>

        <p>You haven't added any books yet! <a href="<?php echo URLROOT; ?>/books/addBook">Add one now!</a> </p>

    <?php endif; ?>

    <?php foreach($data['books'] as $book) : ?>
        
        <div class="card card-body mb-3">
        
        <!-- Give user option to del book if it is still in review by mod -->
        <?php if($book->is_published == false): ?>
        
        <div class="alert alert-dark">
            <form action="<?php echo URLROOT; ?>/books/deleteBook/<?php echo $book->book_id; ?>" method="post">

                In review |  <button class="btn btn-link p-0">Delete</button>
        
            </form>
        </div>
        
        <?php endif; ?>

            <div class="d-inline">

            <!--  Admin can go to book review -->
            <?php if(isAdmin()): ?>

                <a href="<?php echo URLROOT; ?>/books/viewBook/<?php echo $book->book_id; ?>">

                <h5 class=""><?php echo $book->title; ?></h5></a>

            <?php else: ?>
                
                <h5 class=""><?php echo $book->title; ?></h5>

            <?php endif; ?>

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

        </div>

    <?php endforeach; ?>
</div>

<?php require APPROOT . '/views/inc/footer.php' ?>