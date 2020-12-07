<?php require APPROOT . '/views/inc/header.php' ?>
    
    <?php flash('post_message'); ?>

    <div class="card card-body bg-light mt-5">
    <div class="row mb-3">
        <div class="col-md-6">
            <h3 class="d-inline"><?php echo $data['title']; ?></h3>
            Results: <?php echo count($data['returnedQuery']); ?>
        </div>
    </div>

    <?php foreach($data['returnedQuery'] as $q): ?>

        <div class="card card-body mb-3">

            <h4><a href="<?php echo URLROOT; ?>/books/viewBook/<?php echo $q->book_id; ?>"><?php echo $q->title; ?></a></h4>

            Written by:
        
            <?php

                $authors = [];
                foreach($data['authors'] as $author){
                    if($q->book_id == $author->book_id){
                        $authors[] = $author->author;
                    }
                }

                echo implode(", ", $authors);

            ?><br>

            ISBN: <?php echo $q->isbn; ?><br>
            Genre: <?php echo $q->genre; ?>
        </div>

    <?php endforeach;  ?>
    
<?php require APPROOT . '/views/inc/footer.php' ?>