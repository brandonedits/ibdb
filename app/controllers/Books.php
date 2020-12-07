<?php

    class Books extends Controller {
        
        public function __construct(){
            // If not logged in - redirect to login page
            if(!isLoggedIn()){
                redirect('users/login');
            }

            $this->bookModel = $this->model('Book');
            $this->userModel = $this->model('User');
            
        }
        
        public function index(){
            $books = $this->bookModel->getBooks();
            $authors = $this->bookModel->getAuthors();
            
            $data = [
                'title' => 'Recent Additions',
                'books' => $books,
                'authors' => $authors
            ];
            
            $this->view('books/index', $data);
        }

        // add book
        public function addBook(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
                $checkISBN = $this->bookModel->getBookByISBN();

                $data = [
                'page_title' => 'Add Book',
                'title' => trim($_POST['title']),
                'author_fName' => $_POST['author_fName'], /* cant trim array */
                'author_lName' => $_POST['author_lName'],
                
                'isbn' => trim($_POST['isbn']),
                'genre' => $_POST['genre'],
                'synopsis' => trim($_POST['synopsis']),
                'user_id' => $_SESSION['user_id'],
                'isbns' => $checkISBN,
                    
                'title_err' => '',
                'author_err' => '',
                'author_fName_err' => '',
                'author_lName_err' => '',
                'isbn_err' => '',
                'genre_err' => '',
                'synopsis_err' => ''
            ];
                 
                // Validate data
                if(empty($data['title'])){
                    $data['title_err'] = 'Please enter title';
                }

                foreach(array_combine($data['author_fName'], $data['author_lName']) as $first => $last){

                  if(empty($first)){
                    $data['author_err'] = 'Gonna need a first name';
                    $data['author_fName_err'] = true;
                  }

                  if(empty($last)){
                    $data['author_err'] = 'Gonna need a last name';
                    $data['author_lName_err'] = true;
                  }

                  if(empty($first) && empty($last)){
                    $data['author_err'] = 'Gonna need a first and last name';
                    $data['author_fName_err'] = true;
                    $data['author_LName_err'] = true;
                  }

                }

                if(empty($data['isbn'])){
                  $data['isbn_err'] = 'Please enter isbn';

                }

                foreach($checkISBN as $isbn){
                  if($isbn->isbn == $data['isbn']){
                    $data['isbn_err'] = 'Looks like that ISBN matches a book already in the system!';
                  }
                }
          
                if(empty($data['genre'])){
                  $data['genre_err'] = 'Please select a genre';
                }

                if(empty($data['synopsis'])){
                  $data['synopsis_err'] = 'What\'s the book about?';
                }
                
                // Make sure no errors
                if(empty($data['title_err']) && empty($data['author_err']) && empty($data['isbn_err']) && empty($data['genre_err']) && empty($data['synopsis_err'])){
                    // Validated
                    if($this->bookModel->addBook($data)){
                        flash('post_message', 'Book added to be reviewed by a moderator. Check out some other books that have been added in the meantime!');
                        redirect('books');
                    } else {
                    die('Something went wrong');
                    }
                    
                } else {
                    // Load view w/ errors
                    $this->view('books/addBook', $data);
                }
                
            } else {
                
                $data = [
                'page_title' => 'Add Book',
                'title' => '',
                'author_fName' => '',
                'author_lName' => '',
                'isbn' => '',
                'genre' => '',
                'synopsis' => ''
            ];
            
            
            $this->view('books/addBook', $data);
                
            }
                        
        }

        // edit book
        public function editBook($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

        // Sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $book = $this->bookModel->getBookById($id);

        $data = [
          'page_title' => 'Edit Book',
          'id' => $id,
          'title' => trim($_POST['title']),
          'author_fName' => $_POST['author_fName'], /* cant trim array */
          'author_lName' => $_POST['author_lName'],
          
          'isbn' => trim($_POST['isbn']),
          'genre' => $_POST['genre'],
          'synopsis' => trim($_POST['synopsis']),
          'user_id' => $_SESSION['user_id'],
              
          'title_err' => '',
          'author_err' => '',
          'author_fName_err' => '',
          'author_lName_err' => '',
          'isbn_err' => '',
          'genre_err' => '',
          'synopsis_err' => ''
      ];

        // Validate data
        if(empty($data['title'])){
          $data['title_err'] = 'Please enter title';
      }

      foreach(array_combine($data['author_fName'], $data['author_lName']) as $first => $last){

        if(empty($first)){
          $data['author_err'] = 'Gonna need a first name';
          $data['author_fName_err'] = true;
        }

        if(empty($last)){
          $data['author_err'] = 'Gonna need a last name';
          $data['author_lName_err'] = true;
        }

        if(empty($first) && empty($last)){
          $data['author_err'] = 'Gonna need a first and last name';
          $data['author_fName_err'] = true;
          $data['author_LName_err'] = true;
        }

      }

      if(empty($data['isbn'])){
        $data['isbn_err'] = 'Please enter isbn';

      }

      if($book && $data['isbn'] !== $book->isbn){
          $data['isbn_err'] = 'Looks like that ISBN matches a book already in the system!';
      }

      if(empty($data['genre'])){
        $data['genre_err'] = 'Please select a genre';
      }

      if(empty($data['synopsis'])){
        $data['synopsis_err'] = 'What\'s the book about?';
      }
      
      // Make sure no errors
      if(empty($data['title_err']) && empty($data['author_err']) && empty($data['isbn_err']) && empty($data['genre_err']) && empty($data['synopsis_err'])){
          // Validated
          if($this->bookModel->updateBook($data)){
            flash('post_message', 'Book Updated');
            redirect('users/admin');
          } else {
            die('Something went wrong');
          }
        } else {
          // Load view with errors
          $this->view('books/editBook', $data);
        }

      } else {
        // Get existing view from model
        $book = $this->bookModel->getBookById($id);
        $authors = $this->bookModel->getAuthorsByBookId($id);

         $data = [
          'page_title' => 'Edit Book',
          'id' => $id,
          'title' =>$book->title,
          'authors' => $authors,
          'isbn' => $book->isbn,
          'genre' => $book->genre,
          'synopsis' => $book->synopsis,
        ];
  
        $this->view('books/editBook', $data);
      }
    }


        // delete book - Admin or User who added book (if book is still in review)
        public function deleteBook($id){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                // Get existing post from model
                $post = $this->bookModel->getBookById($id);

                // Check for owner
                if($post->user_id != $_SESSION['user_id']){
                  redirect('books');
                }

                
                if($this->bookModel->deleteBook($id)){
                    flash('post_message', 'Book removed from db');
                    redirect('users/admin');
                } else {
                    die('Something went wrong.');
                }
            } else {
                redirect('books');
            }
        }


        // Admin option
        public function deleteReview($id){
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
              
              if($this->bookModel->deleteReview($id)){
                  flash('post_message', 'Review removed from db');
                  redirect('users/admin');
              } else {
                  die('Something went wrong.');
              }
          } else {
              redirect('books');
          }
        }




        public function rateBook($id){
          if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $book = $this->bookModel->getBookById($id);
            

            $data = [
              'book_id' => $book->book_id,
              'user_id' => $_SESSION['user_id'],
              'rating' => $_POST['rating']
            ];

            $userRating = $this->bookModel->getBookRatingByUserId($data);

            if($userRating->rating == $data['rating']){
                $this->bookModel->deleteBookRating($data);
                flash('post_message', 'Rating removed!');
                redirect('books/viewBook/' . $id);
            } elseif($this->bookModel->rateBook($data)){
                flash('post_message', 'You rated this book ' . $data['rating'] . '/5!');
                redirect('books/viewBook/' . $id);
            } else {
                die('Something went wrong.');
            }
        } else {
            redirect('books');
        }
      }


     



        // approve book - Admin option
        public function approveBook($id){
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
              
              if($this->bookModel->approveBook($id)){
                  flash('post_message', 'Book approved and added to db');
                  redirect('users/admin');
              } else {
                  die('Something went wrong.');
              }
          } else {
              redirect('books');
          }
      }

      // approve review - Admin option
      public function approveReview($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            if($this->bookModel->approveReview($id)){
                flash('post_message', 'Review approved and added to db');
                redirect('users/admin');
            } else {
                die('Something went wrong.');
            }
        } else {
            redirect('books');
        }
      }




  public function rateReview($id){
    if(isset($_POST['like'])){

      $data = [
        'review_id' => $_POST['reviewId'],
        'user_id' => $_SESSION['user_id'],
        'action' => 'like'
      ];

      if($this->bookModel->rateReview($data)){
            redirect('books/viewBook/' . $id);
          } else {
              die('Something went wrong.');
          }
      } elseif(isset($_POST['unlike'])){

        $data = [
          'review_id' => $_POST['reviewId'],
          'user_id' => $_SESSION['user_id'],
          'action' => 'unlike'
        ];
  
        if($this->bookModel->rateReview($data)){
              redirect('books/viewBook/' . $id);
            } else {
                die('Something went wrong.');
            }
        } elseif(isset($_POST['dislike'])){

          $data = [
            'review_id' => $_POST['reviewId'],
            'user_id' => $_SESSION['user_id'],
            'action' => 'dislike'
          ];
    
          if($this->bookModel->rateReview($data)){
                redirect('books/viewBook/' . $id);
              } else {
                  die('Something went wrong.');
              }
        } elseif(isset($_POST['undislike'])){

          $data = [
            'review_id' => $_POST['reviewId'],
            'user_id' => $_SESSION['user_id'],
            'action' => 'undislike'
          ];
    
          if($this->bookModel->rateReview($data)){
                redirect('books/viewBook/' . $id);
              } else {
                  die('Something went wrong.');
              }
        } 
      
      
      
      
      else {
          redirect('books/viewBook');
    }
}

      public function viewBook($id){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $book = $this->bookModel->getBookById($id);
                $authors = $this->bookModel->getAuthors();
                $user = $this->userModel->getUserById($book->user_id);


                $review = $this->bookModel->getReviews($book->book_id);


                $likes = $this->bookModel->getLikes();
                $dislikes = $this->bookModel->getDislikes();
                  
                  // Sanitize POST array
                  $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                      
                  $data = [
                    'book' => $book,
                    'authors' => $authors,
                    'user' => $user,
                    'title' => trim($_POST['title']),
                    'comment' => trim($_POST['comment']),
                    'user_id' => $_SESSION['user_id'],
                    'book_id' => $book->book_id,
                    'd-none' => '',
                    'toggle' => 'Maybe Later',
                    'reviews' => $review,
                    'likes' => $likes,
                    'dislikes' => $dislikes,
                      
                    'title_err' => '',
                    'comment_err' => '',
                  ];

                  // filter bad words
                  $filterRegex = strtoupper('(fuck|shit)');
                  $filtered = false;

                  if(preg_match($filterRegex, strtoupper($data['title'])) || preg_match($filterRegex, strtoupper($data['comment']))){
                    $data += ['is_published' => '0'];
                    $filtered = true;
                  } else {
                    $data += ['is_published' => '1'];
                  }
                  
                  // Validate data
                  if(empty($data['title'])){
                      $data['title_err'] = 'Please enter a title';
                  }

                  if(empty($data['comment'])){
                    $data['comment_err'] = 'Not going to comment on the book?!';
                  }
                  
                  // Make sure no errors
                  if(empty($data['title_err']) && empty($data['comment_err'])){
                      // Validated
                      if($this->bookModel->addReview($data)){
                          if($filtered){
                            flash('post_message', 'Review sent to be reviewed by a moderator!');
                            redirect('books/viewBook/' . $data['book']->book_id);
                          } else {
                            flash('post_message', 'Review Added!');
                            redirect('books/viewBook/' . $data['book']->book_id);
                          }
                          
                      } else {
                      die('Something went wrong');
                      }
                      
                  } else {
                      // Load view w/ errors
                      $this->view('books/viewBook', $data);
                  }
                  
              } else {

                    $book = $this->bookModel->getBookById($id);
                    $authors = $this->bookModel->getAuthors();
                    $user = $this->userModel->getUserById($book->user_id);
                    $review = $this->bookModel->getReviews($book->book_id);


                    $likes = $this->bookModel->getLikes();

                    $dislikes = $this->bookModel->getDislikes();

                    $bookRating = $this->bookModel->getBookRating($id);

                    $data = [
                      'book' => $book,
                      'authors' => $authors,
                      'user' => $user,
                      'd-none' => 'd-none',
                      'toggle' => 'Add Review',
                      'title' => '',
                      'book_rating' => $bookRating,
                      'reviews' => $review,
                      'likes' => $likes,
                      'dislikes' => $dislikes,
                      'book_id' => $id,
                      'user_id' => $_SESSION['user_id']
                  ];

                    if(isAdmin() || $book->is_published == true){
                      $this->view('books/viewBook', $data);
                    } else {
                      redirect('');
                    }
              }
        }

      // Search by title, isbn, genre, author(s)
      public function findBook(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
          
            $data = [
              'query' => $_POST['query']
            ];
            
            $this->bookModel->findBook($data);

            $returnedQuery = $this->bookModel->findBook($data);
            $authors = $this->bookModel->getAuthors();
             
            $data = [
              'title' => 'Find Book',
              'authors' => $authors,
              'query' => $_POST['query'],
              'returnedQuery' => $returnedQuery
            ];

            $this->view('books/findBook', $data);

        } else {
            redirect('books');
        }
      }
}