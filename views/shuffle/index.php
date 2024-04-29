<div class="container mt-5">
  <h3 class="mb-4">
    <a href="?ym=<?= $prev ?>" class="link-offset-2 link-underline link-underline-opacity-0">&lt;</a>
    <span class="mx-3"><?= $html_title ?></span>
    <a href="?ym=<?= $next ?>" class="link-offset-2 link-underline link-underline-opacity-0">&gt;</a>
  </h3>
  <table class="table table-bordered table-striped">
  <tr>
          <?php foreach (["日", "月", "火", "水", "木", "金", "土"] as $day) : ?>
          <th class="mw-25 text-center"><?= $day ?></th>
          <?php endforeach ?>
        </tr>
    <?php foreach ($weeks as $week) : ?>
      <?= $week ?>
    <?php endforeach ?>
  </table>
  <?php if ($errors) : ?>
    <?php foreach ($errors as $error) : ?>
      <div class="justify-content-center text-center">
        <?= $error ?>
      </div>
    <?php endforeach ?>
  <?php endif ?>
  <?php if ($toubanbi && empty($errors['memberOver'])) : ?>
    <form action="/touban/?ym=<?= $ym ?>" method="POST" name="register">
      <input type="hidden" name="ym" value="<?= $ym ?>">
      <?php foreach ($touban as $day => $members) : ?>
        <input type="hidden" name="day[]" value="<?= $day ?>">
        <input type="hidden" name="supervisorTouban[]" value="<?= $members[0]['id'] ?>">
        <input type="hidden" name="memberTouban[]" value="<?= $members[1]['id'] ?>">
        <?php endforeach ?>
        <div class="align-items-center px-2 d-flex justify-content-between">
          <a href="?ym=<?= $ym ?>&select=<?= $toubanbi ?>" class="link-dark link-offset-2 link-underline link-underline-opacity-0">もう一度割り振る</a>
          <input type="submit" value="登録する" class="btn btn-warning">
        </div>
      </form>
    <?php else : ?>
      <div>        
        <a href="/touban/" class="link-dark link-offset-2 link-underline link-underline-opacity-0">戻る</a>
      </div>
    <?php endif ?>
