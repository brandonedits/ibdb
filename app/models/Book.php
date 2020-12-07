<?php

    class Book {
        private $db;
        
        public function __construct(){
            $this->db = new Database;
        }

        public function findBook($data){

          $this->db->query('SELECT title, isbn, title, genre, fName, lName, book.book_id,
                            CONCAT(author.fname, " ", author.lname) AS author
                            FROM book
                            INNER JOIN book_author
                            ON book.book_id = book_author.book_id
                            INNER JOIN author
                            ON book_author.author_id = author.author_id
                            WHERE (title LIKE "%" :query "%"
                            OR isbn LIKE "%":query"%"
                            OR genre LIKE "%":query"%"
                            OR fName LIKE "%":query"%"
                            OR lName LIKE "%":query"%"
                            OR CONCAT(author.fname, " ", author.lname) LIKE "%":query"%")
                            AND book.is_published = 1
                            GROUP BY book.book_id
                            ORDER BY lname
          ');

          $this->db->bind(':query', $data['query']);
          
          $results = $this->db->resultSet();
          
          return $results;

        }

        public function getBooks(){
          $this->db->query('SELECT *
                            FROM book
                            LEFT JOIN user
                            ON book.user_id = user.user_id
                            LEFT JOIN book_author
                            ON book.book_id = book_author.book_id
                            LEFT JOIN author
                            ON book_author.author_id = author.author_id
                            GROUP BY book.book_id
                            ORDER BY book.created_at DESC
                            LIMIT 10
                          ');
          
          $results = $this->db->resultSet();
          
          return $results;
        }


        public function getBooksNotPublished(){
          $this->db->query('SELECT *
                            FROM book
                            LEFT JOIN user
                            ON book.user_id = user.user_id
                            WHERE book.is_published = 0
                            GROUP BY book.book_id
                            ORDER BY book.created_at DESC
                          ');
          
          $results = $this->db->resultSet();
          
          return $results;
        }

        public function getBooksUserAdded($data){
          $this->db->query('SELECT title, fName, lName, isbn, genre, is_published, book.book_id, user.user_id
                            FROM book
                            LEFT JOIN user
                            ON book.user_id = user.user_id
                            LEFT JOIN book_author
                            ON book.book_id = book_author.book_id
                            LEFT JOIN author
                            ON book_author.author_id = author.author_id
                            wHERE book.user_id = :user
                            GROUP BY book.book_id
                            ORDER BY book.created_at DESC
                          ');

          $this->db->bind(':user', $data['user']);
          
          $results = $this->db->resultSet();
          
          return $results;
        }

        public function getAuthors(){
          $this->db->query('SELECT
                            CONCAT(author.fname, " ", author.lname) AS author,
                            fname,
                            lname,
                            book.book_id AS book_id
                            FROM book
                            INNER JOIN book_author
                            ON book.book_id = book_author.book_id
                            INNER JOIN author
                            ON book_author.author_id = author.author_id
                            ORDER BY author.lname
                          ');
          
          $results = $this->db->resultSet();
          
          return $results;
        }

        public function getAuthorsByBookId($id){
          $this->db->query('SELECT
              CONCAT(author.fname, " ", author.lname) AS author,
              fname,
              lname
              FROM book
              INNER JOIN book_author
              ON book.book_id = book_author.book_id
              INNER JOIN author
              ON book_author.author_id = author.author_id
              
              WHERE book.book_id = :id
          ');

          $this->db->bind(':id', $id);
          
          $results = $this->db->resultSet();
          
          return $results;
        }

        // public function getBookById($id){
        //   $this->db->query('SELECT *
        //                     FROM book
        //                     LEFT JOIN book_author
        //                     ON book.book_id = book_author.book_id
        //                     LEFT JOIN author
        //                     ON book_author.author_id = author.author_id
        //                     WHERE book.book_id = :id
        //                     GROUP BY book_author.author_id
        //   ');

        //   $this->db->bind(':id', $id);

        //   $results = $this->db->resultSet();
        //   return $results;
        //   // $row = $this->db->single();

        //   // return $row;
        // }




        public function getBookById($id){
          $this->db->query('SELECT *
                            FROM book WHERE book_id = :id
          ');

          $this->db->bind(':id', $id);

          $row = $this->db->single();

          return $row;
        }


        public function getBookByISBN(){
          $this->db->query('SELECT isbn FROM book');
          
          $results = $this->db->resultSet();
          
          return $results;
        }

        public function getReviews($id){
          $this->db->query('SELECT *, 
                            book.book_id as bookId,
                            user.user_id as userId,
                            review.review_id as reviewId,
                            book.title as bookTitle,
                            book.created_at as bookCreated,
                            review.created_at as reviewCreated,
                            review.is_published as reviewIsPublished
                            
                            FROM review
                            LEFT JOIN book
                            ON review.book_id = book.book_id
                            LEFT JOIN user
                            ON review.user_id = user.user_id
                            WHERE review.is_published = 1
                            AND book.book_id = :id
                            GROUP BY review.review_id
                            ORDER BY review.created_at DESC
          ');
          
          $this->db->bind(':id', $id);

          $results = $this->db->resultSet();
          
          return $results;
        }

        public function getReviewsNotPublished(){
          $this->db->query('SELECT *, 
                            book.book_id as bookId,
                            user.user_id as userId,
                            review.review_id as reviewId,
                            book.title as bookTitle,
                            book.created_at as bookCreated,
                            review.created_at as reviewCreated,
                            review.is_published as reviewIsPublished
                            
                            FROM review
                            LEFT JOIN book
                            ON review.book_id = book.book_id
                            LEFT JOIN user
                            ON review.user_id = user.user_id
                            WHERE review.is_published = 0
                            ORDER BY review.created_at ASC
          ');
          
          $results = $this->db->resultSet();
          
          return $results;
        }

        public function addBook($data){

          $this->db->query('INSERT INTO book (title, user_id, isbn, genre, synopsis)
                            VALUES (:title, :user_id, :isbn, :genre, :synopsis);
                                
                            SET @book_id = LAST_INSERT_ID();

          ');
          
          $this->db->bind(':title', $data['title']);
          $this->db->bind(':user_id', $data['user_id']);
          $this->db->bind(':isbn', $data['isbn']);
          $this->db->bind(':genre', $data['genre']);
          $this->db->bind(':synopsis', $data['synopsis']);

          $this->db->execute(); 

          // Add author(s)
          $count = sizeof($data['author_fName']);
          for($i=0; $i< $count; $i++){

            $fName = $data['author_fName'][$i];
            $lName = $data['author_lName'][$i];

            $this->db->query('INSERT INTO author (fName, lName)
                              SELECT * FROM (SELECT :fName, :lName) AS temp
                              WHERE NOT EXISTS (SELECT fName, lName FROM author WHERE fName = :fName && lName = :lName);

                              SELECT *, @author_exists:=author_id FROM author WHERE fName = :fName && lName = :lName;
                              SET @author_id = CASE
                                WHEN @author_exists THEN @author_exists
                                ELSE LAST_INSERT_ID()
                              END;

                              INSERT INTO book_author (book_id, author_id) VALUES (@book_id, @author_id);
              
            ');

            $this->db->bind(':fName', $fName);
            $this->db->bind(':lName', $lName);

            $this->db->execute();              
          }

          return true;

        }

        public function updateBook($data){
          $this->db->query('DELETE FROM book_author
                            WHERE book_id = :id;

                            DELETE author
                            FROM author
                            LEFT JOIN book_author
                            ON author.author_id = book_author.author_id
                            WHERE book_author.author_id IS NULL; -- delete author in author if author is not found in book_author

                            UPDATE book
                            SET title = :title, isbn = :isbn, genre = :genre, synopsis = :synopsis
                            WHERE book_id = :id;

                            SET @book_id = :id;
              
              ');

          // Bind values
          $this->db->bind(':id', $data['id']);
          $this->db->bind(':title', $data['title']);
          $this->db->bind(':isbn', $data['isbn']);
          $this->db->bind(':genre', $data['genre']);
          $this->db->bind(':synopsis', $data['synopsis']);

          $this->db->execute();

          // Add author(s)
          $count = sizeof($data['author_fName']);
          for($i=0; $i< $count; $i++){

            $fName = $data['author_fName'][$i];
            $lName = $data['author_lName'][$i];

            $this->db->query('INSERT INTO author (fName, lName)
                              SELECT * FROM (SELECT :fName, :lName) AS temp
                              WHERE NOT EXISTS (SELECT fName, lName FROM author WHERE fName = :fName && lName = :lName);

                              SELECT *, @author_exists:=author_id FROM author WHERE fName = :fName && lName = :lName;
                              SET @author_id = CASE
                                WHEN @author_exists THEN @author_exists
                                ELSE LAST_INSERT_ID()
                              END;

                              INSERT INTO book_author (book_id, author_id) VALUES (@book_id, @author_id);
              
            ');

            $this->db->bind(':fName', $fName);
            $this->db->bind(':lName', $lName);

            $this->db->execute();              
          }

          return true;

        }

        
        public function deleteBook($id){
          $this->db->query('DELETE book_author, book
                            FROM book_author
                            INNER JOIN book
                            ON book.book_id = :id
                            WHERE book_author.book_id = :id; -- del book_author and book

                            DELETE author
                            FROM author
                            LEFT JOIN book_author
                            ON author.author_id = book_author.author_id
                            WHERE book_author.author_id IS NULL; -- delete author in author if author is not found in book_author
                  ');

          $this->db->bind(':id', $id);

          if($this->db->execute()){
            return true;
          } else {
            return false;
          }
        }

        public function deleteReview($id){
          $this->db->query('DELETE FROM review WHERE review_id = :id');
          
          $this->db->bind(':id', $id);

          if($this->db->execute()){
            return true;
          } else {
            return false;
          }
        }

        public function approveBook($id){
          $this->db->query('UPDATE book SET is_published = :is_published WHERE book_id = :id');
       
          $this->db->bind(':id', $id);
          $this->db->bind(':is_published', 1);

          if($this->db->execute()){
            return true;
          } else {
            return false;
          }
        }

        public function approveReview($id){
          $this->db->query('UPDATE review SET is_published = :is_published WHERE review_id = :id');
       
          $this->db->bind(':id', $id);
          $this->db->bind(':is_published', 1);

          if($this->db->execute()){
            return true;
          } else {
            return false;
          }
        }

        public function rateReview($data){

          switch($data['action']){
            case 'like':
              $this->db->query('INSERT INTO like_dislike (user_id, review_id, action)
                              VALUES(:user_id, :review_id, :action)
                              ON DUPLICATE KEY UPDATE action = "like"
              ');

              $this->db->bind(':user_id', $data['user_id']);
              $this->db->bind(':review_id', $data['review_id']);
              $this->db->bind(':action', $data['action']);
            break;

            case 'dislike':
              $this->db->query('INSERT INTO like_dislike (user_id, review_id, action)
                              VALUES(:user_id, :review_id, :action)
                              ON DUPLICATE KEY UPDATE action = "dislike"
              ');

              $this->db->bind(':user_id', $data['user_id']);
              $this->db->bind(':review_id', $data['review_id']);
              $this->db->bind(':action', $data['action']);
            break;

            case 'unlike':
              $this->db->query('DELETE FROM like_dislike WHERE user_id = :user_id AND review_id = :review_id');
              $this->db->bind(':user_id', $data['user_id']);
              $this->db->bind(':review_id', $data['review_id']);
            break;

            case 'undislike':
              $this->db->query('DELETE FROM like_dislike WHERE user_id = :user_id AND review_id = :review_id');
              $this->db->bind(':user_id', $data['user_id']);
              $this->db->bind(':review_id', $data['review_id']);
            break;

          }

          if($this->db->execute()){
            return true;
          } else {
            return false;
          }
        }

        public function getLikes(){
            $this->db->query('SELECT
                            review.review_id,
                            like_dislike.action AS action,
                            like_dislike.user_id AS likerId
                            FROM book
                            LEFT JOIN review
                            ON book.book_id = review.book_id
                            LEFT JOIN like_dislike
                            ON review.review_id = like_dislike.review_id
          ');

          $results = $this->db->resultSet();
                      
          return $results;
        }

        public function getDislikes(){

          $this->db->query('SELECT
                            review.review_id,
                            like_dislike.action AS action,
                            like_dislike.user_id AS dislikerId
                            FROM book
                            LEFT JOIN review
                            ON book.book_id = review.book_id
                            LEFT JOIN like_dislike
                            ON review.review_id = like_dislike.review_id
                            -- WHERE book.book_id = :book_id
          ');

          // $this->db->bind(':book_id', $id);

          $results = $this->db->resultSet();
                      
          return $results;
        }

        public function addReview($data){
          $this->db->query('INSERT INTO review (user_id, book_id, review_title, comment, is_published)
                            VALUES(:user_id, :book_id, :review_title, :comment, :is_published)');
        
          $this->db->bind(':user_id', $data['user_id']);
          $this->db->bind(':book_id', $data['book_id']);
          $this->db->bind(':review_title', $data['title']);
          $this->db->bind(':comment', $data['comment']);
          $this->db->bind(':is_published', $data['is_published']);
          
          if($this->db->execute()){
              return true;
          } else {
              return false;
          }
        }

        public function rateBook($data){
          $this->db->query('INSERT INTO book_rating (user_id, book_id, rating)
                            VALUES(:user_id, :book_id, :rating)
                            ON DUPLICATE KEY UPDATE rating = :rating
          ');
        
          $this->db->bind(':user_id', $data['user_id']);
          $this->db->bind(':book_id', $data['book_id']);
          $this->db->bind(':rating', $data['rating']);
          
          if($this->db->execute()){
              return true;
          } else {
              return false;
          }
        }

        public function deleteBookRating($data){
          $this->db->query('DELETE FROM book_rating
                            WHERE book_id = :book_id AND user_id = :user_id
          ');
        
          $this->db->bind(':user_id', $data['user_id']);
          $this->db->bind(':book_id', $data['book_id']);
          
          if($this->db->execute()){
              return true;
          } else {
              return false;
          }
        }

        public function getBookRating($id){
          $this->db->query('SELECT book.book_id, AVG(book_rating.rating) AS rating
                            FROM book
                            LEFT JOIN book_rating
                            ON book.book_id = book_rating.book_id
                            WHERE book.book_id = :book_id
          ');

          $this->db->bind(':book_id', $id);

          $results = $this->db->resultSet();
                                
          return $results;
        }

        public function getBookRatingByUserId($data){
          $this->db->query('SELECT rating
            FROM book_rating
            WHERE book_id = :book_id AND user_id = :user_id
          ');

          $this->db->bind(':book_id', $data['book_id']);
          $this->db->bind(':user_id', $data['user_id']);

          $row = $this->db->single();

          return $row;
      }
  }