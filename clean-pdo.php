Basic CRUD operations with PDO
CRUD = Create, Read, Update, Delete

Open a database connection
$host = '127.0.0.1';
$dbname = 'test';
$username = 'root';
$password = '';
$charset = 'utf8';
$collate = 'utf8_unicode_ci';

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $username, $password,
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_PERSISTENT => false,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $charset COLLATE $collate"
    )
);
Select a single row
$stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email AND status=:status LIMIT 1');
$stmt->execute(['email' => $email, 'status' => $status]);
$user = $stmt->fetch();
Select multiple rows
With fetch for large results.

$stmt = $pdo->query('SELECT name FROM users');
while ($row = $stmt->fetch()) {
    echo $row['name'] . "\n";
}
With fetchAll for small results.

$news = $pdo->query('SELECT * FROM news')->fetchAll();
Insert a single row
$row = [
    'username' => 'bob',
    'email' => 'bob@example.com'
];
$sql = "INSERT INTO users SET username=:username, email=:email;";
$status = $pdo->prepare($sql)->execute($row);

if ($status) {
    $lastId = $pdo->lastInsertId();
    echo $lastId;
}
Insert multiple rows
$rows = [];
$rows[] = [
    'username' => 'bob',
    'email' => 'bob@example.com'
];
$rows[] = [
    'username' => 'max',
    'email' => 'max@example.com'
];

$sql = "INSERT INTO users SET username=:username, email=:email;";
$stmt = $pdo->prepare($sql);
foreach ($rows as $row) {
    $stmt->execute($row);
}
Update a single row
$row = [
    'id' => 1,
    'username' => 'bob',
    'email' => 'bob2@example.com'
];
$sql = "UPDATE users SET username=:username, email=:email WHERE id=:id;";
$status = $pdo->prepare($sql)->execute($row);
Update multiple rows
$row = [
    'updated_at' => '2017-01-01 00:00:00'
];
$sql = "UPDATE users SET updated_at=:updated_at";
$pdo->prepare($sql)->execute($row);

$affected = $pdo->rowCount();
Delete a single row
$where = ['id' => 1];
$pdo->prepare("DELETE FROM users WHERE id=:id")->execute($where);
Delete multiple rows
$pdo->prepare("DELETE FROM users")->execute();
