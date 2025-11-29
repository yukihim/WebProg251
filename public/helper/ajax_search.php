<?php
require_once '../../config/database.php';

$db = (new Database())->getConnection();
$query = $_GET['query'] ?? '';
$stmt = $db->prepare("SELECT c.cid, c.model_name
                    FROM Car c
                    JOIN Brand b ON c.brand_id = b.bid
                    JOIN BodyStyle bs ON c.style_id = bs.bsid
                    WHERE c.model_name LIKE :keyword
                        OR b.brand_name LIKE :keyword
                        OR bs.style_name LIKE :keyword
                    LIMIT 10");
$kw = '%' . $query . '%';
$stmt->bindParam(':keyword', $kw);
$stmt->execute();
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>