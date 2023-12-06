<?php
require_once 'templates/header.php';
?>

<?php
$host     = 'localhost'; // Because MySQL is running on the same computer as the web server
$database = 'PHP_connect'; // Name of the database you use (you need first to CREATE DATABASE in MySQL)
$name     = 'root'; // Default username to connect to MySQL is root
$password = ''; // Default password to connect to MySQL is empty
try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $name, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['username']) && isset($_POST['message'])){
        $username = $_POST['username'];
        $message = $_POST['message'];
        $sql = ("INSERT INTO posts (`name`,`message`) value (?,?);");
        $result = $conn->prepare($sql); // chuan bij cau truy vấn
        $result->bindParam(1, $username); //gán 1 tham số bằng 1 biến, nhét biến vào trong dòng $sql
        $result->bindParam(2, $message);
        $result->execute();//thực thi truy vấn
$sql = "SELECT * FROM posts;";
$result = $conn->query($sql);
$posts = $result->fetchAll(PDO::FETCH_ASSOC); // lấy dữ liệu ra, fetcjAll sẽ trả về một mảng chứa tất cả các hàng trong bảng của kết quả trả về
// TO DO: SELECT ALL POSTS FROM DATABASE


// $posts =  $db->query("SELECT * FROM `posts`"); 
?>
<?php
// print_r ($posts);
foreach ($posts as $post) {
    // print_r ($post);
?> 
    

    <div class="card">
        <div class="card-header">
            <span> <?php echo $post['name'] ?></span>
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo  $post['message']?></p>
        </div>
    </div>
    <hr>
<?php
}
}
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>


<form action="index.php" method="post">
    <div class="row mb-3 mt-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Name" name="username">
        </div>
    </div>

    <div class="mb-3">
        <textarea name="message" placeholder="Enter message" class="form-control"></textarea>
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Add new post</button>
    </div>
</form>

<?php
require_once 'templates/footer.php';
?>