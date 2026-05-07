<?php
session_start(); require_once 'db.php';
if (!isset($_SESSION['user_id'])) { header("Location: signin.php"); exit; }

$owner = $_GET['owner'] ?? $_SESSION['username'];
$stmt = $pdo->prepare("SELECT * FROM account WHERE username = ?");
$stmt->execute([$owner]);
$u = $stmt->fetch();
$pic = (!empty($u['profile_pic']) && $u['profile_pic'] !== 'default.png') 
       ? "/socialnet/uploads/" . $u['profile_pic'] 
       : "https://via.placeholder.com/150/111111/FFFFFF?text=NO+PIC";
?>
<!DOCTYPE html><html><head><link rel="stylesheet" href="style.css"><title>PROFILE</title></head><body>
<?php include 'menubar.php'; ?>
<div class="container">
    <?php if($u): ?>
        <img src="<?=$pic?>" class="avatar-large">
        <h2><?=$u['fullname']?></h2>
        <p style="color:#666; font-size:12px; letter-spacing:2px;">@<?=$u['username']?></p>
        <div style="margin-top:40px; text-align:center;">
            <p style="color:#aaa; font-weight:300; line-height: 1.8;"><?=nl2br(htmlspecialchars($u['description']))?></p>
        </div>
    <?php else: ?><h2>USER NOT FOUND</h2><?php endif; ?>
</div></body></html>
