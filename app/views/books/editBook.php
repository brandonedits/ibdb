<?php require APPROOT . '/views/inc/header.php'; ?>
  
  <div class="card card-body bg-light mt-5">
    
  <div class="d-inline">
    
    <h2 class="d-inline-block"><?php echo $data['page_title']; ?></h2>

    <a href="<?php echo URLROOT ?>/books/viewBook/<?php echo $data['id']; ?>" class=""><i class="fa fa-backward"> Back</i></a>

    </div>

    <form action="<?php echo URLROOT; ?>/books/editBook/<?php echo $data['id']; ?>" method="post">

      <div class="form-group">
        <label for="title">Title: <sup>*</sup></label>
        <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
        <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
      </div>

      <label for="author_fName">Author: <sup>*</sup> <span class="d-inline input-group invalid-feedback"><?php echo isset($data['author_err']) ? $data['author_err'] : ''; ?></span></label>

      <div class="form-group row authors">

      <?php if(isset($_POST['title'])): // tried to submit form at least once ?>

        <?php
        
        $count = 0;
        foreach(array_combine($data['author_fName'], $data['author_lName']) as $first => $last):
          $count++;
        
        ?>

          <div class="input-group control-group" <?php echo $count > 1 ? 'style="margin-top: 15px"' : '' ?>>
            <div class="col-sm-6 input-group">
                  <input type="text" name="author_fName[]" class="form-control form-control-lg <?php echo (!empty($data['author_fName_err']) && empty($first)) ? 'is-invalid' : ''; ?>" value="<?php echo $first; ?>" placeholder="first">
            </div>

            <div class="col-sm-6 input-group">

                <input type="text" name="author_lName[]" class="form-control form-control-lg <?php echo (!empty($data['author_lName_err']) && empty($last)) ? 'is-invalid' : ''; ?>" value="<?php echo $last; ?>" placeholder="last">
                <div class="input-group-btn">
                  <button class="btn btn-lg <?php echo $count > 1 ? 'btn-danger remove' : 'btn-success add-more' ?>" type="button"><i class="fas <?php  echo $count > 1 ? 'fa-minus' : 'fa-plus' ?>"></i></button>
                </div>          
            </div>

          </div>

        <?php endforeach;?>

      <?php else: ?>

            <?php foreach($data['authors'] as $i => $author): ?>

                <div class="input-group control-group" <?php echo $i >= 1 ? 'style="margin-top: 15px"' : '' ?>>
                  <div class="col-sm-6 input-group">
                        <input type="text" name="author_fName[]" class="form-control form-control-lg <?php echo (!empty($data['author_fName_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $author->fname; ?>" placeholder="first">
                  </div>

                  <div class="col-sm-6 input-group">
                      <input type="text" name="author_lName[]" class="form-control form-control-lg <?php echo (!empty($data['author_lName_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $author->lname; ?>" placeholder="last">

                      <div class="input-group-btn">
                        <button class="btn btn-lg <?php echo $i >= 1 ? 'btn-danger remove' : 'btn-success add-more' ?>" type="button"><i class="fas <?php echo $i >= 1 ? 'fa-minus' : 'fa-plus' ?>"></i></button>
                      </div>          
                  </div>

                </div>

            <?php endforeach?>

      <?php endif; ?>

      <!-- Additional authors inputs appended here (JS) -->
      </div>
      
      <div class="form-group">
        <label for="title">ISBN: <sup>*</sup></label>
        <input type="text" name="isbn" class="form-control form-control-lg <?php echo (!empty($data['isbn_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['isbn']; ?>">
        <span class="invalid-feedback"><?php echo $data['isbn_err']; ?></span>
      </div>

      <div class="form-group">
        <label for="state">Genre: <sup>*</sup></label><br>
            <select name="genre" id="genre" class="form-control <?php echo (!empty($data['genre_err'])) ? 'is-invalid' : ''; ?>">
            <option value="">Select One</option>
            <?php $options = ['Action', 'Adventure', 'Comedy', 'Horror', 'Mystery']; ?>

              <?php foreach($options as $option) : ?>
                

                <option value="<?php echo $option; ?>" <?php echo $data['genre'] == $option ? 'selected ="selected"' : '' ?>><?php echo $option; ?></option>
                
              <?php endforeach; ?>

            </select>
        </label>
        <span class="invalid-feedback"><?php echo $data['genre_err']; ?></span>
      </div>

      <div class="form-group">
        <label for="synopsis">Synopsis: <sup>*</sup></label>
          <textarea name="synopsis" class="form-control form-control-lg <?php echo (!empty($data['synopsis_err'])) ? 'is-invalid' : ''; ?>"><?php echo htmlspecialchars($data['synopsis']); ?></textarea>
          <span class="invalid-feedback"><?php echo $data['synopsis_err']; ?></span>
      </div>
    
        <input type="submit" value="Submit" class="btn btn-success">
    </form>
    
  </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>