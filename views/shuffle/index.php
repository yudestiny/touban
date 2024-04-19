<div class="container mt-5">
  <h3 class="mb-4">
    <a href="?ym=<?= $prev ?>" class="link-offset-2 link-underline link-underline-opacity-0">&lt;</a>
    <span class="mx-3"><?= $html_title ?></span>
    <a href="?ym=<?= $next ?>" class="link-offset-2 link-underline link-underline-opacity-0">&gt;</a>
  </h3>
  <table class="table table-bordered">
    <tr>
      <th>日</th>
      <th>月</th>
      <th>火</th>
      <th>水</th>
      <th>木</th>
      <th>金</th>
      <th>土</th>
    </tr>
    <?php foreach ($weeks as $week) : ?>
      <?= $week ?>
    <?php endforeach ?>
  </table>
  <?php if ($errors) : ?>
    <?php foreach ($errors as $error) : ?>
      <?= $error ?>
    <?php endforeach ?>
  <?php endif ?>
    <?php if ($toubanbi) : ?>
    <h2><a href="?ym=<?= $ym ?>&select=<?= $toubanbi ?>">もう一度割り振る</a></h2>
    <form action="/touban/?ym=<?= $ym ?>" method="POST" name="register">
    <input type="hidden" name="ym" value="<?= $ym ?>">
    <?php foreach ($touban as $day => $members) : ?>
      <input type="hidden" name="day[]" value="<?= $day ?>">
      <input type="hidden" name="supervisorTouban[]" value="<?= $members[0]['id'] ?>">
      <input type="hidden" name="memberTouban[]" value="<?= $members[1]['id'] ?>">
    <?php endforeach ?>
      <input type="submit" value="登録する">
    </form>
    <?php else : ?>
      <div>
        <a href="/touban">戻る</a>
      </div>
    <?php endif ?>
</div>
