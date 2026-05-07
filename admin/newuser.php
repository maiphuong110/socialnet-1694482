<?php
require_once '../socialnet/db.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $p = password_hash($_POST['p'], PASSWORD_DEFAULT);
    try {
        $pdo->prepare("INSERT INTO account (username, fullname, password, description) VALUES (?,?,?,?)")
            ->execute([$_POST['u'], $_POST['f'], $p, $_POST['d']]);
        $msg = "USER CREATED SUCCESSFULLY";
    } catch (Exception $e) { $msg = "ERROR: USERNAME EXISTS"; }
}
?>
<!DOCTYPE html><html><head><link rel="stylesheet" href="../socialnet/style.css"><title>ADMIN</title></head><body>
<div class="container">
    <h2>CREATE USER</h2>
    <p style="font-size:0.7em; color:yellow; margin-bottom: 30px;"><?=$msg?></p>
    
    <form method="POST" style="text-align: left;">
        <div style="margin-bottom: 25px;">
            <label style="font-size: 11px; color: #888; letter-spacing: 1px;">FULL NAME</label>
            <input name="f" required style="width: 100%; display: block; margin-top: 5px;">
        </div>
        
        <div style="margin-bottom: 25px;">
            <label style="font-size: 11px; color: #888; letter-spacing: 1px;">USERNAME (NO SPACES)</label>
            <input name="u" required pattern="^\S+$" maxlength="20" title="No spaces allowed" style="width: 100%; display: block; margin-top: 5px;">
        </div>
        
        <div style="margin-bottom: 25px;">
            <label style="font-size: 11px; color: #888; letter-spacing: 1px;">PASSWORD</label>
            <input type="password" name="p" required style="width: 100%; display: block; margin-top: 5px;">
        </div>
        
        <div style="margin-bottom: 35px;">
            <label style="font-size: 11px; color: #888; letter-spacing: 1px;">INITIAL DESCRIPTION</label>
            <textarea name="d" rows="3" style="resize: none; width: 100%; display: block; margin-top: 5px;"></textarea>
        </div>
        
        <button type="submit" style="width: 100%;">REGISTER</button>
    </form>
</div></body></html>
