<?php
session_start(); require_once 'db.php';
if (!isset($_SESSION['user_id'])) { header("Location: signin.php"); exit; }


$me_stmt = $pdo->prepare("SELECT fullname, username, profile_pic FROM account WHERE id = ?");
$me_stmt->execute([$_SESSION['user_id']]);
$me = $me_stmt->fetch();

$my_pic = (!empty($me['profile_pic']) && $me['profile_pic'] !== 'default.png') 
          ? "/socialnet/uploads/".$me['profile_pic'] 
          : "https://via.placeholder.com/150/111111/FFFFFF?text=NO+PIC";

$stmt = $pdo->prepare("SELECT username, fullname, profile_pic FROM account WHERE id != ?");
$stmt->execute([$_SESSION['user_id']]);
$users = $stmt->fetchAll();
?>
<!DOCTYPE html><html><head><link rel="stylesheet" href="style.css"><title>HOME</title></head><body>
<?php include 'menubar.php'; ?>
<div class="container">

    <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 50px;">
        <img src="<?=$my_pic?>" style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover; margin-bottom: 20px; border: 1px solid #333;">
        <p style="font-size: 22px; margin: 0; font-weight: 400; letter-spacing: 2px;"><?=$me['fullname']?></p>
        <p style="color:#666; font-size: 13px; letter-spacing: 2px; margin-top: 8px;">@<?=$me['username']?></p>
    </div>

    <h2 style="font-size: 14px; color:#888; text-align: left; border-bottom: 1px solid #333; padding-bottom: 10px; margin-bottom: 0;">NETWORK EXPLORE</h2>
    <ul class="user-list" style="list-style: none; padding: 0; margin-top: 10px;">
        <?php foreach($users as $u):
             $pic = (!empty($u['profile_pic']) && $u['profile_pic'] !== 'default.png') 
                   ? "/socialnet/uploads/".$u['profile_pic'] 
                   : "https://via.placeholder.com/45/111111/FFFFFF?text=?";
        ?>
        <li class="user-item" style="display: flex; align-items: center; padding: 15px 0; border-bottom: 1px solid #222;">
            <img src="<?=$pic?>" style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover; margin-right: 20px; border: 1px solid #333;">
            <a href="profile.php?owner=<?=$u['username']?>" class="user-link" style="color: #ccc; text-decoration: none; font-size: 14px; letter-spacing: 1px;">
                <?=$u['fullname']?> <span style="color:#555; font-size:11px;">(@<?=$u['username']?>)</span>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</div></body></html>
