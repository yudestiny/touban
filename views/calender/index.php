<?php if (!empty($_SERVER['success_message'])) : ?>
  <div><?= $_SERVER['success_message']; ?></div>
<?php endif; ?>
<?php if (!empty($errors)) : ?>
  <?php foreach ($errors as $error) : ?>
    <div><? echo $error; ?></div>
  <?php endforeach; ?>
<?php endif; ?>
<div>
  <h3 class="mb-4">
    <a href="?ym=<?= $prev ?>" class="link-offset-2 link-underline link-underline-opacity-0">&lt;</a>
    <span class="mx-3"><?= $html_title ?></span>
    <a href="?ym=<?= $next ?>" class="link-offset-2 link-underline link-underline-opacity-0">&gt;</a>
  </h3>
  <form action="/touban/" method="POST">
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
        <?= $week; ?>
      <?php endforeach; ?>
    </table>
    
  <?php if ($action === 'create') : ?>
    <input type="hidden" value=<?= $ym ?> name="ym">
    <input type="submit" value="登録する">
    <div><a href="/touban/">戻る</a></div>
  <?php endif; ?>
  </form>
</div>
