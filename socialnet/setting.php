<?php
session_start(); require_once 'db.php';
if (!isset($_SESSION['user_id'])) { header("Location: signin.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_fullname = $_POST['fullname'];
    $new_desc = $_POST['desc'];
    

    $stmt = $pdo->prepare("UPDATE account SET fullname = ?, description = ? WHERE id = ?");
    $stmt->execute([$new_fullname, $new_desc, $_SESSION['user_id']]);
    

    $_SESSION['fullname'] = $new_fullname;


    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $filename = time() . "_" . basename($_FILES['avatar']['name']);
	//        $target = "/uploads/" . $filename;
	$target = __DIR__ . "/uploads/" . $filename;
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
            $pdo->prepare("UPDATE account SET profile_pic = ? WHERE id = ?")->execute([$filename, $_SESSION['user_id']]);
        }
    }
}


$user = $pdo->prepare("SELECT fullname, description, profile_pic FROM account WHERE id = ?");
$user->execute([$_SESSION['user_id']]);
$u = $user->fetch();
$pic = (!empty($u['profile_pic']) && $u['profile_pic'] !== 'default.png') 
       ? "/socialnet/uploads/" . $u['profile_pic'] 
       : "https://via.placeholder.com/150/111111/FFFFFF?text=NO+PIC";
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>SETTINGS</title>
</head>
<body>
<?php include 'menubar.php'; ?>
<div class="container">
    <h2>Account Settings</h2>
    
    <form method="POST" enctype="multipart/form-data" style="text-align: left;">
        
        <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 40px;">
            <img src="<?=$pic?>" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 20px; border: 1px solid #333;">
            
            <label for="avatar-upload" id="avatar-label" style="border: 1px solid #fff; padding: 10px 20px; cursor: pointer; font-size: 10px; letter-spacing: 2px; text-transform: uppercase; transition: 0.3s;">
               EDIT PROFILE PICTURE
            </label>
            <input id="avatar-upload" type="file" name="avatar" style="display: none;" accept="image/png, image/jpeg">
        </div>

        <div style="margin-bottom: 25px;">
            <label style="font-size: 11px; color: #888; letter-spacing: 1px;">FULL NAME</label>
            <input name="fullname" value="<?=htmlspecialchars($u['fullname'])?>" required style="width: 100%; display: block; margin-top: 5px;">
        </div>

        <div style="margin-bottom: 35px;">
            <label style="font-size: 11px; color: #888; letter-spacing: 1px;">BIO / DESCRIPTION</label>
            <textarea name="desc" rows="5" placeholder="Tell us about yourself..." style="resize: none; width: 100%; display: block; margin-top: 5px;"><?=htmlspecialchars($u['description'])?></textarea>
        </div>

        <button type="submit" style="width: 100%;">SAVE ALL CHANGES</button>
    </form>
</div>

<script>
        document.getElementById('avatar-upload').addEventListener('change', function(){
        let label = document.getElementById('avatar-label');
        if(this.files[0]) {
            label.innerText = "IMAGE SELECTED";
            label.style.background = "#fff";
            label.style.color = "#000";
        }
    });
</script>
</body>
</html>
