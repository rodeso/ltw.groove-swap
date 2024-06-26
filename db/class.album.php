<?php
class Album {
    public $id;
    public $title;
    public $artist;
    public $yearOfRelease;
    public $cover;
    public $genre;
    public $rym;
    public $quantity;
    public $minPrice;

    public function __construct($id, $title, $artist, $yearOfRelease, $cover, $genre, $rym, $quantity, $minPrice) {
        $this->id = $id;
        $this->title = $title;
        $this->artist = $artist;
        $this->yearOfRelease = $yearOfRelease;
        $this->cover = $cover;
        $this->genre = $genre;
        $this->rym = $rym;
        $this->quantity = $quantity;
        $this->minPrice = $minPrice;
    }

    // You can also add methods here to perform operations related to albums
    static function getAlbums($db) {
        // Query to retrieve albums from the database
        $query = "SELECT * FROM Album";
    
        // Execute the query
        $result = $db->query($query);
    
        // Initialize an empty array to store albums
        $albums = [];
    
        // Fetch albums from the result set
        while ($row = $result->fetch()) {
            // Create an Album object for each row and add it to the albums array
            $album = new Album($row['ID'], $row['title'], $row['artist'], $row['yearOfRelease'], $row['cover'], $row['genre'], $row['rym'], $row['quantity'], $row['minPrice']);
            $albums[] = $album;
        }
    
        // Close the result set
        $result->closeCursor();
    
        // Return the array of albums
        return $albums;
    }
    static function getAlbumByID($db, $albumId) {
        $query = "SELECT * FROM Album WHERE ID = :albumId";
    
        $statement = $db->prepare($query);
        $statement->bindValue(':albumId', $albumId);
        $statement->execute();
    
        $album = null;
    
        if ($row = $statement->fetch()) {
            $album = new Album($row['ID'], $row['title'], $row['artist'], $row['yearOfRelease'], $row['cover'], $row['genre'], $row['rym'], $row['quantity'], $row['minPrice']);
        }
    
        $statement->closeCursor();
    
        return $album;
    }
    static function searchAlbums($db, $query) {
        $searchQuery = "%{$query}%"; 
    
        $query = "SELECT * FROM Album WHERE title LIKE :searchQuery OR artist LIKE :searchQuery OR genre LIKE :searchQuery";
    
        $statement = $db->prepare($query);
        $statement->bindValue(':searchQuery', $searchQuery);
        $statement->execute();
    
        $albums = [];
    
        while ($row = $statement->fetch()) {
            $album = new Album(
                $row['ID'], 
                $row['title'], 
                $row['artist'], 
                $row['yearOfRelease'], 
                $row['cover'], 
                $row['genre'], 
                $row['rym'], 
                $row['quantity'], 
                $row['minPrice']
            );
            $albums[] = $album;
        }
    
        $statement->closeCursor();
    
        return $albums;
    }
}