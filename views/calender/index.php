<?php if (!empty($_SERVER['success_message'])) : ?>
  <div><?= $_SERVER['success_message']; ?></div>
<?php endif; ?>
<?php if (!empty($errors)) : ?>
  <?php foreach ($errors as $error) : ?>
    <div><? echo $error; ?></div>
  <?php endforeach; ?>
<?php endif; ?>
<div class="container mt-5">
  <h3 class="mb-4"><a href="?ym=<?= $prev ?>">&lt;</a><span class="mx-3"><?php echo $html_title ?></span><a href="?ym=<?= $next ?>">&gt;</a></h3>
  <form action="/">
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
        <?php echo $week; ?>
      <?php endforeach; ?>
    </table>
    
  <?php if ($action === 'create') : ?>
    <input type="submit" value="登録する">
    <div><a href="/touban">戻る</a></div>
  <?php endif; ?>
  </form>
  <?php if ($action === 'index') : ?>
    <h2><a href="shuffle?ym=<?= $ym ?>">当番日を選択する</a></h2>
    <h2><a href="create?ym=<?= $ym ?>">カレンダー上のメンバーの割り当て・編集</a></h2>
    <div><a href="register">メンバーを新規登録する</a></div>
  <?php endif; ?>
</div>
