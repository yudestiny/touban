<div class="container mt-5">
  <h3 class="mb-4"><span class="mx-3"><?php echo $html_title ?></span></h3>
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
  <?php if ($errors) : ?>
    <?php foreach ($errors as $error) : ?>
      <?= $error ?>
    <?php endforeach; ?>
  <?php endif; ?>
    <?php if ($toubanbi) : ?>
    <h2><a href="?ym=<?= $ym ?>&select=<?= $toubanbi ?>">もう一度割り振る</a></h2>
    <form action="/touban" method="POST" name="register">
      <input type="submit" value="登録する">
    </form>
    <?php else : ?>
      <div>
        <a href="/touban">戻る</a>
      </div>
    <?php endif; ?>
    <!-- <div><a href="" onclick="document.register.submit();">登録する</a></div> -->
</div>
