<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
     <div class="container">
      <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">

          <?php if(isset($_SESSION['user_id'])) : ?>

            <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT; ?>/books/addBook">Add Book</a>
            </li>

          <?php endif; ?>

        </ul>

        <!-- find book -->

        <?php if(isset($_SESSION['user_id'])) : ?>
          
        <form class="form-inline my-2 my-lg-0" action="<?php echo URLROOT; ?>/books/findBook/" method="post">
          <input class="form-control mr-sm-2" name="query" type="search" placeholder="title, author, genre, isbn" size="40" value="<?php echo isset($data['query']) ? $data['query'] : ''; ?>">
          <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
        </form>

        <?php endif; ?>
        
        <ul class="navbar-nav ml-auto">
         <?php if(isset($_SESSION['user_id'])) : ?>
         
         <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/users/profile"><?php echo $_SESSION['user_name']; ?></a>
          </li>

          <?php if(isAdmin()) : ?>
            <li class="nav-item">
            <a href="<?php echo URLROOT; ?>/users/admin" class="nav-link">Admin</a></li>
          <?php endif; ?>
         
         <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout">Logout</a>
          </li>
         
         <?php  else : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/users/register">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">Login</a>
          </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
    </nav>