<?php
include('config.php');
check_login();
check_ae(); 

// Process Forward / Reject Choices
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $story_id = intval($_POST['story_id']);
    $notes = clean($_POST['notes']);
    
    if ($_POST['action'] === 'forward') {
        $stmt = $conn->prepare("UPDATE stories SET review_status = 'forwarded_to_se', ae_notes = :notes WHERE id = :story_id");
        $stmt->execute(['notes' => $notes, 'story_id' => $story_id]);
        
        $story = $conn->prepare("SELECT user_id, title FROM stories WHERE id = ?");
        $story->execute([$story_id]);
        $s = $story->fetch();
        notify($s['user_id'], "Your story '" . $s['title'] . "' passed initial review and is forwarded to a Senior Editor!");
        
    } elseif ($_POST['action'] === 'reject') {
        $stmt = $conn->prepare("UPDATE stories SET review_status = 'rejected_by_ae', ae_notes = :notes WHERE id = :story_id");
        $stmt->execute(['notes' => $notes, 'story_id' => $story_id]);
        
        $story = $conn->prepare("SELECT user_id, title FROM stories WHERE id = ?");
        $story->execute([$story_id]);
        $s = $story->fetch();
        notify($s['user_id'], "Your submission '" . $s['title'] . "' was declined during initial review.");
    }
    header("Location: ae_dashboard.php");
    exit();
}

// Get all stories pending Acquisition Editor assignment
$stmt = $conn->query("SELECT s.*, u.username FROM stories s JOIN users u ON s.user_id = u.id WHERE s.review_status = 'pending_ae' ORDER BY s.id DESC");
$submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Acquisition Editor Platform</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f9; color: #333; padding: 40px; }
        .container { max-width: 800px; margin: 0 auto; }
        .card { background: #fff; padding: 25px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        h2 { color: #2c3e50; margin-bottom: 5px; }
        h3 { margin-top: 0; color: #34495e; }
        textarea { width: 100%; height: 80px; padding: 10px; margin: 15px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; resize: vertical; }
        .btn { padding: 12px 20px; border: none; cursor: pointer; color: white; font-weight: bold; border-radius: 4px; margin-right: 10px; }
        .btn-forward { background: #2ecc71; }
        .btn-reject { background: #e74c3c; }
        .btn:hover { opacity: 0.9; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Acquisition Editor Dashboard</h2>
        <p style="color: #7f8c8d; margin-bottom: 30px;">Evaluate incoming author manuscripts and filter submissions.</p>
        <hr style="border: 0; border-top: 1px solid #dcdde1; margin-bottom: 30px;">
        
        <?php if (empty($submissions)): ?>
            <div class="card" style="text-align: center; color: #7f8c8d;">No pending submissions to review right now.</div>
        <?php else: ?>
            <?php foreach ($submissions as $story): ?>
                <div class="card">
                    <h3><?= safe($story['title']) ?> <span style="font-weight: normal; font-size: 14px; color: #95a5a6;">by <?= safe($story['username']) ?></span></h3>
                    <p style="line-height: 1.6; color: #57606f;"><?= nl2br(safe($story['description'])) ?></p>
                    
                    <form method="POST">
                        <input type="hidden" name="story_id" value="<?= $story['id'] ?>">
                        <textarea name="notes" placeholder="Provide analysis notes regarding your decision..." required></textarea>
                        <br>
                        <button type="submit" name="action" value="forward" class="btn btn-forward">Forward to Senior Editor →</button>
                        <button type="submit" name="action" value="reject" class="btn btn-reject">Reject Story</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>