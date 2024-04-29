<?php if (!empty($_SERVER['success_message'])) : ?>
  <div><?= $_SERVER['success_message'] ?></div>
<?php endif ?>
<?php if (!empty($errors)) : ?>
  <?php foreach ($errors as $error) : ?>
    <div><?= $error ?></div>
  <?php endforeach ?>
<?php endif ?>
<div>
  <h3 class="mb-4">
    <a href="?ym=<?= $prev ?>" class="link-offset-2 link-underline link-underline-opacity-0">&lt;</a>
    <span class="mx-3"><?= $html_title ?></span>
    <a href="?ym=<?= $next ?>" class="link-offset-2 link-underline link-underline-opacity-0">&gt;</a>
  </h3>
  <form action="/touban/" method="POST">
    <table class="table table-bordered table-responsive fw-bold table-striped">
      <thead class="table-dark">
        <tr>
          <?php foreach (["日", "月", "火", "水", "木", "金", "土"] as $day) : ?>
          <th class="mw-25 text-center"><?= $day ?></th>
          <?php endforeach ?>
        </tr>
      </thead>
      <?php foreach ($weeks as $week) : ?>
        <?= $week ?>
      <?php endforeach ?>
    </table>
    
  <?php if ($action === 'create') : ?>
    <input type="hidden" value=<?= $ym ?> name="ym">
    <div class="align-items-center px-2 d-flex justify-content-between">
      <a href="/touban/" class="link-dark link-offset-2 link-underline link-underline-opacity-0">戻る</a>
      <input type="submit" value="登録する" class="btn btn-warning">
    </div>
  <?php endif ?>
  </form>
</div>
