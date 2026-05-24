<?php
include('config.php');
check_login();
check_se(); 

// Process Final Executive Decisions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $story_id = intval($_POST['story_id']);
    $se_notes = clean($_POST['se_notes']);
    
    if ($_POST['action'] === 'approve') {
        $stmt = $conn->prepare("UPDATE stories SET review_status = 'approved_by_se', se_notes = :se_notes WHERE id = :story_id");
        $stmt->execute(['se_notes' => $se_notes, 'story_id' => $story_id]);
        
        $story = $conn->prepare("SELECT user_id, title FROM stories WHERE id = ?");
        $story->execute([$story_id]);
        $s = $story->fetch();
        notify($s['user_id'], "Congratulations! Your story '" . $s['title'] . "' has been approved by the Senior Editor. A contract offer is being processed!");
        
    } elseif ($_POST['action'] === 'reject') {
        $stmt = $conn->prepare("UPDATE stories SET review_status = 'rejected_by_se', se_notes = :se_notes WHERE id = :story_id");
        $stmt->execute(['se_notes' => $se_notes, 'story_id' => $story_id]);
        
        $story = $conn->prepare("SELECT user_id, title FROM stories WHERE id = ?");
        $story->execute([$story_id]);
        $s = $story->fetch();
        notify($s['user_id'], "Your escalated submission '" . $s['title'] . "' was declined following senior structural review.");
    }
    header("Location: se_dashboard.php");
    exit();
}

// Get stories escalated by AEs
$stmt = $conn->query("SELECT s.*, u.username FROM stories s JOIN users u ON s.user_id = u.id WHERE s.review_status = 'forwarded_to_se' ORDER BY s.id DESC");
$escalated_stories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Senior Editor Platform</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #eef2f7; color: #333; padding: 40px; }
        .container { max-width: 800px; margin: 0 auto; }
        .card { background: #fff; padding: 25px; margin-bottom: 20px; border-left: 5px solid #3498db; border-radius: 4px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        h2 { color: #2c3e50; margin-bottom: 5px; }
        .ae-notes { background: #fcf8e3; border: 1px solid #faebcc; color: #8a6d3b; padding: 15px; margin: 15px 0; border-radius: 4px; font-size: 14px; }
        textarea { width: 100%; height: 80px; padding: 10px; margin: 15px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn { padding: 12px 20px; border: none; cursor: pointer; color: white; font-weight: bold; border-radius: 4px; margin-right: 10px; }
        .btn-approve { background: #3498db; }
        .btn-reject { background: #7f8c8d; }
        .btn:hover { opacity: 0.9; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Senior Editor Review Board</h2>
        <p style="color: #7f8c8d; margin-bottom: 30px;">Final authorization queue for stories escalated by Acquisition Editors.</p>
        <hr style="border: 0; border-top: 1px solid #dcdde1; margin-bottom: 30px;">

        <?php if (empty($escalated_stories)): ?>
            <div class="card" style="text-align: center; color: #7f8c8d; border-left: none;">No escalated submissions waiting for final evaluation.</div>
        <?php else: ?>
            <?php foreach ($escalated_stories as $story): ?>
                <div class="card">
                    <h3><?= safe($story['title']) ?> <span style="font-weight: normal; font-size: 14px; color: #95a5a6;">Submitted by: <?= safe($story['username']) ?></span></h3>
                    <p style="line-height: 1.6; color: #57606f;"><?= nl2br(safe($story['description'])) ?></p>
                    
                    <div class="ae-notes">
                        <strong>Acquisition Editor Feedback:</strong><br>
                        "<?= safe($story['ae_notes']) ?>"
                    </div>

                    <form method="POST">
                        <input type="hidden" name="story_id" value="<?= $story['id'] ?>">
                        <textarea name="se_notes" placeholder="Write managerial assessment or issuance instructions..."></textarea>
                        <br>
                        <button type="submit" name="action" value="approve" class="btn btn-approve">Approve & Sign Contract</button>
                        <button type="submit" name="action" value="reject" class="btn btn-reject">Final Reject</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>