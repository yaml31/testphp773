<?php 

$feed_names = array(
  'Articles',
  'Products'
);
$connection = mysqli_connect("localhost", "id13829988_root1", 'qVQ=p58xqoTCj$q_', "id13829988_dbname_1");
$names = implode($feed_names);
$query = "SELECT * ".implode($feed_names)." WHERE 1 LIMIT SUM(COUNT(".implode($feed_names)."))";
$rss_feeds_lists = new rss_feeds_list(array('names' => $names, 'query' => $query), $connection);
$rss_feeds_lists->view_feeds();

class rss_feeds_list {
  var $query;
  var $feeds;
  var $result;
  var $name;
  var $date;
  
  function __construct ($args = array('names', 'query'), $connection) {
    $this->name = $args['names'];
    $this->query = $args['query'];
    try {
        $this->update_feeds($args['query'], $connection);
    } catch (Exception $e) {
        echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
    }
    
    $this->date = date('now');
    $this->result = array('date' => $this->date, 'name' => $this->name, 'feed' => $this->feeds);
  }
  
  function update_feeds ($query, $connection) {
      
    $this->feeds = mysqli_fetch_assoc(mysqli_query($connection, $query));
  }
  
  function create_feed ($args = array('names', 'query')) {
    foreach ($names as $name) {
      $names .= $name;
    };
    $feed = mysqli_fetch_array(mysqli_query($connection, "SELECT * FROM '".$names."' WHERE 1 LIMIT COUNT(SUMM('".$names."'))"));
    array_push($this->feeds, $feed);
  }
  
  function delete_feed () {
    /// mysql_query = "DELETE 1 FROM");
  }
  
  function view_feeds () {
    $feeds = $this->feeds;
    echo "<?rss ";
  }
}

?>
