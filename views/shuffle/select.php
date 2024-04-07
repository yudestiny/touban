<div class="container mt-5">
  <h3 class="mb-4"><span class="mx-3"><?php echo $html_title ?></span></h3>
<form action="shuffle/index?ym=<?= $ym ?>" method="POST">
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
<button type="submit">当番を割り振る</button>
    </form>
  <div>
    <a href="/touban">戻る</a>
  </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
  // チェックボックスを含む td 要素をクリックしたときに、チェックボックスをクリック
  $('td:has(input[type=checkbox])').on('click', function(e) {
    $(this).find('input[type=checkbox]').click();
  });
  // バブリングを防止
  $('td input[type=checkbox]').on('click', function(e) {
    e.stopPropagation();
  });
</script>
