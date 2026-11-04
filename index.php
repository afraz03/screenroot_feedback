<?php
declare(strict_types=1);
require __DIR__ . '/config.php';
session_start();

if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

function e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

function rating(string $key, int $min, int $max): ?int
{
    $v = filter_var($_POST[$key] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => $min, 'max_range' => $max]]);
    return $v === false ? null : $v;
}

$errors = [];
$old = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST;

    if (!hash_equals($_SESSION['csrf'], (string)($_POST['csrf'] ?? ''))) {
        $errors['form'] = 'Your session expired. Reload the page and try again.';
    } elseif (!empty($_POST['website'])) {
        // Honeypot field filled in: pretend success, save nothing.
        header('Location: index.php?thanks=1');
        exit;
    } else {
        $name    = trim((string)($_POST['name'] ?? ''));
        $email   = trim((string)($_POST['email'] ?? ''));
        $company = trim((string)($_POST['company'] ?? ''));
        $project = trim((string)($_POST['project'] ?? ''));
        $well    = trim((string)($_POST['went_well'] ?? ''));
        $improve = trim((string)($_POST['improve'] ?? ''));

        $overall = rating('overall_rating', 1, 5);
        $comm    = rating('communication_rating', 1, 5);
        $design  = rating('design_rating', 1, 5);
        $time    = rating('timeliness_rating', 1, 5);
        $nps     = rating('nps_score', 0, 10);

        if ($name === '' || mb_strlen($name) > 120) $errors['name'] = 'Enter your name.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 190) $errors['email'] = 'Enter a valid email address.';
        if (mb_strlen($company) > 160) $errors['company'] = 'Keep the company name under 160 characters.';
        if (mb_strlen($project) > 160) $errors['project'] = 'Keep the project name under 160 characters.';
        if ($overall === null) $errors['overall_rating'] = 'Pick a rating.';
        if ($comm === null)    $errors['communication_rating'] = 'Pick a rating.';
        if ($design === null)  $errors['design_rating'] = 'Pick a rating.';
        if ($time === null)    $errors['timeliness_rating'] = 'Pick a rating.';
        if ($nps === null)     $errors['nps_score'] = 'Pick a score from 0 to 10.';
        if (mb_strlen($well) > 3000 || mb_strlen($improve) > 3000) $errors['text'] = 'Keep comments under 3000 characters.';

        if (!$errors) {
            try {
                $ipHash = hash('sha256', ($_SERVER['REMOTE_ADDR'] ?? '') . IP_SALT);

                // Basic throttle: max 5 submissions per 10 minutes from one address.
                $chk = db()->prepare('SELECT COUNT(*) FROM feedback WHERE ip_hash = ? AND created_at > (NOW() - INTERVAL 10 MINUTE)');
                $chk->execute([$ipHash]);
                if ((int)$chk->fetchColumn() >= 5) {
                    $errors['form'] = 'Too many submissions. Try again in a few minutes.';
                } else {
                    $ins = db()->prepare(
                        'INSERT INTO feedback
                         (name, email, company, project, overall_rating, communication_rating, design_rating,
                          timeliness_rating, nps_score, went_well, improve, can_contact, ip_hash)
                         VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)'
                    );
                    $ins->execute([
                        $name, $email, $company ?: null, $project ?: null,
                        $overall, $comm, $design, $time, $nps,
                        $well ?: null, $improve ?: null,
                        isset($_POST['can_contact']) ? 1 : 0, $ipHash,
                    ]);
                    $_SESSION['csrf'] = bin2hex(random_bytes(32));
                    header('Location: index.php?thanks=1');
                    exit;
                }
            } catch (Throwable $ex) {
                error_log($ex->getMessage());
                $errors['form'] = 'We could not save your feedback. Please try again.';
            }
        }
    }
}

function scale(string $name, string $label, int $min, int $max, string $lo, string $hi, array $old, array $errors): void
{
    $cur = isset($old[$name]) ? (string)$old[$name] : '';
    echo '<fieldset class="field' . (isset($errors[$name]) ? ' has-error' : '') . '">';
    echo '<legend>' . e($label) . '</legend><div class="scale">';
    for ($i = $min; $i <= $max; $i++) {
        $id = $name . '_' . $i;
        echo '<input type="radio" id="' . e($id) . '" name="' . e($name) . '" value="' . $i . '"' . ($cur === (string)$i ? ' checked' : '') . '>';
        echo '<label for="' . e($id) . '">' . $i . '</label>';
    }
    echo '</div><div class="scale-ends"><span>' . e($lo) . '</span><span>' . e($hi) . '</span></div>';
    if (isset($errors[$name])) echo '<p class="error">' . e($errors[$name]) . '</p>';
    echo '</fieldset>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>How's Working with ScreenRoot Been?</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="hero">
  <div class="wrap">
    <p class="brand">ScreenRoot</p>
    <h1>How's Working with ScreenRoot Been?</h1>
    <p class="lead">Tell us how it went. It takes 2 minutes, and we read every response.</p>
  </div>
</header>

<main class="wrap">
<?php if (isset($_GET['thanks'])): ?>
  <section class="card thanks">
    <h2>Thanks for the feedback</h2>
    <p>We'll use it to make the next project better. See our latest work at <a href="https://screenroot.com/work/">screenroot.com</a>.</p>
  </section>
<?php else: ?>
  <form class="card" method="post" action="index.php" novalidate>
    <?php if (isset($errors['form'])): ?><p class="alert" role="alert"><?= e($errors['form']) ?></p><?php endif; ?>

    <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
    <div class="hp" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

    <h2>About you</h2>
    <div class="grid">
      <div class="field<?= isset($errors['name']) ? ' has-error' : '' ?>">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" maxlength="120" required value="<?= e($old['name'] ?? '') ?>" autocomplete="name">
        <?php if (isset($errors['name'])): ?><p class="error"><?= e($errors['name']) ?></p><?php endif; ?>
      </div>
      <div class="field<?= isset($errors['email']) ? ' has-error' : '' ?>">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" maxlength="190" required value="<?= e($old['email'] ?? '') ?>" autocomplete="email">
        <?php if (isset($errors['email'])): ?><p class="error"><?= e($errors['email']) ?></p><?php endif; ?>
      </div>
      <div class="field">
        <label for="company">Company <span class="opt">optional</span></label>
        <input type="text" id="company" name="company" maxlength="160" value="<?= e($old['company'] ?? '') ?>" autocomplete="organization">
      </div>
      <div class="field">
        <label for="project">Project <span class="opt">optional</span></label>
        <input type="text" id="project" name="project" maxlength="160" value="<?= e($old['project'] ?? '') ?>">
      </div>
    </div>

    <h2>Your experience</h2>
    <?php
    scale('overall_rating', 'Overall, how was your experience?', 1, 5, 'Poor', 'Excellent', $old, $errors);
    scale('communication_rating', 'Communication and responsiveness', 1, 5, 'Poor', 'Excellent', $old, $errors);
    scale('design_rating', 'Quality of the design work', 1, 5, 'Poor', 'Excellent', $old, $errors);
    scale('timeliness_rating', 'Delivery against timelines', 1, 5, 'Poor', 'Excellent', $old, $errors);
    scale('nps_score', 'How likely are you to recommend ScreenRoot to a colleague?', 0, 10, 'Not likely', 'Very likely', $old, $errors);
    ?>

    <h2>In your words</h2>
    <div class="field">
      <label for="went_well">What went well?</label>
      <textarea id="went_well" name="went_well" rows="4" maxlength="3000"><?= e($old['went_well'] ?? '') ?></textarea>
    </div>
    <div class="field">
      <label for="improve">What could we do better?</label>
      <textarea id="improve" name="improve" rows="4" maxlength="3000"><?= e($old['improve'] ?? '') ?></textarea>
      <?php if (isset($errors['text'])): ?><p class="error"><?= e($errors['text']) ?></p><?php endif; ?>
    </div>

    <label class="check">
      <input type="checkbox" name="can_contact" value="1"<?= !empty($old['can_contact']) ? ' checked' : '' ?>>
      <span>You can contact me about my feedback.</span>
    </label>

    <button type="submit" class="btn">Send feedback</button>
  </form>
<?php endif; ?>
</main>

<footer class="wrap foot">© <?= date('Y') ?> ScreenRoot Technologies Limited</footer>
</body>
</html>
